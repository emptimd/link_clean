@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <div class="panel-body">
                    <div class="adv-table">
                        <table class="display table table-bordered table-striped" id="notification-table" style="table-layout: fixed">
                            <colgroup>
                                <col width="10px" />
                                <col width="100%" />
                                <col width="150px" />
                                <col width="80px" />
                            </colgroup>
                            <thead>
                            <tr>
                                <th></th>
                                <th class="center">Notification</th>
                                <th class="center">Date</th>
                                <th class="center">Details</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>

@stop

@push('styles')
<style>
    .notification-type {
        height: 25px;
        display: inline-block;
        width: 3px;
    }

    .notification-type.type-0 {
        background-color: #41CAC0;
    }

    .notification-type.type-1 {
        background-color: #78CD51;
    }

    .notification-type.type-2 {
        background-color: #F1C500;
    }

    .notification-type.type-3 {
        background-color: #FF6C60;
    }

    td:first-child {
        padding: 8px 0 !important;
    }

</style>
@endpush
@push('pagescript')
<script>

    $(function() {
        let $dashboard_table = $('#notification-table');

        $dashboard_table.DataTable({
            iDisplayLength: 10,
            bProcessing: true,
            bServerSide: true,
            bAutoWidth: false,
            searching: false,
            sAjaxSource:'/ajax/notifications',
            "lengthChange" : false,
            sServerMethod: "POST",
//            fnServerParams: function ( aoData ) {
//                aoData.push( { name: "full", value: 1 } );
//            },
            aoColumnDefs: [
                { "sClass": "center", "aTargets": [ 0,1,2,3 ] },
                { "bSortable": false, "aTargets": [ 0,3 ] },
                // { "bSearchable": false, "aTargets": [ 2,3,4 ] }
            ],
             aaSorting: [[ 2, "desc" ]]
        });

    });
</script>
@endpush