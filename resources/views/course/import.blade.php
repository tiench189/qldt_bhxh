@extends('layout')

@section('page-title')
    Nhập học viên theo danh sách
@stop

@section('content')
    <script language="JavaScript" type="text/javascript">
        $(document).ready(function () {
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
            <th class="chk" data-checkbox="true" style="min-width: 30px">Chọn</th>
            <th style="min-width: 150px">Username</th>
            <th style="min-width: 150px">Email</th>
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

        @if ($row["chk"] == -1)
            <tr class="warning">
                <td> {{ Form::checkbox('chkallow[]', $row["uar"], false, array("disabled")) }}  </td>
                <td colspan="4">
                    <s>{{$row["uar"]}}</s>
                </td>
                <td>{{$row["cln"]}}</td>
                <td colspan="4"> <span class="label label-danger"> Username/email không tồn tại! </span></td>
            </tr>
        @elseif ($row["chk"] == 0)
            <tr>
                <td> {{ Form::checkbox('chkallow[]', $row["uar"]->email) }}  </td>
                <td><strong> {{$row["uar"]->username}} </strong></td>
                <td><strong> {{$row["uar"]->email}} </strong></td>
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
                    <span class="label label-success"> Học viên mới </span>
                    @if ($row["chkcat"]["code"] == 1)
                        <span class="label label-warning"> Đã học nội dung đào tạo này.</span>
                    @endif

                </td>
            </tr>
        @else
            <tr class="warning">
                <td> {{ Form::checkbox('chkallow[]', $row["uar"]->email, false, array("disabled")) }}  </td>
                <td> <s> {{$row["uar"]->username}} </s> </td>
                <td> <s> {{$row["uar"]->email}} </s> </td>
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
</div>
{!! Form::close() !!}

@stop