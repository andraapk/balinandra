{!! Form::open(['url' => route('balin.change.password'), 'class' => 'form']) !!}
    <div class="form-group input-group">
		<span class="input-group-addon" id="basic-addon1">
			<div class="text-center" style="width:30px;">
				<i class="fa fa-lock fa-lg aria-hidden="true"></i>
			</div>
		</span>
        {!! Form::password('password', ['class' => 'form-control hollow password', 'placeholder' => 'Masukkan Password', 'required' => 'required', 'tabindex' => 1]) !!}
    </div>	
	<div class="form-group input-group">
		<span class="input-group-addon" id="basic-addon1">
			<div class="text-center" style="width:30px;">
				<i class="fa fa-key fa-lg aria-hidden="true"></i>
			</div>
		</span>
        {!! Form::password('password_confirmation', ['class' => 'form-control hollow password', 'placeholder' => 'Konfirmasi Password', 'required' => 'required', 'tabindex' => 2]) !!}
    </div>	
	<div class="form-group text-right">
		<button type="submit" class="btn btn-orange pl-xl pr-xl">Ganti</button>
	</div>
{!! Form::close() !!}