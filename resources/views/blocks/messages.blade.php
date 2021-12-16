@if(Session::has('success'))
    <div class="alert alert-primary" role="alert">
        <strong>Success:</strong> {{Session::get('success')}}
    </div>
@endif

@if(Session::has('danger'))
    <div class="alert alert-danger" role="alert">
        <strong>Success:</strong> {{Session::get('danger')}}
    </div>
@endif

@if(Session::has('warning'))
    <div class="alert alert-warning" role="alert">
        <strong>Success:</strong> {{Session::get('warning')}}
    </div>
@endif
