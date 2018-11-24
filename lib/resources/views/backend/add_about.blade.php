@extends('backend.master')
@section('title','Thêm giới thiệu')
@section('main')


<script type="text/javascript" src="{{asset('public/ckeditor/ckeditor.js')}}"></script>

<div class="container-fluid">
	<div>
		<h3 class="">Thêm mới giới thiệu</h3>
	</div>
	<div class="col-md-8">
		<form method="post" enctype="multipart/form-data">
			<div class="form-group">
			    <label>Tiêu đề</label>
			    <input type="text" class="form-control" name="name" placeholder="Tiêu đề" required>
			</div>
			
			
			<div class="form-group">
				<label>Nội dung</label>
				<textarea class="form-control ckeditor" rows="5" name="content"></textarea>
				<script type="text/javascript">
                    var editor = CKEDITOR.replace('content',{
                        language:'vi',
                        filebrowserImageBrowseUrl: '{{asset('admin/ckfinder/image')}}',
                        filebrowserImageUploadUrl: '{{asset('admin/ckfinder/connector')}}',
                    });
				</script>

			</div>
		  	<div class="form-group">
		    	
		    	<input type="submit" class="btn btn-success" value="Thêm mới">
		    	<a href="{{asset('admin/about')}}" class="btn btn-warning"> Quay lại</a>
		  	</div>
		  	{{csrf_field()}}
		</form>
	</div>
</div>

@stop