 Grupo 2
 
Bienvenidos a Wallet Laravel!

Este proyecto contiene:

Generar una llave privada con las 12 palabras semilla, email y la hora Validacion de datos para que el coordinador revise la informacion de la wallet

Para que elproyecto funcione necesita tener en cuenta la ejecucion de las siguientes lineas

composer install ----solo para la primera vez que entra al proyecto en un pc nuevo

crear una tabla en la base llamada wallet en laravel en el archivo .env configurar credenciales de la db y luego correr el siguiente comando php artisan migrate ----OJO desde el directorio raiz del proyecto (c:xampp/htdocs/wallet)

url para generar llave web (No repetir correo) http://localhost/wallet/public/generarllaveWeb/probandodesdelaweb/diego@web.com1

El proyecto está realizado bajo el framework Laravel que está construido con Php, donde trae el modelo, vista y controlador, para dar un orden al código y de esta forma tener un mejor manejo por parte del usuario.

Modelo: En el modelo realizaremos el backend Wallet.php

// instancia las variables protected $fillable = [ 'id','palabras','email', 'private_key','plata','fecha', Vista Encontraremos las instancias para declarar las variables y de esta forma veremos el frontend del proyecto wallet.blade.php //Generamos el formulario donde se generan las 12 palabras para el wallet acompañado de un correo electrónico para indicar que va pertenecer a un usuario.

div class="container">

Generar Llave Pagina

{{ Form::open(array('url' => '/generarllave')) }} {{Form::label('palabras_lbl', 'Ingresa las 12 palabras')}}
{{Form::text('palabras')}}
{{Form::label('email_lbl', 'Ingresa tu correo')}}
{{Form::text('email')}}
{{Form::submit('Generar')}} {{ Form::close() }} // Es este bloque se realiza el formulario donde se reflejadas las llaves guardadas que se almacenan en una base de datos en este caso en mysql. div class="row">
Listado de llaves guardadas

@if (count($llaves) > 0) Cantidad de llaves guardadas: {{count($llaves)}}
@foreach ($llaves as $llave) {{$llave->private_key}}
@endforeach @endif
// En este bloque se realiza la verificación de la llave del usuario con el fin de no generar problemas al momento 
de verificación.

<div class="row">
    <div>
        <h2>Verificar hash</h2>
        <br>
        {{ Form::open(array('url' => '/verificar')) }}
            {{Form::label('hash_lbl', 'Ingresa La llave privada a verificar')}}
            <br>
            {{Form::text('private_key-verificacion')}}
            <br>
            {{Form::label('email_lbl', 'Ingresa el correo correspondiente a la llave con el fin de verificar que sea el propietario')}}
            <br>
            {{Form::text('email-verificacion')}}
            <br>
            {{Form::submit('Comprobar')}}
        {{ Form::close() }}
    </div>
Controlador:
En el controlador generamos la llave y mandamos la indicación al coordinador para devolver la sentencia de este mismo. wallet.controller

// con este método generamos la llave web dando la indicación a coordinador public function generarllaveWeb($palabras, $email) { $walletNuevo = new Wallet();

    $walletNuevo->palabras = $palabras;
    $walletNuevo->email = $email;
    //$walletNuevo->plata = $plata;
    
    $fecha = Carbon::now();

    $token = $walletNuevo->palabras . $walletNuevo->email . $fecha;

    $walletNuevo->fecha = $fecha;
    $walletNuevo->private_key = hash('sha256', $token);
    $walletNuevo->save();
    //retorna la respuesta del coordinador
    return [$walletNuevo->private_key];

}
// Genera la llave a nivel local public function generarllave(Request $request) { $walletNuevo = new Wallet();

    $walletNuevo->palabras = $request->input('palabras');
    $walletNuevo->email = $request->input('email');
    //$walletNuevo->plata = $request->input('plata');
    $fecha = Carbon::now();

    $token = $walletNuevo->palabras . $walletNuevo->email . $fecha;

    $walletNuevo->fecha = $fecha;

    $walletNuevo->private_key = hash('sha256', $token);
    $walletNuevo->save();


    $llaves = Wallet::all();
    return view('wallet')->with('llaves',$llaves);

}
// Cumple la función de validar si la wallet pertenece a un usuario de lo contrario no validad el ingreso public function verificar(Request $request) { $private_key = $request->input('private_key-verificacion'); $walletAVerificar = Wallet::where('private_key','=',$private_key)->firstOrFail();//arroja error 404 si el wallet no existe

    if($walletAVerificar->email == $request->input('email-verificacion')){
        return view('existe')->with('existe',true);//retorna si llave y correo corresponden
    }else{
        return view('existe')->with('existe',false);//retorna si no es suyo
    }
}   
Direccion del servidor:
http://142.44.246.66 Registro: Registra los datos suministrados por el usuario.   
http://142.44.246.66 Generarllave: Genera la llave con los datos dado por el usuario.
http://142.44.246.66 Verificar: Verifica la informacion de la con el correo indicando si es correcto o no lo es.

