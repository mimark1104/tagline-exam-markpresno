@extends('templates.template')
@section('title', 'Add Item')
@section('content')
	<h1 class="text-center py-5">Add Item</h1>
	<div class="container">
		<div class="row">
			<div class="col-lg-6 offset-lg-3">
				<form action="/admin/additem" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label for="name">Item Name:</label>
						<input type="text" name="name" class="form-control">
					</div>
					<div class="form-group">
						<label for="description">Item Description:</label>
						<textarea name="description" class="form-control"></textarea>
					</div>
					<div class="form-group">
						<label for="price">Item Prices:</label>
						<input type="number" name="price" class="form-control">
					</div>
					<div class="form-group">
						<label for="img_path">Item Image:</label>
						<input type="file" name="img_path" class="form-control">
					</div>
					<div class="form-group">
						<label for="category_id">Item Category:</label>
						<select name="category_id" class="form-control">
							@foreach($categories as $category)
								<option value="{{$category->id}}">{{$category->name}}</option>
							@endforeach
						</select>
					</div>
					<button type="submit" class="btn btn-success">Add Item</button>
				</form>
			</div>
		</div>
	</div>
@endsection