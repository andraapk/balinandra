@extends('web_v2.page_templates.layout')

@section('content')
	<div class="container-fluid background">
		<div class="row">
			{{-- empty area --}}
			<div class="hidden-xs hidden-sm col-md-7 col-lg-7 text-center preface">
			</div>

			{{-- reset password --}}
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
				<div class="row panel-akun p-xs mt-md">
					<div class="col-md-12 text-center">
						<h2 class="text-center mb-lg">Ubah Password</h2>
						@include('web_v2.components.alert-box')
						@include('web_v2.components.reset.form')
					</div>	
					<div class="clearfix">&nbsp;</div>
				</div>                        
			</div>
		</div>
	</div>
@stop

@section('wrapper_class')
	bg-login-page
@stop

@section('script_plugin')

@stop