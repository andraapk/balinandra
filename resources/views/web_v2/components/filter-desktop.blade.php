<div class="panel panel-default mt-0" style="box-shadow: none !important;">
	<div class="panel-heading bg-white pb-sm pl-5 pr-5" role="tab" id="headingOne">
		<h4 class="panel-title">Filter
			<span class="pull-right">
				<a href="javascript:void(0);" data-url="{{route('balin.product.index', Input::only('categories'))}}" class="hover-orange clearall-filter">Clear all</a>
			</span>
		</h4>
	</div>
</div>

@foreach($data['tag'] as $key => $value)
	@if($value['category_id']==0)
		@if($key!=0)
				</ul>
			</div>
		</div>
		@endif

		<div class="panel panel-default mt-0">
			<div class="panel-heading" role="tab" id="headingOne">
				<h4 class="panel-title mb-0">{{$value['name']}}</h4>
			</div>
		</div>
		@if(str_is('warna*', $value['slug'])) 
			<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
				<div class="panel-body p-0 mt-xs mb-sm">
					<ul class="list-inline checkbox-color ml-xs mb-xs">
		@else
			<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
				<div class="panel-body p-0 mt-xs mb-sm">
					<ul class="list-unstyled ml-sm mb-0">
		@endif
	@endif
	@if($value['category_id']!=0)
		@if(str_is('warna*', $value['slug'])) 
			<li class="pl-0 pr-0 mb-sm {{ (Input::has('tags') && in_array($value['slug'], Input::get('tags'))) ? 'active' : '' }}">
				{!! Form::checkbox('tags[]', $value['slug'], (Input::has('tags') && in_array($value['slug'], Input::get('tags'))) ? true : null, ['id' => $value['slug'], 'class' => 'checkbox-color hide', 'data-type' => 'tags', 'data-filter' => $value['slug'], 'data-action' => $value['slug'], 'onClick' => 'ajaxFilter(this);']) !!} 
				<span class="color-item" style="background-color: {{$value['code']}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
			</li>
		@else
			<li>
				<div class="checkbox-custom">
					{!! Form::checkbox('tags[]', $value['slug'], (Input::has('tags') && in_array($value['slug'], Input::get('tags'))) ? true : null, ['id' => $value['slug'], 'class' => 'checkbox-filter', 'data-type' => 'tags', 'data-filter' => $value['slug'], 'data-action' => $value['slug'], 'onClick' => 'ajaxFilter(this);']) !!} 
					<label for="{{$value['slug']}}">
						<span>{{$value['name']}}</span>
					</label>
				</div>
			</li>
		@endif
	@endif
@endforeach
		</ul>
	</div>
</div>
