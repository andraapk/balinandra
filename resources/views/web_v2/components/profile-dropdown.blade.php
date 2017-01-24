<ul id="desktop-profile-content hidden-xs hidden-sm" data-show="false" class="dropdown-menu dropdown-menu-right text-regular profile_dropdown" aria-labelledby="dLabel">
	<div class="cart-title text-right pt-xs pr-xs">
		<a href="javascript:void(0);" class="hover-orange text-light close-dropdown">
			Hide 
			<i class="fa fa-times-circle" aria-hidden="true"></i>
		</a>
	</div>
	<?php
		$name = strtoupper(Session::get('whoami')['name']);
		$ex_name = explode(' ',trim($name));
	?>
	<div id="cart-content">
		<div class="row">
			<div class="col-md-12">
				<div class="col-xs-4">
					<div class="avatar">
						{{ $ex_name[0][0] }}
					</div>
				</div>
				<div class="col-xs-8">
					<h4 class="mb-0">{{ $ex_name[0] }}</h4>
					<p class="mb-0">{{ Session::get('whoami')['email'] }}</p>
					<a href="{{route('my.balin.profile')}}" class="hover-orange text-light">My Profile Detail</a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="mt-sm mb-sm border-top-1 border-grey-light pt-xs bg-grey">
					<div class="col-md-12 pb-xs bg-grey">
						<a href="{{route('my.balin.profile.myorder')}}" class="btn hover-orange">
							Order History
						</a>
						<a href="{{route('balin.get.logout')}}" class="btn pull-right hover-orange">
							<i class="fa fa-sign-out"></i> Logout
						</a>				
					</div>
				</div>
			</div>
		</div>
	</div>
</ul>

