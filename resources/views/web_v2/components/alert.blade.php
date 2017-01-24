	<div id="alert_window" class="modal modal-notif modal-center fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
		<div class="modal-dialog modal-sm pt-0">
			<div class="modal-header">
				<div class="row">
					<div class="col-md-12 text-left text-light content text-grey-light">
						<p class="border-bottom-1 border-grey-light">Info</p>
						@if (Session::has('msg') || $errors->any())
							@if (Session::has('msg'))
								{{ Session::get('msg') }}
							@else
								@foreach ($errors->all('<p>:message</p>') as $error)
									<p>{!! $error !!}</p>
								@endforeach
							@endif
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>