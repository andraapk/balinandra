@extends('web_v2.page_templates.layout')

@section('content')
	<div class="row mb-md ml-0 mr-0">
		<div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 text-center pl-0 pr-0">
			<div class="step-checkout text-light">
				<div class="" data-section="#sc1">
					<span>Pengiriman</span>
				</div>
				<div class="" data-section="#sc2">
					<span>Kode Voucher</span>
				</div>
				<div class="" data-section="#sc3">
					<span>Packaging Option</span>
				</div>
				<div class="" data-section="#sc4">
					<span>Pilih Pembayaran</span>
				</div>
				<div class="" data-section="#sc5">
					<span>Summary</span>
				</div>
			</div>
		</div>
	</div>

	<!-- SECTION FORM CHECKOUT -->
	
		{!! Form::hidden('voucher_id', (isset($data['voucher_id']) ? $data['voucher_id'] : ''), ['class' => 'voucher_code']) !!}
		{!! Form::hidden('order_id', $data['order']['data']['id']) !!}

		<div class="row pb-md">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<ul id="" class="list-unstyled">
					<li id="sc1" class="hide">
						<a href="#"></a>
						<div>
							<fieldset>
								@include('web_v2.components.checkout.address')
							</fieldset>
						</div>
					</li>
					<li id="sc2" class="hide">
						<a href="#"></a>
						<div>
							<fieldset>
								@include('web_v2.components.checkout.voucher')
							</fieldset>
						</div>
					</li>
					<li id="sc3" class="hide">
						<a href="#"></a>
						<div>
							<fieldset>
								@include('web_v2.components.checkout.accessories')
							</fieldset>
						</div>
					</li>
					<li id="sc4" class="hide">
						<a href="#"></a>
						<div>
							<fieldset>
								@include('web_v2.components.checkout.choice_payment')
							</fieldset>
						</div>
					</li>
					<li id="sc5" class="hide">
						<a href="#"></a>
						<div>
							<fieldset>
								@include('web_v2.components.checkout.review')
							</fieldset>
						</div>
					</li>
				</ul>
			</div>
		</div>

		{{-- <div class="row mr-0 ml-0">
			<div class="col-sm-12 pt-md pb-md">
				<div id="shipped" class="hide">
					
				</div>
				<div id="voucher" class="hide">
					@include('web_v2.components.checkout.voucher')
				</div>
				<div id="review" class="hide">
					@include('web_v2.components.checkout.review')
				</div>
			</div>
		</div> --}}

		<!-- SECTION CHECKBOX TERM & CONDITION FOR MOBILE & TABLET -->
		{{-- <div class="col-xs-12 hidden-lg hidden-md pt-sm">
			<div class="checkbox i-checks">
				<label class="text-regular"> 
					<input type="checkbox" value="1" name="term" class="" required>
					Saya menyetujui <a href="#" class="link-black unstyle vertical-baseline" data-toggle="modal" data-target="#tnc"><strong>Syarat & Ketentuan</strong></a> pembelian barang di Balin.
				</label>
			</div>
		</div> --}}
		<!-- END SECTION CHECKBOX TERM & CONDITION FOR MOBILE & TABLET  -->

		<!-- SECTION BUTTON CHECKOUT FOR MOBILE & TABLET -->
		{{-- <div class="clearfix">&nbsp;</div>
		<div class="row p-b-md p-t-xs hidden-md hidden-lg">
			<div class="col-md-12">
				<div class="form-group text-right">
					<button type="submit" class="btn btn-black-hover-white-border-black btn-block text-lg" tabindex="7">Checkout</button>
				</div>        
			</div>        
		</div>  --}} 			
		<!-- END SECTION BUTTON CHECKOUT FOR MOBILE & TABLET -->


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
						<div class="col-xs-12 col-sm-12 col-md-12 pr-md pl-md">
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

<!-- Modal Balance -->
<div id="modal-balance" class="modal modal-unique-number fade user-page" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
				<h5 class="modal-title" id="exampleModalLabel">Pengenal Pembayaran </h5>
			</div>
			<div class="modal-body mt-75 mobile-m-t-0" style="text-align:left">
				Pengenal Pembayaran adalah kode atau angka yang kami gunakan untuk mempermudah bagian finance (keuangan) kami dalam mengenali dana pembayaran yang masuk ke rekening kami. 
				Berbeda dengan toko online lainnya dimana kode seperti ini biasanya akan menambah jumlah pembayaran pelanggan, angka yang kami gunakan selalu minus, sehingga nilai pembayaran yang baru selalu lebih kecil dari nilai yang sebelumnya. Dengan demikian, para pelanggan kami tidak akan merasa dirugikan sepeserpun. 
				Saat ini, Pengenal Pembayaran ini hanya berlaku untuk metode pembayaran transfer saja.
			</div>
		</div>
	</div>
</div>

@stop

@section('js')
	$(".modal-fullscreen").on('show.bs.modal', function () {
		setTimeout( function() {
			$(".modal-backdrop").addClass("modal-backdrop-fullscreen");
		}, 0);
	});
	$(".modal-fullscreen").on('hidden.bs.modal', function () {
		$(".modal-backdrop").addClass("modal-backdrop-fullscreen");
	});

	@if (Input::get('section'))
		$( document ).ready(function() {
		    $('#{!! Input::get('section') !!}').removeClass('hide');
		    $('.step-checkout').find('div[data-section="#{!! Input::get('section') !!}"]').addClass('active');
		});
	@else
		$( document ).ready(function() {
		    $('#sc1').removeClass('hide');
		    $('.step-checkout').find('div[data-section="#sc1"]').addClass('active');
		});
	@endif

	$('.btn_accessories').click(function(){
		sub = $(this).parent().parent().find('.gift-value');
		sub_check = $(this).attr('data-check');
		flag = $(this).parent().parent().find('.extension_flag');

		if (sub_check==1) {
			$(sub).addClass('hide');
			$(this).attr('data-check', 0);
			$(this).text('Pilih').addClass('btn-black-hover-white-border-black').removeClass('btn-white-border-black-hover-black');
			flag.val('0');
		}
		else {
			$(sub).removeClass('hide');
			$(this).attr('data-check', 1);
			$(this).text('Batal').addClass('btn-white-border-black-hover-black').removeClass('btn-black-hover-white-border-black');
			flag.val('1');
		}
	});

	<!-- Modal payment -->
	$('.modal-payment').on('show.bs.modal', function(e) {
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
		});
	});	
@stop

@section('js_plugin')
	@include('web_v2.plugins.notif')

@stop
