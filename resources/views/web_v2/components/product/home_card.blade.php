<div class="thumbnail box-grid text-center">
	<a href="{{ route('balin.product.show', $value['slug']) }}" title="{{ $value['name'] }}">
		<img src="{{ (!empty($value['thumbnail']) ? $value['thumbnail'] : '') }}" class="img-responsive" style="{{ isset($style_thumbnail) ? $style_thumbnail : '' }}">
		<div class="hover"></div>
	</a>
	<div class="text-center box-item pl-5 pr-5 mt-xs">
		<a href="{{ route('balin.product.show', $value['slug']) }}" class="text-bold hover-grey-dark {{ isset($text) ? $text : 'text-lg' }}">{{ (!empty($value['name']) ? $value['name'] : '') }}</a>
		<p class="mb-0 text-grey-dark">@money_indo(($value['promo_price']!=0 ? $value['promo_price'] : $value['price']))</p>
		@if ($value['promo_price'] != 0)
			<p class="mtm-sm mb-0 text-grey-dark">
				<span class="text-regular text-strikethrough mtm-md">@money_indo( $value['price'] )</span>
			</p>
		@endif
	</div>
	<a href="{{ route('balin.product.show', (!empty($value['slug']) ? $value['slug'] : $value['id'])) }}" class="btn btn-black-hover-white-border-black btn-block text-uppercase">Detail</a>
</div>
