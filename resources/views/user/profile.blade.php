@extends('layouts.main')

@section('content')

    <div class="row">

        <div class="col-lg-6">
        <section class="panel">
            <header class="panel-heading">
                Profile
            </header>
            <div class="panel-body">
                {!! Form::open(['url' => 'profile']) !!}

                <div class="form-group">
                    {!! Form::label('name', 'Name') !!}
                    {!! Form::text('name', $user->name, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('email', 'E-mail') !!}
                    {!! Form::text('email', $user->email, ['class' => 'form-control', 'disabled' => true]) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('paypal_email', 'Paypal E-mail') !!}
                    {!! Form::email('paypal_email', $user->paypal_email, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::submit('Save profile', ['class' => 'btn btn-success']) !!}
                </div>

                {!! Form::close() !!}
            </div>
        </section>
        </div>

        <div class="col-lg-6">
        <section class="panel">
            <header class="panel-heading">
                Change Password
            </header>
            <div class="panel-body">
                {!! Form::open(['url' => 'profile/password']) !!}

                <div class="form-group">
                    {!! Form::label('new_password', 'New Password') !!}
                    {!! Form::password('new_password', ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('new_password', 'Repeat New Password') !!}
                    {!! Form::password('new_password_confirmation', ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::submit('Change password', ['class' => 'btn btn-success']) !!}
                </div>

                {!! Form::close() !!}
            </div>
        </section>
        </div>

    </div>

@stop