@extends('layouts.app')
@section('contenido')

@if ($existe)
<h1>SI ES SUYA LA CUENTA</h1>
    @if ($tienePlata)
    <h2>Transaccion realizada correctamente</h2>
    @else
    <h2>no tienes fondos suficientes</h2>
    @endif
@else
<h1>NO PERRITO, NO ES SUYA LA CUENTA</h1>
@endif


@endsection
