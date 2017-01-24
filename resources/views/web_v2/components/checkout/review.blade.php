<div class="row ml-0 mr-0">
	<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 bg-white border-1 border-solid border-grey-light no-border-xs">
		<div class="content_checkout">
		<div class="row mb-md hidden-lg hidden-md hidden-sm">
			<div class="col-xs-12 pt-md">
				<h3 class="m-t-none m-b-md">Summary</h3>
				<p style="margin-top:-5px;">Step 5 from 5</p>
			</div>
		</div>	
			<div class="row ml-0 mr-0 pt-xs mt-md hidden-xs">
				<div class="col-md-2 col-sm-2 border-bottom-1 border-grey-light text-grey-dark">
					<p class="mb-5">Produk</p>
				</div>
				<div class="col-md-10 col-sm-10 border-bottom-1 border-grey-light text-grey-dark">
					<div class="row">
						<div class="col-sm-2 col-md-2"></div>
						<div class="col-sm-3 col-md-3">
							<p class="text-right mr-sm mb-5">Harga</p>
						</div>
						<div class="col-sm-1 col-md-1">
							<p class="text-center mb-5">Kuantitas</p>
						</div>
						<div class="col-sm-3 col-md-3">
							<p class="text-right mb-5">Diskon</p>
						</div>
						<div class="col-md-3 col-sm-3">
							<p class="text-right mr-sm mb-5">Total</p>
						</div>
					</div>
				</div>
			</div>

			@if ($data['carts'])
				<?php $total = 0; ?>
				@foreach ($data['carts'] as $k => $item)
					<?php
						$qty 			= 0;
						foreach ($item['varians'] as $key => $value) 
						{
							$qty 		= $qty + $value['quantity'];
						}
					?>

					<!-- SECTION ITEM LIST PRODUCT CHECKOUT -->
					@include('web_v2.components.checkout.item_list_checkout', array(
						"item_list_id"					=> $k,
						"item_list_image"				=> $item['thumbnail'],
						"item_list_name" 				=> $item['name'],
						"item_list_qty"					=> $qty,
						"item_list_normal_price"		=> $item['price'],
						"item_list_size"				=> $item['varians'],
						"item_list_discount_price"		=> (isset($item['promo_price'])&&($item['promo_price']!=0)) ? ($item['price']-$item['promo_price']) : 0,
						"item_list_total_price"			=> (isset($item['promo_price'])&&($item['promo_price']!=0)) ? ($item['promo_price']*$qty) : ($item['price']*$qty),
						"item_varians"					=> $item['varians'],
						"item_list_slug"				=> $item['slug'],
						"item_mode"						=> 'new',
					))
					<?php $total += (isset($item['promo_price'])&&($item['promo_price']!=0)) ? ($item['promo_price']*$qty) : ($item['price']*$qty); ?>
					<!-- END SECTION ITEM LIST PRODUCT CHECKOUT -->
				@endforeach
			@else
				<div class="row chart">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<h4 class="text-center">Tidak ada item di cart</h4>
					</div>
				</div>
			@endif
			<!-- END SECTION PRODUCT IN CART -->

			<!-- SECTION INFO TOTAL PRODUCT & TOTAL PEMBAYARAN FOR DESKTOP -->
			<div class="row ml-0 mr-0" id='section_checkout_order_desktop'>
				@if ($data['carts'])
					<div class="col-lg-12 col-md-12 checkout-bottom panel-subtotal" id="panel-subtotal-normal">
						<div class="row mt-sm">
							<div class="col-xs-7 col-sm-5 col-sm-offset-2 col-md-5 col-md-offset-2 col-lg-5 col-lg-offset-2 text-left text-left border-bottom">
								<span class="text-regular">Subtotal</span>
							</div>
							<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 text-right border-bottom">
								<span class="text-regular text-right" id="total">@money_indo($total)</span>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-7 col-sm-5 col-sm-offset-2 col-md-5 col-md-offset-2 col-lg-5 col-lg-offset-2 text-left">
								<span class="text-regular">Biaya Pengiriman</span>
							</div>
							<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 text-right">
								<span class="text-regular text-right shipping_cost" data-s="0" data-v="0">@money_indo($data['order']['data']['shipping_cost'])</span>
							</div>	
						</div>
						@if (isset($data['order']['data']['extend_cost']))
							@if (isset($data['order']['data']['transactionextensions']))
								@if (empty($data['order']['data']['transactionextensions']))
									<div class="row">
										<div class="col-xs-7 col-sm-5 col-sm-offset-2 col-md-5 col-md-offset-2 col-lg-5 col-lg-offset-2 text-left">
											<span class="text-regular">Bingkisan Tambahan</span>
										</div>
										<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 text-right">
											<span class="text-regular text-right shipping_cost" data-s="0" data-v="0">@money_indo(0)</span>
										</div>	
									</div>								
								@else
									<div class="row">
										<div class="col-xs-12 col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2 col-lg-10 col-lg-offset-2 text-left">
											<span class="text-regular">Bingkisan Tambahan</span>
										</div>
									</div>
									@foreach($data['order']['data']['transactionextensions'] as $key => $value)
										<div class="row">
											<div class="col-xs-7 col-sm-5 col-sm-offset-2 col-md-5 col-md-offset-2 col-lg-5 col-lg-offset-2 text-left mtm-5">
												<span class="ml-5 text-grey-dark text-regular">- {{ $value['productextension']['name'] }}</span>
											</div>
											<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 text-right mtm-5">
												<span class="text-regular text-right potongan_voucher">@money_indo( $value['productextension']['price'] )</span>
											</div>	
										</div>
									@endforeach
								@endif
							@endif
						@endif
						<div class="row">
							<div class="col-xs-7 col-sm-5 col-sm-offset-2 col-md-5 col-md-offset-2 col-lg-5 col-lg-offset-2 text-left">
								<span class="text-regular">Potongan Point</span>
							</div>
							<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 text-right">
								<span class="text-regular text-right" id="point">@money_indo($data['my_point'])</span>
							</div>	
						</div>
						<div class="row">
							<div class="col-xs-7 col-sm-5 col-sm-offset-2 col-md-5 col-md-offset-2 col-lg-5 col-lg-offset-2 text-left">
								<span class="text-regular">
									Potongan Voucher
								</span>
							</div>
							<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 text-right border-bottom">
								<span class="text-regular text-right {{ ($data['order']['data']['voucher_discount']==0) ? 'text-black' : 'text-red' }} voucher_discount" data-unique="{{ $data['order']['data']['voucher_discount'] }}">
									@if ($data['order']['data']['voucher_discount']==0)
										@money_indo($data['order']['data']['voucher_discount'])
									@else
										@money_indo_negative($data['order']['data']['voucher_discount'])
									@endif
								</span>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-7 col-sm-5 col-sm-offset-2 col-md-5 col-md-offset-2 col-lg-5 col-lg-offset-2 text-left">
								<span class="text-regular">
									Potongan Transfer
								</span>
							</div>
							<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 text-right border-bottom">
								<span class="text-regular text-right { ($data['order']['data']['unique_number']==0) ? 'text-black' : 'text-red' }}">
									@if ($data['order']['data']['unique_number']==0)
										@money_indo($data['order']['data']['unique_number'])
									@else
										@money_indo_negative($data['order']['data']['unique_number'])
									@endif
								</span>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-7 col-sm-5 col-sm-offset-2 col-md-5 col-md-offset-2 col-lg-5 col-lg-offset-2 text-left">
								<h4 class="text-md">Total Pembayaran</h4>
							</div>
							<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
								<h4 class="text-md text-right text-bold mb-sm sub_total">
									<?php 
										$total_pembayaran = $total - $data['my_point'] - $data['order']['data']['voucher_discount'] + $data['order']['data']['shipping_cost'] + (isset($data['order']['data']['extend_cost']) ? $data['order']['data']['extend_cost'] : 0);
									?>
									@if ($total_pembayaran && $total_pembayaran < 0)
										@money_indo(0)
									@else
										@money_indo($total_pembayaran)
									@endif
								</h4>
							</div>	
						</div>
					</div>
				@endif
			</div>
			<hr/>
			<!-- END SECTION INFO TOTAL PRODUCT & TOTAL PEMBAYARAN  FOR DESKTOP -->
		</div>
		{!! Form::open(['url' => route('my.balin.checkout.post'), 'method' => 'POST','class' => 'no_enter', 'id' => 'checkout-form']) !!}
			<div class="row pt pb-md">
				<div class="col-xs-12 col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2 col-lg-10 col-lg-offset-2">
					<label class="control control--checkbox line-height-25"> 
						Dengan ini Anda telah menyetujui <a href="javascript:void(0);" class="link-black unstyle vertical-baseline" data-toggle="modal" data-target="#tnc"><strong>Syarat & Ketentuan</strong></a> pembelian barang di Balin.
					    <input type="checkbox" value="1" name="term" required tabindex="8" title='Syarat & Ketentuan harus dicentang' checked="checked" class="hidden"/>
					    <div class="control__indicator"></div>
						<div class="mt-5 text-error"></div>
					</label>
				</div>
			</div>
			<div class="row pt-md pb-md">
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<a href="javascript:void(0);" class="btn btn-transaparent-border-black-hover-black btn_step"
					data-action="{ route('my.balin.checkout.voucher') }}" 
					data-target="#sc4" 
					data-value="#sc5"
					data-param="0"
					data-type="prev"
					data-url="{{ route('my.balin.checkout.get', ['section' => 'sc4']) }}">
					<i class="fa fa-angle-double-left" aria-hidden="true"></i>
					&nbsp;
					Kembali</a>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
				
					<a href="javascript:void(0);" class="btn btn-orange-full btn_step"
					data-action="{{ route('my.balin.checkout.post') }}" 
					data-param="submit"
					data-type="next"
					data-url="{{ route('my.balin.checkout.get', ['section' => 'sc5']) }}">Checkout</a>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
</div>

<!-- SECTION MODAL PAYMENT -->
<div id="" class="modal modal-payment modal-fullscreen fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="row ml-sm mr-sm">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
						<h5 class="modal-title" id="exampleModalLabel">Payment</h5>
					</div>
				</div>
			</div>
			<div class="modal-body mt-75 mobile-m-t-10 ml-xl mr-xl" style="text-align:left">
			</div>
		</div>
	</div>
</div>
<!-- END SECTION MODAL PAYMENT -->