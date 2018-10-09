<?
	include('config.php');

	$addAddress = $sql_connection->prepare("INSERT INTO addresses (address, address_bis, city, postal, country) VALUES (:address, :address_bis, :city, :postal, :country)");
	$addAddress->bindValue(':address', $_POST['address']);
	$addAddress->bindValue(':address_bis', $_POST['address_bis']);
	$addAddress->bindValue(':city', $_POST['city']);
	$addAddress->bindValue(':postal', $_POST['postal']);
	$addAddress->bindValue(':country', $_POST['country']);
	$addAddress->execute();

	$addCustomer = $sql_connection->prepare("INSERT INTO customers (firstname, lastname, addresses_id) VALUES (:firstname, :lastname, :addresses_id)");
	$addCustomer->bindValue(':firstname', $_POST['firstname']);
	$addCustomer->bindValue(':lastname', $_POST['lastname']);
	$addCustomer->bindValue(':addresses_id', $sql_connection->lastInsertId());
	$addCustomer->execute();
?>