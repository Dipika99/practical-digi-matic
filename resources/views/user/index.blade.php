@extends('layouts.app')
@section('page-css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
@endsection
@section('content')
<div class="container">
    <h2>
      User List 
      @if(Auth::user()->isRole('admin'))
      <small><button class="btn btn-link"><a href="{{ route('users.create') }}">Add User</a></button></small>
      @endif
    </h2>
</div>
<div class="container"  style="background-color:white;">
   	
	<div class="card-body">
        <!-- DataTable -->
        <table id="user-datatable" class="display" style="width: 100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            	@foreach($users as $user)
            	<tr>
            		<td>{{ $user->name }}</td>
            		<td>{{ $user->email }}</td>
            		<td>{{ implode(', ',$user->roles()->pluck('name')->toArray()) }}</td>
            		<td>{{ $user->created_at->format('m/d/Y h:i a') }}</td>
            		<td>{{ $user->updated_at->format('m/d/Y h:i a') }}</td>
            		<td>
            			@if(Auth::user()->isRole('admin') || Auth::user()->id==$user->id)
            			<form action="{!! route('users.destroy', $user->id) !!}" onsubmit="return confirm('Are you sure you want to delete this user?');" method="POST">
				                {{ csrf_field() }}
				                {!! method_field('DELETE') !!}
	                        	<a href="{{ route('users.edit', $user->id) }}"><button type="button" class="btn btn-primary btn-sm">Update</button></a>
	                        	@if(Auth::user()->isRole('admin'))
		                        	<button type="submit" class="btn delete btn-danger btn-sm">Delete</button>
		                        @endif
		                </form>
		                @endif
            		</td>
            	</tr>
            	@endforeach
            </tbody>
        </table>
	</div>
</div>
@endsection
@section('page-script')
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script type="text/javascript">
	$(document).ready(function () {
        var table =  $('#user-datatable').DataTable({
        	paging:true,
        	responsive: true,
        });
	});
</script>
@endsection