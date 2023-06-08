@extends('layouts.admin')
@section('header', 'Catalog')

@section('content')
    <div id="controller">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                      <a href="{{ url('catalogs/create') }}" class="btn btn-success" >Create New Catalog</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th class="text-center">No.</th>
                            <th>Name Catalog</th>
                            <th>Jumlah Buku</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($catalogs as $key => $catalog)
                            <tr>
                                <td class="text-center">{{ $key+1 }}.</td>
                                <td>{{ $catalog->name }}</td>
                                <td>{{ count($catalog->books) }}</td>
                                <td>{{ date('j M Y - H:i:s', strtotime($catalog->created_at))}}</td>
                                <td>{{ date('j M Y - H:i:s', strtotime($catalog->updated_at))}}</td>
                                <td> 
                                  <a href="{{ url('catalogs/'.$catalog->id.'/edit') }}" class="btn btn-primary">Edit</a>

                                  <form action="{{ url('catalogs', ['id' => $catalog->id]) }}" method="post">
                                      <input class="btn btn-danger" type="submit" value="Delete"
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