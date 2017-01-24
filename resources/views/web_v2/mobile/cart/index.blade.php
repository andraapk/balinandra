@extends('web_v2.page_templates.layout')

@section('content')
	<section class="container mtm-xs mb-xxl">
		<div id="table-cart" class="row" style="position:relative;">
			<div class="col-xs-12 loading hidden" style="position:fixed !important;">
					{!! HTML::image('images/loading.gif', null, [
						'class' => 'img-responsive', 
						'style' => 'width: 15%;top: 35vh;left: 50vw;transform: translateX(-50%);position: absolute;'
					]) !!}
			</div>
			<div class="col-xs-12">
				<!-- SECTION HEADER TABLE CART -->
				<div class="cart-append-mobile">
				</div>
				<!-- END SECTION HEADER TABLE CART -->
			
				<!-- SECTION CONTENT TABLE CART -->
				<?php 
					$total 	= 0; 
					$i 		= 0;
					$temp_product = 0;
				?>

				@if (!empty($data['carts']) && is_array($data['carts']))
					@foreach ($data['carts'] as $k => $item)
						<?php
							$qty 			= 0;
							foreach ($item['varians'] as $key => $value) 
							{
								$qty 		= $qty + $value['quantity'];
							}
						?>
						@include('web_v2.components.cart.item-list-mobile', array(
							"item_id"			=> $k,
							"item_thumbnail"	=> $item['thumbnail'],
							"item_name" 		=> $item['name'],
							"item_qty"			=> $qty,
							"item_price"		=> $item['price'],
							"item_size"			=> $item['varians'],
							"item_discount"		=> $item['discount'],
							"item_total"		=> $item['discount']!=0 ? (($item['price']-$item['discount'])*$qty) : ($item['price']*$qty),
							"item_slug"			=> $item['slug'],
							"item_mode"			=> 'new',
						))
						<?php $total += ($item['discount']!=0) ? (($item['price']-$item['discount'])*$qty) : ($item['price']*$qty); ?>
					@endforeach
				@else
					<div class="row mr-0 ml-0 p-sm">
						<div class="col-xs-12" style="padding-top: 25vh;">
							<h4 class="text-center text-md">Tidak ada item di cart</h4>
						</div>
					</div>
				@endif
				<!-- END SECTION CONTENT TABLE CART -->

				<!-- SECTION FOOTER CART MOBILE -->
				<div class="row border-bottom-1 solid border-white pb-lg">
					<div class="col-xs-12" >
						@if (!empty($data['carts']) && $data['carts'] != 'remove carts')
							<div class="row cart-footer">
								<div class="col-xs-12">
									<h3 class="text-center">SubTotal</h3>
								</div>
							</div>
							<div class="row empty-cart-mobile cart-footer">
								<div class="col-xs-12">
									<h2 class="text-center total_all" data-get-total="{{ $total }}">
										@if (isset($total))
											@money_indo($total)
										@endif
									</h2>
								</div>
							</div>
						@endif
						<div class="clearfix">&nbsp;</div>
						@if (!empty($data['carts']) && is_array($data['carts']) )
							<div class="row mt-sm mb-sm empty-cart-mobile">
								<div class="col-xs-12">
									<a href="{{ route('my.balin.checkout.get') }}" class="btn btn-orange-full btn-block btn-lg text-uppercase btn-checkout">
										Checkout
									</a>
								</div>
							</div>
						@endif
						<div class="row mt-sm mb-sm">
							<div class="col-xs-12">
								<a href="{{ route('balin.product.index') }}" class="btn btn-orange white btn-block btn-lg text-uppercase">
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
	<section class="container mt-lg mb-lg">
	</section>
@stop

@section('js')
	data_action1 = '{{ route('balin.cart.store') }}';
	data_action2 = '{{ route('balin.cart.list') }}';
@stop