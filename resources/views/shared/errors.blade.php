@if (session('error'))
    <div class="alert alert-danger fade in">
        <button data-dismiss="alert" class="close close-sm" type="button">
            <i class="fa fa-times"></i>
        </button>
        {{ session('error') }}
    </div>
@endif

@if (count($errors) > 0)
    <div class="alert alert-danger fade in">
        <button data-dismiss="alert" class="close close-sm" type="button">
            <i class="fa fa-times"></i>
        </button>
        @foreach ($errors->all() as $error)
            <li>{!! $error !!}</li>
        @endforeach
    </div>
@endif