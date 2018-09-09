@if (session('status'))
    <div class="alert alert-success fade in">
        <button data-dismiss="alert" class="close close-sm" type="button">
            <i class="fa fa-times"></i>
        </button>
        {{ session('status') }}
    </div>
@endif

@if(session('status') == 'Campaign successfully created!') {{-- this for guide.--}}
    @push('pagescript')
    <script>
        var first_campaign_created = 1;
    </script>
    @endpush
@endif
