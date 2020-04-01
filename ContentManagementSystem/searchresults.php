<?php
	require('db_connect.php');

	// Sets the initial page to 1 upon initial load
	if(!isset($_GET['page'])){
		$_GET['page'] = 1;
	}
	else{
		$page = $_GET['page'];
	}

	$searchString = filter_input(INPUT_GET, 'searchbar', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$page = 1;
	$results_per_page = 5;
	$offset = ($_GET['page'] - 1) * $results_per_page;

	//All movies matching search query -- for pagination purposes
	$totalMovies = "SELECT MovieTitle, MovieID FROM Movie WHERE UPPER(MovieTitle) LIKE '%" . strtoupper($searchString) . "%'";

	//Limit of 5 movies, to show per page
	$getMovies = "SELECT MovieTitle, MovieID FROM Movie WHERE UPPER(MovieTitle) LIKE '%" . strtoupper($searchString) . "%' LIMIT " . $offset . ", " . $results_per_page;
	$getReviews = "SELECT Title, ReviewID FROM Review WHERE Title LIKE '" . $searchString . "%'";

	$totalStatement = $db->prepare($totalMovies);
	$movieStatement = $db->prepare($getMovies);
	$reviewStatement = $db->prepare($getReviews);

	$totalStatement->execute();
	$movieStatement->execute();
	$reviewStatement->execute();

	$number_of_results = $totalStatement->rowCount();
	$number_of_pages = ceil($number_of_results/$results_per_page);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Search results for '<?= $searchString ?>'</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body class="bg-dark text-light">
	<?php include('navbar.php'); ?>

	<h2>Movie Results for '<?= $searchString ?>'</h2>

	<!-- Table of Movie Results -->
	<?php if($movieStatement->rowCount() === 0): ?>
		<h4>There are no movies that match '<?= $searchString ?>'</h4>
	<?php else: ?>
		<table class="table table-striped table-hover table-dark">
			<tbody>
				<?php while($row = $movieStatement->fetch()): ?>
					<tr>
						<td><a class="text-primary" href="fullmoviedescription.php?id=<?= $row['MovieID'] ?>"><?= $row['MovieTitle'] ?></a></td>
					</tr>
				<?php endwhile ?>
			</tbody>
		</table>
	<?php endif ?>

	<!-- Pagination Navigation -->
	<?php if($number_of_pages > 1): ?>
		<div class="d-flex justify-content-center">
			<nav aria-label="Page Navigation">
			  <ul class="pagination bg-dark m-auto p-auto">
			    <?php for($page = 1; $page <= $number_of_pages; $page++): ?>
			    	<li class="page-item"><a class="page-link" href="searchresults.php?searchbar=<?= $searchString ?>&page=<?= $page ?>"><?= $page ?></a></li>
			    <?php endfor ?>
			  </ul>
			</nav>
		</div>
	<?php endif ?>

	<!-- Table of Review Results -->
	<h2>Review results for '<?= $searchString ?>'</h2>

	<?php if($reviewStatement->rowCount() === 0): ?>
		<h4>There are no reviews that match '<?= $searchString ?>'</h4>
	<?php else: ?>
		<table class="table table-hover table-dark">
			<tbody>
				<?php while($row = $reviewStatement->fetch()): ?>
					<tr>
						<td><?= $row['Title'] ?></td>
					</tr>
				<?php endwhile ?>
			</tbody>
		</table>
	<?php endif ?>
</body>
</html>