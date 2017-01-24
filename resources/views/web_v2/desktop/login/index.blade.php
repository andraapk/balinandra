@extends('web_v2.page_templates.layout')

@section('balin-login-nav')
	text-orange
@stop

@section('content')
<?php
//get type
if(Session::has('type')){
	$type = Session::get('type');
}elseif(Request::input('type')){
	$type = Request::input('type');
}else{
	$type = 'login'; 
}
?>
	<div class="container-fluid background">
		<div class="row">
			{{-- signup preface --}}
			<div class="hidden-xs hidden-sm col-md-7 col-lg-7 text-center preface">
				<div class="row">
					{!! Html::image('images/white_logo_balin.png', null, ['class' => 'logo']) !!}
				</div>
				<div class="row mb-md">
					<p class="tagline">Fashionable and Modern Batik</p>
				</div>
				<div class="row mb-xl">
					<p class="large">Sign Up Now. </br> Experience Our Best In Everything.</p>
				</div>
				<div class="row mb-sm">
					<p>We Crafting Best Batik For You</p>
				</div>
				<div class="row">
					<p>
						<i class="fa fa-check text-orange" aria-hidden="true"></i>
						100% Cotton Or Premium Cotton
					</p>
					<p>
						<i class="fa fa-check text-orange" aria-hidden="true"></i>
						Modern Pattern
					</p>
					<p>
						<i class="fa fa-check text-orange" aria-hidden="true"></i>
						Fashionable Model
					</p>
				</div>
			</div>

			{{-- signup , signin , register --}}
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
				<div class="row panel-akun p-xs mt-md">
					<div class="col-md-12 text-center">
						<div class="signup" style="{{ $type == 'signup' ? 'display:block;' : 'display:none;' }}">
							<h2 class="text-center mb-lg">Sign Up</h2>
							@include('web_v2.components.alert-box')
							@include('web_v2.components.signup.form')						
						</div>
						<div class="signin" style="{{ $type == 'login' ? 'display:block;' : 'display:none;' }}">
							<h2 class="text-center mb-lg">Sign In</h2>
							@include('web_v2.components.alert-box')
							@include('web_v2.components.login.form')
							<div class="col-sm-12 hidden-md hidden-lg">
								<p class="text-light mt-0 hidden-md hidden-lg btn-signup">Belum mendaftar ? <a href="#" class="text-orange">Sign Up</a></p>
							</div>								
						</div>						
						<div class="forgot" style="{{ $type == 'forgot' ? 'display:block;' : 'display:none;' }}">
							<h2 class="text-center mb-lg">Reset Password</h2>
							@include('web_v2.components.alert-box')
							@include('web_v2.components.forgot.form')
						</div>
					</div>
				</div>
				<div class="row p-xs">
					<div class="col-md-12 auth">
						<p class="signup text-white" style="{{ $type == 'signup' ? 'display:block;' : 'display:none;' }}">
							Sudah Terdaftar?
							<a href="javascript:void(0);" class="text-orange btn-signin">
								Sign In
							</a> 
						</p>
						<p class="signin text-white" style="{{ $type == 'login' ? 'display:block;' : 'display:none;' }}">
							Belum Punya Akun?
							<a href="javascript:void(0);" class="text-orange btn-signup">
								Sign Up
							</a> 
						</p>
						<p class="forgot text-white" style="display:none; color:white !important;">
							Belum Punya Akun?
							<a href="javascript:void(0);" class="text-orange btn-signup">
								Sign Up
							</a> 
						</p>												
					</div>
				</div>
			</div>
		</div>

		<!-- Term and Condition -->
		<div id="tnc" class="modal modal-left modal-fullscreen fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<div class="row ml-xl mr-xl">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pr-md pl-md">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h5 class="modal-title" id="exampleModalLabel">Syarat & Ketentuan</h5>
							</div>
						</div>
					</div>
					<div class="modal-body">
						<div class="row ml-xl mr-xl">
							<div class="col-xs-12 col-sm-12 col-md-12 text-black text-light pr-md pl-md">
								{!! $balin['term_and_condition']['value'] !!}
							</div>
						</div>
						<div class="row ml-xl mr-xl">
							<div class="col-xs-12 col-sm-12 col-md-12 pr-md pl-md">
								<button type="button" class="btn btn-black-hover-white-border-black btn-sm" data-dismiss="modal" aria-label="Close">Tutup</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop

@section('js')
	$('.btn-signin').click( function() {
		$('.signup').hide();
		$('.signin').toggle();
		$('.forgot').hide();
	});
	$('.btn-signup').click( function() {
		$('.signup').show();
		$('.signin').hide();
		$('.forgot').hide();
	});
	$('.btn-cancel').click( function() {
		$('.signup').hide();
		$('.forgot').hide();
		$('.signin').show();
	});
	$('.btn-forgot').click( function() {
		$('.signup').hide();
		$('.signin').hide();
		$('.forgot').show();
	});	
@stop

@section('wrapper_class')
	bg-login-page
@stop

@section('script_plugin')

@stop