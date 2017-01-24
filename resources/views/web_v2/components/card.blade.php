@foreach ($card as $k => $v)
	<div class="{{ $col }} {{ (isset($last) && (end($card)==$v)) ? 'hide' : '' }}">
		<div class="card">
			<?php $categories = [];?>
			
			@foreach($v['categories'] as $key => $value)
				<?php $categories['categories'][] = $value['slug'];?>
			@endforeach
			
			<a href="{{ route('balin.product.show', array_merge(['slug' => $v['slug']], $categories) ) }}">
				<img src="" class="card-image-top center-block card-image img-responsive lazy" data-src="{{ $v['image_sm'] }}"/>
				<div class="hover"></div>
			</a>
			<div class="card-block">
				<h4 class="card-title mb-5 font">
					<a href="{{ route('balin.product.show', ['slug' => $v['slug']]) }}" class="hover-orange">{{ $v['name'] }}</a>
				</h4>
				<p class="card-text mb-5 font hidden-xs">
					@if ($v['promo_price'] != 0)
						<del>@money_indo($v['price'])</del>
						<span class="text-orange">@money_indo($v['promo_price'])</span>
					@else
						<span>@money_indo($v['price'])</span>
					@endif
				</p>
				<p class="card-text mb-5 font hidden-lg hidden-md hidden-sm">
					@if ($v['promo_price'] != 0)
						<del>@money_indo($v['price'])</del><br/>
						<span class="text-orange">@money_indo($v['promo_price'])</span>
					@else
						<span>@money_indo($v['price'])</span>
					@endif
				</p>
				<div class="border-size mb-xs"></div>
				<ul class="list-inline font">
					@foreach ($v['varians'] as $k2 => $v2)
						<li>{{ $v2['size'] }}</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
	@if (($k-1) % 2 == 0)
		@if(strpos($col, 'col-sm-3') == false)
		  	<div class="clearfix visible-xs visible-sm"></div>
		@else
		  	<div class="clearfix visible-xs"></div>
		@endif
	@endif
@endforeach