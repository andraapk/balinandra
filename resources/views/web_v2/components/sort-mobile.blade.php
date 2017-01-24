<div class="panel panel-default mt-0 border-grey">
	<div class="panel-heading" role="tab" id="headingThree">
		<a role="button" data-target="#collapseThree" data-toggle="collapse" data-parent="#accordion" href="javascript:void(0);" aria-expanded="true" aria-controls="collapseThree">
			<h4 class="panel-title">
				Sort By &nbsp; 
				<div class="inline sort-info">
					@if (Input::get('sort') == 'date-asc')
						<label class="btn btn-transparent btn-xs text-xs panel-action mb-1" data-action="date-asc" data-input="link"> Terbaru <i class="fa fa-times-circle"></i></label>
					@elseif (Input::get('sort') == 'date-desc')
						<label class="btn btn-transparent btn-xs text-xs panel-action mb-1" data-action="date-desc" data-input="link"> Terlama <i class="fa fa-times-circle"></i></label>
					@elseif (Input::get('sort') == 'name-asc')
						<label class="btn btn-transparent btn-xs text-xs panel-action mb-1" data-action="name-asc" data-input="link"> Nama A-Z <i class="fa fa-times-circle"></i></label>
					@elseif (Input::get('sort') == 'name-desc')
						<label class="btn btn-transparent btn-xs text-xs panel-action mb-1" data-action="name-desc" data-input="link"> Nama Z-A <i class="fa fa-times-circle"></i></label>
					@elseif (Input::get('sort') == 'price-asc')
						<label class="btn btn-transparent btn-xs text-xs panel-action mb-1" data-action="price-asc" data-input="link"> Harga Termurah <i class="fa fa-times-circle"></i></label>
					@elseif (Input::get('sort') == 'price-desc')
						<label class="btn btn-transparent btn-xs text-xs panel-action mb-1" data-action="price-desc" data-input="link"> Harga Termahal <i class="fa fa-times-circle"></i></label>
					@endif
				</div>
				<span class="pull-right">
					<i class="fa fa-angle-right " aria-hidden="true"></i>
				</span>
			</h4>
		</a>
	</div>
	<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
		<div class="panel-body">
			<ul class="list-unstyled m-0 sort-list ajaxDataSort">
				<li class="p-5">
					<span>@if (Input::get('sort') == 'date-asc') <i class="fa fa-check text-grey-dark"></i> @else &nbsp;&nbsp;&nbsp;&nbsp; @endif</span>
					<a href="javascript:void(0);" class="text-regular" data-action="date-asc" data-title="Terbaru" onClick="ajaxSorting(this, 'mobile')">Terbaru</a>
				</li>
				<li class="p-5">
					<span>@if (Input::get('sort') == 'date-desc') <i class="fa fa-check text-grey-dark"></i> @else &nbsp;&nbsp;&nbsp;&nbsp; @endif</span>
					<a href="javascript:void(0);" class="text-regular" data-action="date-desc" data-title="Terlama" onClick="ajaxSorting(this, 'mobile')">Terlama</a>
				</li>
				<li class="p-5">
					<span>@if (Input::get('sort') == 'name-asc') <i class="fa fa-check text-grey-dark"></i> @else &nbsp;&nbsp;&nbsp;&nbsp; @endif</span>
					<a href="javascript:void(0);" class="text-regular" data-action="name-asc" data-title="Nama A-Z" onClick="ajaxSorting(this, 'mobile')">Nama A-Z</a>
				</li>
				<li class="p-5">
					<span>@if (Input::get('sort') == 'name-desc') <i class="fa fa-check text-grey-dark"></i> @else &nbsp;&nbsp;&nbsp;&nbsp; @endif</span>
					<a href="javascript:void(0);" class="text-regular" data-action="name-desc" data-title="Nama Z-A" onClick="ajaxSorting(this, 'mobile')">Nama Z-A</a>
				</li>
				<li class="p-5">
					<span>@if (Input::get('sort') == 'price-asc') <i class="fa fa-check text-grey-dark"></i> @else &nbsp;&nbsp;&nbsp;&nbsp; @endif</span>
					<a href="javascript:void(0);" class="text-regular" data-action="price-asc" data-title="Harga Termurah" onClick="ajaxSorting(this, 'mobile')">Harga Termurah</a>
				</li>
				<li class="p-5">
					<span>@if (Input::get('sort') == 'price-desc') <i class="fa fa-check text-grey-dark"></i> @else &nbsp;&nbsp;&nbsp;&nbsp; @endif</span>
					<a href="javascript:void(0);" class="text-regular" data-action="price-desc" data-title="Harga Termahal" onClick="ajaxSorting(this, 'mobile')">Harga Termahal</a>
				</li>
			</ul>
		</div>
	</div>
</div>