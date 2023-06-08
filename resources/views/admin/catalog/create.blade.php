@extends('layouts.admin')
@section('header', 'Catalog')

@section('content')
    <div id="controller">
        <div class="row">
            <div class="col">
                <div class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">Create New Catalog</h3>
                    </div>
                    <form action="{{ url('catalogs') }}" method="post">
                        @csrf
                      <div class="card-body">
                        <div class="form-group">
                          <label>Name</label>
                          <input type="text" name="name" class="form-control" placeholder="Enter Name" required="">
                        </div>
                      </div>      
                      <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </div>
                    </form>
                  </div>
            </div>
        </div>
    </div>
@endsection