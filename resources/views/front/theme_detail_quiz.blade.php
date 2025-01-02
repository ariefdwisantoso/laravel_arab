@extends('layouts.front')
@section('content')
<div class="row">
    <div class="col-lg-7"><br>
        <div class="banner_content">
            <h5>{{ $theme->name }}</h5>
            <p>{{ $theme->description }}</p>
            <hr><br>
            <div class="media-list">
                <table id="themesTable" class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-left" style="width: 10px;">No</th>
                            <th class="text-left" style="width: 100px;">Name</th>
                            <th class="text-left" style="width: 100px;">Description</th>
                            <th class="text-left" style="width: 200px;">File</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($media as $index => $m)
                        <tr>
                            <td>{{ $media->firstItem() + $index }}</td>
                            <td>{{ $m->name }}</td>
                            <td>{{ $m->description }}</td>
                            <td><a href="{{ url('theme/details/quiz/mulai', $m->id) }}"> Mulai Quiz</a></td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="x">No media found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

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