@extends('layouts.front')
@section('content')
<div class="row">
    <div class="col-lg-7">
        <div class="banner_content">
            <div class="row">
                <div class="table-responsive shadow-sm">
                    <table id="themesTable" class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-left" style="width: 10px;">No</th>
                                <th class="text-left">Name</th>
                                <th class="text-left">Description</th>
                                <th class="text-center" style="width: 20px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($themes as $index => $theme)
                                <tr>
                                    <td>{{ $themes->firstItem() + $index }}</td>
                                    <td>{{ $theme->name }}</td>
                                    <td>{{ $theme->description }}</td>
                                    <td class="text-center">
                                        <a href="{{ url('theme/details', $theme->id) }}" class="btn btn-info btn-sm"><i class="fa-solid fa-eye"></i> View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center">
                        {{ $themes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="home_right_img">
            <img src="{{ url('satner/img/studying.png') }}" alt="" class="img-fluid">
        </div>
    </div>
</div>
@endsection