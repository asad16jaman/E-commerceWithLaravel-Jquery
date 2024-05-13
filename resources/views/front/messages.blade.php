@if(Session::has("errors"))

<div class="alert alert-danger alert-dismissible">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
<h4><i class="icon fa fa-ban"></i> Alert!</h4>
    {{ Session::get('errors')}}
</div>

@elseif(Session::has("success"))


<div class="alert alert-warning alert-dismissible fade show" role="alert">
{{ Session::get('success')}}
</div>



@endif