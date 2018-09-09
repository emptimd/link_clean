@extends('layouts.main')

@section('content')
    <div class="alert alert-info" style="text-align: center;font-size: 14px;">
        <strong>Attention:</strong> Link Planner allows you to explore potential influence and quality of the link from page and domain referrer where you want to place it.
    </div>
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Add Backlink
                </header>
                <div class="panel-body">
                    <form action="{{ url('/user/check_backlinks/') }}" method="post" class="form-horizontal">
                        {{ csrf_field() }}
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <div class="form-group">
                            <label for="url-data" class="col-sm-1 control-label" style="text-align: center;">URL</label>
                            <div class="col-sm-8">
                                <input type="url" id="url-data" name="url" class="add-backlinks form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="target_url-data" class="col-sm-1 control-label" style="text-align: center;">Target URL</label>
                            <div class="col-sm-8">
                                <input type="url" id="target_url-data" name="target_url" class="add-backlinks form-control" required>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="anchor_text-data" class="col-sm-1 control-label" style="text-align: center;">Anchor</label>
                            <div class="col-sm-8">
                                <input type="text" id="anchor_text-data" name="anchor_text" class="add-backlinks form-control" required>
                            </div>
                        </div>

                        <div class="vcenter">
                            {{--Tags Input--}}
                            {{--<div class="form-group col-sm-5">--}}
                                {{--<label for="tagsinput_tag" class="col-sm-2 control-label" style="text-align: center;">Tags</label>--}}
                                {{--<div class="col-sm-10">--}}
                                    {{--<input name="tags" id="tagsinput" class="tagsinput" value="" />--}}
                                {{--</div>--}}
                            {{--</div>--}}


                            <div class="col-sm-2 col-sm-offset-4" style="text-align: center;margin-top: 10px;">
                                <input type="checkbox" name="no_follow" id="no_follow" value="1">
                                <label for="no_follow">No Follow</label>
                            </div>

                            <div class="col-sm-4 text-center">
                                <button class="btn btn-info">Add</button>

                            </div>
                        </div>


                    </form>
                </div>
            </section>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <div class="panel-body">
                    <div class="adv-table">
                        <form action="{{ url('user/check_backlinks/upload') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="file" name="check_backlinks_file" id="disavow_file" class="hidden" accept="text/plain, .csv">
                            <label for="disavow_file" class="btn btn-default pull-right" style="background-color: transparent;color: #333;margin-bottom: 10px;"><i class="fa fa-upload" aria-hidden="true"></i> Upload CSV</label>
                        </form>
                        <table class="display table table-bordered table-striped" id="dashboard-table">
                            <thead>
                            <tr>
                                <th>URL</th>
                                <th>Target</th>
                                <th>Anchor</th>
                                <th>No Follow</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <button class="btn btn-success confirm_backlinks">Confirm</button>
                    {{--<button class="btn btn-warning delete_all">Clear</button>--}}
                </div>
            </section>
        </div>
    </div>
@stop

{{--@push('styles')--}}
{{--@endpush--}}

@push('pagescript')
{!! Html::script(elixir('js/user_check_backlinks.js')) !!}
@endpush