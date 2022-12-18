(function($) {

	/**
	 * INSERT FORM
	 */
	var form  = $('#add-form'),
		list  = $('#item-list'),
	    input = form.find('#text'),
		edit_form = $('#edit-form');

		// console.log(form);
		// console.log(list);
		// console.log(input);

	// input.val('').focus();
	// $('.submit-button').hide();


	/**
	 * SETTINGS
	 */
	var animation = {
		startColor: '#00bc8c',
		endColor: list.find('li').css('backgroundColor') || '#303030',
		delay: 200
	};


	form.on('submit', function(event) {
		event.preventDefault();

		var req = $.ajax({
			url: form.attr('action'),
			type: 'POST',
			data: form.serialize(),
			dataType: 'json'
		});

		req.done(function(data) {
			if ( data.status === 'success' ) {
				$.ajax({ url: baseURL }).done(function(html) {
					var newItem = $(html).find('#item-' + data.id);

					newItem.appendTo( list )
						.css({ backgroundColor: animation.startColor })
						.delay( animation.delay )
						.animate({ backgroundColor: animation.endColor });

					input.val('').focus();
				});
			}
		});	
	});

	input.on('keypress', function(event) {
		if ( event.which === 13 ) {
			form.submit();
			return false;
		}
	});


	// /**
	//  * EDIT FORM
	//  */
	// $('#edit-form').find('#text').select();

	// //EDIT without redirect

	// $('.hide-items').hide();

	// $('.edit-link').on('click', function (event) {
	// 	event.preventDefault();

	// 	var href = $(this).attr('href'),
	// 	id = href.split('id=')[1],
	// 	item_id = $('#item-'+id),
	// 	save = $('#save-button-'+id),
	// 	remove_link = $(this).siblings('.delete-link');


	// 	$(this).hide();
	// 	$(remove_link).hide();
	// 	$(save).show();
	// 	$(item_id).attr('contenteditable', true);

	// });

	// //save without redirect


	// $('.save-button').on('click',function(event){
	// 	event.preventDefault();

	// 	//console.log('????????');

	// 	var req =$.ajax({
	// 		url:  edit_form.attr('action'),
	// 		type: 'post',
	// 		data: edit_form.serialize(),
	// 		dataType: 'json'
	//   });

	//   req.done(function () {
	// 	$.ajax({ url: baseURL }).done(function(html) {
	// 		var newItem = $(html).find('#item-' + data.id);

	// 		newItem.appendTo( list )
	// 			.css({ backgroundColor: animation.startColor })
	// 			.delay( animation.delay )
	// 			.animate({ backgroundColor: animation.endColor });

	// 		input.val('').focus();
	// 	});
	// });
	// });



	// $('#mybutt').click(function(){
	// 	var myTxt = $('.big_wrapper').html();
	// 	$.ajax({
	// 		type: 'post',
	// 		url:  'sent_data.php',
	// 		data: 'varname=' +myTxt+ '&anothervar=' +moreTxt
	//   });
	// });




	/**
	 * DELETE FORM
	 */
	$('#delete-form').on('submit', function(event) {
		return confirm('for sure?');
	});

	


}(jQuery));