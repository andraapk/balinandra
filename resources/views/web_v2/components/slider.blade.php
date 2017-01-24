<style>
	#slide-loader{
		background:#f0f0f0;
		border: none !important;
		 -webkit-transition: background-color 300ms;
	    -moz-transition: background-color 300ms;
	    -o-transition: background-color 300ms;
	    transition: background-color 300ms;
	}
	#slide-loader .white{
		background:white;
	}	
	@media screen and (max-width: 767px) {
	  #slide-loader{
	    height: 57vw;
	  }
	}
	@media screen and (min-width: 768px) {
	  #slide-loader{
	    height: 43vw;
	  }    
	}

	#slide-loader > .container{
		position: relative;
	    height: 100%;	
	}	
	#slide-loader > .container >.row{
		width: 100%;
	    position: absolute;
	    top: 50%;
	    transform: translateY(-50%);
	}
	#slide-loader.hideBackground{
		background:transparent!important;
	}
</style>

<div id="slide-loader">
	<div class="container" id="loader">
		<div class="row">
			<div class="coll-md-12 text-center mb-md">
				{!! HTML::image('/images/loading-balin.gif', null, ['style' => 'width:7%;']) !!}
			</div>
			<div class="col-md-12 hidden-xs text-center">
				<h3>
					All in good time ...</br>
					<small>a moment till we're ready</small>
				</h3>
			</div>
			<div class="col-xs-12 hidden-sm hidden-md hidden-lg text-center">
				<h4>
					All in good time ...</br>
					<small>a moment till we're ready</small>
				</h4>
			</div>			
		</div>	
	</div>
	<div id="slider" class="owl-carousel owl-theme hidden">
	 	@foreach($sliders as $key => $slider)
			<div id="slider_no_{{$key}}" class="item">
				<img id="slider_img_no_{{$key}}" class="img-responsive img_slider" onError="handleError(this);" src="{{ $slider['image_lg'] }}">
			</div>
	 	@endforeach
	</div>		
</div>

<script>
	function handleError(e) {
		var id = e.id;
		id = id.replace("img_", "");
		document.getElementById(id).remove();
	}
</script>

@section('js')
 	$(window).load(function(){
		initSlider();
 		$('#slider').addClass("white");
 		$('#slider').removeClass("hidden");
 		$('#loader').addClass("hidden");
 		$('#slide-loader').addClass("hideBackground");
	});		
@append