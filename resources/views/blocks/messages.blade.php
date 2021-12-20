@if(Session::has('success'))
    <div class="alert alert-primary" role="alert">
        {{Session::get('success')}}
    </div>
@endif

@if(Session::has('danger'))
    <div class="alert alert-danger" role="alert">
        {{Session::get('danger')}}
    </div>
@endif

@if(Session::has('warning'))
    <div class="alert alert-warning" role="alert">
        {{Session::get('warning')}}
    </div>
@endif
