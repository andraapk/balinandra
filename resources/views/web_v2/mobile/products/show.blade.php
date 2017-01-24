@extends('web_v2.page_templates.layout')

@section('content')
		<section class="container mt-0 mb-lg">
		<div class="row">
			<!-- SECTION IMAGE SLIDER PRODUCT -->
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-center">
				<div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails border-1 border-solid border-grey-light hidden-xs" style="width:100%;">
					<a class="img-large" href="{{ isset($data['product']['data']['data'][0]['image_lg']) ? $data['product']['data']['data'][0]['image_lg'] : '' }}" >
						<img class="img img-responsive text-center canvas-image"  src="{{ isset($data['product']['data']['data'][0]['image_lg']) ? $data['product']['data']['data'][0]['image_lg'] : '' }}" style="width:100%">
					</a>
				</div>
				<div class="row mb-lg">
					<div class="col-md-12 col-lg-12 col-sm-12 hidden-xs mt-xs">
						@if (count($data['product']['data']['data'][0]['images']) != 0)
							<div class="carousel-stacked gallery-product">
								@foreach ($data['product']['data']['data'][0]['images'] as $i => $img)
									<div class="item item-carousel">
										<a href="{{ $img['image_lg'] }}" data-standard="{{ $img['image_lg'] }}">
											<img class="img img-responsive canvasSource pull-left" id="canvasSource{{ $i }}" src="{{ $img['image_lg'] }}" alt="" style="width:70px">
										</a>
									</div>
								@endforeach
							</div>
						@else
							<div class="carousel-stacked gallery-product">
								<div class="item item-carousel">
									<a href="{{ $data['product']['data']['data'][0]['image_lg'] }}" data-standard="{{ $data['product']['data']['data'][0]['image_lg'] }}">
										<img class="img img-responsive canvasSource pull-left" src="{{ isset($data['product']['data']['data'][0]['image_lg']) ? $data['product']['data']['data'][0]['image_lg'] : '' }}" alt="{{ $data['product']['data']['data'][0]['name'] }}" style="width:70px">
									</a>
								</div>
							</div>
						@endif
					</div>
					<div class="col-xs-12 hidden-sm hidden-md hidden-lg">
						<div class="row">
							<div class="col-xs-12">
								<div class="carousel-single gallery-product">
									@if (count($data['product']['data']['data'][0]['images']) != 0)
										@foreach ($data['product']['data']['data'][0]['images'] as $i => $img)
											<div class="item item-carousel">
												<a href="{{ $img['image_lg'] }}" data-standard="{{ $img['image_lg'] }}">
													<img class="img img-responsive canvasSource" id="canvasSource{{ $i }}" src="{{ $img['image_lg'] }}" alt="" style="width:100%;">
												</a>
											</div>
										@endforeach
									@else
										<div class="item item-carousel">
											<a href="{{ $data['product']['data']['data'][0]['image_lg'] }}" data-standard="{{ $data['product']['data']['data'][0]['image_lg'] }}">
												<img class="img img-responsive canvasSource" src="{{ isset($data['product']['data']['data'][0]['image_lg']) ? $data['product']['data']['data'][0]['image_lg'] : 'http://drive.thunder.id/file/public/4/1/2015/12/06/05/avani-short-front.jpg' }}" alt="" style="width:100%;">
											</a>
										</div>									
									@endif
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
			<!-- <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">&nbsp;</div> -->
			<!-- END SECTION IMAGE SLIDER PRODUCT -->

			<!-- SECTION INFO DETAIL PRODUCT -->
			<div class="col-xs-12 col-sm-8 col-md-7 col-lg-7">
				<!-- SECTION DESCRIPTION PRODUCT -->
				<div class="row mb-lg">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<h4 class="mt-0 mb-0">{{ $data['product']['data']['data'][0]['name'] }}</h4>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
						<p class="mb-0">
							@foreach($data['product']['data']['data'][0]['categories'] as $key => $value)
								{{ucwords(str_replace('-', ' ', $value['name']))}}
							@endforeach
						</p>
						<p class="card-text mt-0">
							@if ($data['product']['data']['data'][0]['promo_price'] != 0)
								<del>@money_indo($data['product']['data']['data'][0]['price'])</del>
								<span class="text-orange">@money_indo($data['product']['data']['data'][0]['promo_price'])</span>
							@else
								<span>@money_indo($data['product']['data']['data'][0]['price'])</span>
							@endif
						</p>
					</div>
					@if ($data['product']['data']['data'][0]['promo_price'] != 0 && (!is_null($data['product']['data']['data'][0]['price_end']) && \Carbon\Carbon::parse($data['product']['data']['data'][0]['price_end'])->format('Y-m-d') == \Carbon\Carbon::now()->format('Y-m-d') ))
						<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
							<p class="mb-0">Time left to buy</p>
							<h3 class="text-orange mt-0 countdown" data-seconds-left={{\Carbon\Carbon::now()->diffInSeconds(\Carbon\Carbon::parse($data['product']['data']['data'][0]['price_end']))}}></h3>
						</div>					
					@endif
				</div>


				<!-- START SECTION TRANSACTION MENU -->
				<div class="row">
					<div class="col-md-12">
						<div class="panel-group product-detail" id="accordion" role="tablist" aria-multiselectable="true">

					<!-- START SECTION DESCRIPTION -->
							<div class="panel panel-default mt-0">
								<div class="panel-heading" role="tab" id="headingOne">
									<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
										<h4 class="panel-title">
											Description
											<span class="pull-right">
												<i class="fa fa-angle-right " aria-hidden="true"></i>
											</span>
										</h4>
									</a>
								</div>
								<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
									<div class="panel-body">
										<?php  $description = isset($data['product']['data']['data'][0]['description']) ? json_decode($data['product']['data']['data'][0]['description'], true) : ['description' => '', 'fit' => '']; ?>
										{!! $description['description'] !!}
									</div>
								</div>
							</div>
					<!-- END SECTION DESCRIPTION -->

					<!-- START SECTION FIT & MEASUREMENT -->
							<div class="panel panel-default mt-0">
								<div class="panel-heading" role="tab" id="headingTwo">
									<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
										<h4 class="panel-title">
											Fit & Measurement
											<span class="pull-right">
												<i class="fa fa-angle-right " aria-hidden="true"></i>
											</span>											
										</h4>
									</a>
								</div>
								<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
									<div class="panel-body img-fit">
										{!! $description['fit'] !!}
									</div>
								</div>
							</div>
					<!-- END SECTION FIT & MEASUREMENT-->

					@if(isset($description['care']))
					<!-- START SECTION CARE-->
							<div class="panel panel-default mt-0">
								<div class="panel-heading" role="tab" id="headingThree">
									<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
										<h4 class="panel-title">
											Care
											<span class="pull-right">
												<i class="fa fa-angle-right " aria-hidden="true"></i>
											</span>											
										</h4>
									</a>
								</div>
								<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
									<div class="panel-body img-fit">
										{!! $description['care'] !!}
									</div>
								</div>
							</div>
					<!-- END SECTION CARE-->
					@endif
					<!-- START SECTION SIZE-->
							<div class="panel panel-default mt-0">
								<div class="panel-heading" role="tab" id="headingFour">
									<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
										<h4 class="panel-title">
											Size
											<span class="pull-right active">
												<i class="fa fa-angle-right " aria-hidden="true"></i>
											</span>											
										</h4>
									</a>
								</div>
								<div id="collapseFour" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFour">
									<div id="size-section" class="panel-body">
										@foreach($data['product']['data']['data'][0]['varians'] as $varian)
											<div class="row {{ end($data['product']['data']['data'][0]['varians']) != $varian ? 'mb-sm' : '' }}">
												<div class="col-md-12 col-sm-12 col-xs-12 pl-sm pr-sm text-left">
													<div class="col-xs-9 col-sm-9 col-md-10">
													{{$varian['size']}}
													</div>
													@if($varian['current_stock'] > 0)
														<div class="col-xs-3 col-sm-3 col-md-2 text-center" data-sku="{{ $varian['sku'] }}">	
															<a href="javascript:void(0);" class="pull-left cart-remove not-active">
																<strong>-</strong>
															</a> 
															<span data-id="{{ $varian['id'] }}""  data-stock="{{$varian['current_stock']}}" class="cart">0</span>
															<a href="javascript:void(0);" class="pull-right cart-add"> 
																<strong>+</strong>
															</a>
														</div>
													@else
														<div class="col-xs-3 col-sm-3 col-md-2 text-center">
															Habis	
														</div>
													@endif
												</div>
											</div>
										@endforeach
										<div class="col-md-12 pt-xs text-right">
											<small>
												Not Sure? <a class="hover-orange" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Check Fit & Measurement</a>
											</small>
										</div>											
									</div>
								</div>
							</div>
					<!-- END SECTION SIZE-->

					<!-- START SECTION TOTAL -->
							<div class="panel panel-default mt-0">
								<div class="panel-heading" role="tab" id="headingOne">
									<h4 class="panel-title">
										Total (<span id="items">0</span>)
										<span class="pull-right">
											IDR <span class="total">0</span>
										</span>
									</h4>
								</div>
							</div>
					<!-- START SECTION TOTAL -->

					<!-- START SHARE-->
							<div class="panel panel-default mt-0">
								<div class="panel-heading" role="tab" id="headingOne" style="background-color: white;padding-bottom:15px;">
									<h4 class="panel-title">
										Share
										<span class="pull-right" style="margin-bottom: 10px;">
											<a class="share" target="_blank" href="{{'https://www.facebook.com/dialog/share?'.http_build_query(['app_id' => env('FACEBOOK_CLIENT_ID'),'href' => route('balin.product.show', $data['product']['data']['data'][0]['slug']), 'display' => 'popup']) }}">
												<i class="fa fa-facebook" aria-hidden="true"></i>
											</a>
