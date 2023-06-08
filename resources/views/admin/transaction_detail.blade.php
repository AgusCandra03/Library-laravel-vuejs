@extends('layouts.admin')
@section('header', 'Transaction Detail')

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
                Hello
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
var actionUrl = '{{ url('catalogs') }}';
var apiUrl = '{{ url('api/catalogs') }}';

var columns = [
    {data: 'DT_RowIndex', class: 'text-center', orderable: true},
    {data: 'name', class: 'text-center', orderable: true},
    {data: 'email', class: 'text-center', orderable: false},
    {data: 'phone_number', class: 'text-center', orderable: false},
    {data: 'address', class: 'text-center', orderable: false},
    {render: function(index, row, data, meta) {
    return `
        <a href="#" class="btn btn-warning btn-sm" onclick="controller.editData(event, ${meta.row})">
            Edit
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
        editStatus: false
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
    }
});
</script>
@endsection