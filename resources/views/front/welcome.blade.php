@extends('layouts.front')
@section('content')
<div class="row">
    <div class="col-lg-7">
        <div class="banner_content">
            <div class="row">
                @foreach ($themes as $theme)
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <a href="{{ url('theme/details', $theme->id) }}">
                            <div class="single-brand-item d-table" title="{{ $theme->name }}">
                                <div class="d-table-cell text-center">
                                    <!-- Menampilkan Nama Tema -->
                                    <h5>{{ \Illuminate\Support\Str::limit($theme->name, 10, '...') }}</h5>
                                    <!-- Menampilkan Deskripsi -->
                                    <p>{{ \Illuminate\Support\Str::limit($theme->description, 20, '...') }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                <!-- Tambahkan Paginasi -->
                <div class="pagination-wrapper">
                    {{ $themes->links() }}
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