<div class="row recommend-product mt-sm mb-sm text-regular">
	<div class="col-xs-12">
		<div class="row">
			<div class="col-xs-3 pr-xs">
				<a href="{{ route('balin.product.show', $label_slug) }}">
					<img class="img-responsive ml-sm" style=""  src="{{ $label_image }}">
				</a>
			</div>
			<div class="col-xs-9 pl-sm">
				<h4 class="card-title mt-0 mb-5 font text-lg">
					<a href="{{ route('balin.product.show', ['slug' => $label_slug]) }}" class="hover-orange">{{ $label_name }}</a>
				</h4>
				<p class="card-text mb-5 font">
					@if ($label_promo != 0)
						<del>@money_indo($label_price)</del>
						<span class="text-orange">@money_indo($label_promo)</span>
					@else
						<span>@money_indo($label_price)</span>
					@endif
				</p>
				<div class="border-size mb-5 mt-xs"></div>
				<ul class="list-inline font">
					@foreach ($label_size as $k2 => $v2)
						<li>{{ $v2['size'] }}</li>
					@endforeach
				</ul>
			</div> 
		</div>
	</div>
</div>