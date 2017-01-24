<!-- SECTION CART LIST ITEM DESKTOP -->
<div class="row cart-item border-right-1 border-left-1 border-bottom-1 border-grey-light pb-xs ml-0 mr-0">
	<div class="col-sm-2 col-md-1 col-lg-1">
		<a href="#">
			<img class="img-responsive mt-sm"  src="{{ $item_thumbnail }}" >
		</a>
	</div>
	<div class="col-sm-10 col-md-11 col-lg-11 p-b-sm">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<h4 class="text-md mt-sm">
					<a href="{{ route('balin.product.show', $item_slug) }}" class="title link-black hover-orange"><strong>{{ $item_name }}</strong></a>
				</h4>
				<p class="mb-0 text-regular">Size :</p>
			</div>
		</div>
		@foreach($item_size as $key => $value)
			<div class="row p-xs list-varian" 
				data-vid="{{ $value['varian_id'] }}" 
				data-cid="{{ $item_id }}">
				<div class="col-sm-1 col-md-3 col-lg-3">
					<p class="m-b-none" style="line-height:20px">{{ $value['size'] }}</p>
				</div>
				<div class="col-sm-5 col-md-3 col-lg-3 text-center label_price">
					@if ($item_discount != 0)
						<del>@money_indo($item_price)</del>
						<span class="col-sm-12 hidden-md hidden-lg"><br/></span>
						<span class="text-orange">@money_indo($item_price - $item_discount)</span>
					@else
						<span>@money_indo($item_price)</span>
					@endif
				</div>
				<div class="hidden-sm col-md-1 col-lg-1">&nbsp;</div>
				<div class="col-sm-3 col-md-2 col-lg-2 text-center pl-xxl pr-xxl">
					<a href="javascript:void(0);" class="pull-left cart-remove qty-minus">
						<strong>-</strong>
					</a>
					<span class="qty cart"
						data-action="{{ route('balin.cart.update', ['slug' => $item_slug, 'varian_id' => $value['varian_id']]) }}"
						data-id="{{ $value['varian_id'] }}"  
						data-stock="{{ $value['current_stock'] }}"
						data-price="{{ $item_price }}"
						data-discount="{{ $item_discount }}">{{ $value['quantity'] }}</span>
					<a href="javascript:void(0);" class="pull-right cart-add qty-plus {{ $value['quantity'] == $value['current_stock'] ? 'not-active' : ''}}"> 
						<strong>+</strong>
					</a>
				</div>
				<div class="hidden-sm col-md-1 col-lg-1">&nbsp;</div>
				<div class="col-sm-3 col-md-2 col-lg-2 text-right">
					<span class="total_per_pieces" 
						data-total-piece="{{ ($item_price - $item_discount) * $value['quantity'] }}">
						@money_indo( ($item_price - $item_discount) * $value['quantity'] )
					</span>
				</div>	
			</div>
		@endforeach
	</div>
</div>
<!-- END SECTION CART LIST ITEM DESKTOP -->