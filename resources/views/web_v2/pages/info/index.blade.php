@extends('web_v2.page_templates.layout')

@if(isset($data['type']) && $data['type']=='why-join')
	@section('balin-point-nav')
		text-orange
	@stop
@endif

@section('content')
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix hidden-xs hidden-sm">&nbsp;</div>
	<section class="container">
		<!-- CONTENT -->
		<div class="row">
			<div class="col-md-12 col-lg-12">
				{!!$data['content']!!}
			</div>
		</div>
		<!-- END CONTENT -->
	</section>
@stop
