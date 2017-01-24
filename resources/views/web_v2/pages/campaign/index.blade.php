@extends('web.page_templates.layout_campaign')
@section('content')
	<div class="container-fluid softlaunch-sign-up" style="">
		<div class="row">
			<div class="hidden-xs hidden-sm col-md-7 col-lg-7">&nbsp;</div>
			<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
				<?php
				function isMobile() {
				    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
				}
				?>	

				<div class="row panel panel-default" style="margin-top: 10%">
					<div class="form-softlaunch p-md">
						@if (Session::has('msg-type') && Session::get('msg-type')=='success')
							<div class="text-center">
								<h3 class="">Selamat!</h3> 
								<p class="m-b-sm m-t-md">Anda mendapatkan Balin Point senilai</p> 
								<h3 class="m-b-none">@money_indo(Session::get('msg'))</h3>
								<p class="m-t-md m-b-md">Balin Point anda dapat digunakan untuk berbelanja di Balin.id. Stay tuned dan Balin will be launched on December 7th, 2015! </p>
							</div>
						@else
						<h3 class="">Early Sign Up</h3>
						{!! Form::open(['url' => '']) !!}
							<div class="form-group">
								<label for="" style="font-weight:400">Name</label>
								{!! Form::text('name', null, ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Nama', 'required']) !!}
							</div>
							<div class="form-group">
								<label for="" style="font-weight:400">Email</label>
								{!! Form::email('email', null, ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Email', 'required']) !!}
							</div>
							<div class="form-group">
								<label for="" style="font-weight:400">Password</label>
								{!! Form::password('password', ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Password', 'required']) !!}
							</div>
							<div class="form-group">
								<label for="" style="font-weight:400">Konfirmasi Password</label>
								{!! Form::password('password_confirmation', ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Konfirmasi Password', 'required']) !!}
							</div>

							@if(isset($is_invitation))
								<div class="form-group">
									<label for="" style="font-weight:400">Promo Referral</label>
									{!! Form::text('voucher', null, ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Promo Referral', 'required']) !!}
								</div>
							@endif
							<div class="form-group">
								<p>Dengan mendaftar ke akun balin saya menyetujui <a href="#" class="link-black hover-grey unstyle" data-toggle="modal" data-target="#tnc"><strong>Syarat & Ketentuan</strong></a> untuk dari pihak balin.id.</p>
							</div>
							<div class="form-group text-let">
							    <button type="submit" class="btn btn-black-hover-white-border-black">Sign Up</button>
							</div>
						{!! Form::close() !!}
						<div class="form-group">
							    <a href="#" class="btn btn-black-hover-white-border-black"><i class="fa fa-facebook"></i>&nbsp; Sign Up with Facebook</a>
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>	
	</div>
	<div id="tnc" class="modal modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="exampleModalLabel">Term & Condition</h4>
				</div>
				<div class="modal-body ribbon-menu">
					<div class="row">
						<div class="col-md-12">
							
						</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					<div class="row m-b-sm">
						<div class="col-md-12 text-center">
							<button type="button" class="btn-hollow hollow-black-border" data-dismiss="modal" aria-label="Close">Tutup</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop

@section('body_class')
	bg-login-page
@stop

@section('script_plugin')
	
@stop