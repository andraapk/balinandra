<div class="dropdown">
	<span>
		Urutkan : 
	</span>
	<a class="dropdown-toggle label-sort text-orange" href="#" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
		@if (Input::get('sort') == 'newest-asc')
			Terbaru
		@elseif (Input::get('sort') == 'newest-desc')
			Terlama
		@elseif (Input::get('sort') == 'name-asc')
			Nama A-Z
		@elseif (Input::get('sort') == 'name-desc')
			Nama Z-A
		@elseif (Input::get('sort') == 'price-asc')
			Harga Termurah
		@elseif (Input::get('sort') == 'price-desc')
			Harga Termahal
		@else
			Terbaru
		@endif
		 <i class="fa fa-angle-down"></i>
	</a>
	<ul class="dropdown-menu dropdown-menu-right ajaxDataSort" aria-labelledby="dropdownMenu1" style="min-width: 200px;">
		<li>
			<a href="javascript:void(0);" data-action="newest-asc" onClick="ajaxSorting(this, 'desktop')">
				{!! (Input::get('sort') == 'newest-asc') ? '<i class="fa fa-check"></i>' : '' !!} Terbaru
			</a>
		</li>
		<li>
			<a href="javascript:void(0);" data-action="newest-desc" onClick="ajaxSorting(this, 'desktop')">
				{!! (Input::get('sort') == 'newest-desc') ? '<i class="fa fa-check"></i>' : '' !!} Terlama
			</a>
		</li>
		<li>
			<a href="javascript:void(0);" data-action="name-asc" onClick="ajaxSorting(this, 'desktop')">
				{!! (Input::get('sort') == 'name-asc') ? '<i class="fa fa-check"></i>' : '' !!} Nama A-Z
			</a>
		</li>
		<li>
			<a href="javascript:void(0);" data-action="name-desc" onClick="ajaxSorting(this, 'desktop')">
				{!! (Input::get('sort') == 'name-desc') ? '<i class="fa fa-check"></i>' : '' !!} Nama Z-A
			</a>
		</li>
		<li>
			<a href="javascript:void(0);" data-action="price-asc" onClick="ajaxSorting(this, 'desktop')">
				{!! (Input::get('sort') == 'price-asc') ? '<i class="fa fa-check"></i>' : '' !!} Harga Termurah
			</a>
		</li>
		<li>
			<a href="javascript:void(0);" data-action="price-desc" onClick="ajaxSorting(this, 'desktop')">
				{!! (Input::get('sort') == 'price-desc') ? '<i class="fa fa-check"></i>' : '' !!} Harga Termahal
			</a>
		</li>
	</ul>
</div>