@extends('web_v2.page_templates.layout')

@section('content')
	{{-- CATEGORY --}}
	@include('web_v2.components.category-desktop')

	<section class="container mt-sm mb-sm">
		<div class="row form mr-0 ml-0">
			<div class="col-md-12 content-data">
				<div class="clearfix">&nbsp;</div>
				<div class="row mt-xs mb-xs pl-sm pr-sm" id="coming-soon">
					<div class="col-md-12 text-center">
						<h1 class="">Whoopsie</h1>
						<h3 class="">Halaman yang Anda Cari Tidak Tersedia</h3>
					</div>
				</div>
				<div class="clearfix">&nbsp;</div>
				<div class="row mt-xs mb-xs pl-sm pr-sm">
					<div class="col-md-12 text-left">
						<h4 class="">Anda Mungkin Suka</h4>
						<a class="home-product-more" href="{{route('balin.product.index', $data['linked_search'])}}">Lihat Koleksi&nbsp;<i class="fa fa-chevron-right" aria-hidden="true" style="font-size:10px;"></i></a>
					</div>
				</div>
				<div class="row mt-md mb-sm pl-sm pr-sm">
					{{-- DATA GRID CARD PRODUCT --}}
					@include('web_v2.components.card', [
						'card' 	=> $data['offer'],
				  		'col'	=> 'col-lg-3 col-md-3 col-sm-3 col-xs-6'
					])
				</div>
			</div>
		</div>
	</section>
@stop
