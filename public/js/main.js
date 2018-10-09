$(document).ready(function() {

	var searchClientTimeout;

	$('#search-client').on('keyup', function(event) {
		var value = $(this).val();
		
		clearTimeout(searchClientTimeout);

		if (value.length > 2) {
			searchClientTimeout = setTimeout(function() {

				$.ajax({
					type: 'POST',
					url: 'php/get-clients.php',
					data: {
						keyword: value
					},
					dataType: 'JSON'
				})
				.done(function(data) {
					$('#search-client-list').html('');

					data.forEach(function(val) {
						$('<li><label><input type="radio" class="uk-radio" name="borrowing-client" value="'+val.id+'">&nbsp;'+val.firstname+' '+val.lastname+'</label></li>').appendTo($('#search-client-list'));
					});
				});

			}, 200);
		}
		else {
			$('#search-client-list').html('');
		}
	});


	var searchBookTimeout;

	$('#search-book').on('keyup', function(event) {
		var value = $(this).val();
		
		clearTimeout(searchBookTimeout);

		if (value.length > 2) {
			searchBookTimeout = setTimeout(function() {

				$.ajax({
					type: 'POST',
					url: 'php/get-books.php',
					data: {
						keyword: value
					},
					dataType: 'JSON'
				})
				.done(function(data) {
					$('#search-book-list').html('');

					data.forEach(function(val) {
						$('<li><label><input type="radio" class="uk-radio" name="borrowing-book" value="'+val.id+'">&nbsp;'+val.title+'</label></li>').appendTo($('#search-book-list'));
					});
				});

			}, 200);
		}
		else {
			$('#search-book-list').html('');
		}
	});


	$('#add-borrowing').on('click', function() {
		var data = {
			customer: $('input[name="borrowing-client"]').val(),
			book: $('input[name="borrowing-book"]').val(),
			dateFrom: $('input[name="date-from"]').val()
		};

		$.ajax({
			type: 'POST',
			url: 'php/add-borrowing.php',
			data: data
		})
		.done(function(data) {
			UIkit.modal($('#new-borrowing')[0]).hide();
		});
	});

	$('#new-borrowing').on('hidden', function() {
		$('#search-client').val('');
		$('#search-client-list').html('');
		$('#search-book').val('');
		$('#search-book-list').html('');
		$('input[name="date-from"]').val('');
	});




	$('#add-client').on('click', function() {
		var data = {
			lastname: $('[name="lastname"]').val(),
			firstname: $('[name="firstname"]').val(),
			address: $('[name="address"]').val(),
			address_bis: $('[name="address_bis"]').val(),
			city: $('[name="city"]').val(),
			postal: $('[name="postal"]').val(),
			country: $('[name="country"]').val()
		};

		$.ajax({
			type: 'POST',
			url: 'php/add-client.php',
			data: data
		})
		.done(function(data) {
			UIkit.modal($('#new-client')[0]).hide();
		});
	});

	$('#new-client').on('hidden', function() {
		$('[name="lastname"]').val('');
		$('[name="firstname"]').val('');
		$('[name="address"]').val('');
		$('[name="address_bis"]').val('');
		$('[name="city"]').val('');
		$('[name="postal"]').val('');
		$('[name="country"]').val('');
	});



	$('#add-book').on('click', function() {
		var data = {
			title: $('[name="title"]').val(),
			author: $('[name="author"]').val(),
			isbn: $('[name="isbn"]').val(),
			description: $('[name="description"]').val()
		};

		$.ajax({
			type: 'POST',
			url: 'php/add-book.php',
			data: data,
			dataType: 'JSON'
		})
		.done(function(data) {
			if (data.type === 'success') {
				$('#book-response').html('<div class="uk-alert uk-alert-success">'+data.message+'</div>');
				
				setTimeout(function() {
					UIkit.modal($('#new-book')[0]).hide();
				}, 3000);
			}
			else {
				$('#book-response').html('<div class="uk-alert uk-alert-danger">'+data.message+'</div>');
			}
		});
	});

	$('#new-book').on('hidden', function() {
		$('#book-response').html('');

		$('[name="title"]').val('');
		$('[name="author"]').val('');
		$('[name="isbn"]').val('');
		$('[name="description"]').val('');
	});

});