<?
	include('config.php');

	$dateFrom = new DateTime($_POST['dateFrom']);
	$dateTo = new DateTime($_POST['dateFrom']);
	$dateTo->add((new DateInterval('P3W')));

	$checkBook = $sql_connection->prepare("SELECT COUNT(*) AS bookAvailable FROM borrowing
		WHERE books_id = :id

		AND ('".$dateFrom->format('Y-m-d')."' BETWEEN date_from AND date_to)

		OR books_id = :id 

		AND ('".$dateTo->format('Y-m-d')."' BETWEEN date_from AND date_to)
	");
	$checkBook->bindValue(':id', $_POST['book']);
	$checkBook->execute();

	$bookAvailable = $checkBook->fetch(PDO::FETCH_ASSOC);

	if ($bookAvailable['bookAvailable'] == 0) {
		$addBorrowing = $sql_connection->prepare("INSERT INTO borrowing (customers_id, books_id, date_from, date_to) VALUES (:customer, :book, :date_from, :date_to)");
		$addBorrowing->bindValue(':customer', $_POST['customer']);
		$addBorrowing->bindValue(':book', $_POST['book']);
		$addBorrowing->bindValue(':date_from', $_POST['dateFrom']);
		$addBorrowing->bindValue(':date_to', $dateTo->format('Y-m-d'));
		$addBorrowing->execute();

		echo 'success';
	}
	else {
		echo 'error';
	}
?>