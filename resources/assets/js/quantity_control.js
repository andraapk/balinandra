	var tot_qty 	= 0;
	var gtotal 		= 0;
	var item_qty 	= 0;
	var pqty 		= [];
	var flg 		= 0;
	input_flag 		= 0;

	var tot_qty_mobile = 0;

	$(function() {
		btn_number = $('.btn-number:disabled');
		btn_number_mobile = $('.btn-number-mobile');

		$('.input_number:disabled').each(function(e) {
			cid = $(this).data('cid');
			vid = $(this).data('id');
			fieldName = $(this).attr('data-name');

			list_cart = $('.list-vid[data-vid="'+vid+'"][data-cid="'+cid+'"]');
			list_cart_mobile = $('.list-vid-mobile[data-vid="'+vid+'"][data-cid="'+cid+'"]');

			input_number_mobile = list_cart_mobile.find('.input_number-mobile[data-name="'+fieldName+'"]');

			// flg = 2;
			// show_tooltip($(this), flg);
			// show_tooltip(input_number_mobile, flg);
		});
	});

/*=============================================
===============================================
EVENT BTN_NUMBER CLICK FOR DESKTOP
===============================================
=============================================*/
	$('.btn_number').on('click',function(e){
		e.preventDefault();
		$(this).parent().parent().parent().attr('action', 'javascript:void(0);');

		fieldName 				= $(this).attr('data-field');
		type      				= $(this).attr('data-type');
		page 					= $(this).attr('data-page');

		/* --== in PAGE CART ==-- */
		if (page=='cart') {
			cid 				= $(this).attr('data-cid');
			vid 				= $(this).attr('data-vid');
			list_cart_mobile 	= $('.list_vid_mobile[data-vid="'+vid+'"][data-cid="'+cid+'"]');

			input 				= $(this).parent().parent().find('.input_number').attr('data-name', fieldName);
			lab_total  			= input.parent().parent().parent().parent().parent().parent().find('.label_total');

			input_mobile 		= list_cart_mobile.find('.input_number_mobile[data-name="'+fieldName+'"]');
			lab_total_mobile 	= input_mobile.parent().parent().parent().parent().parent().find('.label_total_mobile');

			action_update 		= $(this).attr('data-action-update');
			varian_qty 			= 0;

		/* --== in PAGE PRODUCT SHOW ==-- */
		} else {
			input 				= $(this).parent().find('.input_number').attr('data-name', fieldName);
		}

		currentVal 				= parseInt(input.val());

		if (!isNaN(currentVal)) {
			if (type == 'minus') {
				// lebih besar dari total minus stock
				if (currentVal > input.attr('min')) {
					if (page == 'cart') {
						qty_minus(input, currentVal, lab_total, type);
						qty_minus_mobile(input_mobile, currentVal, lab_total_mobile, type);
						disable_btn($(this), input, vid, cid);

						varian_qty = currentVal-1;
					} else {
						qty_minus_product(input, currentVal, type);
						disable_btn_product($(this), input);
					}
				} 
				if (parseInt(input.val()) == input.attr('min')) {
					$(this).attr('disabled', true);
				}
			} else if (type == 'plus') {
				// lebih kecil dari total maximum stock
				if (currentVal < input.attr('max')) {
					if (page == 'cart') {
						qty_plus(input, currentVal, lab_total, type);
						qty_plus_mobile(input_mobile, currentVal, lab_total_mobile, type);
						disable_btn($(this), input, vid, cid);

						varian_qty = currentVal+1;
					} else {
						qty_plus_product(input, currentVal, type);
						disable_btn_product($(this), input);
					}
				}
				if (parseInt(input.val()) == input.attr('max')) {
					$(this).attr('disabled', true);
				}
			}

			if (page == 'cart') {
				send_ajax_update(varian_qty, action_update);
			}
			
		} else {
			input.val(0);
		}
	});

	$('.btn_number').mouseleave(function(e){
		e.preventDefault();
		fieldName 				= $(this).attr('data-field');
		var input 				= $(this).parent().find('.input_number').attr('data-name', fieldName);
	});

	$('.input_number').focusin(function(){
		$(this).attr('data-input-flag', 1);
		old_value 				= $(this).attr('data-oldValue', $(this).val());
		fieldName 				= $(this).attr('data-name');
	});

	$('.input_number').focusout(function() {
		$(this).attr('data-input-flag', 0);
		fieldName 				= $(this).attr('data-name');
	});

	$('.input_number').change(function(){
		check_flag = $(this).attr('data-input-flag');
		// if (check_flag==1)
		// {
			minValue 			= parseInt($(this).attr('min'));
			maxValue 			= parseInt($(this).attr('max'));
			valueCurrent 		= parseInt($(this).val());
			name 				= $(this).attr('data-name');
			page 				= $(this).attr('data-page');

			btn_minus 			= $(".btn_number[data-type='minus'][data-field='"+name+"']");
			btn_plus 			= $(".btn_number[data-type='plus'][data-field='"+name+"']");

			if (page === 'cart') {
				cid 				= $(this).attr('data-cid');
				vid 				= $(this).attr('data-id');

				list_cart 			= $('.list_vid[data-vid="'+vid+'"][data-cid="'+cid+'"]');
				list_cart_mobile 	= $('.list_vid_mobile[data-vid="'+vid+'"][data-cid="'+cid+'"]');

				lab_total  			= $(this).parent().parent().parent().parent().parent().parent().find('.label_total');

				input_mobile 		= list_cart_mobile.find('.input_number_mobile[data-name="'+name+'"]');
				lab_total_mobile 	= input_mobile.parent().parent().parent().parent().parent().find('.label_total_mobile');

				action_update 		= $(this).attr('data-action-update');
				varian_qty 			= 0;

				btn_minus 			= list_cart.find(".btn_number[data-type='minus'][data-field='"+name+"']");
				btn_plus 			= list_cart.find(".btn_number[data-type='plus'][data-field='"+name+"']");	
			} else {
				btn_minus 			= $(".btn_number[data-type='minus'][data-field='"+name+"']");
				btn_plus 			= $(".btn_number[data-type='plus'][data-field='"+name+"']");
			}

			// value sekarang lebih besar dari min stock
			if (valueCurrent > minValue) {
				type = 'minus';
				if (page === 'cart') {
					qty_change_input_cart($(this), valueCurrent, lab_total, type);
					qty_change_input_cart_mobile(input_mobile, valueCurrent, lab_total_mobile, type);
					disable_btn(btn_minus, $(this), vid, cid);
				} else {
					btn_minus.removeAttr('disabled');
					// qty_change_input_product($(this));
				}
			} else {
				if (page === 'cart') {
					disable_btn(btn_minus, $(this), vid, cid);
				} else {
					btn_minus.attr('disabled', true);
				}
			}

			// value sekarang lebih kecil dari maximun stock
			if (valueCurrent < maxValue) {
				type = 'plus';
				if (page === 'cart') {
					qty_change_input_cart($(this), valueCurrent, lab_total, type);
					qty_change_input_cart_mobile(input_mobile, valueCurrent, lab_total_mobile, type);
					disable_btn(btn_plus, $(this), vid, cid);
				} else {
					btn_plus.removeAttr('disabled');
					// qty_change_input_product($(this));
				}
				// flg = 0;
				// show_tooltip($(this), flg);
			} else {
				// flg = 2;
				// show_tooltip($(this), flg);

				if (page === 'cart') {
					disable_btn(btn_plus, $(this), vid, cid);
				} else {
					btn_plus.attr('disabled', true);
				}
			}

			if (page == 'cart') {
				send_ajax_update(parseInt($(this).val()), action_update);
			}
		// }
	});

	$(".input_number").keydown(function (e) {
		// Allow: backspace, delete, tab, escape, enter and .
		if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
			 // Allow: Ctrl+A
			(e.keyCode == 65 && e.ctrlKey === true) || 
			 // Allow: home, end, left, right
			(e.keyCode >= 35 && e.keyCode <= 39)) {
				 // let it happen, don't do anything
				 return;
		}
		// Ensure that it is a number and stop the keypress
		if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
			e.preventDefault();
		}
	});

