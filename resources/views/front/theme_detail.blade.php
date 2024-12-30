@extends('layouts.front')
@section('content')
<div class="row">
    <div class="col-lg-7">
        <div class="banner_content">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="single-brand-item d-table">
                        <div class="d-table-cell text-center">
                            <img src="{{ url('satner/img/picture.png') }}" alt="">
                            <a href="{{ url('theme/details/image', $themes->id) }}">Image</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="single-brand-item d-table">
                        <div class="d-table-cell text-center">
                            <img src="{{ url('satner/img/sound.png') }}" alt="">
                            <a href="{{ url('theme/details/sound', $themes->id) }}">Sound</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="single-brand-item d-table">
                        <div class="d-table-cell text-center">
                            <img src="{{ url('satner/img/folder.png') }}" alt="">
                            <a href="{{ url('theme/details/video', $themes->id) }}">Video</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="home_right_img">
            <img class="" src="{{ url('satner/img/studying.png') }}" alt="">
        </div>
    </div>
</div>
@endsection