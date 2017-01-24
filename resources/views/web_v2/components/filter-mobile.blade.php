<div class="panel panel-default mt-0 border-grey" style="height:100%;">
	<div class="panel-heading relative" role="tab" id="headingTwo">
		<a role="button" data-target="#collapseTwo" data-toggle="collapse" data-parent="#accordion" href="javascript:void(0);" aria-expanded="false" aria-controls="collapseTwo">
			<h4 class="panel-title">
				Filter &nbsp;
				<div class="inline filter-info">
					<?php $x=0; $f=0;?>
					@if (!empty($data['active_search']))
						@foreach ($data['active_search'] as $k => $v)
							@if ($k == 1)
								<?php $f=1; ?>
								<content class="filter-more hide">
							@endif
							<label class="btn btn-transparent btn-xs text-xs panel-action mb-1 text-capitalize" data-action="{{ $v['slug'] }}" data-input="{{ ($v['type'] == 'tags') ? 'checkbox' : 'link' }}">{{ $v['value'] }} <i class="fa fa-times-circle"></i></label>
						@endforeach
						@if ($f == 1)
							</content>
							<span class="hover-orange text-xs ml-5 more">More..</span>
						@endif
					@endif
				</div>
				<span class="pull-right absolute" style="right: 15px; top: 10px;">
					<i class="fa fa-angle-right " aria-hidden="true"></i>
				</span>
			</h4>
		</a>
	</div>
	<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
		<div class="panel-body overflowscroll" style="height:calc(100vh - 160px);">
			<div class="row">
				<div class="col-xs-12 col-sm-12 text-right">
				  	<a href="javascript:void(0);" class="hover-orange clearall-filter-mobile" data-url="{{ route('balin.product.index', Input::only('categories')) }}">clear all</a>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12">
					<ul class="list-unstyled category-list">
						<h4 class="mb-5">Category</h4>
						@foreach ($category as $k => $v)
							@if ($v['category_id']!=0 && str_is(strtolower($data['type']).'*', $v['slug']))
								<li class="p-5">
									<span>@if (isset(Input::get('categories')[1]) && Input::get('categories')[1] == $v['slug']) <i class="fa fa-check text-grey-dark"></i> @else &nbsp;&nbsp;&nbsp;&nbsp; @endif</span>
									<a href="javascript:void(0);" class="text-regular" data-categories="{{ Input::get('categories')[0] }}" data-type="categories[]" data-action="{{ $v['slug'] }}" data-url="{{route('balin.product.index', array_merge(['tags' => Input::get('tags')], ['categories[0]' => $v['category']['slug'], 'categories[1]' => $v['slug']]))}}" onClick="ajaxCategory(this);">{{ $v['name'] }}</a>
								</li>
							@endif
						@endforeach
					</ul>
					@foreach($data['tag'] as $key => $value)
						@if($value['category_id']==0)
							@if($key!=0)
									</ul>
								</div>
							</div>
							@endif
							<div class="row mt-5 mb-5">
								<div class="col-md-12">
									<h4 class="mb-5">{{$value['name']}}</h4>
									@if(str_is('warna*', $value['slug']))
										<ul class="list-inline checkbox-color filter-list">
									@else
										<ul class="list-unstyled filter-list">
									@endif
						@endif
						@if($value['category_id']!=0)
							@if(str_is('warna*', $value['slug']))
								<li class="{{ (Input::has('tags') && in_array($value['slug'], Input::get('tags'))) ? 'active' : '' }}">
									{!! Form::checkbox('tags[]', $value['slug'], (Input::has('tags') && in_array($value['slug'], Input::get('tags'))) ? true : null, ['id' => $value['slug'], 'class' => 'checkbox-color hide', 'data-type' => 'tags', 'data-action' => $value['slug'], 'onClick' => 'ajaxFilter(this);']) !!} 
									<span class="color-item" style="background-color: {{$value['code']}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
								</li>
							@else
								<li>
									<div class="checkbox-custom">
										{!! Form::checkbox('tags[]', $value['slug'], (Input::has('tags') && in_array($value['slug'], Input::get('tags'))) ? true : null, ['id' => $value['slug'], 'class' => 'checkbox-filter', 'data-type' => 'tags', 'data-action' => $value['slug'], 'onClick' => 'ajaxFilter(this);']) !!} 
										<label for="{{$value['slug']}}">
											<span class="text-regular">{{$value['name']}}</span>
										</label>
									</div>
								</li>
							@endif
						@endif
					@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>