<!-- 											<a class="share btn p-0 btn-copy-share grey-tooltip" href="javascript:void(0);" data-clipboard-text="" aria-label="Copied..">
												<i class="fa fa-link" aria-hidden="true"></i>
											</a> -->
										</span>
									</h4>
								</div>
							</div>
					<!-- END SHARE -->	

						</div>
					</div>
				</div>
				<!-- END SECTION TRANSACTION MENU -->

				<div class="row">
					<div class="col-md-12 text-right">
						<p id="warning" class="pull-left warning hidden" style="font-size: 12px !important;">* Please select size!</p>
						<a href="javascript:void(0);" class="btn btn-orange buy pl-sm pr-sm">
							<i class="fa fa-shopping-bag" aria-hidden="true"></i>
							&nbsp;Buy Now
						</a>
					</div>
				</div>

			</div>
			<!-- END SECTION INFO DETAIL PRODUCT -->
		</div>

		<!-- SECTION RELATED PRODUCT -->
		<div class="row">
			<div class="container text-left mt-xxl mb-sm">
				<h3 class="text-uppercase m-0">PILIHAN LAIN</h3>
			</div>
		</div>
		<div class="row row-card">	
			@include('web_v2.components.card', [
				'card' 	=> $data['related'],
				'col'	=> 'col-md-3 col-sm-3 col-xs-6' 
			])
		</div>
		<!-- END SECTION RELATED PRODUCT -->

		<div class="row">
			<div class="container text-center mt-xxl mb-sm hidden-sm hidden-md hidden-lg">
				<a href="{{route('balin.product.index', ['categories' => [$data['type']]])}}" class="btn btn-orange buy pl-xl pr-xl">
					Lihat Semua
				</a>
			</div>
		</div>
	</section>
