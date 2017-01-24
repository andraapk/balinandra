@extends('web_v2.page_templates.layout')
@section('content')
	<div class="container mt-md">
		<div class="row error-responsive">
			<div class="col-md-6 col-md-offset-3 text-center">
				<h1 class="mb-sm">{{ is_null($data['msg']) ? '404' : $data['header'] }}</h1>
				<h3 class="mt-sm mb-md">{{ is_null($data['msg']) ? 'Maaf halaman yang Anda tuju tidak tersedia' : $data['msg'] }}</h3>
				<a href="#" class="btn btn-sm btn-black-hover-white-border-black">Home</a>
			</div>
		</div>
	</div>
@stop