<!-- SECTION CART LIST ITEM DESKTOP -->
<div class="hidden-xs">
	<div class="row chart-item pb-xs ml-0 mr-0">
		<div class="col-sm-2 col-md-2">
			<a href="#">
				<img class="img-responsive mt-sm" style="width:60%; margin: 0 auto;"  src="{{ $item_list_image }}" >
			</a>
		</div>
		<div class="col-sm-10 col-md-10 p-b-sm">
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<h4 class="text-md mt-sm">
						<a href="{{ route('balin.product.show', $item_list_slug) }}" class="title link-black hover-grey"><strong>{{ $item_list_name }}</strong></a>
					</h4>
					<p class="mb-0 text-regular">Size :</p>
				</div>
			</div>

			@foreach($item_list_size as $key => $value)
				<div class="row  p-xs list_vid" data-vid="{{$value['varian_id']}}" data-cid="{{$item_list_id}}">
					<div class="col-sm-1 col-md-1 qty-{{ strtolower($value['size']) }}" 
					data-get-flag="qty-{{ strtolower($value['size']) }}">
						<div class="row">
							<div class="col-md-12 pl-5">
								<p class="m-b-none" style="line-height:20px">
									@if (strpos($value['size'], '.')==true)
										<?php $frac = explode('.', $value['size']); ?>
										{{ $frac[0].' &frac12;'}}
									@else
										{{ $value['size'] }}
									@endif
								</p>
							</div>
						</div>
					</div>
					<div class="col-sm-3 col-md-3 text-right pr-md qty-{{ strtolower($value['size']) }} label_price" 
						data-price="{{ $item_list_normal_price }}" 
						data-get-price="qty-{{ strtolower($value['size']) }}" 
						data-get-flag="qty-{{ strtolower($value['size']) }}">
						@money_indo($item_list_normal_price)
					</div>
					<div class="col-sm-3 col-md-3 text-center qty-{{ strtolower($value['size']) }}" data-get-flag="qty-{{ strtolower($value['size']) }}">
						<div class="row qty-cart">
							{!! Form::open(['url' => route('balin.cart.store', ['cid' => $item_list_id, 'vid' => ''] ), 'method' => 'POST', 'class' => 'form-cart no_enter']) !!}
								{!! Form::hidden('cid', $item_list_id, ['class' => 'cid']) !!}
								{!! Form::hidden('vid', null, ['class' => 'vid']) !!}
								<input type="hidden" name="varianids[{{ $value['varian_id'] }}]" class="form-control" value="{{ $value['varian_id'] }}">
								<div class="col-sm-4 col-md-4 text-right pr-0" style="z-index:1">
									<button type="button" class="btn btn-control btn-sm minus btn_number" 
									@if($item_list_qty <= 0)disabled="disabled"@endif 
									data-vid="{{ $value['varian_id'] }}" 
									data-cid="{{ $item_list_id }}"
									data-type="minus" 
									data-field="qty-{{$value['size']}}" 
									data-get-flag="qty-{{$value['size']}}" 
									data-price="{{ $item_list_normal_price }}" 
									data-action-update="{{ route('balin.cart.update', ['slug' => $item_list_slug, 'varian_id' => $value['varian_id']]) }}"
									data-page="cart">
										&ndash;
									</button>
								</div>
								<div class="col-sm-4 col-md-4 pl-0 pr-0">
									<div class="form-group mb-0">
										<input type="number" name="qty[{{ $value['size'] }}]" class="form-control border-1 border-solid border-black input_number qty qty-size pqty" 
										style="width:100%"
										value="{{ $value['quantity'] }}" 
										min="0" max="@if(50<=$value['current_stock']){{ '50' }}@else{{ $value['current_stock'] }}@endif" 
										data-stock="{{ $value['current_stock'] }}" 
										data-action-update="{{ route('balin.cart.update', ['slug' => $item_list_slug, 'varian_id' => $value['varian_id']]) }}" 
										data-name="qty-{{$value['size']}}"
										data-cid="{{ $item_list_id }}"
										data-id="{{ $value['varian_id'] }}" 
										data-oldValue="" 
										data-input-flag="0"
										data-price="{{ $item_list_normal_price }}"
										data-discount="{{ $item_list_discount_price }}"
										data-total="{{ (($item_list_normal_price-$item_list_discount_price)*$item_list_qty) }}" 
										data-subtotal="{{ $item_list_total_price }}" 
										data-page="cart" >
									</div>
								</div>
								<div class="col-sm-4 col-md-4 text-left pl-0">
									<button type="button" class="btn btn-control btn-sm plus btn_number" 
									data-type="plus" 
									@if($item_list_qty >= $value['current_stock'])disabled="disabled"@endif
									data-vid="{{ $value['varian_id'] }}" 
									data-cid="{{ $item_list_id }}"
									data-field="qty-{{$value['size']}}"
									data-get-flag="qty-{{$value['size']}}" 
									data-price="{{ $item_list_normal_price }}" 
									data-action-update="{{ route('balin.cart.update', ['slug' => $item_list_slug, 'varian_id' => $value['varian_id']]) }}"
									data-page="cart">
										&#43;
									</button>
								</div>
							{!! Form::close() !!}   
						</div>
					</div>
					<div class="col-sm-2 col-md-2 text-right pr-md label-price qty-{{ strtolower($value['size']) }}" 
						data-price="{{ $item_list_normal_price }}" 
						data-get-price="qty-{{ strtolower($value['size']) }}" 
						data-get-flag="qty-{{ strtolower($value['size']) }}">
						<span class="mr-lg">@money_indo($item_list_discount_price)</span>
					</div>
					<div class="col-sm-3 col-md-2 text-right qty-{{ strtolower($value['size']) }} label_total" 
						data-total="{{ ($item_list_normal_price - $item_list_discount_price) * $value['quantity'] }}" 
						data-get-total="qty-{{ strtolower($value['size']) }}" 
						data-get-flag="qty-{{ strtolower($value['size']) }}" data-subtotal="{{ $item_list_total_price }}">
						<span>
							@money_indo(($item_list_normal_price-$item_list_discount_price)*$value['quantity'])
						</span>
					</div>	
				</div>
			@endforeach

		</div>
	</div>
