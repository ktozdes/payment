@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
    	{{session('success')}}
    </div>
@elseif (session('warning'))
    <div class="alert alert-warning alert-dismissible fade show">
        {{session('warning')}}
    </div>
@elseif (session('error'))
	<div class="alert alert-danger alert-dismissible fade show">
	    {{session('error')}}
	</div>
@endif
