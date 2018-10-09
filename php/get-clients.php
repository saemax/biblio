<?
	include('config.php');

	$reqClients = $sql_connection->prepare("SELECT * FROM customers WHERE firstname LIKE :keyword OR lastname LIKE :keyword");
	$reqClients->bindValue(':keyword', '%'.$_POST['keyword'].'%');
	$reqClients->execute();

	$clients = $reqClients->fetchAll(PDO::FETCH_ASSOC);

	echo json_encode($clients);
?>