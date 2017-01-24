<div class="row cart-item border-bottom-1 border-grey-light mt-0 mb-xs pt-lg pb-lg">
	<!-- SECTION IMAGE THUMBNAIL -->
	<div class="col-xs-5">
		 <a href="#">
			<img class="img-responsive m-t-sm border-1 border-solid border-grey-light" src="{{ $item_thumbnail }}">
		 </a>
	</div>
	<!-- END SECTION IMAGE THUMBNAIL -->

	<div class="col-xs-7">
		<!-- SECTION DESCRIPTION PRODUCT -->
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<a href="{{ route('balin.product.show', $item_slug) }}" class="title link-black hover-orange">
					<h4 class="mb-xs">{{ $item_name }}</h4>
				</a>
				<p><strong>Size : </strong></p>
			</div>
		</div>
		<!-- END SECTION DESCRIPTION PRODUCT -->

		@foreach($item_size as $key => $value)
			<div class="row list-varian" data-vid="{{ $value['varian_id'] }}" data-cid="{{ $item_id }}">
				<div class="col-xs-7">
					<p>{{ $value['size'] }}</p>
				</div>
				<div class="col-xs-5 text-center">
					<a href="javascript:void(0);" class="pull-left qty-minus cart-remove">
						<strong>-</strong>
					</a>
					<span class="qty"
						data-action="{{ route('balin.cart.update', ['slug' => $item_slug, 'varian_id' => $value['varian_id']]) }}"
						data-id="{{ $value['varian_id'] }}"  
						data-stock="{{ $value['current_stock'] }}"
						data-price="{{ $item_price }}"
						data-discount="{{ $item_discount }}">{{ $value['quantity'] }}</span>
					<a href="javascript:void(0);" class="pull-right cart-add qty-plus {{ $value['quantity'] == $value['current_stock'] ? 'not-active' : ''}}"> 
						<strong>+</strong>
					</a>
				</div>
			</div>	
		@endforeach
		<div class="row mt-xs mb-xs">
			<div class="col-xs-4">
				<label class="label-caption">Harga</label>
			</div>
			<div class="col-xs-8 text-right">
				@if($item_discount > 0)
					<del>@money_indo($item_price)</del></br>
					<span class="text-orange">
						@money_indo($item_price - $item_discount)
					</span> 
				@else
				<label class="label-item">
					@money_indo($item_price) 
				</label>
				@endif
			</div>
		</div>
		<div class="row pt-sm mb-xs border-top-1 border-grey-light">
			<div class="col-xs-4">
				Total
			</div>
			<div class="col-xs-8 text-right">
				<span class="total_per_pieces"
					data-total-piece="{{ ($item_price - $item_discount) * $qty }}">
					@money_indo( ($item_price - $item_discount) * $qty )
				</span>
			</div>
		</div>
	</div>
</div>