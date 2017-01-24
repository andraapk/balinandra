<!-- SECTION INVITE -->
<div class="row ml-0 mr-0">
	<div class="col-sm-12 pl-md pr-md">
		@include('web_v2.components.alert-box')
		<h4>Dapatkan poin, saat anda membagikan referal code anda.</h4>
		<h6 class="text-red">Gunakan comma untuk mengirim ke banyak email</h6>

		{!! Form::open(['url' => route('my.balin.invitation.store'), 'method' => 'POST']) !!}
			{!! Form::hidden('to', Route::currentRouteName(), ['class' => 'from_route']) !!}
			<div class="row mb-sm">
				<div class="col-md-12 mb-md">
					{!! Form::textarea('emails', '', ['class' => 'form-control form_email', 'placeholder' => 'Ketik email disini (gunakan comma untuk mengirim ke banyak email)', 'style' => 'width:100%;resize:none', 'rows' => 3]) !!}
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-md">
					<button type="submit" class="btn btn-orange" data-action=""><i class="fa fa-envelope-o"></i> Kirim</button>
				</div>
			</div>
		{!! Form::close() !!}
		<div class="row mt-lg">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<p>
					Lihat daftar yang telah dibagikan 
					<a class="hover-orange text-grey-dark hover-black text-underline" href="#" 
						data-toggle="modal" 
						data-target=".modal-sub-user-information" 
						data-action="{{ route('my.balin.invitation.index') }}" 
						data-modal-title="Daftar Undangan" 
						data-view="modal-lg">[ Klik ]</a>
				</p>
			</div>
		</div>
	</div>
</div>
<!-- END SECTION INVITE -->