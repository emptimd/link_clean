@extends('layouts.main')

@section('content')
    <div class="alert alert-info" style="text-align: center;font-size: 14px;">
        <strong>Attention:</strong> Link Planner allows you to explore potential influence and quality of the link from page and domain referrer where you want to place it.
    </div>

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <div class="panel-body">
                    <div class="adv-table">
                        <a href="/user/check_backlinks/download" download class="btn btn-default pull-right" style="background-color: transparent;color: #333;margin-bottom: 10px;"><i class="fa fa-download" aria-hidden="true"></i> Download CSV</a>

                        <table class="display table table-bordered table-striped" id="dashboard-table">
                            <thead>
                            <tr>
                                <th>URL</th>
                                <th>No Follow</th>
                                <th>CitationFlow</th>
                                <th>TrustFlow</th>
                                <th>Social Rank</th>
                                <th>R.Influence</th>
                                <th>Quality</th>
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
<script>

    $(function() {
        let $dashboard_table = $('#dashboard-table');

        $dashboard_table.DataTable({
            iDisplayLength: 10,
            bProcessing: true,
            bServerSide: true,
            bAutoWidth: false,
            searching: false,
            sAjaxSource:'/ajax/user_check_backlinks',
            "lengthChange" : false,
            sServerMethod: "POST",
            fnServerParams: function ( aoData ) {
                aoData.push( { name: "full", value: 1 } );
            },
            aoColumnDefs: [
                { "sClass": "center", "aTargets": [ 1,2,3,4,5,6 ] },
//                { "bSortable": false, "aTargets": [ 4 ] },
                // { "bSearchable": false, "aTargets": [ 2,3,4 ] }
            ],
            // aaSorting: [[ 3, "desc" ]]
        });

    });
</script>
@endpush