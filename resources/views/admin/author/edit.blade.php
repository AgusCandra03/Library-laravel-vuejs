@extends('layouts.admin')
@section('header', 'Author')

@section('content')
    <div id="controller">
        <div class="row">
            <div class="col">
                <div class="card card-primary">
                    <div class="card-header">
                        <h5>Edit Author</h5>
                    </div>
                    <form action="{{ url('authors/'.$author->id) }}" method="post">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="card-body">
                            <div class="form-group">
                                <label>Name Author</label>
                                <input type="text" name="name" value="{{ $author->name }}" class="form-control" placeholder="Enter Name" required="">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" value="{{ $author->email }}" class="form-control" placeholder="Email" required="">
                            </div>
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="text" name="phone_number" value="{{ $author->phone_number }}" class="form-control" placeholder="Phone number" required="">
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="address" value="{{ $author->address }}" class="form-control" placeholder="Address" required="">
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