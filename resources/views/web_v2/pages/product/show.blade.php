@extends('web_v2.page_templates.layout')

@section('content')
	<?php 
	// dd($data); 

	?>
	<div class="row">
		<!-- SECTION IMAGE SLIDER PRODUCT -->
		<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
			<div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails border-1 border-solid border-grey-light hidden-xs hidden-sm" style="width:100%;">
				<a class="img-large" href="{{ isset($data['product']['data']['data'][0]['thumbnail']) ? $data['product']['data']['data'][0]['thumbnail'] : 'http://drive.thunder.id/file/public/4/1/2015/12/06/05/avani-short-front.jpg' }}" >
					<img class="img img-responsive text-center canvas-image"  src="{{ isset($data['product']['data']['data'][0]['thumbnail']) ? $data['product']['data']['data'][0]['thumbnail'] : 'http://drive.thunder.id/file/public/4/1/2015/12/06/05/avani-short-front.jpg' }}" style="width:100%">
				</a>
			</div>
			<div class="row">
				<div class="col-md-12 col-lg-12 hidden-xs hidden-sm">
					@if (count($data['product']['data']['data'][0]['images']) != 0)
						<div class="owl-carousel gallery-product">
							@foreach ($data['product']['data']['data'][0]['images'] as $i => $img)
								<div class="item-carousel">
									<a href="{{ $img['thumbnail'] }}" data-standard="{{ $img['thumbnail'] }}">
										<img class="img img-responsive canvasSource" id="canvasSource{{ $i }}" src="{{ $img['thumbnail'] }}" alt="">
									</a>
								</div>
							@endforeach
						</div>
					@else
						<img class="img img-responsive canvasSource" src="{{ isset($data['product']['data']['data'][0]['thumbnail']) ? $data['product']['data']['data'][0]['thumbnail'] : 'http://drive.thunder.id/file/public/4/1/2015/12/06/05/avani-short-front.jpg' }}" alt="{{ $data['product']['data']['data'][0]['name'] }}" style="width:50px">
					@endif
				</div>
				<div class="col-xs-12 col-sm-12 pl-0 pr-0 hidden-md hidden-lg">
					@if (count($data['product']['data']['data'][0]['images']) != 0)
						<div class="owl-carousel gallery-product">
							@foreach ($data['product']['data']['data'][0]['images'] as $i => $img)
								<div class="item-carousel">
									<a href="{{ $img['thumbnail'] }}" data-standard="{{ $img['thumbnail'] }}">
										<img class="img img-responsive canvasSource" id="canvasSource{{ $i }}" src="{{ $img['thumbnail'] }}" alt="">
									</a>
								</div>
							@endforeach
						</div>
					@else
						<img class="img img-responsive canvasSource" src="{{ isset($data['product']['data']['data'][0]['thumbnail']) ? $data['product']['data']['data'][0]['thumbnail'] : 'http://drive.thunder.id/file/public/4/1/2015/12/06/05/avani-short-front.jpg' }}" alt="">
					@endif
				</div>
			</div>
		</div>
		<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">&nbsp;</div>
		<!-- END SECTION IMAGE SLIDER PRODUCT -->

		<!-- SECTION INFO DETAIL PRODUCT -->
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pl-lg">
			<!-- SECTION DESCRIPTION PRODUCT -->
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<h3 class="mt-0">{{ $data['product']['data']['data'][0]['name'] }}</h3>
					<h4 class="text-light mt-sm">
						@money_indo( (isset($data['product']['data']['data'][0]['promo_price'])&&($data['product']['data']['data'][0]['promo_price']!=0)) ? $data['product']['data']['data'][0]['promo_price'] : $data['product']['data']['data'][0]['price'] )
					</h4>
					@if (isset($data['product']['data']['data'][0]['promo_price'])&&($data['product']['data']['data'][0]['promo_price']!=0))
						<span class="text-md text-strikethrough mtm-md">@money_indo( $data['product']['data']['data'][0]['price'] )</span>
					@endif

					<h4 class="mt-xl">DESKRIPSI</h4>
					<?php  $description = isset($data['product']['data']['data'][0]['description']) ? json_decode($data['product']['data']['data'][0]['description'], true) : ['description' => '', 'fit' => '']; ?>
					<p class="text-superlight">{!! $description['description'] !!}</p>
				</div>
			</div>
			<!-- END SECTION DESCRTIPION PRODUCT -->

			<!-- SECTION SIZE & FIT -->
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<h4 class="mt-xl">UKURAN & FIT</h4>
					{!! $description['fit'] !!}
					<?php 
						// HTML::image('images/'.$data['product']['data']['data'][0]['size_fit'].'.png', null, ['class' => 'img-responsive']) 
					?>
				</div>
			</div>
			<!-- END SECTION SIZE & FIT -->

			<!-- SECTION FORM ADD TO CART -->
			{!! Form::open(['url' => route('balin.cart.store', $data['product']['data']['data'][0]['slug']), 'class' => 'form_addtocart']) !!}
				{!! Form::hidden('slug', $data['product']['data']['data'][0]['slug'], ['class' => 'slug_form']) !!}
				{!! Form::hidden('name', $data['product']['data']['data'][0]['name'], ['class' => 'name_form']) !!}
				<!-- SECTION SIZE CHOICE -->
				<div class="row mb-xxl">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<h4 class="mt-xl mb-xl">PILIH UKURAN</h4>
						@foreach($data['product']['data']['data'][0]['varians'] as $k => $v)
							<div class="row border-1 border-solid border-grey text-regular mr-0 ml-0 p-5 mb-xs">
								<div class="col-xs-6 col-sm-6 col-md-5 col-lg-5">
									<p class="mt-5 mb-0">
										@if (strpos($v['size'], '.')==true)
											<?php $frac = explode('.', $v['size']); ?>
											{{ $frac[0].' &frac12;'}}
										@else
											{{ $v['size'] }}
										@endif
									</p>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-7 col-lg-7 text-right size-product">
									<a href="javascript:void(0);" class="btn btn-black-hover-white-border-black btn-sm mrm-3 btn_number minus"
										data-field="qty-{{ strtolower($v['size']) }}[1]"
										data-page="product" 
										data-type="minus" disabled
										>&ndash;</a>
									<input type="hidden" name="varianids[{{ $v['id'] }}]" class="form-control pvarians" value="{{ $v['id'] }}">
									<input type="number" name="qty[{{ $v['id'] }}]" class="text-center text-regular size-input pqty input_number" 
										value=
										"@if(isset($data['carts'][$data['product']['data']['data'][0]['id']]) && $data['carts'][$data['product']['data']['data'][0]['id']]['slug'] == $data['product']['data']['data'][0]['slug'])@if(isset($data['carts'][$data['product']['data']['data'][0]['id']]['varians'][$v['id']]) && ($data['carts'][$data['product']['data']['data'][0]['id']]['varians'][$v['id']]['varian_id']  == $v['id'])){{$data['carts'][$data['product']['data']['data'][0]['id']]['varians'][$v['id']]['quantity']}}@else{{'0'}}@endif{{''}}@else{{'0'}}@endif" 
										min="0" 
										max="{{ (20>=$v['current_stock']) ? $v['current_stock'] : 20 }}"
										data-id="{{ $v['id'] }}"
										data-name="qty-{{ strtolower($v['size']) }}[1]"
										data-stock="{{ $v['current_stock'] }}"
										data-price="{{ (isset($data['product']['data']['data'][0]['promo_price'])&&($data['product']['data']['data'][0]['promo_price']!=0)) ? $data['product']['data']['data'][0]['promo_price'] : $data['product']['data']['data'][0]['price'] }}"
										data-total="@if(isset($data['carts'][$data['product']['data']['data'][0]['id']]) && $data['carts'][$data['product']['data']['data'][0]['id']]['slug'] == $data['product']['data']['data'][0]['slug'])@if(isset($data['carts'][$data['product']['data']['data'][0]['id']]['varians'][$v['id']]) && ($data['carts'][$data['product']['data']['data'][0]['id']]['varians'][$v['id']]['varian_id']  == $v['id'])){{($data['carts'][$data['product']['data']['data'][0]['id']]['price']-$data['carts'][$data['product']['data']['data'][0]['id']]['discount'])*$data['carts'][$data['product']['data']['data'][0]['id']]['varians'][$v['id']]['quantity']}}@else{{'0'}}@endif{{''}}@else{{'0'}}@endif"
										data-oldValue="" 
										data-toggle="tooltip" 
										data-placement="left"
										data-page="product"
										{{ ($v['current_stock']==0) ? 'disabled' : ''}}
										>
									<a href="javascript:void(0);" class="btn btn-black-hover-white-border-black btn-sm mlm-5 btn_number plus"
										data-field="qty-{{ strtolower($v['size']) }}[1]"
										data-page="product"
										data-type="plus"
										{{ ($v['current_stock']==0) ? 'disabled' : ''}}
										>&#43;</a>
								</div>
							</div>
						@endforeach
					</div>
				</div>
				<!-- END SECTION SIZE CHOICE -->
				<div class="clearfix">&nbsp;</div>
				<!-- SECTION TOTAL PRICE -->
				<div class="row border-top-1 border-bottom-1 border-right-0 border-left-0 border-solid mt-xl ml-0 mr-0">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<h4>TOTAL</h4>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
						<h4 class="price_all_product">
							<?php 
								$price 	= $data['product']['data']['data'][0]['price']; 
								$total = 0;
							?>

							@if (!empty($data['carts']))
								@foreach ($data['carts'] as $k => $item)
									@if ($k==$data['product']['data']['data'][0]['id'])
										<?php
											$qty 			= 0;
											foreach ($item['varians'] as $key => $value) 
											{
												$qty 		= $qty + $value['quantity'];
											}
											$total += (($price-$item['discount'])*$qty); 
										?>
									@endif
								@endforeach
								@money_indo($total)
							@else
								@money_indo( isset($data['product']['data']['data'][0]['promo_price']) ? $data['product']['data']['data'][0]['promo_price'] : $data['product']['data']['data'][0]['price'])
							@endif
						</h4>
					</div>
				</div>
				<!-- END SECTION TOTAL PRICE -->

				<!-- SECTION BUTTON ADD TO CART -->
				<div class="row mt-sm mb-md">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
						<a href="javascript:void(0);" class="btn btn-black-hover-white-border-black addto_cart" data-route="{{ route('balin.cart.index') }}">Tambahkan ke Cart</a>
					</div>
				</div>
				<!-- END SECTION BUTTON ADD TO CART -->
			{!! Form::close() !!}
			<!-- END SECTION FORM ADD TO CART -->
		</div>
		<!-- END SECTION INFO DETAIL PRODUCT -->
	</div>

	<!-- SECTION RELATED PRODUCT -->
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-xxl mb-md">
			<h4>PRODUK LAINNYA</h4>
		</div>
		@include('web_v2.components.product.card_product',[
			'datas' 			=> $data['related'],
			'col'				=> 'col-xs-12 col-sm-6 col-md-3 col-lg-3',
			'text'				=> 'text-lg text-light',
			'style_thumbnail' 	=> ''
		])
	</div>
	<!-- END SECTION RELATED PRODUCT -->

	<div class="clearfix">&nbsp;</div>
@stop

@section('js_plugin')
	@include('web_v2.plugins.notif', ['data' => ['title' => 'Terima Kasih', 'content' => 'Produk telah ditambahkan di cart']])
@stop

@section('js')
	data_action1 = '{{ route('balin.cart.store', $data['product']['data']['data'][0]['slug']) }}';
	data_action2 = '{{ route('balin.cart.list') }}';
@stop