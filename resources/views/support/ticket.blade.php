@extends('layouts.main')
@section('content')

    <div class="row">
        <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Support / Ticket #{{ $ticket->id }}
            </header>
            <div class="panel-body">
                <div class="chat-room-head">
                    <h4>{{ $ticket->subject }}</h4>
                </div>

                <?php $odd=true; ?>
                @forelse($ticket->getMessages as $message)
                    <div class="group-rom">
                        <div class="first-part {{ $odd ? 'odd' : '' }}">{{ $message->getUser->name }}</div>
                        <div class="second-part">{!! nl2br(e($message->message)) !!}</div>
                        <div class="third-part">{{ $message->date }}</div>
                    </div>
                    <?php $odd=!$odd; ?>
                @empty
                    <p>Empty</p>
                @endforelse

                @if ($ticket->status != 'closed')
                <footer class="chat">
                    {!! Form::open(['url' => 'support/'.$ticket->id]) !!}
                        <div class="chat-txt">
                            {!! Form::textArea('message', '', ['style' => 'height:35px', 'class' => 'form-control', 'placeholder' => 'Message ...']) !!}
                        </div>
                        {!! Form::submit('Send', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                </footer>
                @endif

            </div>
        </section>
        </div>
    </div>

@stop