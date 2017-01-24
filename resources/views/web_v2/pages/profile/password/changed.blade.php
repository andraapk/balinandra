@extends('web_v2.page_templates.layout')

@section('content')
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix hidden-xs hidden-sm">&nbsp;</div>
	<section class="container">
		<div class="row">
		<!-- SECTION ACTIVATION LINK -->
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h3 class="">Password Anda sudah berubah!</h3> 
				<p class="mb-md mt-md">Akun anda telah berubah, silahkan klik tombol login dibawah untuk masuk ke akun Anda.</p> 
				<a href="{{ route('balin.get.login') }}" class="btn btn-sm btn-black-hover-white-border-black" tabindex="">SIGN IN NOW</a>
			</div>
		</div>
		<!-- END SECTION REFERRAL CODE -->
	</section>
@stop