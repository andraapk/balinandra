@if(isset($searchresult) && count($searchresult))
</br>
<div class="row">
	<div class="col-md-12">
		Menampilkan data pencarian 
			@foreach($searchresult as $key => $variable)
				"{{str_replace('-', ' ', $key)}}" (<a href="{{$variable}}"><i class="fa fa-times"></i> hapus</a>)
			@endforeach
	</div>
</div>
@endif