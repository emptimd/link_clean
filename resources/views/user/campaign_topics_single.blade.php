@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <!--breadcrumbs start -->
            <ul class="breadcrumb">
                <li>{!! link_to('dashboard', 'Dashboard') !!}</li>
                <li>{!! link_to('campaign/'.$campaign->id, $campaign->url) !!}</li>
                <li class="active">{{ $domain }}</li>
            </ul>
            <!--breadcrumbs end -->
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Topics for "{{ $domain }}"
            </header>
            <div class="panel-body">

                <table class="display table table-striped" id="topics-single-table">
                    <thead>
                    <tr>
                        <th>Topic</th>
                        <th class="center">Trust Flow</th>
                        <th class="center">Pages</th>
                        <th class="center">Links</th>
                        <th class="center" style="text-align: center;">Links From Ref Domains</th>
                        {{--<th class="center">Details</th>--}}
                    </tr>
                    </thead>
                </table>
            </div>
        </section>
        </div>
    </div>

    <input type="hidden" id="custom-data" value="{{ $campaign->id }}">
    <input type="hidden" id="custom-url" value="{{ $domain }}">
@stop

@push('pagescript')
    {!! Html::script(elixir('js/topics_single.js')) !!}
@endpush