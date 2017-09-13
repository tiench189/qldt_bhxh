@extends('layout')

@section('page-title')
    Cập Nhật Phiếu Khảo Sát Chất Lượng Đào Tạo
@stop

@section('content')
    {!! Form::open(array('route' => 'khaosat-xoachuyende', 'class' => 'form', 'id' => 'frmchuyenderemove')) !!}
    {{ Form::hidden('chuyendeid', 0, array('id' => 'chuyendeid')) }}
    {!! Form::close() !!}
    <script language="javascript">

        $( document ).ready(function() {

            $('#modalChuyenDe').on('hidden.bs.modal', function () {
                $("#khaosat_id").val("");
                $("#chuyende_id").val("");
                $("#chuyende_noidung").val("");
                $("#modalChuyenDeTitle").html("Thêm Chuyên Đề");
            });
        });

        function removeChuyende(id) {
            if (confirm("Bạn có muốn xóa chuyên đề này?")) {
                document.getElementById("chuyendeid").value = id;
                frmchuyenderemove.submit();
            }
        }
        function updateChuyende(id) {
            $.ajax({
                type: 'GET',
                url: '{{ ENV("ALIAS") }}/khaosat/update_chuyende',
                data: {"_token": "{{ csrf_token() }}", id: id},
                success: function (data) {

                    if (data["id"] != 0) {
                        $("#modalChuyenDeTitle").html("Cập Nhật Chuyên Đề: " + data["khaosat_id"] + "." + data["noi_dung"]);
                        $("#khaosat_id").val(data["khaosat_id"]);
                        $("#chuyende_id").val(data["id"]);
                        $("#chuyende_noidung").val(data["noi_dung"]);
                        $('#modalChuyenDe').modal('show');
                    } else {
                        alert("Có lỗi xảy ra!\r\nKhông tìm thấy chuyên đề này.");
                    }
                }
            });
        }
    </script>
    <div class="breadcrumbs">
        {!! Breadcrumbs::render('khaosat',$khaosat->title) !!}
    </div>
    @if ( $errors->count() > 0 )
        @foreach( $errors->all() as $message )
            <p  class="alert alert-danger">{{ $message }}</p>
        @endforeach
    @endif

    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif

    <button type="button" class="btn btn-warning" data-target="#modalChuyenDe" data-toggle="modal" style="margin-bottom: 5px">
        Thêm Chuyên Đề
    </button>
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th class="stt">#</th>
            <th width="55%">Nội dung</th>
            <th>Ngày tạo</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($khaosat_chuyende as $idx=>$row)
            <tr>
                <td>{{ $row->id }}</td>
                <td>{{ $row->noi_dung }}</td>
                <td>{{\App\Utils::toTimeFormat($row->created_at)}}</td>
                <td>
                    <a href="javascript:updateChuyende({{$row->id}})" class="btn btn-xs btn-primary">Sửa</a>
                    <a href="javascript:removeChuyende({{$row->id}})" class="btn btn-xs btn-danger">Xóa</a>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


    {!! Form::open(array('route' => 'khaosat-create', 'class' => 'form')) !!}

    <div class="form-group">
        <label>Nội dung khảo sát<span class="required">(*)</span> :</label>
        <input type="text" name="title" class="form-control" required>
    </div>

    <div class="form-group">
        {!! Form::submit('Tiếp theo',
          array('class'=>'btn btn-primary')) !!}
    </div>
    {!! Form::close() !!}
    <div id="modalChuyenDe" class="modal fade" role="dialog">
        <div class="modal-dialog" style="margin-top: 150px">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="modalChuyenDeTitle">
                        Thêm Chuyên Đề
                    </h4>
                </div>
                {!! Form::open(array('route' => 'khaosat-themchuyende', 'class' => 'form','id' => 'frmthemchuyende')) !!}
                <input type="hidden" value="{{$khaosat->id}}" name="khaosat_id">
                <input type="hidden" value="0" name="chuyende_id" id="chuyende_id">
                <div class="modal-body">

                    <div class="form-group">
                        <label>Nội dung chuyên đề<span class="required">(*)</span> :</label>
                        <input type="text" name="chuyende_noidung" id="chuyende_noidung" class="form-control" required>
                    </div>

                </div>
                <div class="modal-footer">
                    {!! Form::submit('Cập Nhật', ['class' => 'btn btn-primary']) !!}
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>

@stop