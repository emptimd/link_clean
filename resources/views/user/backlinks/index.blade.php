@extends('layouts.main')

@section('content')
    <div class="alert alert-info" style="text-align: center;font-size: 14px;">
        <strong>Attention:</strong> This tool allows you to add and tag links that you create, before the search engines and seo tools crawlers (Google, Yahoo, Linkquidator, SemRush Majestic, ahrefs and etc.) will update their databases.
    </div>
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Add Backlink
                </header>
                <div class="panel-body">
                    <form action="{{ url('/user/add_backlinks/'.$campaign_id) }}" method="post" class="form-horizontal">
                        {{ csrf_field() }}
                        <input type="hidden" name="campaign_id" value="{{ $campaign_id }}">
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
                            <div class="form-group col-sm-5">
                                <label for="tagsinput_tag" class="col-sm-2 control-label" style="text-align: center;">Tags</label>
                                <div class="col-sm-10">
                                    <input name="tags" id="tagsinput" class="tagsinput" value="" />
                                </div>
                            </div>


                            {{--<div class="col-sm-4">--}}
                                {{--<section class="panel">--}}
                                    {{--<header class="panel-heading">--}}
                                        {{--Tags Input--}}
                                    {{--</header>--}}
                                    {{--<div class="panel-body">--}}
                                        {{--<input name="tagsinput" id="tagsinput" class="tagsinput" value="" />--}}
                                    {{--</div>--}}
                                {{--</section>--}}
                            {{--</div>--}}

                            <div class="col-sm-2" style="text-align: center;margin-top: 10px;">
                                <input type="checkbox" name="follow" id="follow" value="1">
                                <label for="follow">No Follow</label>
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
                        <button class="btn btn-default pull-right" style="background-color: transparent;color: #333;margin-bottom: 10px;"><i class="fa fa-upload" aria-hidden="true"></i> Upload CSV</button>

                        <table class="display table table-bordered table-striped" id="dashboard-table">
                            <thead>
                            <tr>
                                <th>URL</th>
                                <th>Target</th>
                                <th>Anchor</th>
                                <th>Tags</th>
                                <th>No Follow</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <p>You can check link quality and influence, before creating them by <a href="/user/check_backlinks">Link Planner</a></p>
                    <button class="btn btn-success confirm_backlinks">Confirm</button>
                    <button class="btn btn-warning delete_all">Clear</button>
                </div>
            </section>
        </div>
    </div>

    <input type="hidden" id="custom-data" value="{{ $campaign_id }}">
@stop

{{--@push('styles')--}}
{{--@endpush--}}

@push('pagescript')
{!! Html::script('theme/js/jquery.tagsinput.js') !!}
{!! Html::script(elixir('js/user_add_backlinks.js')) !!}
@endpush