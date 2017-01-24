@extends('web_v2.page_templates.layout')

@section('content')
	@include('web_v2.components.category-desktop')
	<section class="container-fluid mb-xs">
		<div class="row form">
			<div class="col-xs-12 col-sm-12 pl-0 pr-0">
				<div class="panel-group filter mb-0" id="accordion" role="tablist" aria-multiselectable="true">
					@include('web_v2.components.category-mobile')
				</div>
			</div>
		</div>
	</section>
	<section class="container mt-xs mb-xs">
		<div class="row">
			<div class="col-md-12 text-center">
				<h1 class="">Whoopsie</h1>
				<h3 class="">Halaman yang Anda Cari Tidak Tersedia</h3>
			</div>
		</div>
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<h4 class="mt-md mb-sm pl-sm pr-sm">Anda Mungkin Suka</h4>
			</div>
		</div>
		<div class="row row-card mt-md mb-sm pl-sm pr-sm">
			{{-- DATA GRID CARD PRODUCT --}}
			@include('web_v2.components.card', [
				'card' 	=> $data['offer'],
		  		'col'	=> 'col-xs-6 col-sm-6',
			])
		</div>
		<div class="col-md-12 text-center">
			<a class="btn btn-orange" href="{{route('balin.product.index', $data['linked_search'])}}">Lihat Semua</a>
		</div>
	</section>
@stop
