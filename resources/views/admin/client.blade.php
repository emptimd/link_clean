@extends('layouts.main')

@section('content')

    <div class="row">
        <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <a href="{{ url('admin/clients') }}">Clients</a> > {{ $client->name }} {{ $client->email }}
            </header>
            <div class="panel-body">
                Campaigns
                <div class="adv-table">
                    <table class="display table table-bordered table-striped" id="client-campaigns-table">
                        <thead>
                        <tr>
                            <th>Campaign</th>
                            <th>Total Backlinks</th>
                            <th>Crawl Date</th>
                            <th>Status</th>
                            <th>Domain</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </section>
        </div>
    </div>
    <input type="hidden" id="custom-data" name="custom-data" value="{{ $client->id }}">
@stop

@push('pagescript')
    {!! Html::script('js/client.js') !!}
@endpush
