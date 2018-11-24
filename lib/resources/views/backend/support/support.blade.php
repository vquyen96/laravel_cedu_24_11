@extends('backend.master')
@section('title','Home')
@section('main')

    <script type="text/javascript" src="{{asset('public/ckeditor/ckeditor.js')}}"></script>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 ">
                <div>
                    <h3>Danh sách lĩnh vực</h3>
                </div>
                <table class="table table-hover">
                    <tr>
                        <th>Email</th>
                        <th>Họ tên</th>
                        <th>Điện thoại</th>
                        <th>Ngày đăng ký</th>

                    </tr>
                    @foreach($items as $item)
                        <tr>
                            <td>{{$item->gift_email}}</td>
                            <td>{{$item->gift_name}}</td>
                            <td>{{$item->gift_phone}}</td>
                            <td>{{$item->created_at}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@stop
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on('click', "input[name='check_all']", function () {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });
        });
    </script>
@stop