@stop

@section('js_plugin')
	@include('web_v2.plugins.owlCarousel')
	@include('web_v2.plugins.countdown')
@stop

@section('js')
	data_action1 = '{{ route('balin.cart.store', $data['product']['data']['data'][0]['slug']) }}';
	data_action2 = '{{ route('balin.cart.list') }}';

	$('.panel').on('hide.bs.collapse', function (e) {
		$(e.currentTarget).find('span').removeClass('active');
	})
	$('.panel').on('show.bs.collapse', function (e) {
		$(e.currentTarget).find('span').addClass('active');
	})


	$('.buy').click(function() {
		<!-- check if busy -->
		if($(this).children().hasClass('fa-pulse')){
			return false;
		}	

		<!-- get data -->
		var base_url = '{{ route('balin.cart.store', ['slug' => $data['product']['data']['data'][0]['slug']]) }}';
		var arr_var_id = [];
		var arr_qty = [];
		var var_ids = '';
		var qty = '';

		$('.cart').each(function() {
			if($(this).text() != 0){
				var_ids = var_ids + 'varianids[]=' + $(this).data('id') + '&';
				qty = qty + 'qty[]=' + $(this).text() + '&';
			}
		});

		<!-- save cart -->
		if(var_ids != '')
		{
			$('#warning').addClass('hidden');
			<!-- ui -->
			$('.cart-add').addClass('not-active');
			$('.cart-remove').addClass('not-active');
			$(this).children().removeClass('fa-shopping-bag');
			$(this).children().addClass('fa-spinner fa-pulse');

			<!-- check if user logged in -->
			var usr = '{{ Session::get('me') }}';
			usr = 'DELETE ME';
			if(usr == ''){
				window.location.replace('{{ route('balin.get.login') }}');
			}else{	
				<!-- send -->
				var query = var_ids + qty;
				var result = $.ajax({
				   	url: '{{ route('balin.cart.store', ['slug' => $data['product']['data']['data'][0]['slug']]) }}',
				   	type:'GET',
				   	data: query,
				   	success: function(data){
				   		<!-- update page -->
						var url = window.location.href;
						$.ajax({
						   	url: url,
						   	type:'GET',
						   	success: function(data){
						    	$('#size-section').html($(data).find('#size-section').html());
						    	$('#cart-desktop').html($(data).find('#cart-desktop').html());
						    	$('#cart-mobile').html($(data).find('#cart-mobile').html());

								<!-- reset ui -->
								$('.buy').children().removeClass('fa-spinner fa-pulse');
								$('.buy').children().addClass('fa-shopping-bag');

								$('.cart-remove').addClass('not-active');
								$('.cart-add').removeClass('not-active');

								$('.total').text(0);
								$('.dropdown-menu').toggle({'display': 'block'});

								setMobileCart();
								$('#modal-cart').modal('show');
						   	},
						   	error: function(){
								location.reload();
						   	},
						});
				   	},
				   	error: function(){
						<!-- reset ui -->
						console.log('error');
						$('.buy').children().removeClass('fa-spinner fa-pulse');
						$('.buy').children().addClass('fa-shopping-bag');
				   	}
				});
			}
		}else{
			$('#warning').removeClass('hidden');
		}
	})		
	$(document).on('click', '.cart-add', function(){
		var prev = parseInt($(this).parent().find('.cart').text());
		var stock = parseInt($(this).parent().find('.cart').data("stock"));
		var current = addStock(prev,stock);
		$(this).parent().find('.cart').text(current);
		$(this).parent().find('.cart').trigger( "change" )

		if(current < stock){
			if(current > 0){
				$(this).siblings('.cart-remove').removeClass('not-active');
			}	
		}else{
			$(this).addClass('not-active');
		}
	});	
	$(document).on('click', '.cart-remove', function(){
		var prev = parseInt($(this).parent().find('.cart').text());
		var stock = parseInt($(this).parent().find('.cart').data("stock"));
		var current = removeStock(prev);
		$(this).parent().find('.cart').text(current);
		$(this).parent().find('.cart').trigger( "change" )

		if(current > 0){
			if(current < stock){
				$(this).siblings('.cart-add').removeClass('not-active');
			}		
		}else{
			$(this).addClass('not-active');
		}
	});
	$(document).on('change', '.cart', function(){
		var total = 0;
		var items = 0;
		var price = {{ $data['product']['data']['data'][0]['promo_price'] == 0 ? $data['product']['data']['data'][0]['price'] : $data['product']['data']['data'][0]['promo_price']}}
		$('.cart').each(function() {
			if($(this).text() > 0){
				total = total + (parseInt($(this).text()) * price);
				items = items + parseInt($(this).text());
			}
		});
		<!-- total = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") -->
		$('.total').text(number_format(total));
		$('#items').text(items);
	});
	
	$('.btn-copy-share').attr('data-clipboard-text', window.location.href);
@stop