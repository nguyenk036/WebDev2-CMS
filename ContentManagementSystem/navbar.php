<?php
	
	$getMenuItems = $db->prepare("SELECT * FROM menuitems");
	$getMenuItems->execute();

	if(isset($_POST) && isset($_POST['additem']) && !empty($_POST['itemname']) && !empty($_POST['url'])){

		$itemname = filter_input(INPUT_POST, 'itemname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$url 	= filter_input(INPUT_POST, 'url', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		$itemQuery = $db->prepare("INSERT INTO menuitems (ItemName, URL) VALUES (:itemname, :url)");
		$itemQuery->bindValue(':itemname', $itemname);
		$itemQuery->bindValue(':url', $url);
		$itemQuery->execute();

		echo "<meta http-equiv='refresh' content='0'>";
	}
?>

<nav class="navbar bg-secondary navbar-dark">
	<a class="navbar-brand" href="#" data-toggle="collapse" data-target="#myNavBar">WEBFLIX REVIEWS</a>
	<div class="btn-group">
	  <?php if(!empty($_SESSION['user_id'])): ?>

	  	<a href="profile.php" class="btn btn-primary"><?= $user->name ?></a>
	  	<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split mr-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		  <span class="sr-only">Toggle Dropdown</span>
		</button>
		<div class="dropdown-menu">
			<?php if($_SESSION['adminstatus'] > 0): ?>
				<a href="allusers.php" class="dropdown-item">Members List</a>
				<div class="dropdown-divider"></div>
			<?php endif ?>
			<a href="logout.php" class="dropdown-item">Logout</a>
		</div>
	  	
	  <?php endif ?>
	  <form class="form-inline" method="get" action="searchresults.php">
		 <input class="form-control mr-sm-2" name="searchbar" type="search" placeholder="Search" aria-label="Search">
		 <button class="btn btn-primary my-2 my-sm-0" type="submit">Search</button>
	  </form>
	</div>
	

	<div class="collapse navbar-collapse" id="myNavBar">
		<ul class="navbar-nav">
			<?php while($item = $getMenuItems->fetch()): ?>
				<li class="nav-item">
					<a class="nav-link" href="<?= $item['URL'] ?>"><?= $item['ItemName'] ?></a>
				</li>
			<?php endwhile ?>
			<?php if(empty($_SESSION['user_id'])): ?>
				<li class="nav-item">
					<a class="nav-link" href="register.php">Register</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="login.php">Login</a>
				</li>
			<?php endif ?>
			<?php if(isset($_SESSION['user_id']) && $user->AdminStatus > 0): ?>
				<li class="nav-item">
					<a class="nav-link" href="#" data-toggle="modal" data-target="#AddItemModal">+ Add a New Menu Item</a>
				</li>
			<?php endif ?>
		</ul>
	</div>
</nav>

<div class="modal fade" id="AddItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content bg-dark text-light">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Add New Menu Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="home.php">
      	<div class="modal-body">
      		<div class="form-group">
      			<label for="itemname">Menu Item Label</label>
	     		<input type="text" name="itemname" class="form-control">
      		</div>
	     	<div class="form-group">
	     		<label for="url">Page URL</label>
	     		<input type="text" name="url" class="form-control">
	     	</div>
	    </div>
	    <div class="modal-footer">
	      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	      <button type="submit" name="additem" class="btn btn-primary">Add Menu Item</button>
	    </div>
      </form>
    </div>
  </div>
</div>