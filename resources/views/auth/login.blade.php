@extends('layouts.app')

@section('content')

    <login-component
        token="@csrf"
    >
    </login-component>

@endsection
