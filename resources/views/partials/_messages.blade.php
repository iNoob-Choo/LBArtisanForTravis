@if (Session::has('success'))
  <div class="alert alert-success" role="alert">
    <strong>Success:</strong> {{Session::get('success')}}
  </div>
@endif

@if (Session::has('success_delete'))
  <div class="alert alert-danger" role="alert">
    <strong>Success:</strong> {{Session::get('success_delete')}}
  </div>
@endif


@if (Session::has('info'))
  <div class="alert alert-warning" role="alert">
    <strong>Warning:</strong> {{Session::get('info')}}
  </div>
@endif
