@extends('layouts.admin')
@section('header', 'Author')

@section('content')
    <div id="controller">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                      <a href="{{ url('authors/create') }}" class="btn btn-success">Create New Author</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>No.</th>
                            <th>Name Author</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($authors as $key => $author)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $author->name }}</td>
                                <td>{{ $author->email }}</td>
                                <td>{{ $author->phone_number }}</td>
                                <td>{{ $author->address }}</td>
                                <td>
                                    <a href="{{ url('authors/'.$author->id.'/edit') }}" class="btn btn-primary">Edit</a>

                                    <form action="{{ url('authors', ['id' => $author->id]) }}" method="post">
                                      <input type="submit" class="btn btn-danger" value="Delete"
                                      onclick="return confirm('Are you sure ?')">
                                      @method('delete')
                                      @csrf
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                      </table>
                    </div>
            </div>
        </div>
    </div>
@endsection