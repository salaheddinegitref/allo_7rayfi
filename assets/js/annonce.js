$('#add-image').click(
		function() {
			// je récupére le nombre des future champs que je vais crée
			const index = +$('#widget-counter').val();

			// je récupére le prototype des entrées
			const tmpl = $('#annonce_images').data('prototype').replace(
					/__name__/g, index);

			// injecter le code au sein de la div
			$('#annonce_images').append(tmpl);

			$('#widget-counter').val(index + 1)

			// gestion du button supprimer
			handleDeleteButtons();

		});

function handleDeleteButtons() {
	$('button[data-action="delete"]').click(function() {
		const target = this.dataset.target;
		$(target).remove();
	});
}

function updateCounter() {
	const count = +$('#annonce_images div.form-group').length;

	$('#widget-counter').val(count);
}

updateCounter()
handleDeleteButtons();