@extends('layout.app')

@section('content')
<div class="card rounded">
    <div class="card-header">
        <h2>Registre-se ja</h2>
        <h5>Teste o funcionamento agora mesmo se registrando com o poder do cognito</h5>
    </div>
    <div class="card-body">

        <form class="py-4 px-2" method="post">
            @csrf

            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email">
                
            </div>
            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirme a senha</label>
                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" aria-describedby="passwordHelpBlock">
                <small id="passwordHelpBlock" class="form-text text-muted">
                A sua senha deve ser a mesma que o campo anterior
                </small>
            </div>
            <div class="col-12 py-1">
                <p class="text-right"><a class="nav-link text-decoration-none" href="/email/verify">Verificar email</a></p>
            </div>
            <button type="submit" class="btn btn-lg btn-block btn-primary">Criar conta</button>
        </form>
    </div>
</div>

@endsection