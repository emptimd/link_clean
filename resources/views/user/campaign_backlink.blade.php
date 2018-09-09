@extends('layouts.main')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <!--breadcrumbs start -->
            <ul class="breadcrumb">
                <li>{!! link_to('dashboard', 'Dashboard') !!}</li>
                <li>{!! link_to('campaign/'.$campaign->id, $campaign->url) !!}</li>
                <li class="active">Backlink #{{ $backlink->id }}</li>
            </ul>
            <!--breadcrumbs end -->
        </div>
    </div>

    <input type="hidden" id="custom_data" value="{{ $backlink->id }}">

    <div class="row">
        <div class="col-lg-12">
            <div class="backlink_header">
                <h4>{!! link_to($backlink->SourceURL, $backlink->SourceURL, [
                            'target' => '_blank',
                            'class' => 'nowrap',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'bottom',
                            'title' => $backlink->SourceURL]) !!}
                </h4>
                <h5>Link Text: {{ $backlink->AnchorText }}</h5>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <aside class="profile-nav alt green-border">
                <div class="panel">
                    <ul class="nav nav-pills nav-stacked">
                        <li><a>
                                <strong>Link Quality</strong>
                                <?php $rank = \App\Models\Campaign::rank_backlink($backlink->total_rank);?>
                                <span class="pull-right r-activity {{ \App\Models\Campaign::rank_backlink_label_class($rank) }}">{{ $rank }} : {{ $backlink->total_rank }}</span>
                            </a>
                        </li>
                        <li><a>
                                Link Trust
                                <span class="label label-primary pull-right r-activity">{{ $backlink->link_rank }}</span>
                            </a>
                        </li>
                        <li><a>
                                Domain Trust
                                <span class="label label-info pull-right r-activity">{{ $backlink->domain_rank }}</span>
                            </a>
                        </li>
                            <li><a>
                                    Domain Social Trust
                                    <span class="label label-success pull-right r-activity">{{ $backlink->social_rank }}</span>
                                </a>
                            </li>
                        <li><a>
                                Referral Influence
                                <span class="label label-default pull-right r-activity">{{ $backlink->referral_influence }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </aside>
        </div>

        <div class="col-md-8 pull-right">
            <div class="panel">
                <div class="panel-body">
                    <table class="table table-striped table-condensed cf">
                        @foreach (\App\Models\Campaign::$backlink_params as $k => $p)
                            <tr>
                                <td><strong>{{ $p }}</strong></td>
                                <td>{{ \App\Models\Campaign::backlink_param_value($k, $backlink->$k) }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <section class="panel">
                <header class="panel-heading">
                    Tags Input
                </header>
                <div class="panel-body">
                    <input name="tagsinput" id="tagsinput" class="tagsinput" value="{{ $tags }}" />
                </div>
            </section>
        </div>

        {{-- TOPICAL info for this SourceURL --}}
        @if($topics->count())
        <div class="col-md-4">
            <aside class="profile-nav alt green-border">
                <div class="panel">
                    <ul class="nav nav-pills nav-stacked">
                        <li><a>
                                <strong>Link Topic</strong>
                            </a>
                        </li>
                        @foreach($topics as $topic)
                            <li><a>
                                    {{ $topic->topic }}
                                    <span class="label label-primary pull-right r-activity">{{ $topic->topical_trust_flow }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>
        </div>
        @endif

    </div>
@stop

<!--custom tagsinput-->

@push('pagescript')
{!! Html::script('theme/js/jquery.tagsinput.js') !!}
<script>
    $(function() {
        $('#tagsinput').tagsInput({

            'onAddTag': function (tag) {
                // make ajax call to add tag
                $.ajax({
                    type: 'POST',
                    url: location.protocol+'//'+location.host+'/tags/',
                    data: {_method: 'post', 'tag': $(this).val(), backlink: $('#custom_data').val()},
                }).done(function( data ) {
                    console.log(data);
                });
            },
            'onRemoveTag': function (tag) {
                // make ajax call to remove tag
                $.ajax({
                    type: 'POST',
                    url: location.protocol+'//'+location.host+'/tags/',
                    data: {_method: 'delete', 'tag': $(this).val(), backlink: $('#custom_data').val()},
                }).done(function( data ) {
                    console.log(data);
                });
            },
            'maxChars': 10,
            defaultText:'add a tag1',
            maxTags: 3,
        });
    });
</script>
@endpush