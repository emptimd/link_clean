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

        {!! Form::open(['url' => 'register', 'class' => 'form-signin']) !!}
        {!! Form::token() !!}
        <h2 class="form-signin-heading">registration now</h2>
        <div class="login-wrap">

            <p> Enter your account details below</p>
        {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Name', 'autofocus', 'required']) !!}
        {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Email', 'required']) !!}
        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password', 'required']) !!}
        {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Re-type Password', 'required']) !!}
        <!-- <label class="checkbox">
				<input type="checkbox" value="agree this condition"> I agree to the <a href="{{ url('terms') }}" target="_blank">Terms of Use</a> and <a href="{{ url('refund-policy') }}" target="_blank">Privacy Policy</a>
			</label> -->
            <p>By continuing, you're confirming that you've read and agree to our:<BR><a href="{{ url('terms') }}" target="_blank">Terms of Use</a> and <a href="{{ url('refund-policy') }}" target="_blank">Privacy Policy</a></p>

            {!! Form::button('Submit', ['type' => 'submit', 'class' => 'btn btn-lg btn-login btn-block']) !!}

            @include('shared.errors')

            <div class="registration">
                Already Registered.
                {!! link_to('login', 'Login') !!}
            </div>

        </div>

        {!! Form::close() !!}

    </div>