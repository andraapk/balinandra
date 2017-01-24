@if ($data['carts'])
	<?php $total = 0; ?>
	@foreach ($data['carts'] as $k => $item)
		<?php
			$qty 			= 0;
			foreach ($item['varians'] as $key => $value) 
			{
				$qty 		= $qty + $value['quantity'];
			}
			$total += (isset($item['promo_price'])&&($item['promo_price']!=0)) ? ($item['promo_price']*$qty) : ($item['price']*$qty);
			// $total += (($item['price']-$item['discount'])*$qty);
		?>
	@endforeach
	<div class="col-lg-12 col-md-12 checkout-bottom panel-subtotal" id="panel-subtotal-normal">
		<div class="row mt-sm">
			<div class="col-xs-6 col-sm-5 col-sm-offset-2 col-md-5 col-md-offset-2 col-lg-5 col-lg-offset-2 text-left text-left border-bottom">
				<span class="text-regular">Subtotal</span>
			</div>
			<div class="col-xs-6 col-sm-5 col-md-5 col-lg-5 text-right border-bottom">
				<span class="text-regular text-right" id="total">@money_indo($total)</span>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6 col-sm-5 col-sm-offset-2 col-md-5 col-md-offset-2 col-lg-5 col-lg-offset-2 text-left">
				<span class="text-regular">Point Anda</span>
			</div>
			<div class="col-xs-6 col-sm-5 col-md-5 col-lg-5 text-right">
				<span class="text-regular text-right" id="point">@money_indo($data['order']['customer']['total_point'])</span>
			</div>	
		</div>
		<div class="row">
			<div class="col-xs-6 col-sm-5 col-sm-offset-2 col-md-5 col-md-offset-2 col-lg-5 col-lg-offset-2 text-left">
				<span class="text-regular">Biaya Pengiriman</span>
			</div>
			<div class="col-xs-6 col-sm-5 col-md-5 col-lg-5 text-right">
				<span class="text-regular text-right shipping_cost" data-s="0" data-v="0">@money_indo($data['order']['shipping_cost'])</span>
			</div>	
		</div>
		<div class="row">
			<div class="col-xs-6 col-sm-5 col-sm-offset-2 col-md-5 col-md-offset-2 col-lg-5 col-lg-offset-2 text-left">
				<span class="text-regular">Potongan Voucher</span>
			</div>
			<div class="col-xs-6 col-sm-5 col-md-5 col-lg-5 text-right border-bottom">
				<span class="text-regular text-right potongan_voucher {{ ($data['order']['voucher_discount']==0) ? 'text-black' : 'text-red' }} voucher_discount" data-unique="{{ $data['order']['voucher_discount'] }}">@money_indo($data['order']['voucher_discount'])</span>
			</div>	
		</div>
		@if (isset($data['order']['extend_cost']))
			<div class="row">
				<div class="col-xs-12 col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2 col-lg-10 col-lg-offset-2">
					<span class="text-regular">Bingkisan Tambahan</span>
				</div>
			</div>
			@if (isset($data['order']['transactionextensions']))
				@foreach($data['order']['transactionextensions'] as $key => $value)
					<div class="row">
						<div class="col-xs-6 col-sm-5 col-sm-offset-2 col-md-5 col-md-offset-2 col-lg-5 col-lg-offset-2 text-left mtm-5">
							<span class="ml-5 text-grey-dark text-regular">- {{ $value['productextension']['name'] }}</span>
						</div>
						<div class="col-xs-6 col-sm-5 col-md-5 col-lg-5 text-right mtm-5">
							<span class="text-regular text-right potongan_voucher">@money_indo( $value['productextension']['price'] )</span>
						</div>	
					</div>
				@endforeach
			@endif
		@endif
		<div class="row">
			<div class="col-xs-6 col-sm-5 col-sm-offset-2 col-md-5 col-md-offset-2 col-lg-5 col-lg-offset-2 text-left">
				<h4 class="text-md">Total Pembayaran</h4>
			</div>
			<div class="col-xs-6 col-sm-5 col-md-5 col-lg-5">
				<h4 class="text-md text-right text-bold mb-sm sub_total">
					<?php 
						$total_pembayaran = $total - $data['order']['customer']['total_point'] - $data['order']['unique_number'] + $data['order']['shipping_cost'] + (isset($data['order']['extend_cost']) ? $data['order']['extend_cost'] : 0);
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