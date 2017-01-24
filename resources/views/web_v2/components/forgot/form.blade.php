{!! Form::open(['url' => route('balin.forgot.password'), 'class' => 'form']) !!}
    <div class="form-group input-group">
		<span class="input-group-addon" id="basic-addon1">
			<div class="text-center" style="width:30px;">
				<i class="fa fa-envelope fa-lg aria-hidden="true"></i>
			</div>
		</span>
		{!! Form::email('email', null, ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Email', 'required']) !!}
    </div>
    <div class="hidden-lg hidden-md hidden-sm col-xs-12">
	    <div class="row clearfix mb-xs">
	    </div>
    </div>	
	<div class="form-group text-right">
		<a href="#" class="hover-grey text-white btn-cancel">Cancel</a>&nbsp;&nbsp;&nbsp;
		<button type="submit" class="btn btn-orange pl-xl pr-xl">Reset</button>
	</div>
{!! Form::close() !!}