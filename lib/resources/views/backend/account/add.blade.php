@extends('backend.master')
@section('title','Home')
@section('main')


    <script type="text/javascript" src="{{asset('public/ckeditor/ckeditor.js')}}"></script>

    <div>
        <div>
            <h3 class="">Thêm mới tài khoản</h3>
        </div>
        <div>
            <form method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tên của bạn</label>
                            <input type="text" class="form-control" name="name" placeholder="Tên của bạn" required>
                        </div>
                        <div class="form-group">
                            <label>Địa chỉ email</label>
                            <input type="text" class="form-control" name="email" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <label>Mật khẩu</label>
                            <input type="password" class="form-control" name="password" placeholder="Mật khẩu" required>
                        </div>
                        <div class="form-group">
                            <label>Chức vụ</label>
                            <select class="form-control" name="level">
                                <option value="{{\App\Models\Account::USER}}">Học viên</option>
                                <option value="{{\App\Models\Account::AFFILIATE}}">Cộng tác viên</option>
                                <option value="{{\App\Models\Account::TEACHER}}">Giáo viên</option>
                                <option value="{{\App\Models\Account::MANAGING_AFF}}">Quản trị CTV</option>
                                <option value="{{\App\Models\Account::MANAGING_TEA}}">Quản trị giáo viên</option>
                                <option value="{{\App\Models\Account::EDITOR}}">Biên tập viên</option>
                                <option value="{{\App\Models\Account::ACCOUNTANT}}">Kế toán</option>
                                @if(Auth::user()->level <3)
                                    <option value="{{\App\Models\Account::ADMIN}}">Quản trị viên</option>
                                @endif
                                @if(Auth::user()->level <2)
                                    <option value="{{\App\Models\Account::ADMIN_SUPER}}">Admin</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tóm tắt</label>
                            <textarea class="form-control" rows="5" name="summary"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Chi tiết</label>
                            <textarea class="form-control" rows="5" name="content"></textarea>
                            <script type="text/javascript">
                                var editor = CKEDITOR.replace('content',{
                                    language:'vi',
                                    filebrowserImageBrowseUrl: '{{asset('admin/ckfinder/image')}}',
                                    filebrowserImageUploadUrl: '{{asset('admin/ckfinder/connector')}}',
                                });
                            </script>

                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Ảnh</label>
                        <input id="img" type="file" name="img" class="cssInput " onchange="changeImg(this)" style="display: none!important;">
                        <img style="cursor: pointer;" id="avatar" class="cssInput thumbnail tableImgAvatar" width="s%" src="img/user.png">
                    </div>
                </div>



                <div class="form-group">

                    <input type="submit" class="btn btn-success" value="Thêm mới">
                    <a href="{{asset('admin/account')}}" class="btn btn-warning"> Quay lại</a>
                </div>
                {{csrf_field()}}
            </form>
        </div>
    </div>

@stop