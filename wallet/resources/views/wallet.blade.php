@extends('layouts.app')
@section('contenido')

<div class="container">
    <div class="row">
        <div>
            <h2>Generar Llave Pagina</h2>
            <br>
            {{ Form::open(array('url' => '/generarllave')) }}
                {{Form::label('palabras_lbl', 'Ingresa las 12 palabras')}}
                <br>
                {{Form::text('palabras')}}
                <br>
                {{Form::label('email_lbl', 'Ingresa tu correo')}}
                <br>
                {{Form::text('email')}}
                <br>
                
                {{Form::submit('Generar')}}
            {{ Form::close() }}

        </div>
    </div>
    <hr>
    <div class="row">
        <div>
            <h2>Listado de llaves guardadas</h2>
            <br>
            @if (count($llaves) > 0)
                Cantidad de llaves guardadas: {{count($llaves)}}
                <br>
                @foreach ($llaves as $llave)
                {{$llave->private_key}}
                <br>
                @endforeach
            @endif
        </div>
    </div>
    <br>
    <br>
    <hr>
    <br>
    <div class="row">
        <div>
            <h2>Verificar hash</h2>
            <br>
            {{ Form::open(array('url' => '/verificar')) }}
                {{Form::label('hash_lbl', 'Ingresa La llave privada a verificar')}}
                <br>
                {{Form::text('private_key-verificacion')}}
                <br>
                {{Form::label('email_lbl', 'Ingresa el correo correspondiente a la llave con el fin de verificar que sea el due;o')}}
                <br>
                {{Form::text('email-verificacion')}}
                <br>
                {{Form::submit('Comprobar')}}
            {{ Form::close() }}
        </div>
    </div>
</div>
<br>
<br>
<hr>
<br>
<div class="row">
    <div>
        <h2>Realizar Transaccion</h2>
        <br>
        {{ Form::open(array('url' => '/moverplata')) }}
            {{Form::label('hash_lbl', 'Ingresa el hash de la cuenta 1')}}
            <br>
            {{Form::text('hash_inicial')}}
            <br>
            {{Form::label('email_lbl', 'comprueba que la cuenta es tuya ingresando el correo')}}
            <br>
            {{Form::text('email_inicial')}}
            <br>
            {{Form::label('hash_lbl', 'Ingresa el hash de la cuenta 2')}}
            <br>
            {{Form::text('hash_destino')}}
            <br>
            {{Form::label('hash_lbl', 'Ingresa el monto a transferir de cuenta 1 a cuenta 2')}}
            <br>
            {{Form::number('monto_transferir')}}
            <br>
            {{Form::submit('Comprobar')}}
        {{ Form::close() }}
    </div>
</div>
</div>

@endsection
