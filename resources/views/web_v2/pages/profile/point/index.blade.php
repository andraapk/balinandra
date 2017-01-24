<?php 
	// dd($data['point']); 
?>
<!-- SECTION POINT DESKTOP -->
<div class="hidden-xs hidden-sm">
	<div class="row m-sm">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<h4 class="text-light">Point Anda Sekarang <span class="text-bold"> @money_indo($data['me']['total_point'])</span></h4>
		</div>
	</div>
	<div class="row ml-0 mr-0 pl-xl pr-xl">
		<div class="col-md-12 col-sm-12 border-bottom-1 border-grey-dark pr-md pr-md">
			<div class="row text-grey-dark ml-0 mr-0">
				<div class="col-sm-3">
					<h5>Tanggal</h5>
				</div>
				<div class="col-sm-2 ">
					<h5 class="p-r-sm">Saldo</h5>
				</div>
				<div class="col-sm-3">
					<h5>Expired</h5>
				</div>
				<div class="col-sm-4">
					<h5>Info</h5>
				</div>
			</div>
		</div>
	</div>
	<div class="row ml-0 mr-0 pl-sm pr-sm">
		<div class="col-md-12 col-lg-12 pl-sm pr-sm">
			@forelse ($data['point']['data'] as $k => $v)
				<?php
					$datetrans				= Carbon::now();

					if ($v['expired_at'] < $datetrans)
					{
						$is_expired			= true;
					}
					else
					{
						$is_expired 		= false;
					}
				?>
				<div class="row ml-0 mr-0 pl-sm pr-sm {{ ($v != end($data['point']['data'])) ? 'border-bottom-1 border-grey-dark' : '' }}">
					<div class="col-md-3 col-lg-3">
						<p>@datetime_indo($v['created_at'])</p>
					</div>
					<div class="col-md-2">
						<p>
							@if (!$is_expired)
								@money_indo(  ($v['prev_amount'] + $v['amount']) )
							@else
								<i>Expired</i>
							@endif
						</p>
					</div>
					<div class="col-md-3">
						<p>@datetime_indo($v['expired_at'])</p>
					</div>
					<div class="col-md-4">
						<p>
							Point Anda {{ ($v['amount'] > 0) ? 'Bertambah' : 'Berkurang' }} @money_indo( abs($v['amount']) )
							{{ $v['notes'] }}
						</p>
					</div>
				</div>
			@empty
				<div class="row ml-0 mr-0 pl-sm pr-sm">
					<div class="col-md-12 col-lg-12">
						<p class="mt-5 mb-5 text-center"> Belum memiliki history point </p>
					</div>
				</div>
			@endforelse
		</div>
	</div>
</div>
<!-- END SECTION POINT DESKTOP -->

<!-- SECTION POINT MOBILE, TABLET -->
<div class="hidden-md hidden-lg">
	<div class="row m-md border-bottom-1 border-grey-light">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center mb-sm">
			<h4 class="text-light mb-0">Point Anda Sekarang</h4>
			<h4 class="text-bold"> @money_indo($data['me']['total_point'])</h4>
		</div>
	</div>
	<div class="row m-md">
		<div class=" col-xs-12">
			<?php $prev_amount = 0; ?>
			@forelse ($data['point']['data'] as $k => $v)
				<?php
					$datetrans				= Carbon::now();

					if ($v['expired_at'] < $datetrans)
					{
						$is_expired			= true;
					}
					else
					{
						$is_expired 		= false;
					}
				?>
				<div class="row mt-5 {{ ($v != end($data['point']['data'])) ? 'border-bottom-1 border-grey-light' : '' }}">
					<div class="col-xs-12 text-center">
						<p class="text-regular mb-5">@datetime_indo( $v['created_at'] )</p>
						@if ($v['amount'] > 0)
							<p class="text-lg mb-5 text-green">
								<span>(+)</span> @money_indo( abs($v['amount']) )
							</p>
						@else
							<p class="text-lg mb-5 text-red">
								<span>(-)</span> @money_indo( abs($v['amount']) )
							</p>
						@endif
						<p class="text-xs mb-0">Poin Anda sekarang</p>
						<p class="mt-0 mb-0">
							@if (!$is_expired)
								@money_indo( ($v['prev_amount'] + $v['amount']) )
							@else
								<i>Expired</i>
							@endif
						</p>
						<h4 class="text-lg text-light mt-5 mb-5">{!! $v['notes'] !!}</h4>
						<p class="text-xs">expired on</br> <span class="text-sm">@date_indo( $v['expired_at'] )</span></p>
					</div>
				</div>
				<?php $prev_amount 	= $prev_amount + $v['amount']; ?>
			@empty
				<div class="row">
					<div class="col-xs-12">
						<p class="text-center"> Belum memiliki history point </p>
					</div>
				</div>
			@endforelse
		</div>
	</div>
</div>