@extends('web_v2.page_templates.layout')

@section('content') 
    <div class="container-fluid background">
        <div class="row" style="height:100vh;">
            {{-- signup preface --}}
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="top: 50vh;position: absolute;transform: translateY(-50%);">
                <div class="row">
                    {!! Html::image('images/white_logo_balin.png', null, ['class' => 'logo', 'style' => 'width:250px;']) !!}
                    <h4 class="text-white" style="font-weight:100;">Maaf saat ini kami tidak dapat memproses permintaan Anda.<br/> Silahkan coba lagi beberapa saat.</h4>
                </div>
            </div>
        </div>
    </div>
@stop
