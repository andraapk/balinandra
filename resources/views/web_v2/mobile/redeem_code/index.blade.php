@extends('web_v2.page_templates.layout')

@section('content')
	<section class="container-fluid mtm-xs mb-md">
		<div class="row bg-grey">
			<div class="col-xs-12 pt-md pb-md">
				<h1 class="mt-sm mb-md">
					<span class="text-uppercase">{{ isset($data['me']['data']['code_referral']) ? $data['me']['data']['code_referral'] : '' }}</span>
				</h1>
				<a class="text-grey-dark hover-orange text-sm pull-right pr-xs referal_code" href="#" 
					data-toggle="modal" 
					data-target=".modal-invitation" 
					data-modal-title="Bagikan via Email" 
					data-from="{{ Route::currentRouteName() }}"
					data-view="modal-lg">[ Bagikan via Email ]</a>
			</div>
		</div>
	</section>
	<section class="container">
		@if (!Session::has('error_invite') && Session::get('error_invite') != '1')
		  	@include('web_v2.components.alert-box')
		@endif
		<div class="row text-center">
			<div class="col-xs-12 mt-md mb-xl">
				<p class="mt-5 mb-0 relative">
					BALIN Point anda saat ini
					<a href="#" class="hover-orange text-grey-dark text-regular help absolute pl-5" 
						data-toggle="modal" 
						data-target=".modal-balin-point">
						<i class="fa fa-question-circle"></i>
					</a>
				</p>
				<h1 class="mt-5 text-orange">@money_indo($data['me']['data']['total_point'])</h1>
				<a class="text-grey-dark hover-orange text-sm" href="#" 
					data-toggle="modal" 
					data-target=".modal-user-information" 
					data-action="{{ route('my.balin.profile.point', $data['me']['data']['id']) }}" 
					data-modal-title="History Point Anda" 
					data-view="modal-lg">[ Riwayat Balin Point ]</a>
			</div>
			<div class="col-xs-12 mt-md">
				{!! Form::open(['url' => route('my.balin.redeem.store'), 'class' => 'mt-0']) !!}
					<div class="form-group">
						<h4 class="relative">
							Punya Referal Code ?
							<a href="#" class="hover-orange text-grey-dark text-regular help absolute pl-5" 
								data-toggle="modal" 
								data-target=".modal-referral-code"
								style="top:0">
								<i class="fa fa-question-circle"></i>
							</a>
						</h4>
					</div>
					{!! Form::hidden('to', Route::currentRouteName()) !!}
					<div class="form-group">
						<div class="loading-voucher text-center hide">
							{!! Html::image('images/loading.gif', null, ['style' => 'width:20px']) !!}
						</div>
						{!! Form::hidden('from', 'my.balin.redeem.index') !!}
						{!! Form::input('text', 'referral_code', null, [
								'class' => 'form-control inline-block transaction-input-voucher-code check-voc-ref',
								'placeholder' => 'Referal code referensi',
								'style' => 'width:80%',
								'tabindex' => '1'
						]) !!}
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-orange" data-action="" tabindex="2">Gunakan</button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</section>
	<!-- SECTION MODAL FULLSCREEN INVITATION -->
	<div id="modal-balance" class="modal modal-invitation modal-fullscreen fade" tabindex="0" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<div class="row ml-xs mr-xs">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<button type="button" class="close close_modal" data-dismiss="modal" aria-label="Close">&times;</button>
							<h5 class="modal-title" id="exampleModalLabel"></h5>
						</div>
					</div>
				</div>
				<div class="modal-body">
					@include('web_v2.pages.profile.invitation.create')
				</div>
			</div>
		</div>
	</div>
	<!-- END SECTION MODAL FULLSCREEN INVITATION-->

	<!-- SECTION MODAL FULLSCREEN USER-INFORMATION -->
	<div id="modal-balance" class="modal modal-user-information modal-fullscreen fade" tabindex="0" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<div class="row ml-sm mr-sm">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
							<h5 class="modal-title" id="exampleModalLabel">History Balance</h5>
						</div>
					</div>
				</div>
				<div class="modal-body">
				</div>
			</div>
		</div>
	</div>
	<!-- END SECTION MODAL FULLSCREEN USER-INFORMATION-->

	<!-- SECTION MODAL SUB USER INFORMATION -->
	<div class="modal modal-sub-user-information modal-fullscreen fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-black text-white">
					<div class="row ml-xs mr-xs">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
							<h5 class="modal-title" id="exampleModalLabel">History Balance</h5>
						</div>
					</div>
				</div>
				<div class="modal-body pt-5 mt-sm">
				</div>
			</div>
		</div>
	</div>
	<!-- END SECTION MODAL SUB USER INFORMATION -->

	<!-- SECTION MODAL BALIN POINT -->
	<div id="" class="modal modal-balin-point modal-fullscreen fade modal-balance" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<div class="row ml-sm mr-sm">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
							<h5 class="modal-title" id="exampleModalLabel">Balin Point</h5>
						</div>
				   </div>
				</div>
				<div class="modal-body mt-75 mobile-m-t-10 ml-md mr-md" style="text-align:left">
					<p>Balin Point ini adalah voucher discount yang dapat anda gunakan untuk pembelian produk di Balin</p>
					<p>Untuk menambah jumlah Balin Point ini, ajak teman dan kerabat anda untuk melakukan registrasi di situs Balin.id dan berikan kode referal anda kepada mereka. Dengan menggunakan kode referal anda, teman anda akan mendapatkan Balin Point sebesar Rp. 50.000 dan anda akan mendapatkan Balin Point sebesar Rp. 10.000.</p>
					<p>Kode referal anda, pada mulanya hanya dapat anda berikan kepada 10 orang teman anda. Apabila teman yang menggunakan kode referal anda melakukan pembelian, anda akan mendapatkan tambahan kuota tersebut menjadi 11 dan anda akan mendapatkan Balin Point sebesar Rp. 10.000, dan demikian seterusnya tanpa ada batasnya.</p>
					<p>Semakin banyak teman yang menggunakan referal anda dan semakin sering teman yang anda referensikan melakukan pembelian, semakin besar voucher yang anda dapatkan.</p>
					<p>Balin Point tidak dapat diuangkan.</p>
				</div>
			</div>
		</div>
	</div>
	<!-- END SECTION MODAL BALIN POINT -->

	<!-- SECTION MODAL REFERRAL CODE -->
	<div id="" class="modal modal-referral-code modal-fullscreen fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<div class="row ml-sm mr-sm">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
							<h5 class="modal-title" id="exampleModalLabel">Referal Code</h5>
						</div>
					</div>
				</div>
				<div class="modal-body mt-75 mobile-m-t-10 ml-md mr-md" style="text-align:left">
					<p>Kode referal adalah kode akun anda di Balin.id. Anda dapat mengajak teman atau kerabat anda untuk mendaftar ke situs Balin.id dan berikan kode referal anda. Dengan menggunakan kode referal anda, teman anda akan mendapatkan Balin Point sebesar Rp. 50.000 dan anda akan mendapatkan Balin Point sebesar Rp. 10.000</p>
					<p>Kode referal anda, pada mulanya hanya dapat anda berikan kepada 10 orang teman anda. Apabila teman yang menggunakan kode referal anda melakukan pembelian, anda akan mendapatkan tambahan kuota tersebut menjadi 11 dan anda akan mendapatkan Balin Point sebesar Rp. 10.000, dan demikian seterusnya tanpa ada batasnya.</p>
					<p>Semakin banyak teman yang menggunakan referal anda dan semakin sering teman yang anda referensikan melakukan pembelian, semakin besar voucher yang anda dapatkan.</p>
					<p>Balin Point tidak dapat diuangkan.</p>
				</div>
			</div>
		</div>
	</div>
	<!-- END SECTION MODAL REFERRAL CODE -->
