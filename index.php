<?
	include('php/config.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Biblio App</title>
		<meta charset="utf-8">

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.17/css/uikit.min.css" />
	</head>
	<body>
		<div class="uk-container uk-margin-top">
			<div class="uk-width-1-1">
				<button class="uk-button uk-button-default" uk-toggle="target: #new-borrowing">Nouvel emprunt</button>
				<button class="uk-button uk-button-default" uk-toggle="target: #new-client">Ajouter un client</button>
				<button class="uk-button uk-button-default" uk-toggle="target: #new-book">Ajouter un livre</button>
			</div>

			<h2>Retour du jour</h2>
			<table class="uk-table uk-table-border">
				<thead>
					<tr>
						<th>Titre</th>
						<th>Auteur</th>
						<th>Client</th>
						<th>Retard</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
<?
					$reqTodayReturns = $sql_connection->prepare("SELECT borrowing.id AS borrowing_id, borrowing.date_to, customers.firstname, customers.lastname, books.title, books.author FROM borrowing

						INNER JOIN customers ON borrowing.customers_id = customers.id

						INNER JOIN books ON borrowing.books_id = books.id

						WHERE date_to <= DATE(NOW()) AND return_date IS NULL");

					$reqTodayReturns->execute();
					$todayReturns = $reqTodayReturns->fetchAll(PDO::FETCH_ASSOC);

					foreach($todayReturns as $val) {
						$today = new DateTime();
						$dateto = new DateTime($val['date_to']);
						$diff = $dateto->diff($today)->format('%a');
?>
						<tr class="<? echo $diff > 5 ? 'uk-alert-danger' : ($diff > 2 ? 'uk-alert-warning' : 'uk-alert-success'); ?>">
							<td><? echo $val['title']; ?></td>
							<td><? echo $val['author']; ?></td>
							<td><? echo $val['lastname'].' '.$val['firstname']; ?></td>
							<td><? echo $diff > 1 ? $diff.' jours' : $diff.' jour'; ?></td>
							<td><a href="php/return-book.php?id=<? echo $val['borrowing_id']; ?>" class="uk-button uk-button-default uk-button-small"><span uk-icon="check"></span></a></td>
						</tr>
<?
					}
?>
				</tbody>
			</table>
		</div>

		<div id="new-borrowing" uk-modal>
			<div class="uk-modal-dialog uk-modal-body">
				<h2 class="uk-modal-title">Nouvel emprunt</h2>

				<div class="uk-margin">
					<input id="search-client" class="uk-input" type="text" placeholder="Rechercher un client">
					<ul id="search-client-list" class="uk-list uk-list-divider"></ul>
				</div>

				<div class="uk-margin">
					<input id="search-book" class="uk-input" type="text" placeholder="Rechercher un livre">
					<ul id="search-book-list" class="uk-list uk-list-divider"></ul>
				</div>

				<div class="uk-margin">
					<input type="date" class="uk-input" name="date-from">
				</div>

				<p class="uk-text-right">
					<button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
					<button id="add-borrowing" class="uk-button uk-button-primary" type="button">Save</button>
				</p>
			</div>
		</div>

		<div id="new-client" uk-modal>
			<div class="uk-modal-dialog uk-modal-body">
				<h2 class="uk-modal-title">Nouveau client</h2>

				<div class="uk-margin">
					<input type="text" name="lastname" class="uk-input" placeholder="Nom" required>
				</div>

				<div class="uk-margin">
					<input type="text" name="firstname" class="uk-input" placeholder="Prénom" required>
				</div>

				<div class="uk-margin">
					<input type="text" name="address" class="uk-input" placeholder="Adresse" required>
				</div>

				<div class="uk-margin">
					<input type="text" name="address_bis" class="uk-input" placeholder="Complément d'adresse">
				</div>

				<div class="uk-margin">
					<input type="text" name="city" class="uk-input" placeholder="Ville" required>
				</div>

				<div class="uk-margin">
					<input type="text" name="postal" class="uk-input" placeholder="Code postal" required>
				</div>

				<div class="uk-margin">
					<select name="country" class="uk-select" placeholder="Pays" required>
						<option value="CH">Suisse</option>
						<option value="FR">France</option>
					</select>
				</div>

				<p class="uk-text-right">
					<button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
					<button id="add-client" class="uk-button uk-button-primary" type="button">Save</button>
				</p>
			</div>
		</div>

		<div id="new-book" uk-modal>
			<div class="uk-modal-dialog uk-modal-body">
				<h2 class="uk-modal-title">Nouveau livre</h2>

				<div class="uk-margin">
					<input type="text" name="title" class="uk-input" placeholder="Titre" required>
				</div>

				<div class="uk-margin">
					<input type="text" name="author" class="uk-input" placeholder="Auteur" required>
				</div>

				<div class="uk-margin">
					<input type="text" name="isbn" class="uk-input" placeholder="ISBN" required>
				</div>

				<div class="uk-margin">
					<textarea name="description" class="uk-textarea" placeholder="Description"></textarea>
				</div>

				<div id="book-response"></div>

				<p class="uk-text-right">
					<button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
					<button id="add-book" class="uk-button uk-button-primary" type="button">Save</button>
				</p>
			</div>
		</div>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.17/js/uikit.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.17/js/uikit-icons.min.js"></script>

		<script src="public/js/main.js"></script>
	</body>
</html>