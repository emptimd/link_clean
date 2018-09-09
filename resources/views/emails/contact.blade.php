@extends('layouts.email')

@section('content')
Name: {{ $name }} <BR>
Email: {{ $email }} <BR>
Subject: {{ $subject }} <BR>
Message: {{ $msg }}
@stop
