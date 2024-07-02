@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header text-center bg-white border-0">
                    <h2 class="h5">Registro</h2>
                </div>
                <div class="card-body">
                    <form id="registerForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nome Completo</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Digite a senha novamente</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="zip" class="form-label">CEP</label>
                                <input type="text" class="form-control" id="zip" name="zip" required>
                                <div id="zipLoading" class="spinner-border spinner-border-sm text-primary" role="status" style="display:none;">
                                    <span class="visually-hidden">Buscando...</span>
                                </div>
                                <div id="zipError" class="text-danger" style="display:none;">CEP inválido</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Endereço</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="neighborhood" class="form-label">Bairro</label>
                                <input type="text" class="form-control" id="neighborhood" name="neighborhood" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">Cidade</label>
                                <input type="text" class="form-control" id="city" name="city" disabled required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="state" class="form-label">UF</label>
                                <input type="text" class="form-control" id="state" name="state" disabled required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary" id="registerButton" disabled>Registrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Mensagem -->
<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="messageModalLabel"><i class="fas fa-info-circle"></i> Mensagem</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalMessage"></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    const zipInput = $('#zip');
    const addressInput = $('#address');
    const neighborhoodInput = $('#neighborhood');
    const cityInput = $('#city');
    const stateInput = $('#state');
    const registerButton = $('#registerButton');
    const zipLoading = $('#zipLoading');
    const zipError = $('#zipError');
    const modalMessage = $('#modalMessage');
    const messageModal = $('#messageModal');

    zipInput.mask('00000-000');

    function validateForm() {
        let isValid = true;
        $('#registerForm input[required]').each(function() {
            if ($(this).val() === '') {
                isValid = false;
            }
        });
        registerButton.attr('disabled', !isValid);
    }

    function debounce(func, wait, immediate) {
        let timeout;
        return function() {
            const context = this, args = arguments;
            const later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }

    const checkZipCode = debounce(function() {
        const zip = zipInput.val().replace(/\D/g, '');
        if (zip.length === 8) {
            zipLoading.show();
            zipError.hide();

            $.ajax({
                url: '/api/lookup/' + zip,
                type: 'GET',
                success: function(response) {
                    zipLoading.hide();
                    if (response) {
                        addressInput.removeAttr('disabled');
                        neighborhoodInput.removeAttr('disabled');

                        stateInput.attr('disabled', true);
                        cityInput.val(response.localidade);
                        stateInput.val(response.uf);

                        cityInput.attr('disabled', true);
                        stateInput.attr('disabled', true);

                        if (response.logradouro == null) {
                            addressInput.val('');
                            neighborhoodInput.val('');
                        } else {
                            addressInput.val(response.logradouro);
                            neighborhoodInput.val(response.bairro);
                        }

                        validateForm();
                    } else {
                        clearAddressFields();
                        zipError.show().text('CEP inválido');
                    }
                },
                error: function() {
                    zipLoading.hide();
                    clearAddressFields();
                    zipError.show().text('Erro ao buscar o CEP');
                }
            });
        }
    }, 500);

    function clearAddressFields() {
        addressInput.val('');
        neighborhoodInput.val('');
        cityInput.val('');
        stateInput.val('');
    }

    function handleFormSubmit(e) {
        e.preventDefault();
        zipInput.unmask();

        $.ajax({
            url: '{{ route('register') }}',
            type: 'POST',
            data: $('#registerForm').serialize(),
            success: function(response) {
                modalMessage.text(response.message);
                messageModal.modal('show');
            },
            error: function(response) {
                let errorMessages = '';
                $.each(response.responseJSON.errors, function(key, value) {
                    errorMessages += value[0] + '<br>';
                });
                modalMessage.html(errorMessages);
                messageModal.modal('show');
            }
        });
    }

    zipInput.on('input', checkZipCode);
    $('#registerForm').on('submit', handleFormSubmit);
    $('#registerForm input[required]').on('input', validateForm);

    $('.btn-close').click(function() {
        messageModal.modal('hide');
    });
});
</script>
@endsection
