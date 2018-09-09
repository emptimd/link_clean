@extends('layouts.landing')
@section('body_class', 'login-body')
@section('styles')
    {!! Html::style('landing/css/bootstrap.min.css') !!}
    {!! Html::style('theme/css/bootstrap-reset.css') !!}
    {!! Html::style(elixir('theme/css/style.css')) !!}
    {!! Html::style('theme/css/style-responsive.css') !!}
@endsection
@section('content')

    <div class="container">

        @include('shared.status')
        {!! Form::open(['url' => 'password/reset', 'class' => 'form-signin']) !!}
        <h2 class="form-signin-heading">reset password</h2>
        <div class="login-wrap">
            {!! Form::token() !!}

            {!! Form::hidden('token', $token) !!}

            <div class="form-group">
                {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'E-Mail', 'required']) !!}
            </div>

            <div class="form-group">
                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password', 'required']) !!}
            </div>

            <div class="form-group">
                {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm Password', 'required']) !!}
            </div>

            <div class="form-group">
                {!! Form::button('Reset Password', ['type' => 'submit', 'class' => 'btn btn-lg btn-login btn-block']) !!}
            </div>
            @include('shared.errors')
        </div>
        {!! Form::close() !!}

    </div>
@endsection