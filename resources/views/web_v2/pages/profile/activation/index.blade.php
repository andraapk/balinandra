@extends('web_v2.page_templates.layout')

@section('content')
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix hidden-xs hidden-sm">&nbsp;</div>
	<section class="container">
		<div class="row ml-0 mr-0 pb-md">
		<!-- SECTION ACTIVATION LINK -->
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h3 class="">Selamat!</h3> 
				<p class="mb-md mt-md">Akun anda telah aktif, silahkan klik tombol login dibawah untuk mendapatkan hadiah yang menarik.</p> 
				<a href="{{ route('balin.get.login') }}" class="btn btn-black-hover-transparent-border-black" tabindex="1">SIGN IN NOW</a>
			</div>
		</div>
		<!-- END SECTION REFERRAL CODE -->
	</section>
@stop