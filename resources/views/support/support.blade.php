@extends('layouts.main')

@section('content')

    <div class="row">
        <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Support
                <a href="{{ url('support/new') }}" class="btn btn-success btn-xs pull-right">Create Ticket</a>
            </header>
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Subject</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                            <tr>
                                <td nowrap>{{ $ticket->date }}</td>
                                <td>{!! $ticket->status() !!}</td>
                                <td>{{ $ticket->subject }}</td>
                                <td>{!! link_to('support/'.$ticket->id, 'details', ['class' => 'btn btn-xs btn-info']) !!}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <p>You have no tickets yet. Do you need our assistance with something ? Please <a href="{{ url('support/new') }}" class="btn btn-success btn-xs">Create Ticket</a> and we will help you.</p>
                                </td>
                            </tr>

                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
        </div>
    </div>

@stop