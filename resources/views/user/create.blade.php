@extends('layouts.app')

@section('content')
<div class="container">
    <h2>
      Add User 
      <small><button class="btn btn-link"><a href="{{ route('users.index') }}">User List</a></button></small>
    </h2>
</div>
<hr>
<div class="container">
	<div class="col-sm-10" style="background-color:white">
		<form method="post" enctype="multipart/form-data" action="{{ route('users.store') }}">
			@method('POST')
			@include('user._form')
			<div class="form-group row mb-0">
	            <div class="col-md-6 offset-md-4">
	                <button type="submit" class="btn btn-primary">
	                    {{ __('Add') }}
	                </button>
	            </div>
	        </div>
		</form>
		<br>
</div>
</div>
@endsection