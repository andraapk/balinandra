{!! Form::open(['url' => (isset($data['code']) && isset($data['link'])) ? route('balin.invitation.post', ['code' => $data['code'], 'link' => $data['link']]) : route('balin.post.signup'), 'class' => 'hollow-login']) !!}
	<div class="form-group">
		<div class="input-group input-group-custom">
			<div class="input-group-addon bg-grey-dark border-transparent text-white text-lg"><i class="fa fa-envelope"></i></div>
			{!! Form::email('email', null, ['class' => 'form-control input-lg text-lg', 'placeholder' => 'Email', 'required' => 'required', 'tabindex' => 1]) !!}
		</div>
	</div>
	<div class="form-group">
		<div class="input-group input-group-custom">
			<div class="input-group-addon bg-grey-dark border-transparent text-white text-lg"><i class="fa fa-lock"></i></div>
			{!! Form::password('password', ['class' => 'form-control input-lg text-lg', 'placeholder' => 'Password', 'required' => 'required', 'tabindex' => 2]) !!}
		</div>
	</div>
	<div class="form-group row ml-0 mr-0">
		<div class="col-xs-3 col-sm-3 pl-0 pr-5">
			{!! Form::select('gender', ['male' => 'Mr.', 'female' => 'Mrs.'], null, ['class' => 'form-control input-lg text-lg text-center drop-down', 'required' => 'required', 'tabindex' => 3]) !!}
		</div>
		<div class="col-xs-9 col-sm-9 pl-5 pr-0">
			{!! Form::text('name', null, ['class' => 'form-control input-lg text-lg', 'placeholder' => 'Name', 'required' => 'required', 'tabindex' => 4]) !!}
		</div>
	</div>
	<div class="form-group">
		<div class="input-group input-group-custom">
			<div class="input-group-addon bg-grey-dark border-transparent text-white text-lg"><i class="fa fa-calendar-o"></i></div>
			{!! Form::text('dob', null, ['class' => 'form-control input-lg text-lg date_format', 'placeholder' => 'Tanggal Lahir', 'required' => 'required', 'tabindex' => 5]) !!}
		</div>
	</div>
    <div class="hidden-lg hidden-md hidden-sm col-xs-12">
	    <div class="row clearfix mb-sm">
	    </div>
    </div>		
	<div class="form-group mt-lg">
		<button type="submit" class="btn btn-orange btn-lg text-lg pl-xxl pr-xxl" tabindex="6">Sign Up</button>
	</div>
	<p class="text-light"><em>atau</em></p>
	<a href="{{route('balin.get.sso')}}" class="btn btn-facebook btn-social btn-block btn-lg text-lg">
		<span class="fa fa-facebook"></span>
		Gunakan Facebook
	</a>
	<p class="text-light mt-lg hidden-md hidden-lg btn-signin">Sudah terdaftar ? <a href="javascript:void(0)" class="text-orange">Sign In</a></p>
{!! Form::close() !!}