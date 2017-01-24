{{--
Yang menggunakan widget ini
1. login
2. Me profile
3. Redeem Code
4. Invitation Create
 --}}

 @if(Session::has('msg') || $errors->any())
	<div class="row">
	    <div class="col-lg-12">
	        <div class="alert text-left pl-sm alert-{{Session::get('msg-type')}}">
				@if (Session::has('msg') || $errors->any())
					@if (Session::has('msg'))
					<P></P>
					<p>
						{{ Session::get('msg') }}
					</p>
					<P></P>
					@else
						@foreach ($errors->all('<p>:message</p>') as $error)
							<p>{!! $error !!}</p>
						@endforeach
					@endif
				@endif
			</div>
		</div>
	</div>
@endif