<!-- SECTION REFERENCE -->
<div class="row ml-0 mr-0">
	<div class="col-sm-12 pl-xl pr-xl">
		{!! Form::open(['url' => route('my.balin.redeem.store'), 'method' => 'POST']) !!}
			{!! Form::hidden('to', Route::currentRouteName()) !!}
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="hollow-label" for="referral_code">Referral Code</label>
						{!! Form::text('referral_code', '', ['class' => 'form-control hollow mod_referral_code', 'required' => 'required', 'tabindex' => '1', 'placeholder' => 'Masukkan nama referral code referensi'] ) !!}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group text-right">
						<button type="submit" class="btn btn-orange" tabindex="2">Gunakan</button>
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
</div>
<!-- END SECTION REFERENCE -->