@extends('layouts.main')

@section('content')


    <div class="row">
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="adv-table">
                        <table class="display table table-bordered table-striped table-condensed"
                               id="events-table">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th class="center">Action</th>
                                <th class="center">user_id</th>
                                <th class="center">Date</th>
                                <th class="center">Selected plan</th>
                                <th class="center">Revenue</th>
                                <th class="center">Revenue Status</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@push('pagescript')
    <script>
        $(function() {
            // show events table
            $('#events-table').DataTable({
                iDisplayLength: 25,
                bProcessing: true,
                bAutoWidth: false,
                sAjaxSource: location.pathname,
                sServerMethod: "GET",
                aoColumnDefs: [
                    { "sClass": "center", "aTargets": [ 1,2,3,4,5,6 ] }
                ],
                order: [ [0, 'desc'] ]
            });
        });
    </script>
@endpush