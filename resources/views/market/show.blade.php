@extends('layouts.main')

@section('content')
    <style>
        .search-container .add-backlinks {
            margin-right: 3%;
        }
    </style>
    <h1 class="h1 text-center">{{ $market->url }}</h1>

    <h3>Task: {{ $market->name }}</h3>

    <h4 class="extras">Extras: {{ implode(', +' , $extras) }}</h4>

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <div class="search-container">
                        <form action="{{ url('/admin/market/'.$market->id) }}" method="post">
                            {{ csrf_field() }}
                            <input type="url" id="url-data" name="url" class="add-backlinks" placeholder="URL" required>
                            <input type="url" id="target_url-data" name="target_url" class="add-backlinks" placeholder="Target URL" required>
                            <input type="text" id="anchor_text-data" name="anchor_text" class="add-backlinks" placeholder="Anchor Text" required>

                            <input type="checkbox" name="follow" id="follow">
                            <label for="follow">Do Follow</label>

                            <button class="btn btn-info pull-right">Add</button>
                        </form>

                    </div>
                </header>
                <div class="panel-body">
                    <div class="adv-table">
                        <table class="display table table-bordered table-striped" id="dashboard-table">
                            <thead>
                            <tr>
                                <th>URL</th>
                                <th>Target</th>
                                <th>No Follow</th>
                                <th>Anchor</th>
                                <th>Date</th>
                                <th class="hidden-phone">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($market_backlinks as $d)
                                <tr>
                                    <td title="{{ $d->url }}">{{ $d->url }}</td>
                                    <td class="center">{{ $d->target_url }}</td>
                                    <td class="center">{{ $d->follow ? '-' : '+' }}</td>
                                    <td class="center">{{ $d->anchor_text }}</td>
                                    <td class="center">{{ $d->created_at->toDateTimeString() }}</td>
                                    <td class="center"><a data-url="{{ $d->url }}" class="btn btn-xs delete_campaign btn-danger" data-id="{{ $market->id }}" data-backlink="{{ $d->id }}">delete</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <footer class="panel-footer">
                    <form action="{{ url('/admin/market/'.$market->id.'/publish') }}" method="post">
                        {{ csrf_field() }}
                        <button class="btn btn-success pull-right publish">Publish</button>
                    </form>
                    <div class="clearfix"></div>
                </footer>
            </section>
        </div>

    </div>
@stop

{{--@push('styles')--}}
{{--@endpush--}}

@push('pagescript')
<script>
    function submit(action, method, values){
        if(action === false) return;
        var form = $('<form/>', {
            action: action,
            method: method
        });

        // add csrf token
        form.append($('<input/>', {
            type: 'hidden',
            name: '_token',
            value: $('meta[name="csrf-token"]').attr('content')
        }));

        $.each(values, function() {
            form.append($('<input/>', {
                type: 'hidden',
                name: this.name,
                value: this.value
            }));
        });
        form.appendTo('body').submit();
    }


    $(function(){
        let $body = $('body'),
            $dashboard_table = $('#dashboard-table');

        $dashboard_table.DataTable({
            iDisplayLength: 100,
            bProcessing: true,
            searching: false,
            bAutoWidth: false,
            "lengthChange" : false,
            aoColumnDefs: [
                { "sClass": "center", "aTargets": [ 0,1,2,3,4 ] },
                { "bSortable": false, "aTargets": [ 4 ] },
                { "bSearchable": false, "aTargets": [ 2,3,4 ] }
            ],
            aaSorting: [[ 4, "desc" ]]
        });

        $body.on('click', '.delete_campaign', function(e){
            e.preventDefault();
            var $this = $(this);

            if(confirm('Are you sure you want to delete the backlink: '+$this.data('url')+'?'))
            {
                submit('/admin/market/'+$this.data('id')+'/'+$this.data('backlink'), 'POST', [
                    { name: '_method', value: 'delete' },
                    { name: 'id', value: $this.data('id') }
                ]);
            }
            return false;
        });
    });
</script>
@endpush