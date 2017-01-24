<div class="row ml-0 mr-0">
	<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 bg-white border-1 border-solid border-grey-light no-border-xs">
		<form id="choice_payment">
			<div class="row pt-md pb-sm">
				<div class="col-md-12 hidden-xs">
					<h3 class="m-t-none m-b-md">Pilih Pembayaran</h3>
				</div>
				<div class="hidden-lg hidden-md hidden-sm col-xs-12 pb-0">
					<h3 class="m-t-none m-b-md">Pilih Pembayaran</h3>
					<p style="margin-top:-5px;">Step 4 from 5</p>
				</div>
			</div>

			@if($veritrans_option)
			<div class="row">
				<div class="col-md-12">
					<h4>Creadit Card</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<label class="control control--radio payment-list">
						<div class="row">
							<div class="col-md-11 col-sm-10 col-xs-10">
								<i class="sprite-vendor vendor-master-card payment-list-img"></i>
								<span class="pl-lg hidden-xs">Bayar Dengan MasterCard Credit Card</span>
								<span class="pl-sm hidden-lg hidden-md hidden-sm">MasterCard</span>
							</div>
							<div class="col-md-1 col-sm-2 col-xs-2 text-right">
								<input type="radio" value="veritrans" name="choice_payment" required tabindex="8" style="margin-top:15px;" />
							</div>
						</div>				
					</label>
				</div>
			</div>
		
			<div class="row">
				<div class="col-md-12">
					<label class="control control--radio payment-list">
						<div class="row">
							<div class="col-md-11 col-sm-10 col-xs-10">
								<i class="sprite-vendor vendor-visa payment-list-img"></i>
								<span class="pl-lg hidden-xs">Bayar Dengan Visa Credit Card</span>
								<span class="pl-sm hidden-lg hidden-md hidden-sm">Visa</span>
							</div>
							<div class="col-md-1 col-sm-2 col-xs-2 text-right">
								<input type="radio" value="veritrans" name="choice_payment" required tabindex="8" style="margin-top:15px;" />
							</div>
						</div>				
					</label>
				</div>
			</div>
			@endif


			<div class="row">
				<div class="col-md-12">
					<h4>Bank Transfer</h4>
				</div>
			</div>		

			<div class="row">
				<div class="col-md-12">
					<label class="control control--radio payment-list">
						<div class="row">
							<div class="col-md-11 col-sm-10 col-xs-10">
								<i class="sprite-vendor vendor-bca payment-list-img"></i>
								<span class="pl-lg hidden-xs">Bayar Via Bank BCA</span>
								<span class="pl-sm hidden-lg hidden-md hidden-sm">BCA</span>							
							</div>
							<div class="col-md-1 col-sm-2 col-xs-2 text-right">
								<input type="radio" value="transfer" name="choice_payment" required tabindex="8" style="margin-top:15px;" />
							</div>
						</div>				
					</label>
				</div>
			</div>	

			<div class="row">
				<div class="col-md-12">
					<label class="control control--radio payment-list">
						<div class="row">
							<div class="col-md-11 col-sm-10 col-xs-10">
								<i class="sprite-vendor vendor-mandiri payment-list-img"></i>
								<span class="pl-lg hidden-xs">Bayar Via Bank Mandiri</span>
								<span class="pl-sm hidden-lg hidden-md hidden-sm">Mandiri</span>							
							</div>
							<div class="col-md-1 col-sm-2 col-xs-2 text-right">
								<input type="radio" value="transfer" name="choice_payment" required tabindex="8" style="margin-top:15px;" />
							</div>
						</div>				
					</label>
				</div>
			</div>	

			@if($veritrans_option)
			<div class="row">
				<div class="col-md-12">
					<label class="control control--radio payment-list">
						<div class="row">
							<div class="col-md-11 col-sm-10 col-xs-10">
								<i class="sprite-vendor vendor-atm-bersama payment-list-img"></i>
								<span class="pl-lg hidden-xs">Bayar Via Jaringan ATM Bersama</span>
								<span class="pl-sm hidden-lg hidden-md hidden-sm">ATM Bersama</span>
							</div>
							<div class="col-md-1 col-sm-2 col-xs-2 text-right">
								<input type="radio" value="veritrans" name="choice_payment" required tabindex="8" style="margin-top:15px;" />
							</div>
						</div>				
					</label>
				</div>
			</div>	
			@endif

			<div class="row">
				<div class="col-md-12">
				 	<label id="choice_payment_error" class="warning" for="voucher" style="display:none;">Anda belum memilih metode pembayaran</label>
				</div>
			</div>	
			<div class="row mt-md mb-md">
				<div class="col-md-12">
					<h5>Powered by &nbsp; <span class="sprite-vendor vendor-midtrans"></span></h5>
				</div>
			</div>								
		</form>
		<div class="row pt-md pb-md">
			<div class="col-xs-4 col-sm-4 col-md-6 col-lg-6">
				<a href="javascript:void(0);" class="btn btn-transaparent-border-black-hover-black btn_step" 
				data-target="#sc3"  
				data-value="#sc4"
				data-param="0"
				data-type="prev"
				data-url="{{ route('my.balin.checkout.get', ['section' => 'sc3']) }}">
				<i class="fa fa-angle-double-left" aria-hidden="true"></i>
				&nbsp;
				Kembali</a>
			</div>
			<div class="col-xs-8 col-sm-8 col-md-6 col-lg-6 text-right">
				<a href="javascript:void(0);" class="btn btn-orange btn_step btn_next btn_payment" 
				data-action="{{ route('my.balin.checkout.choicepayment') }}"
				data-target="#sc5"  
				data-value="#sc4"
				data-param="4"
				data-type="next"
				data-event="choice_payment"
				data-url="{{ route('my.balin.checkout.get', ['section' => 'sc5']) }}">Lanjutkan
				&nbsp;
				<i class="fa fa-angle-double-right" aria-hidden="true"></i>
				</a>
			</div>
		</div>
	</div>
</div>
