@extends('layout.master')

@section('content')
    <div class="container-fluid">

        <div>
            <h1 >Form cao nhap Major: {{ $major->name }}</h1>

        </div>


        <div class="card shadow mb-4">
            <div class="card-body">

                @if (\Session::has('msg'))
            <div class="alert alert-success">
                {{ \Session::get('msg') }}
            </div>
            @endif

            <form action="{{ route('majors.update', $major) }}" method="post" enctype="multipart/form-data">
                @csrf
                        @method('PUT')

                <label for="name">Name</label>
                <input type="text" class="form-control" name="name", id="name" value="{{ $major->name }}">
                
                <br>
                <a href="{{ route('majors.index') }}" class="btn btn-infor mt-3">Trang chu</a>
                <button type="submit" class="btn btn-primary mt-3">Submit</button>
                
            </div>

        </div>

    @endsection

