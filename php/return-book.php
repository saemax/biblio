<?
	include('config.php');

	$id = $_GET['id'];

	if (ctype_digit($id)) {

		$updateReturn = $sql_connection->prepare("UPDATE borrowing SET return_date = DATE(NOW()) WHERE id = :id");
		$updateReturn->bindValue(':id', $id);
		$updateReturn->execute();

		header('Location: '.$_SERVER['HTTP_REFERER']);
	}
?>