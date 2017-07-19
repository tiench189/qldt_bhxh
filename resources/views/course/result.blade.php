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
    {{ Form::hidden('courseid', 0, array('id' => 'courseid')) }}
    {!! Form::close() !!}
    <script language="javascript">
        function xoanguoidung(cid, sid, courseid) {

            if (confirm("Bạn có muốn xóa?")) {
                document.getElementById("classid").value = cid;
                document.getElementById("studentid").value = sid;
                document.getElementById("courseid").value = courseid;
                frmstudentremove.submit();
            }

        }


        $( document ).ready(function() {
            $( "#frmaddstudent" ).on("submit", function (event) {

                var $this = $(event.target);

                if ($this.data('passed')) {
                    return true;
                } else {
                    event.preventDefault();
                }

                course_id = $("#addcourseid").val();
                student_id = $("#addstdid").val();

                $.ajax({
                    type: 'POST',
                    url: 'http://duy.qldt.vn/course/checkStudentCategory',
                    data: { "_token": "{{ csrf_token() }}",c: course_id, s: student_id },
                    success: function (data) {

                        if(data["code"] == 1) {
                            var khoahoc = "";
                            for(var row in data["data"]) {
                                khoahoc += "    - " + data["data"][row]["lop_id"] + ". " + data["data"][row]["ten_lop"] + "\n";
                            }

                            if(confirm("Học viên đã học các lớp dưới đây trong nội dung đào tạo này:\n\n" + khoahoc + "\nĐồng ý thêm?")) {
                                $this
                                    .data('passed', true)
                                    .trigger('submit');
                            }
                        } else if(data["code"] == -1 || data["code"] == 0) {
                            $this
                                .data('passed', true)
                                .trigger('submit');
                        }
                    }
                });
                event.preventDefault();
            });
        });
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
    @if(\App\Roles::checkRole('student-add'))
        <button type="button" class="btn btn-primary btn-add" data-toggle="modal" data-target="#myModal"
                style="margin-bottom: 10px">Thêm Học Viên
        </button>
    @endif

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
                            Thêm học viên vào <strong>{{$class->ten_lop}}</strong> -
                            <strong>{{$course->fullname}}</strong>
                        @endif
                    </h4>
                </div>
                <div class="modal-body">


                    {!! Form::open(array('route' => 'student-add', 'class' => 'form','id' => 'frmaddstudent')) !!}
                    {{ Form::hidden('id', $course->id, array('id' => 'addcourseid')) }}
                    @if($courseID != 0)
                        <div class="form-group">
                            <label>Lớp: <span class="required">(*)</span></label>
                            {!! Form::select('cid', $ddclass, '',
                                array('class'=>'form-control','id'=>"addclassid")) !!}
                        </div>
                    @else
                        {{ Form::hidden('cid', $class->id, array('id' => 'addclassid')) }}
                    @endif
                    <div class="form-group">
                        <label>Học Viên: <span class="required">(*)</span></label>
                        {!! Form::select('sid', $dduser, '',
                            array('class'=>'form-control','id'=>"addstdid")) !!}
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
            <th>Họ tên<br><input type="text"></th>
            <th>Email<br><input type="text"></th>
            <th class="{{$classID == 0?'':'hidden'}}">Lớp<br><input type="text"></th>
            <th>Đơn vị<br><input type="text"></th>
            <th style="width: 70px">Trạng thái<br>
                <select>
                    <option value=""></option>
                    <option value="Hoàn thành">Hoàn thành</option>
                    <option value="Đang học">Đang học</option>
                    <option value="Hủy">Hủy</option>
                </select>
            </th>
            <th style="width: 30px">Điểm<br><input type="text"></th>
            <th style="width: 60px">Xếp loại
                <select>
                    <option value=""></option>
                    @foreach($xeploai as $x)
                        <option value="{{$x->name}}">{{$x->name}}</option>
                    @endforeach
                </select>
            </th>
            <th style="width: 110px">Ngày hoàn thành<br><input type="text"></th>
            @if(\App\Roles::checkRole('student-remove'))
                <th></th>
            @endif
            @if(\App\Roles::checkRole('class-capnhathocvien'))
                <th></th>
            @endif
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
                @if(\App\Roles::checkRole('student-remove'))
                    <td>
                        <a href="javascript:void(0)"
                           onclick="xoanguoidung({{$row->lop_id}},{{$row->user_id}},{{$course->id}})"
                           class="btn btn-xs btn-primary">Xóa</a>
                    </td>
                @endif
                @if(\App\Roles::checkRole('class-capnhathocvien'))
                    <td><a class="btn btn-primary btn-xs"
                           href="{{route('class-capnhathocvien', ['uid' => $row->user_id, 'cid' => $row->lop_id])}}">Cập
                            nhật</a></td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
    <style>
        #table_filter {
            display: none;
        }
    </style>
@stop
