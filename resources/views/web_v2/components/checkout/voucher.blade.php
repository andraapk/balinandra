<div class="row ml-0 mr-0">
	<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 bg-white border-1 border-solid border-grey-light no-border-xs">
		<div id="content_voucher">
			@if (!isset($data['order']['data']['voucher']))
				<div class="row mb-sm">
					<div class="hidden-xs col-md-12">
						<h3 class="text-normal">Punya Kode Voucher ?</h3>
					</div>	
					<div class="hidden-lg hidden-md hidden-sm col-xs-12 pt-md">
						<h3 class="m-t-none m-b-md">Punya Kode Voucher ?</h3>
						<p style="margin-top:-5px;">Step 2 from 5</p>
					</div>
				</div>	
				<div class="row pt-md pb-sm panel_form_voucher">
					<div class="col-md-12 mb-xs">
						<p class="text-light">Masukan kode voucher Anda dan dapatkan diskon terbaik dari kami. </br> <span style="font-size:11px;">*Kosongkan bila tidak ada</span></p>
						<div class="mt-xs mb-xs" style="position:relative">
							<div class="text-center hide loading loading_voucher" style="z-index:99;">
								{!! Html::image('images/loading.gif', null, []) !!}
							</div>
							{!! Form::text('voucher', null, [
								'class' 		=> 'form-control transaction-input-voucher-code text-regular voucher_desktop',
								'placeholder' 	=> 'Voucher code',
								'style'			=> 'width:100%',
								'data-action'	=> route('my.balin.checkout.voucher')
							]) !!}
						</div>
							<label id="voucher-error" class="warning" for="voucher" style="display:none;">Kode Voucher yang Anda masukan tidak valid. Silahkan cek ulang kode Anda atau kosongkan untuk melanjutkan.</label>
					</div>
				</div>
			@else
				<div class="row pt-md pb-sm">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<p>
							@if ($data['order']['data']['voucher']['type'] == 'free_shipping_cost')
								Selamat! Anda mendapat potongan : gratis biaya pengiriman.
							@elseif ($data['order']['data']['voucher']['type'] == 'debit_point')
								Selamat! Anda mendapat bonus balin point sebesar {{ $data['order']['data']['voucher']['value'] }} (Balin Point akan ditambahkan jika pesanan sudah dibayar)
							@endif
						</p>
					</div>
				</div>
			@endif
		</div>
		<div class="row pt-md pb-md">
			<div class="col-xs-4 col-sm-4 col-md-6 col-lg-6">
				<a href="javascript:void(0);" class="btn btn-transaparent-border-black-hover-black btn_step" 
				data-target="#sc1"  
				data-value="#sc2"
				data-param="0"
				data-type="prev"
				data-url="{{ route('my.balin.checkout.get', ['section' => 'sc1']) }}">
				<i class="fa fa-angle-double-left" aria-hidden="true"></i>
				&nbsp;
				Kembali</a>
			</div>
			<div class="col-xs-8 col-sm-8 col-md-6 col-lg-6 text-right">
				<a id="trick-voucher" href="javascript:void(0);" class="btn btn-orange btn_step next_voucher" 
				data-action="{{ route('my.balin.checkout.voucher') }}" 
				data-target="#sc3"  
				data-value="#sc2"
				data-param="2"
				data-type="next"
				data-event="voucher"
				data-lock="1"
				data-url="{{ route('my.balin.checkout.get', ['section' => 'sc3']) }}">Lanjutkan
				&nbsp;
				<i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
			</div>
		</div>
	</div>
</div>