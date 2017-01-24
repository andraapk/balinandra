<footer class="container-fluid bg-grey text-black">
	{{-- -------------------------------- DESKTOP -------------------------------- --}}
	<div class="row hidden-xs">
		<div class="col-md-12">
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-sm-3">
						<h4>Tentang BALIN</h4>
						<ul class="list-unstyled">
							<li><a href="{{route('balin.info.index', ['type' => 'about-us'])}}" class="hover-orange">About Us</a></li>
							<li><a href="{{route('balin.info.index', ['type' => 'terms-conditions'])}}" class="hover-orange">Terms &#38; Conditions</a></li>
							@if (Session::has('whoami'))
								<li><a href="{{route('my.balin.redeem.index')}}" class="hover-orange">BALIN Point</a></li>
							@else
								<li><a href="{{route('balin.info.index', ['type' => 'why-join'])}}" class="hover-orange">BALIN Point</a></li>
							@endif
						</ul>
					</div>
					<div class="col-md-3 col-sm-3">
						<h4>Keep in touch</h4>
						<ul class="list-unstyled fa-ul ml-0">
							<li><a href="{{route('balin.contact.us')}}" class="hover-orange">Kontak BALIN</a></li>
							<li><a href="{{$balin['info']['facebook_url']['value']}}" target="_blank" class="social-url-footer">Facebook</a></li>
							<li><a href="{{$balin['info']['instagram_url']['value']}}" target="_blank" class="social-url-footer">Instagram</a></li>
						</ul>
					</div>
					<div class="col-md-3 col-sm-3">
						<h4>Cara Pembayaran</h4>
						<ul class="list-unstyled text-grey-lightest">
							<li>Credit Card</li>
							<li>ATM Transfer</li>
							<li>CIMB Clicks</li>
							<li>E-pay BRI</li>
							<li>BCA Klikpay</li>
							<li>Telkomsel Cash</li>
							<li>XL Tunai</li>
							<li>BBM Money</li>
							<li>Indosat Dompetku</li>
							<li>Mandiri e-cash</li>
							<li>Mandiri bill payment</li>
							<li>Indomaret</li>
						</ul>
					</div>
					<div class="col-md-3 col-sm-3">
						<h4>Fast Payment</h4>
						<ul class="list-unstyled text-grey-lightest">
							<li>
							BCA </br>
							a/n Balin Indonesia CV </br>
							No. Rek. 011-325-5151
							</li>
							<li>&nbsp</li>
							<li>
							Bank Mandiri </br>
							a/n CV BALIN INDONESIA </br>
							No. Rek. 144-00-7000-7577
							</li>
							<li>&nbsp</li>
						</ul>
						<h4>Layanan Pelanggan</h4>
						<ul class="list-unstyled text-grey-lightest">
							<li>Jl. M.T. Haryono 116 Kav 2 Malang</li>
							<li>+628 223 225 0755</li>
							<li>help@balin.id</li>
						</ul>											
					</div>
				</div>
				<hr class="border-grey-dark">
				<div class="row">
					<div class="col-md-12 text-center">
						<span>&copy; 2015-2016 CV. Balin Indonesia</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	{{-- -------------------------------- MOBILE -------------------------------- --}}
	<div class="row hidden-md hidden-lg hidden-sm footer-mobile">
		<div class="col-xs-12 text-center">
		  	<p>&copy; 2015-2016 CV. Balin Indonesia</p>
		  	<p class="info">
		  		Jl. M.T. Haryono 116 Kav 2 Malang</br>
				+628 223 225 0755</br>
				help@balin.id
		  	</p>
		</div>
		<div class="col-xs-12 text-center">
			<a href="#" class="btn btn-sm btn-transaparent-border-black-hover-black">
				<i class="fa fa-instagram" aria-hidden="true"></i>
			</a>
			<a href="#" class="btn btn-sm btn-transaparent-border-black-hover-black">
				<i class="fa fa-facebook" aria-hidden="true"></i>
			</a>
		</div>
	</div>
</footer>