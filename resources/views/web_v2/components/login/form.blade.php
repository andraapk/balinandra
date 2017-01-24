{!! Form::open(['url' => route('balin.post.login'), 'class' => '']) !!}


    <div class="form-group input-group">
		<span class="input-group-addon" id="basic-addon1">
			<div class="text-center" style="width:30px;">
				<i class="fa fa-envelope fa-lg aria-hidden="true"></i>
			</div>
		</span>
        {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Masukkan Email', 'required' => 'required', 'tabindex' => 1]) !!}
    </div>

    <div class="form-group input-group">
		<span class="input-group-addon" id="basic-addon2">
			<div class="text-center" style="width:30px;">
			<i class="fa fa-lock fa-lg aria-hidden="true"></i>
			</div>
		</span>
        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Masukkan Password', 'required' => 'required', 'tabindex' => 2]) !!}
    </div>

    <div class="hidden-lg hidden-md hidden-sm col-xs-12">
	    <div class="row clearfix mb-xs">
	    </div>
    </div>	

	<div class="form-group">
		<a href="javascript:void(0);" class="btn-forgot t-xs text-white pull-left" tabindex="3">Lupa Password?</a>
	    <button type="submit" class="pull-right btn btn-orange pl-xl pr-xl" tabindex="4">Sign In</button>
	</div>

	<div class="clearfix mb-xs">&nbsp;</div>

	<p class="text-light"><em>atau</em></p>
		<a href="{{route('balin.get.sso')}}" class="btn btn-facebook btn-social btn-block btn-lg text-lg">
		<span class="fa fa-facebook"></span>
		Gunakan Facebook
	</a>

	<div class="clearfix mb-md">&nbsp;</div>
{!! Form::close() !!}