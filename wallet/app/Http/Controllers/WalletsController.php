<?php

namespace App\Http\Controllers;

use App\Wallet;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WalletsController extends Controller
{
    public function index()
    {
        $llaves = Wallet::all();
        return view('wallet')->with('llaves',$llaves);
    }

    public function generarllaveWeb($palabras, $email, $plata)
    {
        $walletNuevo = new Wallet();

        $walletNuevo->palabras = $palabras;
        $walletNuevo->email = $email;
        $walletNuevo->plata = $plata;
        
        $fecha = Carbon::now();

        $token = $walletNuevo->palabras . $walletNuevo->email . $fecha;

        $walletNuevo->fecha = $fecha;
        $walletNuevo->private_key = hash('sha256', $token);
        $walletNuevo->save();

        return [$walletNuevo->private_key];

    }

    public function generarllave(Request $request)
    {
        $walletNuevo = new Wallet();

        $walletNuevo->palabras = $request->input('palabras');
        $walletNuevo->email = $request->input('email');
        $walletNuevo->plata = $request->input('plata');
        $fecha = Carbon::now();

        $token = $walletNuevo->palabras . $walletNuevo->email . $fecha;

        $walletNuevo->fecha = $fecha;

        $walletNuevo->private_key = hash('sha256', $token);
        $walletNuevo->save();


        $llaves = Wallet::all();
        return view('wallet')->with('llaves',$llaves);

    }

    public function verificar(Request $request)
    {
        $private_key = $request->input('private_key-verificacion');
        $walletAVerificar = Wallet::where('private_key','=',$private_key)->firstOrFail();//arroja error 404 si el wallet no existe

        if($walletAVerificar->email == $request->input('email-verificacion')){
            return view('existe')->with('existe',true);//retorna si llave y correo corresponden
        }else{
            return view('existe')->with('existe',false);//retorna si no es suyo
        }
    }

    public function moverplata(Request $request)
    {
        $private_key = $request->input('hash_inicial');
        $private_key_destino = $request->input('hash_destino');

        $walletInicial = Wallet::where('private_key','=',$private_key)->firstOrFail();

        if($walletInicial->email == $request->input('email_inicial')){

            if($walletInicial->plata >=  $request->input('monto_transferir')){

                $walletDestino = Wallet::where('private_key','=',$private_key_destino)->firstOrFail();
                $walletDestino->plata += $request->input('monto_transferir');
                $walletInicial->plata -= $request->input('monto_transferir');

                $walletDestino->save();
                $walletInicial->save();

                return view('moverplata')->with('existe',true)->with('tienePlata',true);
            }else{
                return view('moverplata')->with('existe',true)->with('tienePlata',false);
            }
        }else{
            return view('moverplata')->with('existe',false);
        }
    }
}
