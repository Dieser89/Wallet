@extends('layouts.app')
@section('contenido')

@if ($existe)
<h1>SI ES SUYA LA LLAVE</h1>
@else
<h1>NO PERRITO, NO ES SUYA LA LLAVE</h1>
@endif


@endsection
