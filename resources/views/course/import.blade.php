@extends('layout')

@section('page-title')
    Nhập học viên theo danh sách
@stop

@section('content')
    <script language="JavaScript" type="text/javascript">
        $(document).ready(function () {

                $("#checkedAll").change(function(){
                    if(this.checked){
                        $(".checkSingle").each(function(){
                            this.checked=true;
                        })
                    }else{
                        $(".checkSingle").each(function(){
                            this.checked=false;
                        })
                    }
                });

                $(".checkSingle").click(function () {
                    if ($(this).is(":checked")){
                        var isAllChecked = 0;
                        $(".checkSingle").each(function(){
                            if(!this.checked)
                                isAllChecked = 1;
                        })
                        if(isAllChecked == 0){ $("#checkedAll").prop("checked", true); }
                    }else {
                        $("#checkedAll").prop("checked", false);
                    }
                });

            $('#tableimport tr').click(function (event) {
                if (event.target.type !== 'checkbox') {
                    $(':checkbox', this).trigger('click');
                }
            });

            $("input[type='checkbox']").change(function (e) {
                if ($(this).is(":checked")) {
                    $(this).closest('tr').addClass("success");
                } else {
                    $(this).closest('tr').removeClass("success");
                }
            });
        });

    </script>
    <div class="page-title">Nhập học viên cho khóa học: {{ $course->fullname  }}</div>

    @if ( $errors->count() > 0 )
        @foreach( $errors->all() as $message )
            <p class="alert alert-danger">{{ $message }}</p>
        @endforeach
    @endif

    {!! Form::open(array('route' => 'student-import-submit', 'class' => 'form')) !!}
    {{ Form::hidden('id', $course->id, array('id' => 'courseid')) }}
    {{ Form::hidden('cid', $class->id, array('id' => 'classid')) }}
    {{ Form::hidden('importtype', $importtype, array('id' => 'importtype')) }}


    <table id="tableimport" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th class="chk" data-checkbox="true" style="min-width: 30px"><input type="checkbox" checked="checked" id="checkedAll" /></th>
            <th style="min-width: 150px">Username/Email</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th style="min-width: 200px">Lớp</th>
            <th>Điểm TB</th>
            <th>Xếp loại</th>
            <th>Trạng thái</th>
            <th>Cảnh báo</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($rs as $idx => $row)

        @if ($row["chk"] < 0)
            <tr class="warning">
                <td> {{ Form::checkbox('chkallow[]', $row["uar"], false, array("disabled")) }}  </td>
                <td colspan="3">
                    <s>{{$row["uar"]}}</s>
                </td>
                <td>{{$row["cln"]}}</td>
                <td colspan="4">
                    @if ($row["chk"] == -1)
                        <span class="label label-danger"> Thông tin Học viên không hợp lệ </span>
                    @else
                        <span class="label label-danger"> Thông tin Học viên không đầy đủ </span>
                    @endif


                </td>
            </tr>
        @elseif ($row["chk"] == 0)
            <tr>
                <td> {{ Form::checkbox('chkallow[]', $row["uar"]->email, array("checked"), ['class'=>"checkSingle"]) }}  </td>
                <td>
                    @if(filter_var($row["uar"]->email, FILTER_VALIDATE_EMAIL))
                        <strong> {{$row["uar"]->email}} </strong>
                    @else
                        <em>(Không khai báo)</em>
                    @endif
                </td>
                <td> {{$row["uar"]->firstname}} </td>
                <td> {{$row["uar"]->lastname}} </td>
                <td> {{$row["cln"]}} </td>
                <td> {{$row["avg"]}} </td>
                <td>
                    @isset($xeploai[$row["rnk"]])
                        {{ $xeploai[$row["rnk"]] }}
                    @endisset
                </td>
                <td>
                    @if ($row["stt"] == 'finished')
                        <span class="label label-success"> Hoàn thành.</span>
                    @else
                        <span class="label label-info"> Đang học.</span>
                    @endif
                </td>
                <td>

                    @if ($row["ins"] == true)
                        <span class="label label-info"> [+] Thêm mới </span>
                    @else
                        <span class="label label-success"> Chưa Đăng ký </span>
                    @endif

                    @if ($row["chkcat"]["code"] == 1)
                        <span class="label label-warning"> Đã học nội dung đào tạo này.</span>
                    @endif

                </td>
            </tr>
        @else
            <tr class="warning">
                <td> {{ Form::checkbox('chkallow[]', $row["uar"]->email, false, array("disabled")) }}  </td>
                <td>
                    @if(filter_var($row["uar"]->email, FILTER_VALIDATE_EMAIL))
                        <strong> {{$row["uar"]->email}} </strong>
                    @else
                        <em>(Không khai báo)</em>
                    @endif
                </td>
                <td> <s> {{$row["uar"]->firstname}} </s> </td>
                <td> <s> {{$row["uar"]->lastname}} </s> </td>
                <td> <s> {{$row["cln"]}} </s> </td>
                <td> {{$row["avg"]}} </td>
                <td>
                    @isset($xeploai[$row["rnk"]])
                        {{ $xeploai[$row["rnk"]] }}
                    @endisset
                </td>
                <td>
                    @if ($row["stt"] == 'finished')
                        <span class="label label-success"> Hoàn thành.</span>
                    @else
                        <span class="label label-info"> Đang học.</span>
                    @endif
                </td>
                <td>
                    <span class="label label-danger"> Đang học lớp này.</span>
                    @if ($row["chkcat"]["code"] == 1)
                        <span class="label label-warning"> Đã học nội dung đào tạo này.</span>
                    @endif
                </td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>


<div class="form-group">
    {!! Form::submit('Nhập dữ liệu',
      array('class'=>'btn btn-primary')) !!}
    @if ($importtype == "course")
        {{ link_to_action('CourseController@allResult','Quay về',['c'=>$course->id],['class'=>'btn btn-danger']) }}
    @else
        {{ link_to_action('CourseController@allResult','Quay về',['class'=>$class->id],['class'=>'btn btn-danger']) }}
    @endif

</div>
{!! Form::close() !!}

@stop