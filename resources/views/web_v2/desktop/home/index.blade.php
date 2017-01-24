@extends('web_v2.page_templates.layout')

@section('content')
	<section class="home-slider">
		@include('web_v2/components/slider', ['sliders' => $data['sliders']])
	</section>

	@if(isset($data['shop_by_style']))
	<div class="container shop-by-style-desktop">
		<h2 class="text-center title">
			Shop By Style
		</h2>
		@include('web_v2.components.tile-desktop')
	</div>
	@endif

	@if(count($data['new_release']))
	<section class="container-fluid bg-grey mt-xl pt-sm">
		<div class="row mt-sm mb-sm">
			<div class="container text-center">
				@if(!$data['premium'])
					<h3 class="text-uppercase m-0">NEW RELEASE</h3>
				@else
					<h5 class="text-uppercase m-0 text-orange">NEW RELEASE</h5>
					<h3 class="text-uppercase m-0">PREMIUM COTTON</h3>
				@endif
				<a class="home-product-more" href="{{route('balin.product.index', $data['linked_search'])}}">Lihat Koleksi&nbsp;<i class="fa fa-chevron-right" aria-hidden="true" style="font-size:10px;"></i></a>
			</div>
		</div>
		<div class="container pt-md mb-xs">
			<div class="row">
			  	@include('web_v2.components.card', [
			  		'card' 	=> $data['new_release'],
			  		'col'	=> 'col-md-3 col-sm-3 col-xs-6 mb-md card_product_desktop',
			  		'data'	=> ['type' => 'women']
			  	])
			</div>
		</div>
	</section>
	@endif
	
	@if(isset($data['instagram']))
	<section class="container mt-xl">
		<div class="row pb-xs">
			<div class="col-md-12 text-center">
				<p class="m-0">Make sure you follow us</p>
				<h3 class="text-uppercase mtm-5 mbm-5">
					<a href="{{$balin['info']['instagram_url']['value']}}" class="hover-orange" target="_blank">
						<i class="fa fa-instagram" aria-hidden="true"></i>
						balin.id
					</a>
				</h3>
			</div>
		</div>
		<div class="row pt-md pb-md mb-sm">
			@include('web_v2.components.card_ig', [
				'card'	=> $data['instagram'],
				'col'	=> 'col-md-3 col-sm-3 col-xs-6'
			])
		</div>
	</section>
	@endif
@stop

@section('js_plugin')
	@include('web_v2.plugins.owlCarousel')
@stop