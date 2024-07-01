@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header text-center bg-white border-0">
                    <h2 class="h5">Login</h2>
                </div>
                <div class="card-body">
                    <form id="loginForm">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="d-grid gap-2 d-md-block text-center">
                            <button type="submit" class="btn btn-primary">Login</button>
                            <button type="button" class="btn btn-secondary" id="forgotPasswordButton">Esqueci minha senha</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Erro -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel"><i class="fas fa-exclamation-circle text-danger"></i> Erro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="errorModalBody">
            </div>
        </div>
    </div>
</div>

<!-- Modal de Sucesso -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel"><i class="fas fa-check-circle text-success"></i> Sucesso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Login bem-sucedido!</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('login') }}',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    localStorage.setItem('auth_token', response.access_token);
                    $('#successModal').modal('show');
                    setTimeout(function() {
                        window.location.href = '{{ route('home') }}';
                    }, 2000);
                },
                error: function(response) {
                    if (response.status === 422) {
                        let errors = response.responseJSON.errors;
                        let errorMessages = '<ul>';
                        for (let field in errors) {
                            if (errors.hasOwnProperty(field)) {
                                errors[field].forEach(function(error) {
                                    errorMessages += '<li>' + error + '</li>';
                                });
                            }
                        }
                        errorMessages += '</ul>';
                        $('#errorModalBody').html(errorMessages);
                        $('#errorModal').modal('show');
                    } else {
                        $('#errorModalBody').html('<p>Credenciais incorretas!.</p>');
                        $('#errorModal').modal('show');
                    }
                }
            });
        });

        $('#forgotPasswordButton').on('click', function() {
            window.location.href = '{{ route('password.request') }}';
        });

        $('.btn-close').click(function() {
            $('#errorModal').modal('hide');
            $('#successModal').modal('hide');
        });
    });
</script>
@endsection
