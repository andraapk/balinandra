{{-- -------------------------------- DESKTOP -------------------------------- --}}
<div class="row">
	<div class="col-md-12">
		<div class="row">

{{-- -------------------------------- tile 1 -------------------------------- --}}
			<div class="col-sm-6">
				@if(array_key_exists('1', $data['shop_by_style']) == true)
				<a href="{{ $data['shop_by_style'][1]['action_url'] }}">
					<div class="tile text-center">
						{!! Html::image($data['shop_by_style'][1]['images']['image_lg'], null, ['class' => 'img-responsive']) !!}
						<div class="jumbotron">
							<h2 class="text-uppercase">{{ $data['shop_by_style'][1]['caption'] }}</h2>
						</div>
					</div>
				</a>
				@endif
			</div>

{{-- -------------------------------- tile 2 -------------------------------- --}}
			<div class="col-sm-6">
				@if(array_key_exists('2', $data['shop_by_style']) == true)
				<a href="{{ $data['shop_by_style'][2]['action_url'] }}">
					<div class="tile text-center">
						{!! Html::image($data['shop_by_style'][2]['images']['image_lg'], null, ['class' => 'img-responsive']) !!}
						<div class="jumbotron">
							<h2 class="text-uppercase">{{ $data['shop_by_style'][2]['caption'] }}</h2>
						</div>
					</div>
				</a>
				@endif
			</div>

		</div>
	</div>
</div>
<div class="row mt-xl hidden-xs">
	<div class="col-md-12">
		<div class="row">
{{-- -------------------------------- tile 3 -------------------------------- --}}
			<div class="col-sm-4 col-md-4">
				@if(array_key_exists('3', $data['shop_by_style']) == true)
					<a href="{{ $data['shop_by_style'][3]['action_url'] }}">
						<div class="tile text-center">
							{!! Html::image($data['shop_by_style'][3]['images']['image_lg'], null, ['class' => 'img-responsive']) !!}
							<div class="jumbotron">
								<h2 class="text-uppercase">{{ $data['shop_by_style'][3]['caption'] }}</h2>
							</div>
						</div>
					</a>
				@endif
			</div>

{{-- -------------------------------- tile 4 -------------------------------- --}}				
			<div class="col-sm-4 col-md-4">
				@if(array_key_exists('4', $data['shop_by_style']) == true)
					<a href="{{ $data['shop_by_style'][4]['action_url'] }}">
						<div class="tile text-center">
							{!! Html::image($data['shop_by_style'][4]['images']['image_lg'], null, ['class' => 'img-responsive']) !!}
							<div class="jumbotron">
								<h2 class="text-uppercase">{{ $data['shop_by_style'][4]['caption'] }}</h2>
							</div>
						</div>
					</a>
				@endif
			</div>

{{-- -------------------------------- tile 5 -------------------------------- --}}				
			<div class="col-sm-4 col-md-4">
				@if(array_key_exists('5', $data['shop_by_style']) == true)
					<a href="{{ $data['shop_by_style'][5]['action_url'] }}">				
						<div class="tile text-center">
							{!! Html::image($data['shop_by_style'][5]['images']['image_lg'], null, ['class' => 'img-responsive']) !!}
							<div class="jumbotron">
								<h2 class="text-uppercase">{{ $data['shop_by_style'][5]['caption'] }}</h2>
							</div>
						</div>
					</a>
				@endif	
			</div>

		</div>
	</div>
</div>
