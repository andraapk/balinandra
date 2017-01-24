@extends('web_v2.page_templates.layout')

@section('content')
	<!-- CONTENT -->
	<div class="clearfix">&nbsp;</div>
	<section class="container">
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="row">
					<div class="col-md-12">
						<h3>Contact Us</h3>
						<div class="clearfix">&nbsp;</div>
						@include('web_v2.components.alert-box')

						{!! Form::open(['url' => route('balin.email.us')]) !!}
						    <div class="form-group">
						        <label for="name" style="font-weight:400">Nama *</label>
								{!! Form::text('name', (Session::has('whoami') ? Session::get('whoami')['name'] : ''), [
											'class'         => 'form-control hollow', 
											'tabindex'      => '1', 
											'placeholder'   => 'Masukkan nama anda',
											'required' 		=> 'required'
								]) !!}
						    </div>
						    <div class="form-group">
						        <label for="email" style="font-weight:400">Email *</label>
								{!! Form::email('email', (Session::has('whoami') ? Session::get('whoami')['email'] : ''), [
											'class'         => 'form-control hollow', 
											'tabindex'      => '2', 
											'placeholder'   => 'Masukkan email anda',
											'required' 		=> 'required'
								]) !!}
						    </div>

						    <div class="form-group">
							    <label for="message" style="font-weight:400">Pesan *</label>
								{!! Form::textarea('message',null, [
											'class'         => 'form-control hollow', 
											'placeholder'   => 'Masukkan pesan anda',
											'rows'          => '5',
											'tabindex'      => '3',
											'style'         => 'resize:none;',
											'required' 		=> 'required'
								]) !!}
							</div>
							<p class="t-xs" style="color:#666">
								* wajib untuk diisi.
							</p>
							<div class="clearfix">&nbsp;</div>
							<div class="form-group text-right">
							    <button type="submit" class="btn btn-orange buy " tabindex="4">Kirim</button>
							</div>
							<div class="clearfix">&nbsp;</div>
						{!! Form::close() !!}
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 hide-xs">
				<div class="row">
					<div class="col-md-12 text-center">					
						<h3>We'd love to help!</h3>
					</div>
				</div>
				<div class="row clearfix">&nbsp;</div>
				<div class="row">
					<div class="col-md-12 text-center">						
						<p><i class="fa fa-map-marker"></i> &nbsp;{{ $balin['info']['address']['value'] }}</p>
					</div>						
				</div>
				<div class="row">
					<div class="col-md-12 text-center">						
						<p><i class="fa fa-envelope"></i> &nbsp;{{ $balin['info']['email']['value'] }}</p>
					</div>						
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
						<p><i class="fa fa-mobile"></i> &nbsp;{{ $balin['info']['phone']['value'] }}</p>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
						<p><i class="fa fa-whatsapp"></i> &nbsp;{{ $balin['info']['phone']['value'] }}</p>
					</div>
				</div>
				<div class="row clearfix">&nbsp;</div>
				@if(isset($balin['info']['instagram_url']) || isset($balin['info']['twitter_url']) || isset($balin['info']['facebook_url']))
					@if(!empty($balin['info']['instagram_url']['value']) || !empty($balin['info']['twitter_url']['value']) || !empty($balin['info']['facebook_url']['value']))
						<div class="row">
							<div class="col-md-12 text-center">
								<h3>Also find us on</h3>
							</div>
						</div>
					@endif
				@endif

				<div class="clearfix">&nbsp;</div>
				<div class="row">
					<div class="col-md-12 text-center">
					@if(isset($balin['info']['instagram_url']) && !empty($balin['info']['instagram_url']['value']))
						<a href="{{$balin['info']['instagram_url']['value']}}" target="blank" class="btn btn-socmed mr-xs info"><i class="fa fa-instagram"></i></a>
					@endif

					@if(isset($balin['info']['twitter_url']) && !empty($balin['info']['twitter_url']['value']))
						<a href="{{$balin['info']['twitter_url']['value']}}" target="blank" class="btn btn-socmed mr-xs info"><i class="fa fa-twitter"></i></a>
					@endif

					@if(isset($balin['info']['facebook_url']) && !empty($balin['info']['facebook_url']['value']))
						<a href="{{$balin['info']['facebook_url']['value']}}" target="blank" class="btn btn-socmed mr-xs info"><i class="fa fa-facebook"></i></a>
					@endif
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- END CONTENT -->
@stop