</div>

<!-- END SECTION CART LIST ITEM DESKTOP -->
<div class="hidden-sm hidden-md hidden-lg">
	<div class="row mt-sm mb-md border-bottom-1 border-grey-light">
		<div class="col-xs-10 col-xs-offset-1">
			<div class="row">
				<!-- SECTION IMAGE THUMBNAIL -->
				<div class="col-xs-10 col-xs-offset-1">
					 <a href="#">
						<img class="img-responsive m-t-sm border-1 border-solid border-grey-light" src="{{ $item_list_image }}">
					 </a>
				</div>
				<!-- END SECTION IMAGE THUMBNAIL -->

				<div class="col-sm-10 col-xs-12">
					<!-- SECTION DESCRIPTION PRODUCT -->
					<div class="row">
						<div class="col-sm-12 col-xs-12">
							<a href="{{ route('balin.product.show', $item_list_slug) }}" class="title link-black hover-grey"><h4 class="m-b-xs">{{ $item_list_name }}</h4></a>
							<p class="m-t-sm m-b-sm"><strong>Size : </strong></p>
						</div>
					</div>
					<!-- END SECTION DESCRIPTION PRODUCT -->

					@foreach($item_list_size as $key => $value)
						<div class="row m-b-md list_vid_mobile" data-vid="{{ $value['varian_id'] }}" data-cid="{{ $item_list_id }}">
							<div class="col-xs-3">
								<p class="m-t-xxs m-b-xxs">
									@if (strpos($value['size'], '.')==true)
										<?php $frac = explode('.', $value['size']); ?>
										{{ $frac[0].' &frac12;'}}
									@else
										{{ $value['size'] }}
									@endif
								</p>
							</div>
							<div class="col-xs-4"></div>
							{!! Form::open(['url' => route('balin.cart.store', ['cid' => $item_list_id, 'vid' => null] ), 'method' => 'POST', 'class' => 'form-cart qty-cart']) !!}
								{!! Form::hidden('cid', $item_list_id, ['class' => 'cid']) !!}
								{!! Form::hidden('vid', null, ['class' => 'vid']) !!}
								<div class="col-xs-1 pr-0">
									<button type="button" class="btn btn-control minus pull-right btn_number_mobile" 
										@if($item_list_qty <= 0)disabled="disabled"@endif 
										data-type="minus" 
										data-field="qty-{{$value['size']}}" 
										data-get-flag="qty-{{$value['size']}}" 
										data-price="{{ $item_list_normal_price }}" 
										data-vid="{{ $value['varian_id'] }}" 
										data-cid="{{ $item_list_id }}"
										data-action-update="{{ route('balin.cart.update', ['slug' => $item_list_slug, 'varian_id' => $value['varian_id']]) }}" 
										data-page="cart">
										&ndash;
									</button>
								</div>
								<div class="col-xs-2 pl-0 pr-0">
									<div class="form-group">
										<input type="number" name="qty[]" style="width:100%;border-radius:0" class="form-control qty-size text-center qty pqty-mobile input_number_mobile" value="{{ $value['quantity'] }}" 
										min="0" max="@if(50<=$value['current_stock']){{ '50' }}@else{{ $value['current_stock'] }}@endif" 
										data-stock="{{ $value['current_stock'] }}" 
										data-cid="{{ $item_list_id }}"
										data-id="{{ $value['varian_id'] }}" 
										data-action-update="{{ route('balin.cart.update', ['slug' => $item_list_slug, 'varian_id' => $value['varian_id']]) }}"
										data-name="qty-{{ strtolower($value['size']) }}"
										data-oldValue="" 
										data-price="{{ $item_list_normal_price }}"
										data-discount="{{ $item_list_discount_price }}"
										data-total="{{ (($item_list_normal_price-$item_list_discount_price)*$value['quantity']) }}" 
										data-subtotal="{{ $item_list_total_price }}" 
										data-page="cart"
										 @if($value['current_stock']==0){{'disabled'}}@endif>
									</div>	
								</div>	
								<div class="col-xs-1 pl-0">
									<button type="button" class="btn btn-control plus pull-left btn_number_mobile" 
									data-type="plus" 
									data-vid="{{ $value['varian_id'] }}" 
									data-cid="{{ $item_list_id }}"
									data-field="qty-{{$value['size']}}"
									data-get-flag="qty-{{$value['size']}}"
									data-price="{{ $item_list_normal_price }}" 
									data-action-update="{{ route('balin.cart.update', ['slug' => $item_list_slug, 'varian_id' => $value['varian_id']]) }}"
									data-page="cart"
									@if($value['quantity'] >= $value['current_stock'])disabled="disabled"@endif >
										&#43;
									</button>
								</div>
								<input type="hidden" name="varianids[]" class="form-control" value="{{ $value['varian_id'] }}">
							{!! Form::close() !!}   
						</div>	
					@endforeach
					<div class="row mt-xs mb-xs">
						<div class="col-xs-4">
							<label class="label-caption">Harga</label>
						</div>
						<div class="col-xs-7 text-right">
							<label class="label-item">
								@money_indo($item_list_normal_price) 
							</label>
						</div>
					</div>
					<div class="row mt-xs mb-xs">
						<div class="col-xs-4">
							<label class="label-caption">Diskon</label>
						</div>
						<div class="col-xs-7 text-right">
							<label class="label-item">
								@money_indo($item_list_discount_price) 
							</label>
						</div>
					</div>
					<div class="row pt-sm mb-xs border-top-1 border-grey-light">
						<div class="col-xs-4">
							Total
						</div>
						<div class="col-xs-7 text-right">
							<label class="label-item label_total_mobile" data-subtotal="{{ $item_list_total_price }}">
								@money_indo($item_list_total_price)
							</label>
						</div>
						<div class="col-xs-1">&nbsp;</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- SECTION CART LIST ITEM MOBILE & TABLET -->

<!-- END SECTION LIST ITEM MOBILE & TABLET -->