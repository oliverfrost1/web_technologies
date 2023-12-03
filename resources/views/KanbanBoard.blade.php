@extends('Layout')

@section('content')
    <div id="react-root"></div>
    @vite(['resources/react/app.tsx'])
@stop
