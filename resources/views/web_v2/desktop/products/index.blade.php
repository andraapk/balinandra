@extends('web_v2.page_templates.layout')

@section('content')
	{{-- CATEGORY --}}
	@include('web_v2.components.category-desktop')

	<section class="container mt-sm mb-sm">
		<div class="row form mr-0 ml-0">
			<div class="col-md-3 col-sm-3 hidden-xs">
				<div id="left_menu" style="position: fixed; width: 19%;">
					<div class="panel-group product-detail mt-5" id="accordion" role="tablist" aria-multiselectable="true">
						{{-- FILTER-DESKTOP --}}
						@include('web_v2.components.filter-desktop')

						<div class="panel-body p-0 mt-md">
							<div class="panel-heading pt-0 bg-white border-top-1 border-grey" role="tab" id="headingOne">
								<h4 class="panel-title mt-sm">
									Share
									<span class="pull-right mtm-5">
										<a class="share btn p-0 btn-facebook-share" target="_blank" href="{{'https://www.facebook.com/dialog/share?'.http_build_query(['app_id' => env('FACEBOOK_CLIENT_ID'), 'display' => 'popup']) }}">
											<i class="fa fa-facebook" aria-hidden="true"></i>
										</a>
<!-- 										<a class="share btn p-0 btn-copy-share grey-tooltip" href="javascript:void(0);" data-clipboard-text="" aria-label="Copied..">
											<i class="fa fa-link" aria-hidden="true"></i>
										</a> -->
									</span>
								</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-9 col-sm-9 relative page_holder">
				<div class="ajax-loading mt-lg" style="display:none;">
					<img src="/images/loading-balin.gif" />
					<h3>
						All in good time ...</br>
						<small>a moment till we're ready</small>
					</h3>
				</div>
				<div class="content-data" data-title="{{ isset($page_subtitle) ? $page_subtitle . ' - ' . $page_title : 'BALIN.ID' }}">
					@if(count($data['offer']))
						<div class="clearfix">&nbsp;</div>
						<div class="row mt-xs mb-xs pl-sm pr-sm" id="coming-soon">
							<div class="col-md-12 text-center">
								<h3 class="">COMING SOON</h3>
								<h5 class="">Please stay tuned to be the first to know when our product is ready</h5>
							</div>
						</div>
						<div class="clearfix">&nbsp;</div>
						<div class="row mt-xs mb-xs pl-sm pr-sm">
							<div class="col-md-12 text-left">
								<h4 class="">Anda Mungkin Suka</h4>
								<a class="home-product-more" href="{{route('balin.product.index', $data['linked_search'])}}">Lihat Koleksi&nbsp;<i class="fa fa-chevron-right" aria-hidden="true" style="font-size:10px;"></i></a>
							</div>
						</div>
						<div class="row mt-md mb-sm pl-sm pr-sm">
							{{-- DATA GRID CARD PRODUCT --}}
							@include('web_v2.components.card', [
								'card' 	=> $data['offer'],
						  		'col'	=> 'col-lg-4 col-md-4 col-sm-6 col-xs-6 card_product_desktop'
							])
						</div>
					@else
						<div class="row mt-xs mb-xs pl-sm pr-sm">
							<div class="col-md-6 col-lg-6 text-left">
								<p class="">Showing {{ $paging_from }} - {{ $paging_to }} of {{ $paging->total() }} results</p>
							</div>
							<div class="col-md-6 col-lg-6 text-right sort-content">
								{{-- SORT-DESKTOP --}}
								@include('web_v2.components.sort-desktop')
							</div>
						</div>
						<div class="row mt-md mb-sm pl-sm pr-sm">
							{{-- DATA GRID CARD PRODUCT --}}
							@include('web_v2.components.card', [
								'card' 	=> $data['product'],
						  		'col'	=> 'col-lg-4 col-md-4 col-sm-6 col-xs-6 card_product_desktop'
							])
						</div>
					@endif
					<div class="row mt-sm mb-sm">
						{{-- DATA AJAX PAGINATION --}}
						@include('web_v2.components.ajax_page')
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			{{-- FUNCTION AJAX PAGINATION, FILTER, SORT --}}
			@include('web_v2.plugins.ajaxPaging')
		</div>
	</section>
@stop

@section('js_plugin')
@stop

@section('js')  
	$(document).ready(function(){
		$('.page_holder').css('min-height', $('#left_menu').height());

		{{-- MENU FIXED --}}
		pos = 125;
		$(this).scroll(function() {
			h_footer = $('.divider_footer').offset().top - 55;
			if($(this).scrollTop() > 40){
				$('#left_menu').css({ top: '65px' });
				ideal_pos =  h_footer - $('#left_menu').height();
				if($(this).scrollTop() >= ideal_pos ) {
					$('#left_menu').css({ top: ideal_pos - $(this).scrollTop() + 55 + 'px' });
				}
			}else{
				$('#left_menu').css({ top: pos + 'px' });
			}
		});

		{{-- FUNCTION CHECKBOX FILTER COLOR CLICK --}}
		$('span.color-item').click(function(){
			item = $(this).parent();
			color = $(this).attr('data-color');
			checkboxcolor = $(this).parent().find('.checkbox-color');

			if (item.hasClass('active')) {
				item.removeClass('active');
				checkboxcolor.prop('checked', false);
			} else {
				item.addClass('active');
				checkboxcolor.prop('checked', true);
			}
			ajaxFilter(checkboxcolor);
		});

		{{-- FUNCTION CLEARALL FILTER DESKTOP --}}
		$('.clearall-filter').click(function(){
			// to ajax paging 
			ajaxPaging($(this));

			// remove filter active
			$('.checkbox-filter').prop('checked', false);
			$('.checkbox-color').prop('checked', false);
			$('span.color-item').parent().removeClass('active');
		});

		$('.btn-copy-share').attr('data-clipboard-text', window.location.href);
		fb_link = $('.btn-facebook-share').attr('href');
		$('.btn-facebook-share').attr('href', fb_link + '&href=' +window.location.href);

		{{-- event link pagination ajax --}}
		$('.pagination-link').bind('click', function(e){
			e.preventDefault();
			ajaxPaging($(this));
		});
	});
@stop