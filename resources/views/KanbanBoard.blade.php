@extends('Layout')

@section('content')
    <div id="react-root"></div>
    @vite(['resources/js/app.tsx'])
@stop
