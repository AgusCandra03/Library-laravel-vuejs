@extends('layouts.admin')
@section('header', 'Peminjaman')

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
    <div id="controller">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-7">
                                <a href="#" @click="addData()" class="btn btn-primary">Tambah Transaksi</a>
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-control">
                                    <option value="3">Filter Status</option>
                                    <option value="1">Belum Dikembalikan</option>
                                    <option value="2">Sudah Dikembalikan</option>
                                </select>
                            </div>
                            <div class="input-group date col-md-3" id="reservationdate" data-target-input="nearest">
                                <input type="text" name="date_start" id="date_start" class="form-control datetimepicker-input" data-target="#reservationdate" placeholder="Filter Tanggal Pinjam"/>
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="datatable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 15px">No.</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Nama Peminjam</th>
                                    <th>Lama Pinjam (hari)</th>
                                    <th>Total Buku</th>
                                    <th>Total Bayar</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                {{-- Modals add dan edit --}}
                <div class="modal fade" id="modal-default">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <form :action="actionUrl" method="post" autocomplete="off" @submit="submitForm($event, data.id)">
                            <div class="modal-header">
                                <h4 class="modal-title">Tambah / Edit</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                @csrf
                                <input type="hidden" name="_method" value="PUT" v-if="editStatus">

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Anggota</label>
                                    <div class="col-sm-8">
                                        <select id="member" name="member_id" class="form-control">
                                            @foreach($members as $member)
                                            <option :value="{{ $member->id }}" :selected="data.member_id == {{ $member->id }}">
                                                {{ $member->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Tanggal</label>
                                    <div class="col-md-4">
                                        <input id="date_start" type="date" name="date_start" :value="data.date_start" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="date_end" type="date" name="date_end" :value="data.date_end" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Buku</label>
                                    <div class="col-sm-8">
                                        <select id="book" class="select2" name="multiple_book[]" multiple="multiple" data-placeholder="Buku" class="form-control" required>
                                            @foreach ($books as $book)
                                            @if($book->qty > 0){
                                                <option value="{{ $book->id }}" >
                                                    {{ $book->title }}
                                                </option>
                                            }
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row" v-if="editStatus">
                                    <label class="col-sm-4 col-form-label">Status</label>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <div class="form-check">
                                              <input id="radio1" class="form-check-input" type="radio" name="status" value="1" :checked="data.status==1">
                                              <label for="radio1" class="form-check-label">Belum Dikembalikan</label>
                                            </div>
                                            <div class="form-check">
                                              <input id="radio2" class="form-check-input" type="radio" name="status" value="2" :checked="data.status!=1">
                                              <label for="radio2" class="form-check-label">Sudah Dikembalikan</label>
                                            </div>
                                          </div>
                                    </div>
                                </div>
                              </div>
                              <div class="modal-footer justify-content-right">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                      </div>
                    </div>
                </div>

                {{-- modal detail --}}
                <div class="modal fade" id="modal-detail">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Detail Peminjaman</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-md-3">Anggota</label>
                                <label class="col-md-1">:</label>
                                <label class="col-md-6" name="name" id="name" style="font-weight: normal"></label>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3">Tanggal</label>
                                <label class="col-md-1">:</label>
                                <label class="col-md-6" name="tanggal_pinjam" id="tanggal_pinjam" style="font-weight: normal"></label>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3">Buku</label>
                                <label class="col-md-1">:</label>
                                <label class="col-md-6" name="list_buku" id="list_buku" style="font-weight: normal"></label>

                            </div>

                            <div class="form-group">
                                <label class="col-md-3">Status</label>
                                <label class="col-md-1">:</label>
                                <label class="col-md-6" name="status_name" id="status_name" style="font-weight: normal"></label>
                            </div>
                        <div class="modal-footer justify-content-right">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                    </div>
                </div>
        </div>
    </div>
@endsection

@section('js')
<!-- DataTables  & Plugins -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script type="text/javascript">
var actionUrl = '{{ url('transactions') }}';
var apiUrl = '{{ url('api/transactions') }}';

var columns = [
    {data: 'DT_RowIndex', class: 'text-center', orderable: true},
    {data: 'tanggal_pinjam', class: 'text-center', orderable: false},
    {data: 'tanggal_kembali', class: 'text-center', orderable: false},
    {data: 'name', class: 'text-center', orderable: true},
    {data: 'lama_pinjam', class: 'text-center', orderable: true},
    {data: 'total_buku', class: 'text-center', orderable: true},
    {data: 'total_bayar', class: 'text-center', orderable: true},
    {data: 'status_name', class: 'text-center', orderable: false},
    {render: function(index, row, data, meta) {
    return `
        <a href="#" class="btn btn-warning btn-sm" onclick="controller.editData(event, ${meta.row})">
            Edit
        </a>
        <a href="#" class="btn btn-success btn-sm" onclick="controller.detailData(event, ${meta.row})">
            Detail
        </a>
        <a href="#" class="btn btn-danger btn-sm" onclick="controller.deleteData(event, ${data.id})">
            Delete
        </a>
    `;
    }, orderable: false, width: '200px', class: 'text-center'},
];


var controller = new Vue({
    el: '#controller',		
    data: {
        datas: [],
        data: {},
        actionUrl,
        apiUrl,
        editStatus: false,
        multi_select: [],
    },
    mounted: function(){
        this.datatable();
    },
    methods: {
        datatable(){
            const _this = this;
            _this.table = $('#datatable').DataTable({
                ajax:{
                    url: apiUrl,    //  url: _this.apiUrl,
                    type: 'GET',
                },
                columns
            }).on('xhr', function(){
                _this.datas = _this.table.ajax.json().data;
            });
        },
        addData(){
            this.data = {};
            this.editStatus = false;

            $('#modal-default').modal();
            $("#book option:selected").prop("selected", false);
            $("#book").trigger("change");
        },
        editData(event, row){
            // console.log(this.datas[row]);
            this.data = this.datas[row];
            this.editStatus = true;
            this.selectedValues = [1];
            $("#book option:selected").prop("selected", false); //clear selected

            var dets = this.data.transaction_details;
            dets.forEach((element) => {
                console.log(element.book_id);
                $("#book option[value='" + element.book_id +"']").prop("selected", true);
            });

            $('#modal-default').modal();
            $("#book").trigger("change");
        },
        deleteData(event, id){
            if(confirm("Are you sure ?")){
                $(event.target).parents('tr').remove();
                axios.post(this.actionUrl+'/'+id, {_method: 'DELETE'}).then(response=>{
                    alert('Data has been removed');
                });
            }
        },
        detailData(event, row){
            this.data = this.datas[row];

            var str = this.data.name;
            $('#name').html(str);

            var str1 = this.data.tanggal_pinjam;
            $('#tanggal_pinjam').html(str1);

            var str3 = this.data.status_name;
            $('#status_name').html(str3);
            
            var dets = this.data.transaction_details;
            let text = "";
            dets.forEach((element) => {
                console.log(element.books);
                text += element.books.title + "<br/> "; 
            });

            $('#list_buku').html(text);

            $('#modal-detail').modal();
        },
        submitForm(event,id){
            event.preventDefault();
            const _this = this;
            var actionUrl = ! this.editStatus ? this.actionUrl : this.actionUrl+'/'+id;
            axios.post(actionUrl, new FormData($(event.target)[0])).then(response=> {
                $('#modal-default').modal('hide');
                _this.table.ajax.reload();
            });
        },
    }
});
</script>

<script type="text/javascript">
$(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
});

$('select[name=status]').on('change', function(){
    status = $('select[name=status]').val();
    if(status == 3){
      controller.table.ajax.url(apiUrl).load();
    } else {
      controller.table.ajax.url(apiUrl+'?status='+status).load();
    }
})

//Date picker
$('#reservationdate').datetimepicker({
    format: 'YYYY-MM-DD',
    onSelect: function(dateText) {
        console.log("Selected date: " + dateText + "; input's current value: " + this.value);
    }
});

$('#reservationdate').on('change.datetimepicker', ({date, oldDate}) => {
    date_start = $('input[name=date_start]').val();
    controller.table.ajax.url(apiUrl+'?date_start='+date_start).load();
});

$('input[name=date_start]').on('change', function(){
    date_start = $('input[name=date_start]').val();
    controller.table.ajax.url(apiUrl+'?date_start='+date_start).load();
});

</script>
@endsection