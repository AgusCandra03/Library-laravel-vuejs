@extends('layouts.admin')
@section('header', 'Book')

@section('css')

@endsection

@section('content')
<div id="controller">
    <div class="row">
        <div class="col-md-5 offset-md-3">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input type="text" class="form-control" autocomplete="off" placeholder="Search from title" v-model="search">
            </div>
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary" @click="addData()">Create New Book</button>
        </div>
    </div>
    <hr>

    {{-- box card --}}
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12" v-for="book in filteredList">
          <div class="info-box" v-on:click="editData(book)">
            <div class="info-box-content">
              <span class="info-box-text h5">@{{ book.title }} - @{{ book.qty }} </span>
              <span class="info-box-number">Rp. @{{ numberWithSpaces(book.price) }} ,-</span>
            </div>
          </div>
        </div>
    </div>

    {{-- modals --}}
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <form :action="actionUrl" method="post" autocomplete="off">
                <div class="modal-header">
                    <h4 class="modal-title">Book</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="_method" value="PUT" v-if="editStatus">

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">ISBN</label>
                        <div class="col-sm-9">
                            <input type="text" name="isbn" class="form-control" placeholder="ISBN" :value="book.isbn">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Title</label>
                        <div class="col-sm-9">
                            <input type="text" name="title" class="form-control" placeholder="Title" :value="book.title">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Year</label>
                        <div class="col-sm-9">
                            <input type="text" name="year" class="form-control" placeholder="Year" :value="book.year">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Publisher</label>
                        <select name="publisher_id" class="col-sm-9 form-control">
                            @foreach ($publishers as $publisher)
                                <option :selected="book.publisher_id == {{ $publisher->id }}" value="{{ $publisher->id }}">
                                    {{ $publisher->name }}
                                </option>    
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Author</label>
                        <select name="author_id" class="col-sm-9 form-control">
                            @foreach ($authors as $author)
                                <option :selected="book.author_id == {{ $author->id }}" value="{{ $author->id }}">
                                    {{ $author->name }}
                                </option>    
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Catalog</label>
                        <select name="catalog_id" class="col-sm-9 form-control">
                            @foreach ($catalogs as $catalog)
                                <option :selected="book.catalog_id == {{ $catalog->id }}" value="{{ $catalog->id }}">
                                    {{ $catalog->name }}
                                </option>    
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Quantity</label>
                        <div class="col-sm-9">
                            <input type="number" name="qty" class="form-control" placeholder="Qty" :value="book.qty">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Price</label>
                        <div class="col-sm-9">
                            <input type="text" name="price" class="form-control" placeholder="Rp.  ,-" :value="book.price">
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" v-if="editStatus" v-on:click="deleteData(book.id)">Delete</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
          </div>
        </div>
    </div>


</div>
@endsection

@section('js')

<script type="text/javascript">
    var actionUrl = '{{ url('books') }}';
    var apiUrl = '{{ url('api/books') }}';

    var controller = new Vue({
        el: '#controller',
        data: {
            books: [],
            search: '',
            actionUrl,
            apiUrl,
            book: {},   //variable untuk value pada form
            editStatus: false,
        },
        mounted: function(){
            this.get_books();
        },
        methods: {
            get_books(){
                const _this = this;
                $.ajax({
                    url: apiUrl,
                    method: 'GET',
                    success: function(data){
                    _this.books = JSON.parse(data);
                },
                error: function(error){
                    console.log(error);
                }
                })
            },
            addData(){
                this.book = {};
                this.actionUrl = '{{ url('books') }}';
                this.editStatus = false;
                $('#modal-default').modal();
            },
            editData(book){
                this.book = book;
                this.actionUrl = '{{ url('books') }}'+'/'+book.id;
                this.editStatus = true;
                $('#modal-default').modal();
            },
            deleteData(id){
                this.actionUrl = '{{ url('books') }}'+'/'+id;
                    this.editStatus = false;
                    this.buttonAction = true;
                    $('#modal-default').modal();
                    if(confirm("Are you sure ?")){
                        axios.post(this.actionUrl, {_method: 'DELETE'}).then(response=>{
                            location.reload();
                        });
                    }
            },
            numberWithSpaces(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
        },
        computed: {
            filteredList(){
                return this.books.filter(book => {
                    return book.title.toLowerCase().includes(this.search.toLowerCase())
                })
            }
        }
    });
</script>
@endsection