<script type="text/javascript">
	var tmpData;

	/**
	 * [ajaxPaging get data-url from paginate]
	 * @param  {[type]} e [description]
	 * @return {[type]}   [description]
	 */
	function ajaxPaging(e) {
		var toUrl = $(e).attr("href");
		ajaxPage(toUrl);
		window.history.pushState("", "", toUrl);
		get_url_send_to_btn_share();
	};

	/**
	 * [ajaxPage for ajax get data]
	 * @param  {[type]} toUrl [description]
	 * @param  {[type]} e     [description]
	 * @return {[type]}       [description]
	 */
	function ajaxPage(toUrl) {
		$.ajax({
			url: 	toUrl,
			type: 	'GET',
			beforeSend: function() {
				$('.content-data').fadeOut(200);
				$('html, body').animate({scrollTop: 0}, 200);
				$('.ajax-loading').fadeIn(200);
			},
			success: function(data) {
				$('.content-data').html($(data).find('.content-data').html());
				$('.ajax-loading').fadeOut(100);
				$('.content-data').fadeIn(200);
				$('.content-data').attr('data-title', $(data).find('.content-data').data('title'));
				document.title=$(data).find('.content-data').data('title');
				tmpData = data;
				$('.lazy').lazy();
			},
			error: function(){
				var error = "</br></br><h4 class='text-center m-t-md'>Terjadi masalah penerimaan data, silahkan muat ulang halaman</h4>";
				$('.content-data').html(error);
				$('.content-data').fadeIn(400);
			}
		});	
	};

	/**
	* [clearSort description]
	* @return {[type]} [description]
	*/
	function clearFlag(param, content, title) {
		if ((param == 'desktop') && (content == 'sort')) {
			$('.ajaxDataSort').find(".fa").removeClass("fa-check");
		}
		{{-- UNTUK SORT MOBILE --}}
		else if ((param == 'mobile') && (content == 'sort')) {
			$('.sort-info').fadeOut(400);
			$('.sort-info').html('');
		}
		else if ((param == 'mobile') && (content == 'filter')) {
			$('.filter-info').fadeOut(400);
			$('.filter-info').html('');
		}
	}

	/**
	 * [ajaxCategory description]
	 * @param  {[type]} e [description]
	 * @return {[type]}   [description]
	 */
	function ajaxCategory(e) {
		type = $(e).attr('data-type').toLowerCase();
		category = $(e).data('action').toLowerCase();

		url = window.location.href;

		if (url.indexOf(type +'=' + category) == -1) {
			ajaxAddCategory(e)
		} else {
			ajaxRemoveCategory(e);
		}
		get_url_send_to_btn_share();
	}

	/**
	 * [ajaxAddCategory description]
	 * @param  {[type]} e [description]
	 * @return {[type]}   [description]
	 */
	function ajaxAddCategory(e) {
		type 	= $(e).attr("data-type").toLowerCase();
		categories 	= $(e).attr("data-action").toLowerCase();
		categories_first = $(e).attr('data-categories').toLowerCase();

		url     = window.location.href;

		toUrl	= url.replace(/(categories)[^\&]+/, '').replace(/(categories)[^\&]+/, '');
		toUrl 	= toUrl.replace(/(page)[^\&]+/, '');

		if (toUrl.indexOf("?") == -1) {
			toUrl 	= toUrl + "?categories[]=" + categories_first + "&" + type + "=" + categories;
		} else {
			toUrl 	= toUrl + "&categories[]=" + categories_first + "&" + type + "=" + categories;
		}

		// add to active category mobile to category info
		text = categories.replace(/-/g, ' ');
		total_filter_info = $('div.filter-info').children().length;
		
		// cek total filter-info
		$('div.filter-info').find('label[data-input="link"]').remove();
		if (total_filter_info < 2) {
			$('div.filter-info').append('<label class="btn btn-transparent btn-xs text-xs panel-action mb-1 text-capitalize" data-action="' + categories + '" data-input="link"> Category: ' + text + ' <i class="fa fa-times-circle"></i></label> ');
		} else {
			// total info lbh dari 1
			if (total_filter_info == 1) { 
				$('div.filter-info').append('<content class="filter-more hide"></content>');
			}
			$('.more').remove();
			$('content.filter-more').append('<label class="btn btn-transparent btn-xs text-xs panel-action mb-1 text-capitalize" data-action="' + categories + '" data-input="link"> Category: ' + text + ' <i class="fa fa-times-circle"></i></label> ');
			$('div.filter-info').append('<span class="hover-orange text-xs ml-5 more">More..</span>');
			$('.more').on('click', function(e){click_more($(this), e)});
		}

		$('ul.category-list li').find('span').html('&nbsp;&nbsp;&nbsp;&nbsp;');
		$(e).parent().find('span').html('<i class="fa fa-check text-grey-dark">');

		toUrl		= toUrl.replace('?&', '?');
		toUrl		= toUrl.replace('??', '?');
		toUrl		= toUrl.replace('&&', '&');

		toUrl		= toUrl.replace('?&&', '?&');
		toUrl		= toUrl.replace('&&&', '&');

		ajaxPage(toUrl, null);
		window.history.pushState("", "", toUrl);
	}

	/**
	 * [ajaxRemoveCategory description]
	 * @param  {[type]} e [description]
	 * @return {[type]}   [description]
	 */
	function ajaxRemoveCategory(e) {
		type 	= $(e).attr("data-action").toLowerCase();
		categories_first = $(e).attr('data-categories').toLowerCase();

		url     = window.location.href;

		toUrl	= url.replace(/(categories)[^\&]+/, '').replace(/(categories)[^\&]+/, '');
		toUrl 	= toUrl.replace(/(page)[^\&]+/, '');

		if (toUrl.indexOf("?") == -1) {
			toUrl 	= toUrl + "?categories[]=" + categories_first;
		} else {
			toUrl 	= toUrl + "&categories[]=" + categories_first;
		}

		// remove category filter-info active
		total_filter_info = $('div.filter-info').find('.panel-action').length;
		$('div.filter-info label[data-action="' + type + '"]').remove();

		if (total_filter_info <= 2) {
			$('.more').remove();
		}

		$(e).parent().find('span').html('&nbsp;&nbsp;&nbsp;&nbsp;');

		toUrl		= toUrl.replace('?&', '?');
		toUrl		= toUrl.replace('??', '?');
		toUrl		= toUrl.replace('&&', '&');

		toUrl		= toUrl.replace('?&&', '?&');
		toUrl		= toUrl.replace('&&&', '&');

		ajaxPage(toUrl, null);
		window.history.pushState("", "", toUrl);
	}

	/**
	 * [ajaxFilter description]
	 * @param  {[type]} e [description]
	 * @return {[type]}   [description]
	 */
	function ajaxFilter(e) {
		var type 	= $(e).attr("data-type").toLowerCase();
		var filter 	= $(e).attr("data-action").toLowerCase();	

		var url     = window.location.href;

		if (url.indexOf(type + "[]=" + filter) == -1) {
			ajaxAddFilter(e);
		} else {
			ajaxRemoveFilter(e);
		}
		get_url_send_to_btn_share();
	}

	/**
	 * [ajaxAddFilter description]
	 * @param  {[type]} e [description]
	 * @return {[type]}   [description]
	 */
	function ajaxAddFilter(e){
		var type 	= $(e).attr("data-type").toLowerCase();
		var filter 	= $(e).attr("data-action").toLowerCase();
		var url     = window.location.href;
		var toUrl;

		url			= url.replace(/(page=)[^\&]+/, '');

		if (url.indexOf("?") == -1) {
			toUrl 	= url + "?" + type + "[]=" + filter;
		} else {
			toUrl 	= url + "&" + type + "[]=" + filter;
		}

		// add label info filter active 
		text = filter.replace(/-/g, ' ').replace(' ', ': ');
		total_filter_info = $('div.filter-info').children().length;

		// cek total filter-info
		if (total_filter_info < 1) {
			$('div.filter-info').append('<label class="btn btn-transparent btn-xs text-sm panel-action mb-1 text-capitalize" data-action="' + filter + '" data-input="checkbox"> ' + text + ' <i class="fa fa-times-circle"></i></label> ');
		} else {
			// total info lbh dari 1
			if (total_filter_info == 1) { 
				$('div.filter-info').append('<content class="filter-more hide"></content>');
			}
			$('.more').remove();
			$('content.filter-more').append('<label class="btn btn-transparent btn-xs text-xs panel-action mb-1 text-capitalize" data-action="' + filter + '" data-input="checkbox"> ' + text + ' <i class="fa fa-times-circle"></i></label> ');
			$('div.filter-info').append('<span class="hover-orange text-xs ml-5 more">More..</span>');
			$('.more').on('click', function(e){click_more($(this), e)});
		}

		toUrl		= toUrl.replace('?&', '?');
		toUrl		= toUrl.replace('&&', '&');

		toUrl		= toUrl.replace('?&&', '?&');
		toUrl		= toUrl.replace('&&&', '&');

		ajaxPage(toUrl);

		window.history.pushState("", "", toUrl);
	}

	/**
	 * [ajaxRemoveFilter description]
	 * @param  {[type]} e [description]
	 * @return {[type]}   [description]
	 */
	function ajaxRemoveFilter(e) {
		var type 	= $(e).attr("data-type").toLowerCase();
		var filter 	= $(e).attr("data-action").toLowerCase();
		filter 		= filter.replace(" ","%20"); 

		var url     = window.location.href;
		var toRemove= type + "[]=" + filter;
		var toUrl	= url.replace(toRemove, '');

		toUrl		= toUrl.replace(/(page)[^\&]+/, '');
		toUrl		= toUrl.replace('?&', '?');

		toUrl		= toUrl.replace('?&&', '?&');
		toUrl		= toUrl.replace('&&&', '&');	

		// remove filter-info active
		total_filter_info = $('div.filter-info').find('.panel-action').length;
		$('div.filter-info label[data-action="' + filter + '"]').remove();

		if (total_filter_info <= 2) {
			$('.more').remove();
		}

		ajaxPage(toUrl);
		window.history.pushState("", "", toUrl);
	}

	/**
	 * [ajaxSorting description]
	 * @param  {[type]} e     [description]
	 * @param  {[type]} param [for mobile or desktop]
	 * @return {[type]}       [description]
	 */
	function ajaxSorting(e, param) {
		var type 	= $(e).attr("data-action").toLowerCase();
		var title 	= $(e).attr('data-title');

		var url 	= window.location.href;

		if (url.indexOf("sort=" + type) == -1) {
			ajaxAddSort(e, param, title);
		} else {
			ajaxRemoveSort(e, param, null);
		}
		get_url_send_to_btn_share();
	}

	/**
	 * [ajaxAddSort description]
	 * @param  {[type]} e     [description]
	 * @param  {[type]} param [for desktop or mobile]
	 * @return {[type]}       [description]
	 */
	function ajaxAddSort(e, param, title) {
		var type 	= $(e).attr("data-action").toLowerCase();
		var id 		= $('.sort-content');
		var url     = window.location.href;
		var toUrl	= url.replace(/(sort)[^\&]+/, '');
		toUrl 		= toUrl.replace(/(page)[^\&]+/, '');

		if (toUrl.indexOf("?") == -1) {
			toUrl 	= toUrl + "?sort=" + type;
		} else {
			toUrl 	= toUrl + "&sort=" + type;
		}	

		// add label-info sort
		$('div.sort-info').html('<label class="btn btn-transparent btn-xs text-xs panel-action mb-1 text-capitalize" data-action="' + type + '" data-input="link"> ' + title +
										' <i class="fa fa-times-circle"></i></label> ');

		$('ul.sort-list li').find('span').html('&nbsp;&nbsp;&nbsp;&nbsp;');
		$(e).parent().find('span').html('<i class="fa fa-check text-grey-dark">');

		toUrl		= toUrl.replace('?&', '?');
		toUrl		= toUrl.replace('??', '?');
		toUrl		= toUrl.replace('&&', '&');

		toUrl		= toUrl.replace('?&&', '?&');
		toUrl		= toUrl.replace('&&&', '&');

		ajaxPage(toUrl, id);
		window.history.pushState("", "", toUrl);
	}

	/**
	 * [ajaxRemoveSort description]
	 * @param  {[type]} e     [description]
	 * @param  {[type]} param [for desktop or mobile]
	 * @return {[type]}       [description]
	 */
	function ajaxRemoveSort(e, param) {
		var type 	= $(e).attr("data-action").toLowerCase();
		var id 		= $(e).parent().attr('id');

		var url     = window.location.href;
		var toUrl	= url.replace(/(sort)[^\&]+/, '');

		toUrl		= toUrl.replace('?&', '?');
		toUrl		= toUrl.replace('?&&', '?&');

		toUrl		= toUrl.replace('&&', '&');
		toUrl		= toUrl.replace('&&&', '&');

		// remove sort-info active
		$('div.sort-info label[data-action="' + type + '"]').remove();

		$(e).parent().find('span').html('&nbsp;&nbsp;&nbsp;&nbsp;');

		ajaxPage(toUrl, id);
		window.history.pushState("", "", toUrl);
	}

	/**
	 * [stop_double_event disabled event click in label collapse]
	 * @return {[type]} [description]
	 */
	function stop_double_event(e, item) {
		e.stopPropagation();
		action = item.data('action');
		input = item.data('input');

		if (input == 'link') {
			link_set = $('a[data-action=' + action + ']');
			link_set.trigger('click');
		} else {
			checkbox_set = $('input[type=checkbox][data-action=' + action + ']');
			checkbox_set.trigger('click');
		}
		item.remove();
	}

	/**
	 * [get_url_send_to_btn_share change value btn share product index]
	 * @return {[type]} [description]
	 */
	function get_url_send_to_btn_share() {
		$('.btn-copy-share').attr('data-clipboard-text', window.location.href);
		fb_link = $('.btn-facebook-share').attr('href');
		$('.btn-facebook-share').attr('href', fb_link + '&href=' +window.location.href);
	}
</script>