@extends('templates.template')
@section('title', 'Catalog')
@section('content')
	<h1 class="text-center py-5">Inventory</h1>

	@if(Session::has("message"))
		<h4>{{Session::get('message')}}</h4>
	@endif

	<div class="container">
		<div class="row">
			@foreach($items as $item)
				<div class="col-lg-4">
					<div class="card">
						<img src="{{$item->img_path}}" alt="" height="300px">
						<div class="card-body">
							<h5 class="card-title">{{$item->name}}</h5>
							<p class="card-text">{{$item->description}}</p>
							<p class="card-text">{{$item->price}}</p>
							<p class="card-text">{{$item->category->name}}</p>
						</div>
						@auth
							@if(Auth::user()->role_id == 1)
						<div class="card-footer">
							<a href="/admin/edititem/{{$item->id}}" class="btn btn-warning">Edit Item</a>
							<form action="/admin/delete/{{$item->id}}" method="POST">
								@csrf
								@method('DELETE')
								<button type="submit" class="btn btn-danger">Delete Item</button>
							</form>
						</div>
							@endif
						@endauth
						<div class="card-footer">
							<!-- <form action="/addtocart/{{$item->id}}" method="POST">
								@csrf
								<input type="number" class="form-control" value="1" name="quantity">
								<button type="submit" class="btn btn-primary">Add To Cart</button>
							</form> -->
							<input type="number" name="quantity" id="quantity_{{$item->id}}" value="1" class="form-control">
							<button class="btn btn-warning" onclick="addToCart({{$item->id}})">Add Item</button>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>

<script>
	function addToCart(id){
		let quantity = document.querySelector('#quantity_'+id).value;
		//alert(quantity + " of item " + id + " has been added to cart");
		let data = new FormData;

		data.append("_token", "{{csrf_token()}}");
		data.append("quantity", quantity);

		fetch("/addtocart/"+id,{
				method: "POST",
				body: data
			}).then(response =>{
				return response.text();
			}).then(data=>{
				//console.log(data);
				document.querySelector('#cartCount').innerHTML = data;
			})
		}
</script>
@endsection