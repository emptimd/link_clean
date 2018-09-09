@extends('layouts.main')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Payments
                </header>
                <div class="panel-body">
                    <form action="{{ url('/admin/payments') }}" method="POST">
                        {{ csrf_field() }}
                        <button class="btn btn-info btn-xs pay-all">Pay All</button>
                    </form>
                    <div class="adv-table">
                        <table class="display table table-bordered table-striped" id="payments-table">
                            <thead>
                            <tr>
                                <th class="center">ID</th>
                                <th class="center">Name</th>
                                <th class="center">Email</th>
                                <th class="center">Balance</th>
                                <th class="center">Pay</th>
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
            var table = $('#payments-table');
            table.DataTable({
                iDisplayLength: 100,
                bProcessing: true,
                bAutoWidth: false,
                aaData: app.payments,
                aoColumnDefs: [
                    { "sClass": "center", "aTargets": [ 1,2,3,4 ] }
                ],
                order: [ [0, 'desc'] ]
            });

            table.on('click', '.pay-single' ,function(){
            	var $this = $(this);
                submit(location.protocol+'//'+location.host+'/admin/payments/'+$this.data('id'), 'post', [
                    {name: 'id', value: $this.data('id')}
                ]);
            });
        });
    </script>
@endpush