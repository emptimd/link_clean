@extends('layouts.main')

@section('content')

    <div class="row">
        <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Support
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <table class="display table table-bordered table-striped" id="support-table">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Subject</th>
                            <th>Domain</th>
                            <th class="hidden-phone"></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </section>
        </div>
    </div>

@stop

@push('pagescript')
    {!! Html::script(elixir('js/support.js')) !!}
@endpush