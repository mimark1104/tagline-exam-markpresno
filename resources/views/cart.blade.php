@extends('templates.template')
@section('title', 'Cart')
@section('content')
	<h1 class="text-center py-5">Cart</h1>

	@if($item_cart != null)
	<div class="container">
		<div class="row">
			<div class="col-lg-8 offset-lg-2">
				<table class="table table-striped">
					<thead>
						<th>Item Name:</th>
						<th>Item Quantity:</th>
						<th>Item Price:</th>
						<th>Item Subtotal:</th>
						<th>Action:</th>
					</thead>
					<tbody>
						@foreach($item_cart as $item)
							<tr>
								<td>{{$item->name}}</td>
								<td>
									<form action="/cart/updateqty" method="POST" class="input-group">
										@csrf
										@method('PATCH')
										<input type="hidden" value="{{$item->id}}" name="id">
										<input type="number" name="quantity" value="{{$item->quantity}}" class="form-control">
										<button type="submit" class="btn btn-info">Update Qty</button>
									</form>
								</td>
								<td>{{$item->price}}</td>
								<td>{{$item->subtotal}}</td>
								<td>
									<form action="/cart/changeqty/{{$item->id}}" method="POST">
										@csrf
										@method('DELETE')
										<button type="submit" class="btn btn-warning">Remove From Cart</button>
									</form>
								</td>
							</tr>
						@endforeach
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td>Total: {{$total}}</td>
							<td>
								<a href="/cart/emptycart" class="btn btn-danger">Clear Cart</a>
							</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td><a href="/cart/checkout" class="btn btn-info">Pay via COD</a></td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	@else
		<h2 class="text-center py-5">Cart is Empty</h2>
		<a href="/catalog" class="btn btn-info">Go back to shopping!</a>
	@endif
@endsection