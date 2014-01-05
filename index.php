<!DOCTYPE html>
<html>
		<head>
		<meta charset=utf-8>
		<title>The Epic E-book Library</title>
		<link rel="stylesheet" href="css/styles.css">
		<link rel="icon" type="image/png" href="images/ebook_icon32px.gif">

		<link href='http://fonts.googleapis.com/css?family=Alegreya+Sans:300,400' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Alegreya+Sans' rel='stylesheet' type='text/css'>

		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
  		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  		<link rel="stylesheet" href="/resources/demos/style.css">
		
		</head>
	<body>
			<?php
			// Connect to Database
			
			mysql_connect("localhost", "root", "") or die("DB connection error");
			mysql_select_db("ebooklib") or die("could not select db");
			?>
			
	<div id="wrapper">
	<div id="greenline"></div>
		<div id="topic">
			THE EPIC E-BOOK LIBRARY
		</div>
		<div id="books">
		<?php
				// List books from database

			$haku = mysql_query("SELECT * FROM ebooks ORDER BY name ASC") or die(mysql_error());
			echo '<table class="booktable">';
			while ($info = mysql_fetch_array($haku)) {
			
				//echo "<td>" . $info['name'] . "<br />";
				echo "<td>";
				echo "<a href=http://192.168.1.253/ebooklib/uploads/" . $info['file'] . "><img src=http://192.168.1.253/ebooklib/uploads/photos/" . $info['cover'] . " height='200' width='160'>" . "</a>";
				//echo "<tr><td> <a href=http://192.168.1.253//ebooklib/uploads/" . $info['file'] . ">" . $info['file'] . "</a></td>";
				echo '<form action="poista.php" method="post">
				<input type="hidden" name="id" value="' . $info['id'] . '" />
				<input type="submit" name="poista" value="Remove">
				|
				<a href=http://192.168.1.253/ebooklib/uploads/' . $info['file'] . '><input type="button" value="Download"></a>
				</form></td>';
			}
			echo "</table>";
		?>
		</div>
			<!-- Supress xampp notice warnings -->
			<?php error_reporting(E_ALL ^ E_NOTICE); ?>

			<?php
			// Get values from form post and send to Database. If fields are empty echo a warning.
			$name = $_POST['name'];
			$file = $_FILES['file']['name'];
			$cover = $_FILES['photo']['name'];

			$file = preg_replace("/[^a-zA-Z0-9\.]/", "", $file);
			$file = preg_replace("/\s+/", "_", $file);

			$cover = preg_replace("/[^a-zA-Z0-9\.]/", "", $cover);
			$cover = preg_replace("/\s+/", "_", $cover);

			if ($_POST['name'] && $_FILES['file']['name']) {
				mysql_query("INSERT INTO ebooks (name, file, cover) VALUES ('$name', '$file', '$cover') ");
			} else {
					// echo 'Remember to fill all the fields';
			}
			?>

			<?php
			// Move the actual uploaded file into the right directory
				if ($_FILES['file']['name']) {
				$file = $_FILES['file']['name'];
				$file = preg_replace("/[^a-zA-Z0-9\.]/", "", $file);
				$file = preg_replace("/\s+/", "_", $file);
				$destination = "uploads/";
				move_uploaded_file($_FILES['file']['tmp_name'], $destination.$file);
			}
			?>
			<?php
			// Move the cover photo into the right directory
			if ($_FILES['photo']['name']) {
				$cover = preg_replace("/[^a-zA-Z0-9\.]/", "", $cover);
				$cover = preg_replace("/\s+/", "_", $cover);
				$destination = "uploads/photos/";
				move_uploaded_file($_FILES['photo']['tmp_name'], $destination.$cover);
				header('Location: index.php');
			}
			?>


		  <script>
  			$(function() {
    		$( "#upload" ).draggable();
  			});
  			</script>

		<div id="upload">
						<table class="uploadform">
				<h3>Add new e-books</h3>
				<form method="post" enctype="multipart/form-data">
					<tr>
						<td>Title:</td><td>
						<input type="text" name="name" style="height: 25px;" />
						</td>
					</tr>
						<tr>
						<td>Cover photo:</td><td>
						<input type="file" name="photo" />
						</td>
					</tr>
					<tr>
						<td>E-book file:</td><td>
						<input type="file" name="file" />
						</td>
					</tr>
					<tr>
						<td>
						<input type="submit" value="Upload" />
						</td>
					</tr>
				</form>
			</table>
		</div>
	</div>
	</body>

</html>
