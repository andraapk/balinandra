@extends('web_v2.page_templates.layout')

@section('content')
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix hidden-xs hidden-sm">&nbsp;</div>
	<div class="clearfix hidden-xs hidden-sm">&nbsp;</div>
	<section class="container">
		<div class="row">
			<div class="col-xs-12 col-md-12 col-sm-12">
				<!-- SECTION HEADER TABLE CART -->
				<div class="row p-sm ml-0 mr-0 hidden-xs bg-grey">
					<div class="col-sm-2 col-md-1 text-uppercase">
						<span class="ml-sm">Produk</span>
					</div>
					<div class="col-sm-10 col-md-11 text-uppercase hidden-xs">
						<div class="row">
							<div class="col-sm-5 col-md-5 text-right">
								<span class="mr-xxl">Harga</span>
							</div>
							<div class="col-sm-2 col-md-2 text-center">
								<span>Kuantitas</span>
							</div>
							<div class="col-sm-2 col-md-2 text-right">
								<span>Diskon</span>
							</div>
							<div class="col-sm-3 col-md-3 text-center">
								<span>Total</span>
							</div> 	
						</div>
					</div>
				</div>
				<!-- END SECTION HEADER TABLE CART -->
			
				<!-- SECTION CONTENT TABLE CART -->
				<?php 
					$total 	= 0; 
					$i 		= 0;
					$temp_product = 0;
				?>

				@if (!empty($data['carts']))
					@foreach ($data['carts'] as $k => $item)
						<?php
							$qty 			= 0;
							foreach ($item['varians'] as $key => $value) 
							{
								$qty 		= $qty + $value['quantity'];
							}
						?>
						@include('web_v2.components.cart.item_list_cart', array(
							"item_list_id"					=> $k,
							"item_list_image"				=> $item['thumbnail'],
							"item_list_name" 				=> $item['name'],
							"item_list_qty"					=> $qty,
							"item_list_normal_price"		=> $item['price'],
							"item_list_size"				=> $item['varians'],
							"item_list_discount_price"		=> $item['discount']!=0 ? $item['price']-$item['discount'] : $item['discount'],
							"item_list_total_price"			=> $item['discount']!=0 ? (($item['price']-$item['discount'])*$qty) : ($item['price']*$qty),
							"item_varians"					=> $item['varians'],
							"item_list_slug"				=> $item['slug'],
							"item_mode"						=> 'new',
						))
						<?php $total += ($item['discount']!=0) ? (($item['price']-$item['discount'])*$qty) : ($item['price']*$qty); ?>
					@endforeach
				@else
					<div class="row mr-0 ml-0 p-sm hidden-xs">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<h4 class="text-center text-md">Tidak ada item di cart</h4>
						</div>
					</div>
					<div class="row mr-0 ml-0 p-sm hidden-sm hidden-md hidden-lg">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<h4 class="text-center text-md">Tidak ada item di cart</h4>
						</div>
					</div>
				@endif
				<!-- END SECTION CONTENT TABLE CART -->

				<!-- SECTION TABLE FOOTER CART -->
				<!-- SECTION FOOTER CART DESKTOP -->
				@if (!empty($data['carts']))
					<div class="row bg-grey p-sm ml-0 mr-0 hidden-xs">
						<div class="col-sm-12 col-md-12">
							<div class="row chart-footer">
								<div class="col-sm-9 col-md-8">
									<h4 class="text-uppercase text-right">Sub Total</h4>
								</div>
								<div class="col-sm-3 col-md-3 pr-0">
									<h4 class="text-right grand_total" data-total-item="{{ $total }}">
										@if ($total)
											<strong>@money_indo($total)</strong>
										@endif
									</h4>
								</div>	
							</div>
						</div>
					</div>
				@endif

				<div class="clearfix hidden-xs">&nbsp;</div>
				<div class="clearfix hidden-xs">&nbsp;</div>
				<div class="row ml-0 mr-0">
					<div class="col-lg-12 col-md-12 col-sm-12 hidden-xs">
						<div class="row">
							<a href="{{ route('balin.product.index') }}" class="btn btn-transaparent-border-black-hover-black pull-left text-uppercase">
								Lanjut Belanja
							</a>
							@if (!empty($data['carts']))
								<a href="{{ route('my.balin.checkout.get') }}" class="btn btn-orange pull-right text-uppercase">
									Checkout
								</a>			
							@endif				
						</div>
					</div>
					<div class="clearfix hidden-xs">&nbsp;</div>
					<div class="clearfix hidden-xs">&nbsp;</div>
				</div>
				<!-- END SECTION FOOTER CART DESKTOP -->

				<!-- SECTION FOOTER CART MOBILE -->
				<div class="row hidden-lg hidden-md hidden-sm border-bottom-1 solid border-white bg-black pb-lg">
					<div class="col-xs-12" >
						@if (!empty($data['carts']))
							<div class="row p-t-xs m-b-none">
								<div class="col-xs-12">
									<h3 class="text-center text-white">SubTotal</h3>
								</div>
							</div>
							<div class="row empty-cart-mobile">
								<div class="col-xs-12">
									<h2 class="text-center text-white grand_total_mobile" data-get-total="{{ $total }}">
										@if (isset($total))
											@money_indo($total)
										@endif
									</h2>
								</div>
							</div>
						@endif
						<div class="clearfix">&nbsp;</div>
						@if (!empty($data['carts']))
							<div class="row mt-sm mb-sm empty-cart-mobile">
								<div class="col-xs-12">
									<a href="{{ route('my.balin.checkout.get') }}" class="btn btn-black-border-white-hover-white btn-block btn-lg text-uppercase">
										Checkout
									</a>
								</div>
							</div>
						@endif
						<div class="row mt-sm mb-sm">
							<div class="col-xs-12">
								<a href="{{ route('balin.product.index') }}" class="btn btn-black-border-white-hover-white btn-block btn-lg text-uppercase">
									Lanjut Belanja
								</a>
							</div>
						</div>
					</div>
				</div>
				<!-- END SECTION FOOTER CART MOBILE -->
				<!-- END SECTION TABLE FOOTER CART -->
			</div>
		</div>
	</section>
@stop

@section('js')
	data_action1 = '{{ route('balin.cart.store') }}';
	data_action2 = '{{ route('balin.cart.list') }}';
@stop