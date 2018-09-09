@extends('layouts.main')

@section('content')

    <div class="row">
        <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Support / Create New Ticket
            </header>
            <div class="panel-body">
                {!! Form::open(['url' => 'support/new']) !!}

                <div class="form-group">
                    {!! Form::label('subject', 'Subject') !!}
                    {!! Form::text('subject', '', ['required', 'class' => 'form-control', 'placeholder' => 'Subject']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('message', 'Message') !!}
                    {!! Form::textArea('message', '', ['required', 'class' => 'form-control', 'placeholder' => 'Please describe the issue you have faced here...']) !!}
                </div>

                <div class="form-group">
                    {!! Form::submit('Create Ticket', ['class' => 'btn btn-success']) !!}
                </div>

                {!! Form::close() !!}
            </div>
        </section>
        </div>
    </div>

@stop