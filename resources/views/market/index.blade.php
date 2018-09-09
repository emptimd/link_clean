@extends('layouts.main')

@section('content')
    <h1 class="h1 text-center">Marketplace Admin Panel</h1>

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    For Stas
                    <form action="/admin/market" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <input type="number" name="campaign_id" required placeholder="Enter the campaign id">

                        <button class="button button-success">Submit</button>
                    </form>
                </header>
                <div class="panel-body">
                    <div class="adv-table">
                        <table class="display table table-bordered table-striped" id="dashboard-table">
                            <thead>
                            <tr>
                                <th>Campaign</th>
                                <th>Task</th>
                                <th>Project Status</th>
                                <th>Date</th>
                                <th class="hidden-phone">Action</th>
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
{!! Html::script(elixir('js/market.js')) !!}
@endpush