/*=============================================
===============================================
EVENT BTN_NUMBER CLICK FOR MOBILE & TABLET
===============================================
=============================================*/
	$('.btn_number_mobile').click(function(e){
		e.preventDefault();
		fieldName 			= $(this).attr('data-field');
		type      			= $(this).attr('data-type');
		cid 				= $(this).attr('data-cid');
		vid 				= $(this).attr('data-vid');
		list_cart 			= $('.list_vid[data-vid="'+vid+'"][data-cid="'+cid+'"]');
		page 				= $(this).attr('data-page');

		input_mobile 		= $(this).parent().siblings().find('.input_number_mobile').attr('data-name', fieldName);
		input 				= list_cart.find('.input_number[data-name="'+fieldName+'"]');
		lab_total_mobile 	= input_mobile.parent().parent().parent().parent().parent().find('.label_total_mobile');
		lab_total  			= input.parent().parent().parent().parent().parent().parent().find('.label_total');

		action_update 		= $(this).attr('data-action-update');
		varian_qty 			= 0;

		currentVal = parseInt(input_mobile.val());

		if (!isNaN(currentVal)) {
			if (type == 'minus') {
				if (currentVal > input_mobile.attr('min')) {
					qty_minus_mobile(input_mobile, currentVal, lab_total_mobile, type);
					qty_minus(input, currentVal, lab_total, type);
					disable_btn($(this), input_mobile, vid, cid);

					varian_qty = currentVal-1;
				} 
				if (parseInt(input_mobile.val()) == input_mobile.attr('min')) {
					$(this).attr('disabled', true);
				}

			} else if (type == 'plus') {

				if (currentVal < input_mobile.attr('max')) {
					qty_plus_mobile(input_mobile, currentVal, lab_total_mobile, type);
					qty_plus(input, currentVal, lab_total, type);
					disable_btn($(this), input_mobile, vid, cid);	

					varian_qty = currentVal+1;
				}
				if (parseInt(input_mobile.val()) == input_mobile.attr('max')) {
					$(this).attr('disabled', true);
					// flg = 1;
					// show_tooltip(input_mobile, flg);
				}
			}
			send_ajax_update(varian_qty, action_update);
		} else {
			input_mobile.val(0);
		}
	});

	$('.input_number_mobile').focusin(function(){
		$(this).attr('data-input-flag', 1);
		old_value 		= $(this).attr('data-oldValue', $(this).val());
		fieldName 		= $(this).attr('data-name');
		cid 			= $(this).attr('data-cid');
		vid 			= $(this).attr('data-id');
		list_cart 		= $('.list_vid[data-vid="'+vid+'"][data-cid="'+cid+'"]');

		list_cart.find('.input_number[data-name="'+fieldName+'"]').attr('data-input-flag', 1); 
	   
	});
	$('.input_number_mobile').focusout(function() {
		$(this).attr('data-input-flag', 0);
		fieldName 		= $(this).attr('data-name');
		cid 			= $(this).attr('data-cid');
		vid 			= $(this).attr('data-id');
		list_cart 	 	= $('.list_vid[data-vid="'+vid+'"][data-cid="'+cid+'"]');

		list_cart.find('.input_number[data-name="'+fieldName+'"]').attr('data-input-flag', 1); 

	});

	$('.input_number_mobile').change( function() {
		check_flag = $(this).attr('data-input-flag');
		// if (check_flag==1)
		// {
			minValue 			=  parseInt($(this).attr('min'));
			maxValue 			=  parseInt($(this).attr('max'));
			valueCurrent 		= parseInt($(this).val());
			name 				= $(this).attr('data-name');

			cid 				= $(this).attr('data-cid');
			vid 				= $(this).attr('data-id');

			list_cart 			= $('.list_vid[data-vid="'+vid+'"][data-cid="'+cid+'"]');
			list_cart_mobile 	= $('.list_vid_mobile[data-vid="'+vid+'"][data-cid="'+cid+'"]');

			lab_total_mobile 	= $(this).parent().parent().parent().parent().parent().parent().find('.label_total_mobile');

			input 				= list_cart.find('.input_number[data-name="'+name+'"]');
			lab_total			= input.parent().parent().parent().parent().parent().parent().find('.label_total');

			action_update 		= $(this).attr('data-action-update');

			btn_minus 			= list_cart_mobile.find(".btn_number_mobile[data-type='minus'][data-field='"+name+"']");
			btn_plus 			= list_cart_mobile.find(".btn_number_mobile[data-type='plus'][data-field='"+name+"']");	

			if (valueCurrent > minValue) {
				type = 'minus';
				qty_change_input_cart(input, valueCurrent, lab_total, type);
				qty_change_input_cart_mobile($(this), valueCurrent, lab_total_mobile, type);
				disable_btn(btn_minus, $(this), vid, cid);
			} else {
				disable_btn(btn_minus, $(this), vid, cid);
			}

			if (valueCurrent < maxValue) {
				type = 'plus';
				qty_change_input_cart(input, valueCurrent, lab_total, type);
				qty_change_input_cart_mobile($(this), valueCurrent, lab_total_mobile, type);
				disable_btn(btn_plus, $(this), vid, cid);
				// flg = 0;
				// show_tooltip($(this), flg);
			} else {
				// flg = 2;
				// show_tooltip($(this), flg);

				disable_btn(btn_plus, $(this), vid, cid);
			}

			send_ajax_update(parseInt($(this).val()), action_update);
		// }
	});
	
	$(".input_number_mobile").keydown(function (e) {
		// Allow: backspace, delete, tab, escape, enter and .
		if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
			 // Allow: Ctrl+A
			(e.keyCode == 65 && e.ctrlKey === true) || 
			 // Allow: home, end, left, right
			(e.keyCode >= 35 && e.keyCode <= 39)) {
				 // let it happen, don't do anything
				 return;
		}
		// Ensure that it is a number and stop the keypress
		if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
			e.preventDefault();
		}
	});

