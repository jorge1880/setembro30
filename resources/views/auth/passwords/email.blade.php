@extends('admin.layout')
@section('title', 'Recuperar Senha')
@section('conteudo')
<div class="row container">
    <div class="col s12 m8 offset-m2">
        <div class="card z-depth-4">
            <div class="card-content">
                <span class="card-title">Recuperação de Senha</span>
                @if(session('status'))
                    <div class="card-panel green white-text">{{ session('status') }}</div>
                @endif
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="input-field">
                        <input id="email" type="email" name="email" class="validate" required autofocus>
                        <label for="email">E-mail</label>
                        @error('email')
                            <span class="red-text">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn blue waves-effect waves-light">
                        Enviar nova senha
                    </button>
                    <a href="{{ route('login.form') }}" class="btn grey waves-effect waves-light">Voltar ao login</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 