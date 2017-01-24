<!-- SECTION ITEM LIST PRODUCT CHECKOUT FOR DESKTOP -->
<div class="hidden-xs">
	<div class="row border-bottom-1 border-grey-light mr-0 ml-0">
		<div class="col-sm-2 col-md-2">
			<a href="{{ route('balin.product.show', $item_list_slug) }}">
				<img class="img-responsive mt-sm mb-sm" src="{{ $item_list_image }}" style="width: 85%;">
			</a>
		</div>
		<div class="col-sm-10 col-md-10 mt-xs mb-sm">
			<div class="row m-b-xs">
				<div class="col-md-12">
					<h4 class="text-md mb-xs">
						<a href="{{ route('balin.product.show', $item_list_slug) }}" class="title">
							<strong>{{ $item_list_name }}</strong>
						</a>
					</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-12">
					<div class="row">
						<div class="col-sm-12 col-xs-12">
							<p class="text-regular mb-sm"><strong>Size</strong></p>
						</div>
					</div>
				</div>
			</div>
			@foreach($item_list_size as $key => $value)
				<div class="row pb-xs">
					<div class="col-sm-2 col-md-2 text-regular">
						@if (strpos($value['size'], '.')==true)
							<?php $frac = explode('.', $value['size']); ?>
							{{ $frac[0].' &frac12;'}}
						@else
							{{ $value['size'] }}
						@endif
					</div>
					<div class="col-sm-3 col-md-3 text-right text-regular">
						@money_indo($item_list_normal_price)
					</div>
					<div class="col-sm-1 col-md-1 text-right text-regular">
						<span class="ml-lg">{{ $value['quantity'] }}</span>
					</div>
					<div class="col-sm-3 col-md-3 text-right text-regular pr-md">
						@money_indo($item_list_discount_price) 
					</div>
					<div class="col-sm-3 col-md-3 text-right text-regular">
						@money_indo(($item_list_normal_price-$item_list_discount_price)*$value['quantity'])
					</div>
				</div>
			@endforeach
		</div>
	</div>
</div>
<!-- END SECTION ITEM LIST PRODUCT  CHECKOUT FOR DESKTOP -->

<!-- SECTION ITEM LIST PRODUCT CHECKOUT FOR MOBILE & TABLET -->
<div class="hidden-sm hidden-md hidden-lg">
	<div class="row ml-0 mr-0 mb-sm">
		<div class="col-xs-12">
			<div class="row">
				<div class="col-xs-8 col-xs-offset-2">
					 <a href="#">
						<img class="img-responsive m-t-sm" src="{{ $item_list_image }}" >
					 </a>
				</div>
				<div class="col-xs-12">
					<div class="row">
						<div class="col-sm-12 col-xs-12">
							<h4 class="text-lg text-bold">{{ $item_list_name }}</h4>
							<p class="text-regular text-bold">Size </p>
						</div>
					</div>
					@foreach($item_list_size as $key => $value)
						<div class="row text-regular">
							<div class="col-xs-4">
								<span class="m-t-xxs m-b-xxs">
									@if (strpos($value['size'], '.')==true)
										<?php $frac = explode('.', $value['size']); ?>
										{{ $frac[0].' &frac12;'}}
									@else
										{{ $value['size'] }}
									@endif
								</span>
							</div>
							<div class="col-xs-8 text-right">
								<span class="m-b-sm label-item m-r-sm">
									{{ $value['quantity'] }}
								</span>
							</div>
						</div>
					@endforeach
					<div class="row text-regular">
						<div class="col-xs-4">
							<span class="text-regular">Harga</span>
							<span class="pull-right">:</span>
						</div>
						<div class="col-xs-8 text-right">
							<span class="label-item">
								@money_indo($item_list_normal_price) 
							</span>
						</div>
					</div>
					<div class="row text-regular pb-5 border-bottom-1 border-grey">
						<div class="col-xs-4">
							<span class="text-regular">Diskon</span>
							<span class="pull-right">:</span>
						</div>
						<div class="col-xs-8 text-right">
							<span class="m-b-sm label-item m-r-sm">
								@money_indo($item_list_discount_price) 
							</span>
						</div>
					</div>
					<div class="row text-regular mt-5">
						<div class="col-xs-4 hidden-xs">
							<span>Total</span>
							<span class="pull-right">:</span>
						</div>
						<div class="col-xs-4 hidden-sm hidden-md hidden-lg">
							&nbsp;
						</div>
						<div class="col-xs-8 text-right">
							<span class="label-item m-r-sm">
								@money_indo($item_list_total_price)
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix hidden-xs">&nbsp;</div>
</div>
<!-- END SECTION ITEM LIST PRODUCT CHECKOUT FOR MOBILE & TABLET -->