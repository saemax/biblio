<?
	include('config.php');

	$title = trim($_POST['title']);
	$author = trim($_POST['author']);
	$description = $_POST['description'];
	$isbn = trim($_POST['isbn']);

	if (!empty($title) && !empty($author) && !empty($isbn)) {
		$addBook = $sql_connection->prepare("INSERT INTO books (title, author, description, isbn, state) VALUES (:title, :author, :description, :isbn, 1)");
		$addBook->bindValue(':title', $_POST['title']);
		$addBook->bindValue(':author', $_POST['author']);
		$addBook->bindValue(':description', $_POST['description']);
		$addBook->bindValue(':isbn', $_POST['isbn']);
		$addBook->execute();

		echo json_encode(array('type' => 'success', 'message' => 'Votre livre a bien été ajouté !'));
	}
	else {
		echo json_encode(array('type' => 'error', 'message' => 'Certains champs sont vides.'));
	}
?>