@extends('layouts.front')
@section('content')
<div class="row">
    <div class="col-lg-7">
        <div class="banner_content">
            <h5>{{ $theme->name }}</h5>
            <p>{{ $theme->description }}</p>
            <hr><br>
            <div class="media-list">
                @foreach ($media as $m)
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="single-brand-item d-table" title="{{ $m->name }}" data-toggle="modal" data-target="#mediaModal_{{ $m->id }}">
                        <div class="d-table-cell text-center">
                            <!-- Menampilkan Nama Tema -->
                            <h5>{{ \Illuminate\Support\Str::limit($m->name, 10, '...') }}</h5>
                            <!-- Menampilkan Deskripsi -->
                            <p>{{ \Illuminate\Support\Str::limit($m->description, 20, '...') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Modal untuk Media -->
                <div class="modal fade" id="mediaModal_{{ $m->id }}" tabindex="-1" role="dialog" aria-labelledby="mediaModalLabel_{{ $m->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mediaModalLabel_{{ $m->id }}">{{ $m->name }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Deskripsi:</strong> {{ $m->description }}</p>
                                <p><strong>Tipe:</strong> {{ $m->type }}</p>
                                <div style="text-align: center;">
                                    <img src="{{ asset('storage/media_files/' . $m->file_path) }}" alt="{{ $m->name }}" class="img-fluid">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                @endforeach
                <!-- Tambahkan Paginasi -->
                <div class="pagination-wrapper">
                    {{ $media->links() }}
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