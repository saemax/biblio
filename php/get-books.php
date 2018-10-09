<?
	include('config.php');

	$reqBooks = $sql_connection->prepare("SELECT * FROM books WHERE title LIKE :keyword OR author LIKE :keyword OR isbn LIKE :keyword");
	$reqBooks->bindValue(':keyword', '%'.$_POST['keyword'].'%');
	$reqBooks->execute();

	$books = $reqBooks->fetchAll(PDO::FETCH_ASSOC);

	echo json_encode($books);
?>