@stop

@section('balin-point-nav')
	text-orange
@stop

@section('js')
	// modal invitation
	$('.modal-invitation').on('show.bs.modal', function(e) {
		title 		= $(e.relatedTarget).attr('data-modal-title');
		view_mode 	= $(e.relatedTarget).attr('data-view');
		parsing 	= $(e.relatedTarget).attr('data-action-parsing');
		from 		= $(e.relatedTarget).attr('data-from');

		$(this).find('.modal-title').html(title);
		$(this).find('.modal-dialog').addClass(view_mode);
	});	

	// modal
	$('.modal-user-information').on('show.bs.modal', function(e) {
		action 		= $(e.relatedTarget).attr('data-action');
		title 		= $(e.relatedTarget).attr('data-modal-title');
		view_mode 	= $(e.relatedTarget).attr('data-view');
		parsing 	= $(e.relatedTarget).attr('data-action-parsing');
		from 		= $(e.relatedTarget).attr('data-from');

		$(this).find('.modal-body').html('<p class="ml-md mr-md pl-xs pr-xs">loading...</p>');
		$(this).find('.modal-title').html(title);
		$(this).find('.modal-dialog').addClass(view_mode);
		$(this).find('.modal-body').load(action, function() {
			if (parsing !== null && parsing !== undefined) {
				change_action($(this), parsing);
			}
			if (from !== null && from !== undefined) {
				$('.from_route').val(from);
			}
		});
	});	

	// sub modal in modal
	$('.modal-sub-user-information').on('show.bs.modal', function(e) {
		action 		= $(e.relatedTarget).attr('data-action');
		title 		= $(e.relatedTarget).attr('data-modal-title');
		view_mode 	= $(e.relatedTarget).attr('data-view');
		parsing 	= $(e.relatedTarget).attr('data-action-parsing');

		$(this).find('.modal-body').html('<p class="ml-md mr-md pl-xs pr-xs">loading...</p>');
		$(this).find('.modal-title').html(title);
		$(this).find('.modal-dialog').addClass(view_mode);
		$(this).find('.modal-body').load(action, function() {
			if (parsing !== null && parsing !== undefined) {
				change_action($(this), parsing);
			}
		});
	});	

	// check error in modal
	function dataError(){
		var data = '@if (Session::has('msg') || $errors->any())@foreach ($errors->all('<p>:message</p>') as $error)<p>{!! $error !!}</p>@endforeach @endif';
		if (data.toLowerCase().indexOf("email") >= 0){
			if (data != ''){
				$('.modal-invitation').modal('show');
			}
		}
	}
	$(document).ready(dataError);

	// remove data in modal invitation
	$('.referal_code').on('click', function() {
		alert = $('.modal-invitation').find('.alert');
		alert.parent().parent().remove();
		$('.form_email').text('');
	});
@stop