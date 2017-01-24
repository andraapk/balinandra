@extends('web_v2.page_templates.layout')

@section('content')
	@if(isset($data['shop_by_style']))
	 <section class="container home">
	 	<div class="row">
	 		@include('web_v2/components/slider', ['sliders' => $data['sliders']])
	 	</div>
	 
	 	<div class="container shop-by-style-mobile">
	 		<h2 class="text-center title">
	 			Shop By Style
	 		</h2>
	 		<div class="content">
	 			@include('web_v2.components.tile-mobile')
	 		</div>
	 	</div>
	 </section>
	 @endif
	 
	 @if(count($data['new_release']))
	 <section class="container-fluid bg-grey mt-xl pt-sm">
	 	<div class="row mt-sm mb-sm">
	 		<div class="container text-center">
	 			<div class="col-md-12">
	 				@if(!$data['premium'])
	 					<h3 class="text-uppercase m-0">NEW RELEASE</h3>
	 				@else
	 					<h5 class="text-uppercase m-0 text-orange">NEW RELEASE</h5>
	 					<h3 class="text-uppercase m-0">PREMIUM COTTON</h3>
	 				@endif
	 			</div>
	 		</div>
	 	</div>
	 	<div class="container pt-md pb-sm">
	 		<div class="row">
	 		  	@include('web_v2.components.card', [
	 		  		'card' 	=> $data['new_release'],
	 		  		'col'	=> 'col-md-3 col-sm-3 col-xs-6 card_product_desktop',
			  		'data'	=> ['type' => 'women']
	 		  	])
	 		</div>
	 	</div>
	 	<div class="container text-center">
	 		<div class="row">
	 			<div class="col-md-12">
	 				<a href="{{route('balin.product.index', $data['linked_search'])}}" class="btn btn-orange buy">
	 					Lihat Semua
	 				</a>
				</div>
			</div>
		</div>
		 <div class="clearfix">&nbsp;</div>
	</section>
	@endif

	@if(isset($data['instagram']))
	<section class="container mt-xl">
		<div class="container">
			<div class="row pb-xs">
				<div class="col-md-12 text-center">
					<p class="m-0">Make sure you follow us on</p>
					<h3 class="text-uppercase mtm-5 mbm-5">
						<a href="{{$balin['info']['instagram_url']['value']}}" class="hover-orange" target="_blank">
							<i class="fa fa-instagram" aria-hidden="true"></i>
							balin.id
						</a>
					</h3>
				</div>
			</div>
			<div class="row pt-md pb-md mb-sm instagram-mobile">
				<div class="row">
					<div class="carousel">
			 			@foreach($data['instagram'] as $key => $data)
							<?php $link = json_decode($data['value'], true); ?>
							<a class="link" href="{{$link['action']}}" target="_blank">
								<div class="item">
									<div class="col-xs-12 pl-0 pr-0">
										<div class="tile text-center">
											{!! Html::image($data['image_sm'], null, ['class' => 'img-responsive ig_mobile']) !!}
											<div class="jumbotron">
											</div>
										</div>
									</div>
								</div>
							</a>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</section>
	@endif
@stop

@section('js_plugin')
	@include('web_v2.plugins.owlCarousel')
@stop