/*=============================================
===============================================
FUNCTION IN PAGE PRODUCT SHOW
===============================================
=============================================*/
	function disable_btn_product(e, t) {
		minValue =  parseInt($(t).attr('min'));
		maxValue =  parseInt($(t).attr('max'));
		valueCurrent = parseInt($(t).val());
			
		name = $(e).attr('data-field');

		if(valueCurrent > minValue) {
			$(".btn_number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled');
		} else {
			$(".btn_number[data-type='minus'][data-field='"+name+"']").attr('disabled', true);
			// $(e).val($(this).attr('data-oldValue'));
		}

		if(valueCurrent < maxValue) {
			flg = 0;
			show_tooltip(t, flg);

			$(".btn_number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled');
		} else {
			flg = 2;
			show_tooltip(t, flg);

			$(".btn_number[data-type='plus'][data-field='"+name+"']").attr('disabled', true);
			// $(this).val($(this).attr('data-oldValue'));
		}
	}

	/*=============================================
		[ FUNCTION QTY CHANGE INPUT CART in PAGE PRODUCT ]
		fungsi : menghitung total 1 varian saat input number diubah
		param : object class input_number, value input_number, label total product, dan data-attribute type pada input_number
		=============================================*/
	function qty_change_input_product(e) {
		sumtotal = 0;
		total_product(e, type);
		sumtotal += sumtotal_product(e);
		$('.price_all_product').text('IDR '+number_format(sumtotal))
		e.attr('data-oldValue', e.val());
	}

	/*=============================================
	[ FUNCTION QTY PLUS PRODUCT in PAGE PRODUCT ]
	fungsi : untuk merubah value input_number tipe plus dan memanggil fungsi untuk mentotal varian dan sumtotal varians
	param : object class input_number, value input_number, dan data-attribute type pada input_number
	=============================================*/
	function qty_plus_product(e, current_val, type) {
		var old_value = 0;
		var sumtotal = 0;

		old_value = current_val;
		e.val(current_val + 1).change();
		total_product(e, type);
		sumtotal += sumtotal_product(e);

		$('.price_all_product').text('IDR '+number_format(sumtotal))
		e.attr('data-oldValue', old_value);
	}

	/*=============================================
	[ FUNCTION QTY MINUS PRODUCT in PAGE PRODUCT  ]
	fungsi : untuk merubah value input_number tipe minus dan memanggil fungsi untuk mentotal varian dan sumtotal varians
	param : object class input_number, value input_number, dan data-attribute type pada input_number
	=============================================*/
	function qty_minus_product(e, current_val, type) {
		old_value = 0;
		sumtotal = 0;

		old_value = current_val;
		e.val(current_val - 1).change();
		total_product(e, type);
		sumtotal += sumtotal_product(e);

		$('.price_all_product').text('IDR '+number_format(sumtotal))
		e.attr('data-oldValue', old_value);
	}

	/*=============================================
	[ FUNCTION TOTAL PRODUCT in PAGE PRODUCT  ]
	fungsi : untuk mentotal input_number per varians
	param : object class input_number
	=============================================*/
	function total_product(e, flag) {
		qty = parseInt(e.val());
		price = parseInt(e.attr('data-price'));
		total_price_qty = 0;
		
		total_price_qty = (price*qty);
		e.attr('data-total', total_price_qty);
	}

	/*=============================================
	[ FUNCTION SUM TOTAL PRODUCT in PAGE PRODUCT ]
	fungsi : untuk mentotal semua input_number varians
	return : jumlah total
	=============================================*/
	function sumtotal_product() {
		total_all = 0;

		$('.input_number').each( function() {
			temp = parseInt($(this).attr('data-total'));
			total_all += temp;
		});
		return total_all;
	}

	/*=============================================
	[ FUNCTION RETURN VALUE TO NULL ]
	fungsi		: untuk return 0 setelah add to cart
	parameter	: object class input_number
	=============================================*/
	function return_value_to_null()
	{
		e = $(".input_number");
		e.val(0);
		e.attr("data-total", "0");
		e.attr("data-oldValue", "0");
		$(".price_all_product").text("IDR "+number_format(0));
		$(".btn_number[data-type='minus']").attr('disabled', true);
		setTimeout( function() {
			$('#notif_window').modal('hide');
		}, 1500);
	}

/*=============================================
===============================================
FUNCTION IN PAGE CART
===============================================
=============================================*/
	function disable_btn(e, t, vid, cid) {
		minValue =  parseInt($(t).attr('min'));
		maxValue =  parseInt($(t).attr('max'));
		valueCurrent = parseInt($(t).val());
		var list_cart = $('.list_vid[data-vid="'+vid+'"][data-cid="'+cid+'"]');
		var list_cart_mobile = $('.list_vid_mobile[data-vid="'+vid+'"][data-cid="'+cid+'"]');
			
		name = $(e).attr('data-field');

		if (valueCurrent > minValue) {
			list_cart_mobile.find(".btn_number_mobile[data-type='minus'][data-field='"+name+"']").removeAttr('disabled');
			list_cart.find(".btn_number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled');
		} else {
			list_cart_mobile.find(".btn_number_mobile[data-type='minus'][data-field='"+name+"']").attr('disabled', true);
			list_cart.find(".btn_number[data-type=minus][data-field="+name+"]").attr('disabled', true);
			$(t).val(minValue);
		}
		if(valueCurrent < maxValue) {
			flg = 0;
			show_tooltip(t, flg);
			
			list_cart_mobile.find(".btn_number_mobile[data-type='plus'][data-field='"+name+"']").removeAttr('disabled');
			list_cart.find(".btn_number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled');
		} else {
			flg = 1;
			show_tooltip(t, flg);

			list_cart_mobile.find(".btn_number_mobile[data-type='plus'][data-field='"+name+"']").attr('disabled', true);
			list_cart.find(".btn_number[data-type='plus'][data-field='"+name+"']").attr('disabled', true);
			$(t).val(maxValue);
		}	
	}

	/*========== SECTION QUANTITY PLUS ==============*/
		/*=============================================
		[ FUNCTION QTY PLUS in PAGE CART for DESKTOP ]
		fungsi : untuk merubah value input_number tipe plus dan memanggil fungsi untuk mentotal varian dan sumtotal varians
		param : object class input_number, value input_number, label total product, dan data-attribute type pada input_number
		=============================================*/
		function qty_plus(e, current_val, lab_total, type) {
			var old_value = 0;
			var total_item = 0;

			old_value = current_val;
			e.val(current_val + 1).change();
			total_item = total(e, type);
			lab_total.attr('data-total', total_item);
			lab_total.find('span').text('IDR '+number_format(total_item));
			e.attr('data-oldValue', old_value);
			grand_total();
		}

		/*=============================================
		[ FUNCTION QTY PLUS MOBILE in PAGE CART for MOBILE ]
		fungsi : untuk merubah value input_number tipe plus dan memanggil fungsi untuk mentotal varian dan sumtotal varians
		param : object class input_number, value input_number, label total product mobile, dan data-attribute type pada input_number_mobile
		=============================================*/
		function qty_plus_mobile(e, current_val, lab_total_mobile, type)
		{
			var old_value = 0;
			var sumtotal_mobile = 0;

			old_value = current_val;
			e.val(current_val + 1).change();
			total_mobile(e, type);
			sumtotal_mobile += sum_total_mobile(e);
			lab_total_mobile.attr('data-subtotal', sumtotal_mobile);
			lab_total_mobile.text('IDR '+number_format(sumtotal_mobile));
			e.attr('data-oldValue', old_value);
			grand_total_mobile();
		}

	/*========== SECTION QUANTITY MINUS ==============*/
		/*=============================================
		[ FUNCTION QTY MINUS in PAGE CART for DESKTOP ]
		fungsi : untuk merubah value input_number tipe minus dan memanggil fungsi untuk mentotal varian dan sumtotal varians
		param : object class input_number, value input_number, label total product, dan data-attribute type pada input_number
		=============================================*/
		function qty_minus(e, current_val, lab_total, type)
		{
			var old_value = 0;
			var total_item = 0;

			old_value = current_val;
			e.val(current_val - 1).change();
			total_item = total(e, type);
			lab_total.attr('data-total', total_item);
			lab_total.find('span').text('IDR '+number_format(total_item));
			e.attr('data-oldValue', old_value);
			grand_total();
		}

		/*=============================================
		[ FUNCTION QTY MINUS MOBILE in PAGE CART for MOBILE ]
		fungsi : untuk merubah value input_number_mobile tipe minus dan memanggil fungsi untuk mentotal varian dan sumtotal varians
		param : object class input_number_mobile, value input_number_mobile, label total product mobile, dan data-attribute type pada input_number_mobile
		=============================================*/
		function qty_minus_mobile(e, current_val, lab_total_mobile, type) {
			var old_value = 0;
			var sumtotal_mobile = 0;

			old_value = current_val;
			e.val(current_val - 1).change();
			total_mobile(e, type);
			sumtotal_mobile += sum_total_mobile(e);
			lab_total_mobile.attr('data-subtotal', sumtotal_mobile);
			lab_total_mobile.text('IDR '+number_format(sumtotal_mobile));
			e.attr('data-oldValue', old_value);
			grand_total_mobile();
		}

	/*========== SECTION CHANGE INPUT NUMBER ==============*/
		/*=============================================
		[ FUNCTION QTY CHANGE INPUT CART in PAGE CART for DESKTOP ]
		fungsi : menghitung total 1 varian saat input number diubah
		param : object class input_number, value input_number, label total product, dan data-attribute type pada input_number
		=============================================*/
		function qty_change_input_cart(e, current_val, lab_total, type) {
			total_item = 0;
			e.val(current_val);
			total_item = total(e, type);
			lab_total.attr('data-total', total_item);
			lab_total.find('span').text('IDR '+number_format(total_item));
			e.attr('data-oldValue', e.val());
			// e.attr('value', e.val());
			grand_total();
		}

		/*=============================================
		[ FUNCTION QTY CHANGE INPUT CART MOBILE in PAGE CART for MOBILE ]
		fungsi : menghitung total 1 varian saat input number diubah
		param : object class input_number_mobile, value input_number_mobile, label total product mobile, dan data-attribute type pada input_number_mobile
		=============================================*/
		function qty_change_input_cart_mobile(e, current_val, lab_total_mobile, type) {
			sumtotal_mobile = 0;
			e.val(current_val);
			total_mobile(e, type);
			sumtotal_mobile += sum_total_mobile(e);
			lab_total_mobile.attr('data-subtotal', sumtotal_mobile);
			lab_total_mobile.text('IDR '+number_format(sumtotal_mobile));
			grand_total_mobile();
		}

	/*========== SECTION TOTAL ==============*/
		/*=============================================
		[ FUNCTION TOTAL in PAGE CART for DESKTOP ]
		fungsi : untuk menghitung harga 1 varian
		param : object class input_number
		return : harga 1 varian
		=============================================*/
		function total(e, flag)
		{
			qty = parseInt(e.val());
			price = parseInt(e.attr('data-price'));
			discount = parseInt(e.attr('data-discount'));
			total_price_qty = 0;
			
			total_price_qty = ((price-discount)*qty);
			e.attr('data-total', total_price_qty);

			return total_price_qty;
		}

		/*=============================================
		[ FUNCTION TOTAL MOBILE in PAGE CART for MOBILE ]
		fungsi : untuk menghitung harga 1 varian
		param : object class input_number_mobile
		return : harga 1 varian
		=============================================*/
		function total_mobile(e, flag)
		{
			qty = parseInt(e.val());
			price = parseInt(e.attr('data-price'));
			discount = parseInt(e.attr('data-discount'));
			total_price_qty = 0;
			
			total_price_qty = ((price-discount)*qty);
			e.attr('data-total', total_price_qty);
		}

	/*========== SECTION SUM TOTAL ==============*/
		/*=============================================
		[ FUNCTION SUM TOTAL in PAGE CART for DESKTOP ]
		fungsi : untuk menghitung harga total semua varian
		param : object class input_number
		return : harga semua varian
		=============================================*/
		function sum_total(e)
		{
			var cid = e.attr('data-cid');
			var total_all = 0;

			$('.input_number[data-cid="'+cid+'"]').each( function() {
				var temp = parseInt($(this).attr('data-total'));
				total_all += temp;
			});
			return total_all;
		}

		/*=============================================
		[ FUNCTION SUM TOTAL MOBILE in PAGE CART for MOBILE ]
		fungsi : untuk menghitung harga total semua varian
		param : object class input_number_mobile
		return : harga semua varian
		=============================================*/
		function sum_total_mobile(e)
		{
			var cid = e.attr('data-cid');
			var total_all = 0;

			$('.input_number_mobile[data-cid="'+cid+'"]').each( function() {
				var temp = parseInt($(this).attr('data-total'));
				total_all += temp;
			});
			return total_all;
		}

	/*========== SECTION GRAND TOTAL ==============*/	
		/*=============================================
		[ FUNCTION GRAND TOTAL in PAGE CART for DESKTOP ]
		fungsi : untuk menghitung harga total semua product
		=============================================*/
		function grand_total()
		{
			var grandtotal = 0;
			$('.label_total').each( function() {
				var temp = parseInt($(this).attr('data-total'));
				grandtotal += temp;
			});
			$('.grand_total').html('<strong>IDR ' +number_format(grandtotal)+'</strong>');	
		}

		/*=============================================
		[ FUNCTION GRAND TOTAL MOBILE in PAGE CART for MOBILE ]
		fungsi : untuk menghitung harga total semua product
		=============================================*/
		function grand_total_mobile() 
		{
			var grandtotal = 0;
			$('.label_total_mobile').each( function() {
				var temp = parseInt($(this).attr('data-subtotal'));
				grandtotal += temp;
			});
			$('.grand_total_mobile').text('IDR ' +number_format(grandtotal));
		}

/*=============================================
===============================================
EVENT & FUNCTION OTHER
===============================================
=============================================*/
	// ======= STOP IN CART =======
	function show_tooltip(input, flg)
	{
		if (flg == 1) {
			$(input).tooltip({delay: { "show": 1800, "hide": 8000 }, title: 'Maaf untuk ukuran ini sisa ' +input.attr('max')+' item'}).tooltip('show');
			position_input = $(input).position();
			$('.tooltip').css('top', -5 + 'px').css('z-index', '99').css('width', 90 + 'px').css('margin-left', position_input.left-130 + 'px');
			$('.tooltip-arrow').css('top', 25 + 'px');
			setTimeout( function() {
				$(input).tooltip('hide');
			}, 3000);
		}
		else if (flg == 2) {
			$(input).tooltip({delay: { "show": 1000, "hide": 1500 }, title: 'Maaf stock barang size ini habis'}).tooltip('show');
			position_input = $(input).position();
			$('.tooltip').css('top', -5 + 'px').css('z-index', '99').css('width', 90 + 'px').css('margin-left', position_input.left-130 + 'px');
			$('.tooltip-arrow').css('top', 25 + 'px');
			setTimeout( function() {
				$(input).tooltip('hide');
			}, 3000);
		} else {
			
			$(input).tooltip('destroy');
		}
	}

	/* ===FUNCTION ADD TO CART=== */
	$('.addto_cart').on('click', function(e) {
		pvarians 		= [];
		pqty 			= [];
		form_quantity 	= $('.form_addtocart');
		pslug			= $('.slug_form').val();
		pname 			= $('.name_form').val();
		count_cart 		= 0;
		check 			= 0;
		route 			= $(this).attr('data-route');

		form_quantity.attr('action', 'javascript:void(0);');
		$('.pqty').each( function() {
			var value = parseInt($(this).val());
			pqty.push($(this).val());
			check += value;
		});
		
		$('.pvarians').each( function() {
			pvarians.push($(this).val());
		});

		$.ajax({
			url: data_action1,
			type: 'POST',
			dataType:"json",
			data: {slug: pslug, product_name: pname, qty: pqty, varianids: pvarians},
			beforeSend: function() {
				$('.addto_cart').text('Ditambahkan...');
			},
			success: function(result) {
				count_cart 	= Object.keys(result.carts).length; 
				$('.addto_cart').text('Tambahkan ke Cart');
				$('.ico_cart').find('span').text(count_cart);
				$('.ico_cart').attr('href', route);

				// Get ajax refresh list cart
				$.ajax({
					url: data_action2,
					success: function(msg) {
						$('.cart_dropdown').html(msg);
						$('#notif_window').modal('show');

						setTimeout( function() {
							$('#notif_window').modal('hide');
						}, 1500);
						// return_value_to_null('.input_number');
					}
				});

			}
		});
	});

	/**
	 * [send_ajax_update cart on page cart index]
	 * @param  {[type]} item_qty [description]
	 * @param  {[type]} action   [description]
	 * @return {[type]}          [description]
	 */
	function send_ajax_update(item_qty, action) {
		return $.ajax({
			url: action,
			type: 'POST',
			dataType:"json",
			async: true,
			data: {qty: item_qty},
			success: function(result) {
				count_cart 	= Object.keys(result.carts).length; 
				$('.cart-count').find('strong').html(count_cart);
				if (count_cart == 0){
					$('.cart-count').removeClass('bg-orange text-white');
				}
				$.ajax({
					url: data_action2,
					beforeSend: function() {
						// $('chart-dropdown').html("<img src='/Balin/web/image/loading.gif'/>");
					},
					success: function(msg) {
						$('.cart_dropdown').html(msg);
					},
				   	fail: function(){
				   		location.reload();
				   	}					
				});
			},
		   	fail: function(){
		   		location.reload();
		   	}
		});
	}

	/**
	 * [number_format for money]
	 * @param  {[type]} number        [description]
	 * @param  {[type]} decimals      [description]
	 * @param  {[type]} dec_point     [description]
	 * @param  {[type]} thousands_sep [description]
	 * @return {[type]}               [description]
	 */
	function number_format(number, decimals, dec_point, thousands_sep) {
	  number = (number + '').replace(/[^0-9+\-Ee.]/g, '');

	  var n = !isFinite(+number) ? 0 : +number,
			prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
			sep = (typeof thousands_sep === 'undefined') ? '.' : thousands_sep,
			dec = (typeof dec_point === 'undefined') ? ',' : dec_point,
			s = '',
			toFixedFix = function (n, prec) {
				var k = Math.pow(10, prec);
				return '' + (Math.round(n * k) / k).toFixed(prec);
			};

	  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
		s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
		if (s[0].length > 3) {
			s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
		}

		if ((s[1] || '').length < prec) {
			s[1] = s[1] || '';
			s[1] += new Array(prec - s[1].length + 1).join('0');
		}
		return s.join(dec);
	}




	/**
	 * New function cart items
	 */
	
	/**
	 * [addStock in cart]
	 * @param {[type]} current [description]
	 * @param {[type]} stock   [description]
	 */
	function addStock (current, stock) {
		if (current < stock) {
			return current + 1;
		} else {
			return current;
		}
	}

	/**
	 * [removeStock in cart]
	 * @param  {[type]} current [description]
	 * @return {[type]}         [description]
	 */
	function removeStock (current) {
		if (current > 0) {
			return current - 1;
		} else {
			return current;
		}
	}

	/**
	 * [button add +1 item in cart]
	 * @param  {[type]} ) {		prev      [description]
	 * @return {[type]}   [description]
	 */
	$(document).on('click', '.qty-plus', function() {
		$('.loading').removeClass('hidden');
		
		prev = parseInt($(this).parent().find('.qty').text());
		stock = parseInt($(this).parent().find('.qty').data('stock'));
		current = addStock(prev, stock);
		$(this).parent().find('.qty').text(current);
		$(this).parent().find('.qty').trigger('change');

		if (current < stock) {
			if (current > 0 ) {
				$(this).siblings('.qty-minus').removeClass('not-active');
			}
		} else {
			$(this).addClass('not-active');
		}
	});

	/**
	 * [button -1 item size in cart]
	 * @param  {[type]} ) {		prev      [description]
	 * @return {[type]}   [description]
	 */
	$(document).on('click', '.qty-minus', function() {
		$('.loading').removeClass('hidden');

		prev = parseInt($(this).parent().find('.qty').text());
		stock = parseInt($(this).parent().find('.qty').data('stock'));
		current = removeStock(prev);
		$(this).parent().find('.qty').text(current);
		$(this).parent().find('.qty').trigger('change');

		if (current > 0) {
			if (current < stock) {
				$(this).siblings('.qty-plus').removeClass('not-active');
			}
		} else {
			$(this).addClass('not-active');
		}
	});

	/**
	 * [check label qty on change and get total price]
	 * @param  {[type]} ) {		total     [description]
	 * @return {[type]}   [description]
	 */
	$(document).on('change', '.qty', function() {
		total = 0;
		total_mobile = 0;
		price = $(this).data('price');
		discount = $(this).data('discount');
		action = $(this).data('action');
		row_varian_desktop = $(this).parent().parent();
		row_varian_mobile = $(this).parent().parent();
		total = total + (parseInt($(this).text()) * (price - discount));

		row_varian_mobile.parent().find('.list-varian').each(function() {
			qty = $(this).find('span.qty');
			qty = parseInt(qty.text());
			total_mobile = total_mobile + (qty * (price-discount));
		});

		send_ajax_update(parseInt($(this).text()), action).done(function(data){
			var url = window.location.href;
			$.ajax({
			   	url: url,
			   	type:'GET',
			   	success: function(data){
			    	$('#table-cart').html($(data).find('#table-cart').html());
			    	$('.loading').addClass('hidden');
			   	},
			   	fail: function(){
			   		location.reload();
			   	}
			});	
		});			

	});

	/**
	 * [check total per all item]
	 * @param  {[type]} ) {		total_all [description]
	 * @return {[type]}   [description]
	 */
	$(document).on('change', '.total_per_pieces', function() {
		total_all = 0;
		$('.total_per_pieces').each( function() {
			total_all = total_all + parseInt($(this).data('total-piece'));
		});
		$('.total_all').text('IDR ' + number_format(total_all));
	});