@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Redefinir Senha</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $email) }}" required>
        </div>
        <div class="form-group">
            <label for="password">Nova Senha</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="password-confirm">Confirme a Nova Senha</label>
            <input type="password" class="form-control" id="password-confirm" name="password_confirmation" required>
        </div>
        <button type="submit" class="btn btn-primary">Redefinir Senha</button>
    </form>
</div>
@endsection
