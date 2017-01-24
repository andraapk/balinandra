<!-- SECTION BREADCRUMB FOR DESKTOP -->
<div class="hidden-xs">
	<section class="container">
		<div class="row mt-md">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pl-0 pr-0">
				<ol class="breadcrumb" style="background:none">
					@foreach($breadcrumb as $b_title => $b_url)
						@if ($b_url == head($breadcrumb))
							<li>
								<a class="hover-black" href="{{route('balin.home.index')}}">Home</a>
							</li>
						@endif
						@if ($b_url == end($breadcrumb))
							<li class="active">
								<a class="hover-orange" href="{{ $b_url }}"><strong>{{$b_title}}</strong></a>
							</li>
						@else
							<li>
								<a class="hover-orange" href="{{ $b_url }}"> {{$b_title}} </a>
							</li>
						@endif
					@endforeach
				</ol>
			</div>
		</div>
	</section>
</div>
<!-- END SECTION BREADCRUMB FOR DESKTOP -->

<!-- SECTION BREADCRUMB FOR MOBILE, TABLET -->
<div class="hidden-lg hidden-md hidden-sm" style="margin-left: 15px;margin-right: 15px;margin-top :-10px;">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pl-0 pr-0">
			<ol class="breadcrumb bg-none mt-xs mb-xs">
				<?php $ctr = 0;?>
				@foreach($breadcrumb as $b_title => $b_url)
					@if ($b_url == head($breadcrumb))
						<li>
							<a class="hover-black" href="{{route('balin.home.index')}}">Home</a>
						</li>
					@endif
					@if($b_url == end($breadcrumb))
						@if($ctr > 0)
							<?php 
								// </br>
							?>
						@endif
						<li class="active">
							<a class="hover-gray" href="{{ $b_url }}"><strong>{{$b_title}}</strong></a>
						</li>
					@else
						<?php $ctr++ ?>
						<li>
							<a class="hover-black" href="{{ $b_url }}">{{$b_title}} </a>
						</li>
						@if($ctr == count($breadcrumb)-1 && $ctr > 0)
							<?php
								// <li></li>
							?>
						@endif
					@endif
				@endforeach
			</ol>
		</div>
	</div>
</div>
<!-- END SECTION BREADCRUMB FOR MOBILE, TABLET -->