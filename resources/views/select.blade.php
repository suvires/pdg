@extends('layouts.app')

@section('content')
    <h2>Elige una escuela</h2>
    <ul class="list-unstyled">
        <li><a href="{{ route('index', 'es') }}">ENEB.ES</a></li>
        <li><a href="{{ route('index', 'com') }}">ENEB.COM</a></li>
        <li><a href="{{ route('index', 'pt') }}">ENEB.PT</a></li>
        <li><a href="{{ route('index', 'iseb') }}">ISEB</a></li>
    </ul>
@endsection