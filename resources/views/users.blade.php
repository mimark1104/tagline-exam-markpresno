@extends('templates.template')
@section('title', 'Users')
@section('content')
	<h1 class="text-center py-5">Users</h1>

	<div class="container">
		<div class="row">
			<div class="col-lg-10 offset-lg-1">
				<table class="table table-striped border">
					<thead>
						<th>User Name</th>
						<th>User Email</th>
						<th>Date Registered</th>
						<th>Role</th>
						<th>Action</th>
					</thead>
					<tbody>
						@foreach($users as $user)
							<tr>
								<td>{{$user->name}}</td>
								<td>{{$user->email}}</td>
								<td>{{$user->created_at->diffForHumans()}}</td>
								<td>
									{{$user->role->name}}
									<form action="/admin/updateuserrole/{{$user->id}}" method="POST" class="input-group">
									@csrf
									@method('PATCH')
										<!-- <select name="role_id" class="form-control">
											@foreach($roles as $role)
												<option value="{{$role->id}}" {{$role->id == $user->role_id ? "selected" : ""}}>{{$role->name}}</option>
											@endforeach
										</select>
										<button type="submit" class="btn btn-success">@if($user->role_id ==1)
										Demote
										@else
										Promote
										@endif</button> -->
										@if($user->role_id==1)
											<input type="hidden" name="role_id" value="2">
											<button type="submit" class="btn btn-warning">Demote</button>
										@else
											<input type="hidden" name="role_id" value="1">
											<button type="submit" class="btn btn-success">Promote</button>
										@endif
									</form>
								</td>
								<td></td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection