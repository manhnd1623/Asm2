@extends('layout.master')

@section('content')
    <div class="container-fluid">

        <div>
            <h1 >Danh sách Major</h1>

            <a href="{{ route('majors.create') }}">
                <i class="fas fa-download fa-sm text-white-50"> </i> Add
            </a>
        </div>


        @if (\Session::has('msg'))
            <div class="alert alert-success">
                {{ \Session::get('msg') }}
            </div>
            
        @endif
        
        <table class="table">
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Action</td>
            </tr>

            @foreach ($data as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>
                    <a href="{{ route('majors.edit', $item) }}">Edit</a>
                    <form action="{{ route('majors.delete', $item) }}" method="post">
                        @csrf
                        @method('DELETE')

                        <button type="submit" onclick="return confirm('Co chac xoa ko?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
                
            @endforeach
        </table>
        {{  $data->links() }}
    </div>

    @endsection

