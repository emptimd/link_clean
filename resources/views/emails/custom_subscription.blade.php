@extends('layouts.email')

@section('content')
    User ID: {{ $user_id }} <BR>
    User Email: {{ $user_email }} <BR>
    Domains Count: {{ $domains_count }} <BR>
    Backlinks Count: {{ $backlinks_count }} <BR>
    <hr>
    Description: {{ $description }}
@stop
