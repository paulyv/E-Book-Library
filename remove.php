<?php
$mysqli = mysqli_connect("localhost", "root", "", "ebooklib");

if (mysqli_connect_errno()) {
	printf("Failed to connect to db: %s\n", mysqli_connect_error());
	exit();
} else {
	$id_row = $_POST['id'];
	$sql = ("DELETE FROM ebooks WHERE id = ($id_row)");
	mysqli_query($mysqli, $sql);
}

mysqli_close($mysqli);
header('Location: index.php');
?>