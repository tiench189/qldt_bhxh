@extends('layout')

@section('page-title')
    @if($courseID != 0 && $classID == 0)
        Danh sách học viên {{$course->fullname}}
    @else
        Danh sách học viên {{$class->ten_lop}} - {{$course->fullname}}
    @endif
@stop

@section('content')
    {!! Form::open(array('route' => 'student-remove', 'class' => 'form', 'id' => 'frmstudentremove')) !!}
    {{ Form::hidden('cid', 0, array('id' => 'classid')) }}
    {{ Form::hidden('sid', 0, array('id' => 'studentid')) }}
    {!! Form::close() !!}
    <script language="javascript">
        function xoanguoidung(cid,sid) {

            if(confirm("Bạn có muốn xóa?")) {
                document.getElementById("classid").value = cid;
                document.getElementById("studentid").value = sid;
                frmstudentremove.submit();
            }


        }
    </script>
    <div class="page-title">
        @if($courseID != 0)
            Danh sách học viên: <strong>{{$course->fullname}}</strong>
        @else
            Danh sách học viên: <strong>{{$class->ten_lop}}</strong> - <strong>{{$course->fullname}}</strong>
        @endif
    </div>
    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif
    <!-- Trigger the modal with a button -->
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Thêm Học Viên</button>

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        @if($courseID != 0)
                           Thêm học viên vào <strong>{{$course->fullname}}</strong>
                        @else
                            Thêm học viên vào <strong>{{$class->ten_lop}}</strong> - <strong>{{$course->fullname}}</strong>
                        @endif
                    </h4>
                </div>
                <div class="modal-body">


                    {!! Form::open(array('route' => 'student-add', 'class' => 'form')) !!}
                    {{ Form::hidden('id', $course->id, array('id' => 'courseid')) }}
                    @if($courseID != 0)
                    <div class="form-group">
                        <label>Lớp: <span class="required">(*)</span></label>
                        {!! Form::select('cid', $ddclass, '',
                            array('class'=>'form-control','id'=>"classid")) !!}
                    </div>
                    @else
                        {{ Form::hidden('cid', $class->id, array('id' => 'classid')) }}
                    @endif
                    <div class="form-group">
                        <label>Học Viên: <span class="required">(*)</span></label>
                        {!! Form::select('sid', $dduser, '',
                            array('class'=>'form-control')) !!}
                    </div>
                    <div class="form-group">
                        <label>Điểm trung bình: <span class="required">(*)</span></label>
                        {!! Form::number('grade', "",
                            array('class'=>'form-control','style'=>"width: 70px")) !!}
                    </div>
                    <div class="form-group">
                        <label>Xếp loại: <span class="required">(*)</span></label>
                        {!! Form::select('xeploai', $ddlxeploai, '',
                            array('class'=>'form-control')) !!}
                    </div>
                    <div class="form-group">
                        <label>Trạng thái: <span class="required">(*)</span></label>
                        {!! Form::select('status', ['finished'=>'Hoàn Thành','inprogress'=>"Đang học"], '',
                            array('class'=>'form-control')) !!}
                    </div>


                    <div class="form-group">
                        {!! Form::submit('Cập nhật',
                          array('class'=>'btn btn-primary')) !!}
                    </div>
                    {!! Form::close() !!}


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <table class="table table-bordered" id="table" data-export="[0,1,2,3,4,5,6,7,8]">
        <thead>
        <tr>
            <th class="stt">#</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th class="{{$classID == 0?'':'hidden'}}">Lớp</th>
            <th>Đơn vị</th>
            <th>Trạng thái</th>
            <th>Điểm</th>
            <th>Xếp loại</th>
            <th>Ngày hoàn thành</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($allResult as $idx=>$row)
            <tr>
                <td>{{$idx + 1}}</td>
                <td>{{$users[$row->user_id]->firstname}} {{$users[$row->user_id]->lastname}}</td>
                <td>{{$users[$row->user_id]->email}}</td>
                <td class="{{$classID == 0?'':'hidden'}}">{{$row->ten_lop}}</td>
                <td>{{array_key_exists($users[$row->user_id]->donvi, $donvi)?$donvi[$users[$row->user_id]->donvi]->ten_donvi:''}}</td>
                <td>{{\app\Utils::getStatus($row->status)}}</td>
                <td>{{$row->grade}}</td>
                <td>{{$xeploai[$row->xeploai]->name}}</td>
                <td>{{\app\Utils::formatTimestamp($row->complete_at)}}</td>
                <td>
                    <a href="javascript:void(0)" onclick="xoanguoidung({{$row->lop_id}},{{$row->user_id}})" class="btn btn-xs btn-info">Xóa</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
