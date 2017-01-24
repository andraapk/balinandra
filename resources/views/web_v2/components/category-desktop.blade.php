{{-- -------------------------------- DESKTOP -------------------------------- --}}
<section class="container-fluid bg-grey submenu">
	<div class="row">
		<div class="col-md-12 hidden-xs">
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<ul class="list-inline p-sm m-0 category-list">
							@foreach ($category as $k => $v)
								@if($v['category_id']!=0 && str_is(strtolower($data['type']).'*', $v['slug']))
									@if(isset(Input::get('categories')[1]) && Input::get('categories')[1] == $v['slug'])
										<?php $class	= 'text-orange';?>
									@else
										<?php $class	= 'hover-orange';?>
									@endif
									<li class="" style="width:8em;">
										<a href="{{route('balin.product.index', array_merge(['tags' => Input::get('tags')], ['categories[0]' => $v['category']['slug'], 'categories[1]' => $v['slug']]))}}" class="{{$class}}">{{ strtoupper($v['name']) }}</a>
									</li>
								@endif
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>