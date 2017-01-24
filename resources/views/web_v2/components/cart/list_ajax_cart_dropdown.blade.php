<!-- 
	list item cart dropdown, this same for cart_dropdown.blade.php but remove tag ul because in finished ajax add to cart
-->
<?php $carts = Session::get('carts'); ?>

@if (!empty($carts) && is_array($carts))
	<?php $total = 0; $i=0; ?>
	<div class="cart-content">
		<!-- SECTION CART DROPDOWN CONTENT -->
		@foreach ($carts as $k => $item)
			<?php
				$qty 			= 0;
				foreach ($item['varians'] as $key => $value) 
				{
					$qty 		= $qty + $value['quantity'];
				}
			?>
			<!-- SECTION CART DROPDOWN ITEM -->
			<li class="pb-xs {{ ($item != end($carts) ? 'border-bottom-1 border-grey-light' : '') }}">
				@include('web_v2.components.cart.cart_dropdown_item', [
					'label_id'				=> $k,
					'label_image'			=> $item['thumbnail'],
					'label_name'			=> $item['name'],
					'label_qty'				=> $item['varians'],
					'label_price'			=> $item['price'],
					'label_discount'		=> ($item['discount']!=0) ? $item['discount'] : 0,
					'label_total'			=> ($item['discount']!=0 ? ($item['price']-$item['discount']) : $item['price'])*$qty
				])
			</li>
			<!-- END SECTION CART DROPDOWN ITEM -->

			<?php $total += (($item['discount']!=0 ? $item['promo_price'] : $item['price'])*$qty); $i++; ?>
		@endforeach
	</div>
	<div class="cart-bottom">
		<li class="cart-dropdown-subtotal border-top-1 border-grey-light border-bottom-1 pt-xs">
			<div class="row">
				<div class="col-sm-12">
					<p class="text-center"><strong>SUBTOTAL <span class="ml-md">@money_indo($total)</span></strong></p>
				</div>
			</div>
		</li>  
		<li class="p-xs">
			<div class="row">
				<div class="col-xs-12 text-center" style=" ">
					<a href="{{ route('balin.cart.index') }}" class="btn btn-black-hover-white-border-black mr-sm">Lihat Cart</a>
					<a href="{{ route('my.balin.checkout.get') }}" class="btn btn-black-hover-white-border-black ml-sm">Checkout</a>
				</div>
			</div>
		</li> 
	</div>
@else
	<li class=" solid text-center">
		<h4 class="pt-md pb-md mt-0 text-md text-normal letter-space-xs" style="text-transform:none;">Belum ada item di Cart</h4>
	</li>
	<li class="bg-black text-white">
		<div class="row">
			<div class="col-xs-12 text-center" style=" ">
				<h4 class="mb-xs text-md letter-space-sm text-bold">Anda Mungkin Suka</h4>
			</div>
		</div>
	</li>

	@if(isset($recommend['data']['data']))
		<!-- SECTION RECOMMENDATION PRODUCT -->
		@foreach($recommend['data']['data'] as $k => $item)
			<li class="{{ ($item != end($recommend['data']) ? 'border-bottom-1 border-grey-light' : '') }}">
				@include('web_v2.components.cart.cart_recommendation', [
					'label_id'				=> $k,
					'label_image'			=> $item['thumbnail'],
					'label_name'			=> $item['name'],
					'label_price'			=> $item['price'],
					'label_size'			=> $item['varians'],
					'label_promo'			=> $item['promo_price'],
					'label_slug'			=> $item['slug'],
				])
			</li>
		@endforeach
		<!-- END SECTION RECOMMENDATION PRODUCT -->
	@endif
@endif