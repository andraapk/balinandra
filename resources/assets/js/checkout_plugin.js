	/**
	 * [function pilih address]
	 */
	$('.choice_address').on('change', function() {
		val = $(this).val();
		if (val == 0) {
			parsing_address();
		}
		else {
			parse_address = new Object();
			parse_address.address = $(this).find(':selected').attr('data-address');
			parse_address.phone = $(this).find(':selected').attr('data-phone');
			parse_address.receiver_name = $(this).find(':selected').attr('data-receivername');
			parse_address.zipcode = $(this).find(':selected').attr('data-zipcode');

			parsing_address(parse_address);
			$('label.warning').remove();
		}
	});

	/**
	 * [function check address to parsin function get shipping cost]
	 * 
	 * @param  e {element button step}
	 * @return check {false/true jika ada error}
	 */
	function check_address(e) {
		ch_address_id	= $(e).val();
		action 			= $(e).attr('data-action');
		
		check 			= get_shipping_cost(ch_address_id, action, 1);
		return check;
	}

	/**
	 * [function get shipping cost]
	 * 
	 * @param 	id 		{jika id address tidak ada}
	 * @param 	action 	{url yang akan dituju}
	 * @param 	flag 	{jika address sudah ada 0 merupakan tidak ada perubahan data, 1 ada perubahan data}
	 * @return 	error 	{false/true}
	 */
	function get_shipping_cost(id, action, flag) {
		ch_name 		= $('.ch_name').val();
		ch_phone		= $('.ch_phone').val();
		ch_address 		= $('.ch_address').val();
		ch_zipcode		= $('.ch_zipcode').val();
		modal_alert		= $('#alert_window');
		error 			= false;
		msg 			= '';

		// call ajax add address new
		if (id == 0) {
			$.ajax({
				url: action,
				type: 'post',
				dataType: 'json',
				async: false,
				data: {name: ch_name, phone: ch_phone, address: ch_address, zipcode: ch_zipcode},
				success: function(data) {
					if (typeof(data.type) != "undefined" && data.type !== null) {
						error = true;

						$.each(data.msg, function (index, value) {
							msg += '<p class="mb-5"> - '+ value +'</p>';
						});

						modal_alert.find('.content').html('<p class="border-bottom-1 border-grey-light">Info</p>'+msg);
						$('#alert_window').modal('show');

						setTimeout( function() {
							$('#alert_window').modal('hide');
						}, 1500);
					}
					else {
						reload_view(data, 'desktop');
						reload_view(data, 'mobile');
						parsing_address(data.address);
					}
				}
			});
		}
		// address sudah ada
		else {
			// address sudah ada tapi ubah data address
			$.ajax({
				url: action,
				type: 'post',
				dataType: 'json',
				async: false,
				data: {address_id: id, name: ch_name, phone: ch_phone, address: ch_address, zipcode: ch_zipcode, flagcheck: flag},
				success: function(data) {
					if (typeof(data.type) != "undefined" && data.type !== null) {
						error = true;

						$.each(data.msg, function (index, value) {
							msg += '<p class="mb-5"> - '+ value +'</p>';
						});

						modal_alert.find('.content').html('<p class="border-bottom-1 border-grey-light">Info</p>'+msg);
						modal_alert.modal('show');

						setTimeout( function() {
							modal_alert.modal('hide');
						}, 1500);
					}
					else {
						reload_view(data, 'desktop');
						reload_view(data, 'mobile');
						parsing_address(data.address);
					}
				}
			});	
		}

		return error;
	}

	/**
	 * [function parsing address to input form]
	 * 
	 * @param  e {hasil data respon dari json}
	 */
	function parsing_address (e) {
		ch_name = $('.ch_name');
		ch_address = $('.ch_address');
		ch_zipcode = $('.ch_zipcode');
		ch_phone = $('.ch_phone');

		if (typeof e !== 'undefined' && e != null) {
			ch_name.val(e.receiver_name);
			ch_address.val(e.address);
			ch_zipcode.val(e.zipcode);
			ch_phone.val(e.phone);
		} else {
			ch_name.val('');
			ch_address.val('');
			ch_zipcode.val('');
			ch_phone.val('');
		}
	}

	/**
	 * [function get ajax voucher]
	 * 
	 * @param  e {element input kode voucher}
	 * @return gv {return dari json}
	 */
	function get_voucher (e) {
		value = e.val();
		action = e.attr('data-action');
		return $.ajax({
			url: action,
			type: 'get',
			dataType: 'json', 
			async: false,
			data: {voucher: value},
			success: function(data) {
				return data;
			},
			fail: function(){
				return false;
			}
		});
	}

	/**
	 * [function show voucher modal]
	 * 
	 * @param  e {data dari json}
	 * @param  p {elemet input dari kode voucher}
	 */
	function show_voucher (e, p) {
		error = '';
		if (e.type=='success')
		{
			//tricks
			var trick = $('#trick-voucher').data('lock');
			if(trick == 1){
				error = true;
				$('#trick-voucher').data('lock', 0);
			}

			panel_voucher = $('.panel_form_voucher');
			modal_notif = $('.modal-notif');
			modal_notif.find('.title').children().html('');
			modal_notif.find('.content').html(e.msg);

			set_voucher_id(p);

			if (e.discount==true) {
				$('.shipping_cost').text('IDR 0');
				$('.shipping_cost').attr('data-s', 0);
				$('.shipping_cost').attr('data-v', 1);
			}

			setTimeout( function() {
				$('.loading_voucher').addClass('hide');
				panel_voucher.html('<p class="pl-sm pr-sm mb-0">'+e.msg+'</p>');
			}, 2000);

			$('#notif_window').modal('show');
		}
		else
		{
			error = true;
			setTimeout( function() {
				$('.loading_voucher').addClass('hide');
			}, 2000);
			
			$('#voucher-error').show();
		}

		return error;
	}

	/*
	*	function set voucher id
	*	@param input code object 
	*/
	function set_voucher_id (e) {
		val = e.val();
		$('.voucher_code').val(val);
	}

	function add_gift(e) {
		error = false;
		extension_id = [];
		extension_price = [];
		extension_value = [];
		extension_flag = [];
		action = e.attr('data-action');
		modal_alert		= $('#alert_window');

		$('.extension_id').each( function() {
			extension_id.push($(this).val());
		});
		$('.extension_price').each( function() {
			extension_price.push($(this).val());
		});
		$('.extension_value').each( function() {
			extension_value.push($(this).val());
		});
		$('.extension_flag').each(function() {
			extension_flag.push($(this).val());
		});

		$.ajax({
			url: action,
			type: 'post',
			dataType: 'json',
			async: false,
			data: {product_extension_id: extension_id, value: extension_value, price: extension_price, flag: extension_flag},
			success: function(data) {
				if (typeof(data.type) == 'eror') {
					error = true;
					msg = '';
					$.each(data.msg, function (index, value) {
						msg += '<p class="mb-5"> - '+ value +'</p>';
					});
				}
				else {
					error = false;
					msg = data.msg;

					reload_view(data, 'desktop');
					reload_view(data, 'mobile');
				}

				modal_alert.find('.content').html('<p class="border-bottom-1 border-grey-light">Info</p>'+msg);
				modal_alert.modal('show');

				setTimeout( function() {
					modal_alert.modal('hide');
				}, 1500);
			}
		});

		return error;
	}

	function parsing_choice_payment(data, param) {
		msg = false;
		choicepayment = param;
		action = data.attr('data-action');

		$.ajax({
			url: action,
			type: 'post',
			dataType: 'json',
			async: false,
			data: {choice_payment: choicepayment},
			success: function(data) {
				if (typeof(data.type) == 'eror') {
					msg = false;
				}
				else {
					msg = true;
				}
			}
		});

		return msg;
	}


	/**
	 * [function reload view page section review pesanan]
	 * 
	 * @param  param {element parsing from json}
	 * @param  type {desktop/mobile}
	 */
	function reload_view(param, type){
		$.ajax({
			url: param.action,
			data: {model : type },
			success: function(result) {
				tmp_div = $('#section_checkout_order_'+ type);
				tmp_div.html(result);
			}
		});
	}

	/*
	* jquery validate form
	*/
	var current = 0;
	$('label.required').append('&nbsp;<strong>*</strong>&nbsp;');
	$.validator.addMethod("page_required", function(value, element) {
		var $element = $(element)
		function match(index) {
			return current == index && $(element).parents("#sc" + (index + 1)).length;
		}
		if (match(0) || match(1) || match(2)) {
			return !this.optional(element);
		}
		return "dependency-mismatch";
	}, $.validator.messages.required)

	var v = $("#content_address").validate({
		errorClass: "warning",
		onkeyup: false,
		onfocusout: false
	});

	var checkout_form = $("#checkout-form").validate({
		errorClass: "warning",
		onkeyup: false,
		onfocusout: false,
		errorPlacement: function(error, element) {
			$('.text-error').html(error).addClass('text-regular');
		}
	});

	/**
	 * [event button step click]
	 * 
	 * @var target section yang akan dituju
	 * @var value section saat ini
	 * @var param nomor section yang akan dituju
	 * @var to_ajax ajax yg akan dipanggil
	 * @var type tipe dari button prev/next
	 * @var section nama section untuk lempar ke url
	 */
	$('.btn_step').click(function() {
		target = $(this).attr('data-target');
		param = $(this).attr('data-param');
		value = $(this).attr('data-value');
		type = $(this).attr('data-type');
		to_ajax = $(this).attr('data-event');
		section = $(this).attr('data-url');

		if (type=='next') {
			// jika form semua valid terisi
			if (param!='submit') {
				if (v.form()) {
					current = param;
					get_check = check_ajax_choice(to_ajax, $(this));
					if (get_check!=true) {
						if(target != '#sc3'){
							show_section(target, value);
							window.history.pushState("", "", section);
						}else{
							console.log(value);
							if($('#trick-voucher').data('lock') == '1'){
								if(value == '#sc2'){
									show_section(target, value);
									window.history.pushState("", "", section);
								}
							}else{
								show_section(target, value);
								window.history.pushState("", "", section);
							}
						}
					}				
				}
			}
			else {
				if (checkout_form.form()) {
					$('#checkout-form').submit();
				}
			}
		} 
		else {
			current = param;
			show_section(target, value);
			window.history.pushState("", "", section);
		}
	});

	/**
	 * [function check ajax yang akan dipanggil]
	 * 
	 * @param  ajax {check nama ajax yang akan dipanggil}
	 * @param  e {element button}
	 * @return {return false/true }
	 */
	function check_ajax_choice(ajax, e) {
		param_check = false;
		if (ajax=='address') {
			param_check = check_address(e);
		}
		else if (ajax=='voucher') {
			input_voucher = $('#content_voucher').find('.voucher_desktop');
			$('#voucher-error').hide();
			if (typeof(input_voucher.val()) != "undefined" && input_voucher.val() != '') {
				get_voucher(input_voucher).done(function(data){
					if(data != "undefined" && data != '' ){
						param_check = show_voucher(data, input_voucher);
					}
				});
			}
		}
		else if (ajax=='gift') {
			param_check = add_gift(e);
		}
		else if (ajax=='choice_payment') {
			input_choice_payment = $('input[type=radio][name=choice_payment]:checked').val();
			action = e.attr('data-action');
			if (typeof(input_choice_payment) != "undefined" && input_choice_payment != '') {
				$.ajax({
					url: action,
					type: 'post',
					dataType: 'json',
					data: {choice_payment: input_choice_payment},
					success: function(data) {
						if (typeof(data.type) == 'eror') {
							param_check = false;
						}
						else {
							param_check = true;
						}
					}
				});
				$('#choice_payment_error').hide();
			}else{
				param_check = true;
				$('#choice_payment_error').show();
			}
		}
		else if (ajax=='submit') {

		}
		return param_check;
	}

	/**
	 * [function show/hide section yang aktif]
	 * 
	 * @param  next {section yang akan dituju}
	 * @param  now {section saat ini}
	 */
	function show_section(next, now) {
		$(now).addClass('hide');
		$(next).removeClass('hide');

		$('.step-checkout').find('div[data-section="' +next+ '"]').addClass('active');
		$('.step-checkout').find('div[data-section="' +now+ '"]').removeClass('active');
	}


	<!-- payment	 -->
	$('body').on('click', '.payment-list', function (){
		$('.payment-list-img').removeClass('active');
		$(this).children().children().children().first().addClass('active');
    });	