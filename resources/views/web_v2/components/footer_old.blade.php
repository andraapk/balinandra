<footer class="container-fluid footer">
	<div class="row p-l-none p-r-none">
		<div class="col-md-12 hidden-xs">
			<div class="container">
				<div class="row p-t-xs p-b-md">
					<div class="col-md-4 col-sm-4 text-left">
						<a href="{{route('balin.home.index')}}">{!! HTML::image('images/logo-transparent-small.png','', ['class' => 'img-responsive']) !!}</a>
					</div>
					<div class="col-sm-4 col-md-4 col-lg-4 text-center m-t-sm">
						<ul class="list-inline menu-footer">
							<li><a href="{{route('balin.about.us')}}" class="text-white hover-grey-light">ABOUT US</a></li>
							<li>|</li>
							<li><a href="{{route('balin.contact.us')}}" class="text-white hover-grey-light">CONTACT US</a></li>
						</ul>
					</div>
					<div class="col-sm-4 col-md-4 col-lg-4 text-right">
						@if(isset($balin['info']['instagram_url']) && !empty($balin['info']['instagram_url']['value']))
							<a href="{{$balin['info']['instagram_url']['value']}}" target="blank" class="btn btn-socmed mr-xs"><i class="fa fa-instagram"></i></a>
						@endif
						@if(isset($balin['info']['twitter_url']) && !empty($balin['info']['twitter_url']['value']))
							<a href="{{$balin['info']['twitter_url']['value']}}" target="blank" class="btn btn-socmed mr-xs"><i class="fa fa-twitter"></i></a>
						@endif
						@if(isset($balin['info']['facebook_url']) && !empty($balin['info']['facebook_url']['value']))
							<a href="{{$balin['info']['facebook_url']['value']}}" target="blank" class="btn btn-socmed mr-xs"><i class="fa fa-facebook"></i></a>
						@endif
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 text-center">
						<p class="footer-title-logo m-t-sm m-b-xxs"><a href="#" class="text-white">Copyright 2016 CV. Balin Indonesia</a></p>
					</div>
				</div>
			</div>
		</div>
		<div class="hidden-lg hidden-md hidden-sm col-xs-12 pb-xl">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 m-t-sm text-center">
						<ul class="list-inline menu-footer">
							<li><a href="{{route('balin.about.us')}}" class="text-white hover-grey">ABOUT US</a></li>
							<li>|</li>
							<li><a href="{{route('balin.contact.us')}}" class="text-white hover-grey">CONTACT US</a></li>
						</ul>
					</div>		
				</div>
				<div class="row pb-sm text-center">
					<div class="col-xs-12 pb-xl">
						<a href="{{ route('balin.home.index') }}">{!! HTML::image('images/logo-transparent-small.png','', ['class' => 'img-responsive']) !!}</a>
					</div>
					<div class="col-xs-12">
						@if(isset($balin['info']['instagram_url']) && !empty($balin['info']['instagram_url']['value']))
							<a href="{{$balin['info']['instagram_url']['value']}}" target="blank" class="btn btn-socmed mtm-xs mr-xs"><i class="fa fa-instagram"></i></a>
						@endif
						@if(isset($balin['info']['twitter_url']) && !empty($balin['info']['twitter_url']['value']))
							<a href="{{$balin['info']['twitter_url']['value']}}" target="blank" class="btn btn-socmed mtm-xs mr-xs"><i class="fa fa-twitter"></i></a>
						@endif
						@if(isset($balin['info']['facebook_url']) && !empty($balin['info']['facebook_url']['value']))
							<a href="{{$balin['info']['facebook_url']['value']}}" target="blank" class="btn btn-socmed mtm-xs mr-xs"><i class="fa fa-facebook"></i></a>
						@endif
					</div>
				</div>		
				<div class="row">
					<div class="col-xs-12 text-center">
						<p class="footer-title-logo m-t-sm m-b-xxs"><a href="#" class="text-white">Copyright 2016 CV. Balin Indonesia</a></p>
					</div>
				</div>	
				<div class="row">
					<div class="hidden-lg hidden-md hidden-sm col-xs-12">
						<div class="clearfix">&nbsp;</div>
					</div>
				</div>					
			</div>	
		</div>
	</div>
</footer>