<!-- resources/views/auth/password.blade.php -->

{!! Form::open(array('url' => 'password/email')) !!}
    {!! Form::token() !!}

    <div>
        {!! Form::label('email', 'E-Mail') !!}
        {!! Form::email('email', old('email')) !!}
    </div>

    <div>
        {!! Form::button('Send Password Reset Link', ['type' => 'submit']) !!}
    </div>

{!! Form::close() !!}