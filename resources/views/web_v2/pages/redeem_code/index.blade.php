@extends('web_v2.page_templates.layout')

@section('balin-point-nav')
	text-orange
@stop

@section('content')
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix hidden-xs hidden-sm">&nbsp;</div>
	<div class="clearfix hidden-xs hidden-sm">&nbsp;</div>
	<section class="container">
		<div class="row bg-grey ml-0 mr-0">
			<!-- SECTION REFERRAL CODE & BALIN POINT -->
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pt-lg pb-lg border-top-1 border-white">
				<div class="row">
					<!-- SECTION REFERAAL CODE -->
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pb-0 p-md ">
						<h4 class="pull-left">Referal Code 
							<small>
								<a href="#" class="hover-orange text-black mtm-5" 
									data-toggle="modal" 
									data-target=".modal-referral-code">
									<i class="fa fa-question-circle"></i>
								</a>
							</small>
						</h4>	
						<p class="pull-right mt-5 mb-5 text-uppercase text-bold">
							{{ isset($data['me']['data']['code_referral']) ? $data['me']['data']['code_referral'] : '' }}
						</p>
					</div>
					<div class="hidden-md hidden-lg mtm-xs mbm-xs">&nbsp;</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mtm-xs mb-sm pr-md">
						<p class="mtm-xs pull-right">
							<a class="hover-orange text-sm" href="#" 
								data-toggle="modal" 
								data-target=".modal-user-information" 
								data-action="{{ route('my.balin.invitation.create') }}" 
								data-modal-title="Bagikan via Email" 
								data-from="{{ Route::currentRouteName() }}"
								data-view="modal-lg">[ Bagikan via Email ]</a>
						</p>
					</div>
				</div>
				<!-- END SECTION REFERRAL CODE -->
				<!-- SECTION BALIN POINT -->
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-0 pb-0 p-md">
						<h4 class="pull-left">Balin Point Anda 
							<small>
								<a href="#" class="hover-orange text-black help" 
									data-toggle="modal" 
									data-target=".modal-balin-point">
									<i class="fa fa-question-circle fa-1x"></i>
								</a>
							</small>
						</h4>
						<p class="mt-5 mb-5 pull-right text-bold">@money_indo($data['me']['data']['total_point'])</p>
					</div>
					<div class="hidden-md hidden-lg mtm-xs mbm-xs">&nbsp;</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mtm-xs mb-sm pr-md">
						<p class="mtm-xs pull-right">
							<a class="hover-orange text-sm" href="#" 
								data-toggle="modal" 
								data-target=".modal-user-information" 
								data-action="{{ route('my.balin.profile.point', $data['me']['data']['id']) }}" 
								data-modal-title="History Point Anda" 
								data-view="modal-lg">[ History ]</a>
						</p>
					</div>
				</div>
				<!-- END SECTION BALIN POINT -->
			</div>
			<!-- END SECTION REFERRAL CODE & BALIN POINT -->

			<!-- SECTION FORM INPUT REFERRAL CODE -->
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pt-lg pb-lg border-top-1 border-white">
				<div class="row">
					<div class="col-md-12 p-md">
						<h4 class="m-t-sm">Punya Referal Code ?</h4>
					</div>	
				</div>
				{!! Form::open(['url' => route('my.balin.redeem.store')]) !!}
					{!! Form::hidden('to', Route::currentRouteName()) !!}
					<div class="row mb-sm">
						<div class="col-md-11 pl-md pr-md mb-md">
							<div class="input-group" style="position:relative">
								<div class="loading-voucher text-center hide">
									{!! Html::image('images/loading.gif', null, ['style' => 'width:20px']) !!}
								</div>
								{!! Form::hidden('from', 'my.balin.redeem.index') !!}
								{!! Form::input('text', 'referral_code', null, [
										'class' => 'form-control hollow transaction-input-voucher-code m-b-sm check-voc-ref',
										'placeholder' => 'Referal code referensi',
								]) !!}
								<span class="input-group-btn">
									<button type="submit" class="btn btn-black-hover-white-border-black" data-action="">Gunakan</button>
								</span>
							</div>
						</div>
					</div>
				{!! Form::close() !!}
			</div>
			<!-- END SECTION FORM INPUT REFERRAL CODE -->
		</div>
	</section>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>

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
					<div class="row ml-xl mr-xl">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pr-md pl-md">
							<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
							<h5 class="modal-title" id="exampleModalLabel">History Balance</h5>
						</div>
					</div>
				</div>
				<div class="modal-body m-md pt-5 mt-sm">
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
				<div class="modal-body mt-75 mobile-m-t-10 ml-xl mr-xl" style="text-align:left">
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
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
							<h5 class="modal-title" id="exampleModalLabel">Referal Code</h5>
						</div>
					</div>
				</div>
				<div class="modal-body mt-75 mobile-m-t-10 ml-xl mr-xl" style="text-align:left">
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

@section('js')
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
@stop