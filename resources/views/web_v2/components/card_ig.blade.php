@foreach ($card as $k => $v)
	<?php $link = json_decode($v['value'], true);?>
	<div class="{{ $col }}">
		<div class="card" style="padding-bottom:20px;">
			<a href="{{$link['action']}}" target="_blank">
				<div style="height: 253px; overflow-y: hidden;">
					{!! Html::image($v['image_sm'], '@balinid', ['class' => 'card-img-top center-block img-responsive','style' => 'min-height:253px;object-fit: cover']) !!}
				</div>
				<div class="hover">
					<i class="fa fa-instagram fa-2x text-white"></i>
				</div>
			</a>
		</div>
	</div>
@endforeach