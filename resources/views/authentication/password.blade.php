@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header text-center bg-white border-0">
                    <h2 class="h5">Esqueci minha senha</h2>
                </div>
                <div class="card-body">
                    <div id="statusMessage"></div>
                    <form id="forgotPasswordForm">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Enviar Link de Redefinição de Senha</button>
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
        $('#forgotPasswordForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route('password.request.send') }}',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#modalMessage').text(response.message);
                    $('#messageModal').modal('show');
                },
                error: function(response) {
                    let errorMessages = '';
                    if (response.status === 422) {
                        let errors = response.responseJSON.errors;
                        for (let field in errors) {
                            if (errors.hasOwnProperty(field)) {
                                errors[field].forEach(function(error) {
                                    errorMessages += '<p>' + error + '</p>';
                                });
                            }
                        }
                    } else {
                        errorMessages = '<p>Não foi possível enviar o link da redefinição de senha.</p>';
                    }
                    $('#modalMessage').html(errorMessages);
                    $('#messageModal').modal('show');
                }
            });
        });
    });
</script>
@endsection
