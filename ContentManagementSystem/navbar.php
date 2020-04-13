
<nav class="navbar bg-secondary navbar-dark">
	<a class="navbar-brand" href="#" data-toggle="collapse" data-target="#myNavBar">WEBFLIX REVIEWS</a>
	<form class="form-inline" method="get" action="searchresults.php">
	 	<input class="form-control mr-sm-2" name="searchbar" type="search" placeholder="Search" aria-label="Search">
	  	<button class="btn btn-primary my-2 my-sm-0" type="submit">Search</button>
	</form>

	<div class="collapse navbar-collapse" id="myNavBar">
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" href="home.php">Home</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="movies.php">Movies</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="reviews.php">Reviews</a>
			</li>
			<?php if(empty($_SESSION['user_id'])): ?>
				<li class="nav-item">
					<a class="nav-link" href="register.php">Register</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="login.php">Login</a>
				</li>
			<?php else: ?>
				<li class="nav-item">
					<a class="nav-link" href="profile.php">Profile & Settings</a>
				</li>
			<?php endif ?>
		</ul>
	</div>
</nav>