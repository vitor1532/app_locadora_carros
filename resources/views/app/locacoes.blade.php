@extends('layouts.app')

@section('content')

    <locacoes-component clienteId="{{ Auth::user()->id }}"></locacoes-component>

@endsection
