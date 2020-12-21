@extends('layout.app')

@section('content')
<div class="card rounded">
    <div class="card-header">
        <h2>Conecte-se ja</h2>
        <h5>Teste o funcionamento agora mesmo que acabou de registrar, agora só falta entrar</h5>
    </div>
    <div class="card-body">

        <form class="py-4 px-2" method="post">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email">
                
            </div>
            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <button type="submit" class="btn btn-lg btn-block btn-primary">Entrar</button>
        </form>
    </div>
</div>

@endsection