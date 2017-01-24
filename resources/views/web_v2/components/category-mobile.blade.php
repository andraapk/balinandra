<div class="panel panel-default mt-0 border-grey">
	<div class="panel-heading" role="tab" id="headingOne">
		<a role="button" data-target="#collapseOne" data-toggle="collapse" data-parent="#accordion" href="javascript:void(0);" aria-expanded="true" aria-controls="collapseOne">
			<h4 class="panel-title">
				Category &nbsp;
				<div class="inline category-info">
					@if (!empty(Input::get('categories')))
						@forelse (Input::get('categories') as $k => $v)
							@if (($v != 'pria') && ($v != 'wanita'))
								<label class="btn btn-transparent btn-xs panel-action mb-5" data-action="{{ $v }}" data-input="link"> {{ last(explode('-', $v)) }} <i class="fa fa-times-circle"></i></label>
							@endif
						@empty
						@endforelse
					@endif
				</div>
				<span class="pull-right">
					<i class="fa fa-angle-right " aria-hidden="true"></i>
				</span>
			</h4>
		</a>
	</div>
	<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
		<div class="panel-body">
			<ul class="list-unstyled m-0 category-list">
				@foreach ($category as $k => $v)
					@if ($v['category_id']!=0 && str_is(strtolower($data['type']).'*', $v['slug']))
						@if (isset(Input::get('categories')[1]) && Input::get('categories')[1] == $v['slug'])
							<?php $class	= 'text-orange';?>
						@else
							<?php $class	= 'hover-orange';?>
						@endif
						<li class="p-5" style="width:8em;">
							<a href="javascript:void(0);" class="{{ $class }}" data-categories="{{ Input::get('categories')[0] }}" data-type="categories[]" data-action="{{ $v['slug'] }}" data-url="{{route('balin.product.index', array_merge(['tags' => Input::get('tags')], ['categories[0]' => $v['category']['slug'], 'categories[1]' => $v['slug']]))}}" onClick="ajaxCategory(this);">{{ strtoupper($v['name']) }}</a>
						</li>
					@endif
				@endforeach
			</ul>
		</div>
	</div>
</div>