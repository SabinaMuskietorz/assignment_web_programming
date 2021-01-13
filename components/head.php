<!--this is the header file for all the pages,
 with variables changing depending either person is logged in or not-->
<!DOCTYPE html>
<html>

<head>
	<!--style-->
	<link rel="stylesheet" href="styles.css" />
	<title><?php
	//title variable, changing for every page
		echo $title;
		//Northampton News is the title for index
		?></title>
</head>

<body>
	<header>
		<section>
			<h1>Northampton News</h1>
		</section>
	</header>
	<!--header navigation-->
	<nav>
		<ul>
			<?php
		/*if person is an admin his home website will be admin.php, where from he has access 
		to amend the articles and categories. Also the dropdown menu will be accessing the viewarticles site
		where he can view the articles by categories*/
		if(isset($_SESSION['admin'])) {
			$indexchange = 'admin.php';
			$dropdownchange = 'viewarticles.php?idcategory=';
		}
		/*else if person is normal user his home website will be localnews.php,
		where from he can view the articles and  make comments if logged in. 
		The dropdown menu will be accessing the latestarticles site to view articles from specific category */
		else {
			$indexchange = 'localnews.php';
			$dropdownchange = 'latestarticles.php?idcategory=';
		}
		//implementation of the variable to change home site
		echo '<li><a href="' .$indexchange . '">Home</a></li>';
			?>
			<li><a href="latestarticles.php">Latest Articles</a></li>
			<li><a href="#">Select Category</a>
				<ul>
					<?php
					//that's the code to loop through categories
				$stmt = $pdo->prepare('SELECT * FROM category');
				$stmt->execute();
				foreach ($stmt as $row) {
					//implementation of the variable to change drop down menu
					echo '<li><a href="' . $dropdownchange . $row['idcategory'] . '">' . $row['name'] . '</a></li>';
				}
		?>
				</ul>
			</li>
			<?php
			/* variables to change the text from log in to log out accordingly
			if person is logged in or logged out, and to change the file that 
			user is accesing by clicking on that label */
			//is person is logged in, set variable to that
			if(isset($_SESSION['loggedin'])) {
            $logfilechange = 'logout.php';
            $loglabelchange = 'Log out';
			}
			//else if person is not logged in, set variable to that
            else {
            $logfilechange = 'login.php';
            $loglabelchange = 'Log in';
			}
			//print 
			echo '<li><a href="' .$logfilechange . '">' . $loglabelchange . '</a></li>';
			?>
		</ul>
	</nav>
	<!--header random banner-->
	<img src="images/banners/randombanner.php" />
	<main>