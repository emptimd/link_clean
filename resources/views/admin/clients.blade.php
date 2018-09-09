@extends('layouts.main')

@section('content')

    <div class="row">
        <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Clients
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <table class="display table table-bordered table-striped" id="client-table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>

                            <th>Subscription</th>
                            <th>Credits</th>
                            <th>Domain</th>
                            <th>Created</th>
                            {{--<th>Action</th>--}}
                            <th class="hidden-phone">Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </section>
        </div>
    </div>

    {{-- MODAL FOR ADD CREDITS--}}
    <div class="modal fade" id="add-credits" tabindex="-1" role="dialog" aria-labelledby="give-email-label" aria-hidden="true" data-user="1">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="give-email-label" style="text-align: center;">Add credits to user: <span class="user_name"></span></h4>
                    </div>
                    <div class="modal-body" style="text-align: center">
                        <form id="add-credits-form" action="{{ url('ajax/addCredits') }}">
                            <div class="col-xs-12 col-sm-5" style="float: none;margin: 0 auto;">
                                <div class="form-group has-feedback has-feedback-left">
                                    <label for="credits" style="float:left;margin-left: 2px;">Credits:</label>
                                    <input id="credits" type="number" class="form-control" name="credits" required maxlength="255" placeholder="Nr. of credits to add" style="height: 36px;">

                                    <input id="user" type="hidden" class="form-control" name="user">
                                </div>
                            </div>
                            <button class="btn btn-info lato-bold-18">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop


@push('pagescript')
    {!! Html::script(elixir('js/clients.js')) !!}
@endpush