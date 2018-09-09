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

        {!! Form::open(['url' => 'login', 'class' => 'form-signin']) !!}
        <h2 class="form-signin-heading">log in now</h2>
        <div class="login-wrap">
            {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Email', 'autofocus', 'required']) !!}
            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password', 'required']) !!}
            <label class="checkbox">
                {!! Form::checkbox('remember') !!} Remember me
                <span class="pull-right">
                    <a data-toggle="modal" href="#myModal"> Forgot Password?</a>
                </span>
            </label>
        {!! Form::button('Log In', ['type' => 'submit', 'class' => 'btn btn-lg btn-login btn-block']) !!}

        @include('shared.errors')

        <!-- <p>or you can sign in via social network</p>
			<div class="login-social-link">
				<a href="index.html" class="facebook">
					<i class="fa fa-facebook"></i>
					Facebook
				</a>
				<a href="index.html" class="twitter">
					<i class="fa fa-twitter"></i>
					Twitter
				</a>
			</div> -->
            <div class="registration">
                Don't have an account yet?
                {!! link_to('register', 'Create an account') !!}
            </div>
        </div>

    {!! Form::close() !!}


    <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    {!! Form::open(['url' => 'password/email', 'class' => '']) !!}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Forgot Password ?</h4>
                    </div>
                    <div class="modal-body">
                        <p>Enter your e-mail address below to reset your password.</p>
                        {!! Form::text('email', '', ['class' => 'form-control placeholder-no-fix', 'placeholder' => 'Email', 'autocomplete' => 'off']) !!}
                    </div>
                    <div class="modal-footer">
                        {!! Form::button('Cancel', ['type' => 'submit', 'class' => 'btn btn-default', 'data-dismiss' => 'modal']) !!}
                        {!! Form::button('Submit', ['type' => 'submit', 'class' => 'btn btn-success', 'name' => 'password_reset', 'value' => 1]) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <!-- modal -->
    </div>
@endsection