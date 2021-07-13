<html>
<head>
	<meta charset="UTF-8">
	<title>@yield("title")</title>
	<link rel="stylesheet" href="https://bootswatch.com/4/darkly/bootstrap.css">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	  <a class="navbar-brand" href="/">DEV TECH EXAM PART 2</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>

	  <div class="collapse navbar-collapse" id="navbarColor02">
	    <ul class="navbar-nav ml-auto">
	     <!--  <li class="nav-item active">
	        <a class="nav-link" href="/">Home</a>
	      </li> -->
	      <li class="nav-item">
	        <a class="nav-link" href="/catalog">Inventory</a>
	      </li>
	      @if(Auth::user())
		      @auth
			      @if(Auth::user()->role_id==1)
					<li class="nav-item">
						<a class="nav-link" href="/admin/additem">Add Item</a>
					</li>
					<li class="nav-item">
				       	<a class="nav-link" href="/users">Users</a>
				    </li>
				    <li class="nav-item">
				      <a class="nav-link" href="/admin/allorders">All Orders</a>
				    </li>
			      @else
			      	<li class="nav-item">
				      <a class="nav-link" href="/cart">Cart <span class="badge bg-light" id="cartCount">
				      		@if(Session::has('cart'))
				      			{{array_sum(Session::get('cart'))}}
				      		@else
				      			0
				      		@endif
				      </span></a>
				    </li>
				    <li class="nav-item">
				      <a class="nav-link" href="/orders">My Orders</a>
				    </li>
			      @endif
			      <li class="nav-item">
			        <a class="nav-link" href="">Hi {{Auth::user()->name}}</a>
			      </li>
			      <li class="nav-item">
			        <form action="/logout" method="POST">
			        	@csrf
			        	<button type="submit" class="btn btn-secondary">Logout</button>
			        </form>
			      </li>
		      @endauth
		  @else
		  	  <li class="nav-item">
			      <a class="nav-link" href="/cart">Cart <span class="badge bg-light" id="cartCount">
			      		@if(Session::has('cart'))
			      			{{array_sum(Session::get('cart'))}}
			      		@else
			      			0
			      		@endif
			      </span></a>
			    </li>
			  <li class="nav-item">
		        <a class="nav-link" href="/register">Register</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="/login">Login</a>
		      </li>
		  @endif

	    </ul>
	  </div>
	</nav>

		@yield("content")

	<footer class="footer bg-dark">
		<div class="container">
			<p class="text-center text-white">examination made by mark</p>
		</div>
	</footer>
</body>
</html>