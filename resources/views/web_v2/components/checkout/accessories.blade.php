<div class="row ml-0 mr-0">
	<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 bg-white border-1 border-solid border-grey-light no-border-xs">
		<div class="row pt-md pb-sm">
			<div class="hidden-xs col-sm-12 col-md-12">
				<h3 class="mt-0 text-normal">Packaging Option</h3>
			</div>
			<div class="hidden-lg hidden-md hidden-sm col-xs-12 pb-sm">
				<h3 class="m-t-none m-b-md">Packaging Option</h3>
				<p style="margin-top:-5px;">Step 3 from 5</p>
			</div>	
		</div>
		@if (!is_null($data['product_extension']['data']['data']))
			@forelse ($data['product_extension']['data']['data'] as $k => $v)
				<div class="row pt-md pb-sm">
					<div class="col-md-12 pt-0">
						<h6 class="mt-0 text-normal text-red">* Akan dikenakan biaya tambahan</h6>
					</div>
				</div>
				<div class="row ml-0 mr-0 pt-sm pb-sm border-bottom-1 border-grey-light text-regular line-height-30">

					{!! Form::hidden('flag[]', 0, ['class' => 'extension_flag']) !!}
					{!! Form::hidden('product_extension_id[]', $v['id'], ['class' => 'extension_id']) !!}
					{!! Form::hidden('price[]', $v['price'], ['class' => 'extension_price']) !!}

					<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
						<img src="{{ $v['thumbnail'] }}" class="img-responsive">
					</div>
					<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
						<p class="mb-0">{{ $v['name'] }}</p>
						<p class="text-grey-dark">{{ $v['description'] }}</p>
					</div>
					<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
						@money_indo( $v['price'] )
					</div>
					<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
						<a href="javascript:void(0);" class="btn btn-check btn-sm text-regular btn_accessories" data-check="0" data-sub="gift-value"></a>
					</div>
					@if ($v['is_customize'])
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-md gift-value gift_value hide">
							<div class="form-group">
								<label class="text-regular" for="">Pesan Anda</label>
								{!! Form::textarea('value[]', null, [
									'class'			=> 'form-control text-regular extension_value',
									'rows'			=> '5',
									'style'			=> 'resize:none;',
									'placeholder'	=> 'Tulis pesan anda'
								] ) !!}
							</div>
						</div>
					@else
						{!! Form::hidden('value[]', 1, ['class' => 'form-control text-regular extension_value']) !!}
					@endif
				</div>
			@empty
				<div class="row pt-md pb-sm">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-md">
						<p class="text-md text-light text-center">Maaf, Packaging Option saat ini masih belum tersedia. Silahkan tekan lanjutkan.</p>
					</div>
				</div>
			@endforelse
		@else
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<p class="text-md text-light">Maaf, Packaging Option saat ini belum tersedia</p>
				</div>
			</div>
		@endif
		<div class="clearfix">&nbsp;</div>
		<div class="clearfix">&nbsp;</div>
		<div class="row pt-md pb-md">
			<div class="col-xs-4 col-sm-4 col-md-6 col-lg-6">
				<a href="javascript:void(0);" class="btn btn-transaparent-border-black-hover-black btn_step" 
				data-target="#sc2"  
				data-value="#sc3"
				data-param="0"
				data-type="prev"
				data-url="{{ route('my.balin.checkout.get', ['section' => 'sc2']) }}">
				<i class="fa fa-angle-double-left" aria-hidden="true"></i>
				&nbsp;
				Kembali</a>
			</div>
			<div class="col-xs-8 col-sm-8 col-md-6 col-lg-6 text-right">
				<a href="javascript:void(0);" class="btn btn-orange btn_step" 
				data-action="{{ route('my.balin.checkout.extension') }}" 
				data-target="#sc4"  
				data-value="#sc3"
				data-param="3"
				data-type="next"
				data-event="gift"
				data-url="{{ route('my.balin.checkout.get', ['section' => 'sc4']) }}">Lanjutkan
				&nbsp;
				<i class="fa fa-angle-double-right" aria-hidden="true"></i>
				</a>
			</div>
		</div>
	</div>
</div>