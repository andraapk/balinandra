<nav class="navbar navbar-inverse navbar-fixed-top pt-5 pb-5 m-b-none" role="navigation">
	<div class="container">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed link-grey hover-white text-white" aria-expanded="false" 
					data-toggle="collapse" aria-controls="#bs-example-navbar-collapse-1" data-target="#bs-example-navbar-collapse-1">
				<i class="fa fa-bars fa-lg"></i>
			</button>
			<btn id="cart-mobile" data-toggle="modal" data-target="#modal-cart" class=" border-0 ico_cart navbar-cart";
				">
				<i class="fa fa-shopping-bag fa-lg vertical-baseline"></i>
				<span id="mobile-cart-count">
					<?php 
						$count = 0;

						if (Session::has('carts'))
						{
							foreach (Session::get('carts') as $k => $v)
							{
								if (count($v['varians']) > 1) 
								{
									foreach ($v['varians'] as $k2 => $v2)
									{
										$count = $count+1;
									}
								}
								else 
								{
									$count = $count+1;
								}
							}					
							
						}
					?>
					<span class="cart-count {{ (Session::has('carts') && $count >0) ? 'bg-orange text-white' : '' }}">
						<strong>
							{{ $count }}
						</strong>
					</span>
				</span>
			</btn>
			<a class="navbar-brand" href="{{ route('balin.home.index') }}">
				{!! HTML::image('images/white_logo_balin.png', null, ['class' => 'img-responsive']) !!}
			</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse text-center" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
				<li id="cart-desktop" class="dropdown dropdown-cart  hidden-xs hidden-sm text-light">
					<a href="javascript:void(0);" class="dropdown-toggle text-white pt-xs mt-5 ico_cart hover-orange">
						Shopping Bag
					</a>
					<span id="desktop-cart-count">
						<span class="cart-count {{ (Session::has('carts')&& $count >0) ? 'bg-orange text-white' : '' }}">
							<strong>{{ $count }}</strong>
						</span>
					</span>
					@include('web_v2.components.cart.cart_dropdown', ['carts' => Session::get('carts')]) 
				</li>
<!-- 				<li class="info-point pull-right mt-sm ml-md mr-md hidden-xs hidden-sm">
					<span class="title pl-md pr-md text-regular text-uppercase">Jumlah Point</span>
					<span class="value pl-md pr-md mlm-5 text-regular">
						@money_indo(Session::has('whoami') ? Session::get('whoami')['total_point'] : '0')
					</span>
				</li> -->
			</ul>
			<ul class="nav navbar-nav navbar-right" >
				<li class="hidden-md hidden-lg">
					<a href="{{ route('balin.product.index', array_merge(['categories[]' => 'wanita']) ) }}" class="hover-orange @if(isset(Input::get('categories')[0]) && Input::get('categories')[0] == 'wanita') text-orange @endif">Koleksi Wanita</a>
				</li>
				<li class="hidden-md hidden-lg">
					<a href="{{ route('balin.product.index', array_merge(['categories[]' => 'pria']) ) }}" class="hover-orange @if(isset(Input::get('categories')[0]) && Input::get('categories')[0] == 'pria') text-orange active @endif">Koleksi Pria</a>
				</li>
				<li>
					@if (Session::has('whoami'))
						<a href="{{route('my.balin.redeem.index')}}" class="hover-orange @yield('balin-point-nav')">Balin Point</a>
					@else
						<a href="{{route('balin.info.index', ['type' => 'why-join'])}}" class="hover-orange @yield('balin-point-nav')">Balin Point</a>
					@endif
				</li>
					@if (Session::has('whoami'))
					<li class="dropdown dropdown-profile hidden-sm hidden-xs">
						<a href="javascript:void(0);" class="hover-orange @yield('balin-login-nav') dropdown-toggle profile" >{{Session::get('whoami')['name']}}</a>

						@include('web_v2.components.profile-dropdown') 
					</li>
					<li class="hidden-md hidden-lg">
						<a href="{{route('my.balin.profile')}}" class="hover-orange @yield('balin-login-nav')">{{Session::get('whoami')['name']}}</a>
					</li>
					<li class="hidden-md hidden-lg">
						<a href="{{route('my.balin.profile.myorder')}}" class="hover-orange @yield('balin-login-myorder')">My Order History</a>
					</li>					
					@else
					<li>
						<a href="{{route('balin.get.login')}}" class="hover-orange @yield('balin-login-nav')">SIGN IN</a>
					</li>	
					@endif
				<li class="hidden-md hidden-lg">
					@if (Session::has('whoami'))
						<a href="{{route('balin.get.logout')}}" class="hover-orange">LOGOUT</a>
					@endif
				</li>
			</ul>
		</div>
		<!-- /.navbar-collapse -->

		<?php $extend_search = [];?>

		@if(Input::has('tags'))
			<?php $extend_search = array_merge($extend_search, Input::only('tags'));?>
		@endif

		@if(Input::has('sort'))
			<?php $extend_search = array_merge($extend_search, Input::only('sort'));?>
		@endif
		<div class="text-center center-nav desktop-only" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
				<li class="text-light right">
					<a href="{{ route('balin.product.index', array_merge(['categories[]' => 'pria'], $extend_search) ) }}" class="@if(isset(Input::get('categories')[0]) && Input::get('categories')[0] == 'pria') text-orange active @endif hover-orange man-menu">
						Pria
					</a>
				</li>
				<li>
					<div class="center">
					</div>
				</li>
				<li class="text-light left">
					<a href="{{ route('balin.product.index', array_merge(['categories[]' => 'wanita'], $extend_search) ) }}" class="@if(isset(Input::get('categories')[0]) && Input::get('categories')[0] == 'wanita') text-orange active @endif hover-orange woman-menu">
						Wanita
					</a>
				</li>					
			</ul>
		</div>		
	</div>
</nav>

@include('web_v2.components.modal-cart') 