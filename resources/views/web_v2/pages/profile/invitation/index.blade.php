<!-- SECTION POINT DESKTOP -->
<div class="hidden-xs hidden-sm">
	<div class="row m-sm">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<h4 class="text-light">Kuota Undang Teman <span class="text-bold">{{ $data['me']['data']['quota_referral'] }}</span></h4>
		</div>
	</div>
	<div class="row ml-0 mr-0 pl-xl pr-xl">
		<div class="col-md-12 col-sm-12 border-bottom-1 border-grey-dark pr-md pr-md">
			<div class="row text-grey-dark ml-0 mr-0">
				<div class="col-sm-2">
					<h5>#</h5>
				</div>
				<div class="col-sm-3 ">
					<h5>Tanggal</h5>
				</div>
				<div class="col-sm-3">
					<h5>Email</h5>
				</div>
				<div class="col-sm-3">
					<h5>Respon</h5>
				</div>
			</div>
		</div>
	</div>
	<div class="row ml-0 mr-0 pl-sm pr-sm">
		<div class="col-md-12 col-lg-12 pl-sm pr-sm">
			@if (count($data['invitations'])>0)
				@forelse ($data['invitations']['data'] as $k => $v)
					<div class="row ml-0 mr-0 pl-sm pr-sm {{ ($v != end($data['invitations']['data'])) ? 'border-bottom-1 border-grey-dark' : '' }}">
						<div class="col-md-2 col-lg-2">
							<p>{{ $k+1 }}</p>
						</div>
						<div class="col-sm-3">
							<p>@datetime_indo( $v['created_at'] )</p>
						</div>
						<div class="col-md-3">
							<p>{{ $v['email'] }}</p>
						</div>
						<div class="col-md-3">
							<p>
								@if($v['is_used'])
									<span class="label label-success">Mendaftar</span>
								@else
								@endif
							</p>
						</div>
					</div>
				@empty
					<div class="row ml-0 mr-0 pl-sm pr-sm">
						<div class="col-md-12 col-lg-12">
							<p class="mt-5 mb-5 text-center"> Belum mengundang teman </p>
						</div>
					</div>
				@endforelse
			@endif
		</div>
	</div>
</div>
<!-- END SECTION POINT DESKTOP -->

<!-- SECTION POINT MOBILE, TABLET -->
<div class="hidden-md hidden-lg">
	<div class="row border-bottom-1 border-grey-light">
		<div class="col-xs-12 col-sm-12 text-center mb-sm">
			<h4 class="text-light mb-0">Kuota Undang Teman</h4>
			<h4 class="text-bold">{{ $data['me']['data']['quota_referral'] }}</h4>
		</div>
	</div>
	<div class="row m-md">
		<div class=" col-xs-12">
			@if (count($data['invitations'])>0)
				@forelse ($data['invitations']['data'] as $k => $v)
					<div class="row mt-5 {{ ($v != end($data['invitations']['data'])) ? 'border-bottom-1 border-grey-light' : '' }}">
						<div class="col-xs-12 text-center">
							<p class="text-regular mb-5">@datetime_indo( $v['created_at'] )</p>
							<p class="text-md mb-0">{{ $v['email'] }}</p>
						</div>
					</div>
				@empty
					<div class="row">
						<div class="col-xs-12">
							<p class="text-center"> Belum memiliki history point </p>
						</div>
					</div>
				@endforelse
			@endif
		</div>
	</div>
</div>
