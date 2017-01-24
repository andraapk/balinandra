@foreach ($card as $k => $v)
	<?php $link = json_decode($v['value'], true);?>
	<div class="{{ $col }}">
		<div class="card">
			<a href="{{$link['action']}}" target="_blank">
				{!! Html::image($v['thumbnail'], '@balinid', ['class' => 'card-img-top center-block img-responsive']) !!}
				<div class="hover">
					<i class="fa fa-instagram fa-2x text-white"></i>
				</div>
			</a>
		</div>
	</div>
@endforeach