{{-- -------------------------------- MOBILE -------------------------------- --}}
<div class="row">
	<div class="carousel">


		@if(array_key_exists('1s', $data['shop_by_style']) == true)
		<div class="item">
			<div class="col-xs-12 pl-0 pr-0">
				<a href="{{ $data['shop_by_style']['1s']['action_url'] }}">
					<div class="tile text-center">
						{!! Html::image($data['shop_by_style']['1s']['images']['image_sm'], null, ['class' => 'img-responsive']) !!}
						<div class="jumbotron">
							<h4>{{ $data['shop_by_style']['1s']['caption']}} </h4>
						</div>
					</div>
				</a>
			</div>
		</div>
		@endif

		@if(array_key_exists('2s', $data['shop_by_style']) == true)
		<div class="item">
			<div class="col-xs-12 pl-0 pr-0">
				<a href="{{ $data['shop_by_style']['2s']['action_url'] }}">
					<div class="tile text-center">
						{!! Html::image($data['shop_by_style']['2s']['images']['image_sm'], null, ['class' => 'img-responsive']) !!}
						<div class="jumbotron">
							<h4>{{ $data['shop_by_style']['2s']['caption']}} </h4>
						</div>
					</div>
				</a>
			</div>
		</div>
		@endif

		@if(array_key_exists('3', $data['shop_by_style']) == true)
		<div class="item">
			<div class="col-xs-12 pl-0 pr-0">
				<a href="{{ $data['shop_by_style']['3']['action_url'] }}">
					<div class="tile text-center">
						{!! Html::image($data['shop_by_style']['3']['images']['image_sm'], null, ['class' => 'img-responsive']) !!}
						<div class="jumbotron">
							<h4>{{ $data['shop_by_style']['3']['caption']}} </h4>
						</div>
					</div>
				</a>
			</div>
		</div>
		@endif		

		@if(array_key_exists('4', $data['shop_by_style']) == true)
		<div class="item">
			<div class="col-xs-12 pl-0 pr-0">
				<a href="{{ $data['shop_by_style']['4']['action_url'] }}">
					<div class="tile text-center">
						{!! Html::image($data['shop_by_style']['4']['images']['image_sm'], null, ['class' => 'img-responsive']) !!}
						<div class="jumbotron">
							<h4>{{ $data['shop_by_style']['4']['caption']}} </h4>
						</div>
					</div>
				</a>
			</div>
		</div>
		@endif	

		@if(array_key_exists('5', $data['shop_by_style']) == true)
		<div class="item">
			<div class="col-xs-12 pl-0 pr-0">
				<a href="{{ $data['shop_by_style']['5']['action_url'] }}">
					<div class="tile text-center">
						{!! Html::image($data['shop_by_style']['5']['images']['image_sm'], null, ['class' => 'img-responsive']) !!}
						<div class="jumbotron">
							<h4>{{ $data['shop_by_style']['5']['caption']}} </h4>
						</div>
					</div>
				</a>
			</div>
		</div>
		@endif			

	</div>
</div>