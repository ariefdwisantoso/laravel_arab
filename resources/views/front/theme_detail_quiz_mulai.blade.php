@extends('layouts.front')
@section('content')
<br><br><br><br><br><br>
<h5>{{ $media->name }}</h5>
<p>{{ $media->description }}</p>
<iframe src="{{ $media->link }}" frameborder="0" style="width: 100%; height: 500px;"></iframe>
@endsection