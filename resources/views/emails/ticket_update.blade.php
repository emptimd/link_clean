@extends('layouts.email')

@section('content')
    <p>Hello, {{ $name }}</p>
    <p>Your ticket #{{ $ticket->id }} was updated, please check it <a href="{{ url('support/'.$ticket->id) }}">here</a></p>
@stop