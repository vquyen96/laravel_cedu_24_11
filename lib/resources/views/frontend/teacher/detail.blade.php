@extends('frontend.master')
@section('title', Request::segment(2) == 'add' ? 'Tạo khóa học' : $course->cou_name)
@section('fb_title','Top khóa học hàng đầu')
@section('fb_description','Nơi cung cấp cho bạn những khóa học tốt nhất, rẻ nhất. Tạo lên một môi trường học tập trên cuộc cách mạng công nghệ 4.0')
@section('fb_image',asset('public/layout/frontend/img/dayne-topkin-60559-unsplash.png'))
@section('main')
<link rel="stylesheet" type="text/css" href="css/teacher/detail.css">
<script type="text/javascript" src="{{asset('public/ckeditor/ckeditor.js')}}"></script>

<div class="instruction">

	<div class="instruction_body">
		<a href="{{ asset('') }}" class="instruction_item">
			Trang chủ
		</a>
		<a class="instruction_item">
			>
		</a>
		<a href="{{ asset('teacher/courses') }}" class="instruction_item">
			Khóa học
		</a>
		<a class="instruction_item">
			>
		</a>
		<a href="{{ Request::segment(2) == 'add' ? asset('teacher/add') : asset('teacher/courses/'.$course->cou_slug)}}" class="instruction_item">
			{{ Request::segment(2) == 'add' ? 'Thêm mới' : $course->cou_name }}
		</a>



	</div>

</div>
<div class="main_body">

	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="title">
					<h1>{{ Request::segment(2) == 'add' ? 'Thêm bài giảng' : 'Chỉnh sửa bài giảng' }}</h1>
					<div class="titleContent">
						Chúng tôi cung cấp cho các bạn những khoá học đa dạng và chất lượng nhất
					</div>
				</div>

			</div>

			
			
			<div class="col-md-4 {{ Request::segment(2) == 'add' ? 'd-none' : '' }}">
				<a href="{{asset('teacher/add')}}"class="button-add">Thêm khóa học mới</a> 
			</div>
			
			
		</div>
		<div class="row profile">
			<div class="col-md-4">
				<div class="profileLeft">
					<div class="profileLeftAva">
						<img id="avatarImg" class="cssInput" src="{{ file_exists(storage_path('app/course/'.$course->cou_img)) ? asset('lib/storage/app/course/'.$course->cou_img) : 'img/iamgesadd.jpg' }}">

					</div>
					{{-- <div class="profileLeftButton">	
						{{!isset($course) ? 'Update'  : 'Thay đổi cover' }}
					</div> --}}
					<div class="profileLeftButton">
						<div class="buttonChangeAva">
							Chọn ảnh đại diện
						</div>
						<div class="buttonSaveAva">
							Lưu
						</div>
					</div>
				</div> 
			</div>
			<div class="col-md-8">
				<div class="profileRight">
					<form method="post" enctype="multipart/form-data" >
						{{ csrf_field() }}
						<div class="profileRightTitle">
							Thông tin cơ bản
							@if(isset($course))
							<div class="inputEdit">
								Sửa
								<i class="fas fa-pencil-alt"></i>
							</div>
							<div class="inputDeni">
								Hủy
								<i class="fas fa-ban"></i>
							</div>
							@endif
						</div>
						
						<div class="form_group">
							<label>Tên khóa học</label>
							<div class="form_item">
								@if(isset($course))
								<div class="inputText">
									{{ $course->cou_name }}
								</div>
								@endif
								<div class="inputMain">
									<input type="text" name="cou[cou_name]" class="inputProfile" @if(isset($course)) value="{{ $course->cou_name }} @endif">
									<input id="img" type="file" name="img" class="cssInput " onchange="changeImg(this)"  style="display: none!important;">
								</div>
							</div>
						</div>
						<div class="form_group">
							<label>Giá</label>
							<div class="form_item">
								@if(isset($course))
								<div class="inputText">
									{{ number_format($course->cou_price, 0, ',', '.') }}
								</div>
								@endif
								<div class="inputMain">
									<input type="number" name="cou[cou_price]" class="inputProfile" value="{{ $course->cou_price }}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form_group">
									<label>Trình độ</label>
									<div class="form_item">
										@if(isset($course))
										<div class="inputText">
											{{ level_format($course->cou_level) }}
										</div>
										@endif
										<div class="inputMain">
											<select class="inputProfile" name="cou[cou_level]">
												@for ($i = 1; $i < 4 ; $i++)
												<option value="{{ $i }}" {{ $course->cou_level == $i ? 'selected' : '' }}>{{ level_format($i) }}</option>
												@endfor
											</select>
										</div>

									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form_group">
									<label>Loại bài giảng</label>
									<div class="form_item">
										@if(isset($course))
										<div class="inputText">
											{{ type_format($course->cou_type) }}
										</div>
										@endif
										<div class="inputMain">
											<select class="inputProfile" name="cou[cou_type]">
												@for ($i = 1; $i < 3 ; $i++)
												<option value="{{ $i }}" {{ $course->cou_type == $i ? 'selected' : '' }}>{{ type_format($i) }}</option>
												@endfor
											</select>
										</div>

									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form_group">
									<label>Loại khóa học</label>
									@if(isset($course))
									<div class="inputText">
										{{ $course->cou_gr_name }}
									</div>
									@endif
									<div class="form_item">
										<div class="inputMain">
											<select class="inputProfile" name="cou[cou_gr_id]" id="group">
												@foreach($group as $item)
													<option value="{{$item->gr_id}}" {{ $course->cou_gr_id == $item->gr_id ? 'selected' : ''}}>{{$item->gr_name}}</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form_group">
									<label>Lĩnh vực</label>
									@if(isset($course))
									<div class="inputText">
										{{ $course->cou_gr_child_name }}
									</div>
									@endif
									<div class="form_item">
										<div class="inputMain">
											<select class="inputProfile" name="cou[cou_gr_child_id]" id="group_child">
												@foreach($group_child as $item)
													<option value="{{$item->gr_id}}" {{ $course->cou_gr_child_id == $item->gr_id ? 'selected' : ''}}>{{$item->gr_name}}</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form_group">
							<label>Tóm tắt</label>
							@if(isset($course))
							<div class="inputText inputTextarea">
								{!! $course->cou_summary == null ? 'Cedu cung cấp cho các bạn những khoá học đa dạng và chất lượng nhất' : $course->cou_summary !!}
							</div>
							@endif
							<div class="form_item">
								<div class="inputMain">
									<textarea class="inputProfileTextarea" rows="5" name="cou[cou_summary]">{!! isset($course) ? $course->cou_summary : ''!!}</textarea>
								</div>
							</div>
						</div>
						<div class="form_group">
							<label>Nội dung</label>
							@if(isset($course))
							<div class="inputText inputTextarea">
								{!! $course->cou_content !!}
							</div>
							@endif
							<div class="form_item">
								<div class="inputMain">
									<textarea class="ckeditor inputProfileTextarea" rows="5" name="cou[cou_content]">
										@if(isset($course)) 
										{!! $course->cou_content !!} 
										@endif
									</textarea>
									<script type="text/javascript">
										var editor = CKEDITOR.replace('cou[cou_content]',{
											language:'vi',
											filebrowserImageBrowseUrl: '../../ckfinder/ckfinder.html?Type=Images',
											filebrowserFlashBrowseUrl: '../../ckfinder/ckfinder.html?Type=Flash',
											filebrowserImageUploadUrl: '../../ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
											filebrowserFlashUploadUrl: '../../public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
										});
									</script>
								</div>
							</div>
						</div>		

						

						
						<div class="inputButon">
							<button type="button" class="btnNoSubmit">
								Hủy
							</button>
							<button type="submit" class="btnSubmit">
								{{ Request::segment(2) == 'add' ? 'Tạo mới' : 'Lưu thay đổi ' }}
							</button>
						</div>
						
					</form>
					{{-- EDIT COURSE --}}
					<div class="profileRightTitle {{ Request::segment(2) == 'add' ? 'd-none' : '' }}">
						Chi tiết bài học
					</div>
					<div class="editCourse {{ Request::segment(2) == 'add' ? 'd-none' : '' }}">
						

						@if(isset($course) && isset($course->part))
						<?php $video = 0 ?>
						@foreach($course->part as $item)
						
						<ul>
							<li class="listUnit">
								<i class="fas fa-plus toggle" ></i>
								{{-- Giới thiệu khóa học --}}
								<span>{{$item->part_name}}</span>
								<div class="tool">
									<i class="fas fa-edit edit-title" data-toggle="modal">
										<div class="value_form_tile">{{$item->part_name}}</div>
										<div class="action_form_tile">{{asset('teacher/editpart/'.$item->part_id)}}</div>
									</i>

									<a href="{{asset('teacher/destroypart/'.$item->part_id)}}"  onclick="return confirm('Bạn có chắc chắn muốn xóa ?')">
										<i class="fas fa-trash-alt" data-toggle="modal" data-target="#myModal3"></i>
									</a>

									{{ gmdate("i:s",$item->part_video_duration	) }}		
								</div>
								
								<ul class="unit">
									@foreach($item->lesson as $itemTiny)
									<li>
										<i class="fas fa-video"></i>
										<span>{{$itemTiny->les_name}}</span>
										<div class="tool-2">
											<i class="fas fa-file-alt {{ isset($itemTiny->les_doc_link) ? '' : 'd-none'  }}"></i>
											<i class="fas fa-edit" data-toggle="modal">
												<div class="value_form_video">{{$itemTiny->les_name}}</div>
												<div class="action_form_video">{{asset('teacher/editvideo/'.$itemTiny->les_id)}}</div>
												<div class="link_form_video">{{$itemTiny->les_link}}</div>
												<div class="doc_form d-none">{{ isset($itemTiny->les_doc_link) ? $itemTiny->les_doc_link : '' }}</div>
											</i>
											<a href="{{asset('teacher/destroylesson/'.$itemTiny->les_id)}}"  onclick="return confirm('Bạn có chắc chắn muốn xóa ?')">
												<i class="fas fa-trash-alt"></i>
											</a>
											{{ gmdate("i:s", $itemTiny->les_video_duration) }}		
										</div>
									</li>
									<?php $video++ ?>
									@endforeach
									<li class="add-video">
										<i class="fas fa-plus" data-toggle="modal"></i>
										<span>Thêm video</span>
										<div class="d-none action_form">
											{{asset('teacher/video/'.$item->part_id)}}

										</div>
									</li>
								</ul>
							</li>
						</ul>			
						@endforeach
						@endif

						<div class="addListUnit" >
							<i class="fas fa-plus" data-toggle="modal" data-target="#myModal"></i>
							Thêm bài giảng
						</div>
					</div>
					{{-- END EDIT COURSE --}}


					{{-- EDIT DOCUMENT --}}
					<div class="profileRightTitle {{ Request::segment(2) == 'add' ? 'd-none' : '' }}">
						Tài liệu
					</div>
					<div class="editDocument {{ Request::segment(2) == 'add' ? 'd-none' : '' }}">
						<ul>
							@foreach ($docs as $doc)
								@if ($doc->doc_les_id == null)
									<li class="document">
										<a href="{{ asset('teacher/destroy_doc/'.$doc->doc_id) }}"  onclick="return confirm('Bạn có chắc chắn muốn xóa ?')">
											<i class="fas fa-trash-alt"></i>
										</a>
										<div class="doc_name">
											{{ $doc->doc_name}}
										</div>
										<i class="fas fa-edit edit_document" >
											<div class="d-none action_form">
												{{asset('teacher/editdoc/'.$doc->doc_id)}}
											</div>
											<div class="d-none doc_form">{{ $doc->doc_link }}</div>
										</i>

									</li>
								@endif
									
							@endforeach
								
						</ul>
						<div class="addDocument" >
							<i class="fas fa-plus" data-toggle="modal" data-target="#myModal2"></i>
							Thêm tài liệu
							<div class="d-none action_form">
								{{asset('teacher/doc/'.$course->cou_id)}}
							</div>
						</div>
					</div>
					{{--END EDIT DOCUMENT --}}

					{{-- EDIT EXAM --}}
					<div class="profileRightTitle {{ Request::segment(2) == 'add' ? 'd-none' : '' }}">
						Bài kiểm tra
					</div>
					<div class="editDocument {{ Request::segment(2) == 'add' ? 'd-none' : '' }}">
						{{--<ul>--}}
							{{--@foreach ($exams as $exam)--}}
								{{--<li class="document">--}}
									{{--<a href="{{ asset('teacher/exam/'.$exam->id) }}" class="detail_exam">--}}
										{{--<i class="fas fa-plus toggle"></i>--}}
									{{--</a>--}}

									{{--<div class="exam_name">{{ $exam->name}}</div><div>[{{ $exam->total_score }}]--}}
									{{--</div>--}}

									{{--<div class="exam_time d-none">{{ $exam->time}}</div>--}}
									{{--<div class="exam_description d-none">{{ $exam->description}}</div>--}}
									{{--<div class="exam_pass d-none">{{ $exam->pass}}</div>--}}

									{{--<a href="{{ asset('teacher/destroy_exam/'.$exam->id) }}"  onclick="return confirm('Bạn có chắc chắn muốn xóa ?')">--}}
										{{--<i class="fas fa-trash-alt"></i>--}}
									{{--</a>--}}

									{{--<i class="fas fa-edit edit_exam" >--}}
										{{--<div class="d-none action_form">--}}
											{{--{{asset('teacher/edit_exam/'.$exam->id)}}--}}
										{{--</div>--}}
									{{--</i>--}}

								{{--</li>--}}
							{{--@endforeach--}}
						{{--</ul>--}}
						<form action="{{ asset('teacher/update_order_exam') }}" method="post">
							{{ csrf_field() }}
							<ul class="todo-list">
								@foreach($exams as $exam)
									<li>
										<span class="handle">
										  <i class="fa fa-ellipsis-v"></i>
										  <i class="fa fa-ellipsis-v"></i>
										</span>
										<input style="width: 50px" type="text" value="{{$loop->index + 1}}"
											   name="exam[{{$exam->id}}]">
										<a style="cursor: pointer" href="{{ asset('teacher/exam/'.$exam->id) }}" class="exam_main">
											<span class="text exam_name">{{$exam->name}}</span>
											<div class="exam_time d-none">{{ $exam->time}}</div>
											<div class="exam_description d-none">{{ $exam->description}}</div>
											<div class="exam_pass d-none">{{ $exam->pass}}</div>
										</a>
										<div class="tools">
											<a href="{{ asset('teacher/destroy_exam/'.$exam->id) }}" onclick="return confirm('Bạn chắc chắn muốn xóa')"
											   class="text-danger">
												<i class="fas fa-trash-alt"></i>
											</a>
											<i class="fas fa-edit edit_exam" >
												<div class="d-none action_form">
													{{asset('teacher/edit_exam/'.$exam->id)}}
												</div>
											</i>
										</div>
									</li>
								@endforeach
							</ul>
							<div class="addExam" >
								<i class="fas fa-plus" data-toggle="modal" data-target="#myModal2"></i>
								Thêm bài kiểm tra
								<div class="d-none action_form">
									{{asset('teacher/add_exam/'.$course->cou_id)}}
								</div>
							</div>
							<div class="text-right">
								<button type="submit" class="btn btn-warning">Cập nhật</button>
							</div>
						</form>


					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>

{{--MODAL UP LOAD VIDEO--}}
<div class="modal fade"	 id="modal_add_video">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-title">
				Up video
			</div>
			<form method="post" enctype="multipart/form-data" class="form_add_video">
				{{csrf_field()}}
				<div class="form_group">
					<label>Tên video</label>
					<div class="form_item">
						<div class="input">
							<input type="text"  placeholder="Tên bài" name="les_name">
						</div>
					</div>
				</div>
				<div class="form_group">
					<label>Tải video lên</label>
					<div class="form_item">
						<div class="inputFile">
							Chọn file(.mp4)
							<input id="fileItem" type="file" name="file" class="cssInput" onchange="onChange()">
							<input type="hidden" name="duration" id="duration">
						</div>
					</div>
				</div>
				<div class="show_video">
					<video width="100%" controls autoplay src="" id="video"></video>
				</div>
				<div class="form_group">
					<label>Tải tài liệu lên</label>
					<div class="form_item">
						<div class="inputFile">
							Chọn file(.pdf)
							<input id="upload_add" type="file" name="file_doc" class="cssInput" onchange="Prevew_doc()">
						</div>
					</div>
				</div>
				<div class="show_doc">
					<iframe id="viewer_add" frameborder="0" scrolling="no" width="100%" height="600"></iframe>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn-miss" data-dismiss="modal">Không</button>
					<input type="submit" class="btn-create" value="Lưu" />
				</div>
			</form>
		</div>
	</div>
</div>
{{-- END UP LOAD VIDEO--}}

{{--MODAL SỬA VIDEO--}}
<div class="modal fade"	 id="modal_edit_video">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-title">
				Sửa video
			</div>
			<form method="post" enctype="multipart/form-data" class="form_update_video">
				{{csrf_field()}}
				<div class="form_group">
					<label>Tên video</label>
					<div class="form_item">
						<div class="input">
							<input type="text" class="video_update_value" name="les_name">
						</div>
					</div>
				</div>
				<div class="form_group">
					<label>Tải video lên</label>
					<div class="form_item">
						<div class="inputFile">
							Chọn file(.mp4)
							<input id="fileItem_edit" type="file" name="file" class="cssInput" onchange="onChangeEdit()">
							
							<input type="hidden" name="duration" id="duration_edit">
						</div>
					</div>
				</div>
				<div class="show_video">
					<video width="100%" controls autoplay src="" id="video_edit"></video>
				</div>
				<div class="form_group">
					<label>Tải tài liệu lên</label>
					<div class="form_item">
						<div class="inputFile">
							Chọn file(.pdf)
							<input id="upload_edit" type="file" name="file_doc" class="cssInput" onchange="Prevew_doc_edit()">
						</div>
					</div>
				</div>
				<div class="show_doc">
					<iframe id="viewer_edit" frameborder="0" scrolling="no" width="100%" height="600"></iframe>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn-miss" data-dismiss="modal" >Không</button>
					<input type="submit" class="btn-create" value="Lưu" />
				</div>
			</form>
		</div>
	</div>
</div>
{{-- END SỬA VIDEO--}}

{{--MODAL TẠO BÀI GIẢNG --}}
<div class="modal fade"	 id="myModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-title">
				Tạo bài giảng
			</div>
			<form method="post" enctype="multipart/form-data" action="{{asset('teacher/part/'.$course->cou_id)}}">
				{{ csrf_field() }}
				<div class="form_group">
					<label>Tên bài giảng</label>
					<div class="form_item">
						<div class="input">
							<input type="text"  name="part_name"  placeholder="Tên bài giảng">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn-miss" data-dismiss="modal">Không</button>
					<input type="submit" class="btn-create" value="Tạo"/>
				</div>
			</form>
		</div>
	</div>
</div>
{{-- END TẠO BÀI GIẢNG --}}

{{--MODAL UPDATE BÀI GIẢNG --}}
<div class="modal fade"	 id="myModaledit">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-title">
				Sửa bài giảng
			</div>
			<form method="post" enctype="multipart/form-data" class="form_update_action" >
				{{ csrf_field() }}
				<div class="form_group">
					<label>Tên bài giảng</label>
					<div class="form_item">
						<div class="input">
							<input type="text" class="form_update_tile" name="part_name">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn-miss" data-dismiss="modal">Không</button>
					<input type="submit" class="btn-create" value="Cập nhật"/>
				</div>
			</form>
		</div>
	</div>
</div>
{{-- UPDATE BÀI GIẢNG --}}

{{--MODAL TẠO TÀI LIỆU--}}
<div class="modal fade"	 id="modal_add_doc">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-title">
				Tài liệu
			</div>
			<form method="post" enctype="multipart/form-data" class="form_add_doc" >
				{{ csrf_field() }}
				<div class="form_group">
					<label>Tên tài liệu</label>
					<div class="form_item">
						<div class="input">
							<input type="text" name="doc_name"  placeholder="Tên tài liệu">
						</div>
					</div>
				</div>
				<div class="form_group">
					<label>File tài liệu</label>
					<div class="form_item">
						<div class="inputFile">
							Chọn file
							<input id="upload_doc" type="file" name="file" class="cssInput" onchange="Prevew_document()">
						</div>
					</div>
				</div>
				<div class="show_doc">
					<iframe id="viewer_doc" frameborder="0" scrolling="no" width="100%" height="600"></iframe>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn-miss" data-dismiss="modal">Không</button>
					<button type="submit" class="btn-create">Lưu</button>
				</div>
			</form>
		</div>
	</div>
</div>
{{-- END TẠO TÀI LIỆU --}}

{{--MODAL TẠO BÀI THI--}}
<div class="modal fade"	 id="modal_add_exam">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-title">
				Bài thi
			</div>
			<form method="post"  class="form_add_exam" action="">
                {{ csrf_field() }}
				<div class="form_group">
					<label>Tên Bài thi <span class="text-danger">*</span></label>
					<div class="form_item">
						<div class="input">
							<input type="text" name="name"  placeholder="Tên bài thi" required>
						</div>
					</div>
				</div>

				<div class="form_group">
					<label>Thời gian làm bài (phút) <span class="text-danger">*</span></label>
					<div class="form_item">
						<div class="input">
							<input type="number" name="time"  placeholder="Thời gian làm bài"  required min="0">
							{{--<input type="number" min="0" step="1"/>--}}
						</div>
					</div>
				</div>
				<div class="form_group">
					<label>Chi tiết</label>
					<div class="form_item">
						<div class="input">
							{{--<input type="number" name="order"  placeholder="Thứ tự bài thi">--}}
							<textarea class="form-control" name="description" placeholder="Chi tiết bài thi" rows="5"></textarea>
						</div>
					</div>
				</div>
				<div class="form_group">
					<label>Tỷ lệ qua bài</label>
					<div class="form_item">
						<div class="input">
							<input type="number" name="pass"  placeholder="Tỷ lệ(%)" max="100" required min="0">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn-miss" data-dismiss="modal">Không</button>
					<button type="submit" class="btn-create">Lưu</button>
				</div>
			</form>
		</div>
	</div>
</div>
{{-- END TẠO BÀI THI --}}


<style type="text/css">
@if(!isset($course))
.inputText,.inputTextarea,.inputMain,.inputButon,.inputEdit,.inputDeni{
	display: unset;
}
@endif
</style>

@stop

@section('script')
<script type="text/javascript" src="js/user/profile.js"></script>
<script type="text/javascript" src="js/teacher/detail.js"></script>
<script type="text/javascript" src="js/jquery/jquery.validate.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script type="text/javascript">


	$('.tool-2 .fa-edit').click(function(){
		var value = $(this).find('.value_form_video').text();
		var action = $(this).find('.action_form_video').text();
		var link = $(this).find('.link_form_video').text();
		var doc = $(this).find('.doc_form').text();

		$('.video_update_value').attr('value',value);
		$('.form_update_video').attr('action',action);
		if($('#video_edit').attr('src') != '{{ asset('lib/public/uploads/') }}/'+link){
			$('#video_edit').attr('src','{{ asset('lib/public/uploads/') }}/'+link);
		}
        if($('#video_edit').attr('src') != '{{ asset('lib/public/uploads/') }}/'+link){
            $('#video_edit').attr('src','{{ asset('lib/public/uploads/') }}/'+link);
        }
		// var pdffile_url = dataURItoBlob('http://localhost/c_edu/lib/storage/app/doc/1537496117.pdf');
		// console.log(pdffile_url);
		if(doc !=  null && doc != ''){
			$('#viewer_edit').attr('src', '{{ asset('/lib/storage/app/doc/') }}/' + doc );
	    	$('#viewer_edit').show();
		}
	        
		

		$('#modal_edit_video').modal();
	});

	function changeImg(input){
    //Nếu như tồn thuộc tính file, đồng nghĩa người dùng đã chọn file mới
    if(input.files && input.files[0]){
    	var reader = new FileReader();
        //Sự kiện file đã được load vào website
        reader.onload = function(e){
            //Thay đổi đường dẫn ảnh
            $('#avatarImg').attr('src',e.target.result);
            $('.buttonSaveAva').show();
        }
        reader.readAsDataURL(input.files[0]);
    }
}
	$(document).ready(function() {
		$('.buttonChangeAva').click(function(){
			$('#img').click();
		});
		$('.buttonSaveAva').click(function(){
			// $('.btnSubmit').prop('disabled', true);
			$('.btnSubmit').click();
		});
		@if (Request::segment(2) == 'add')
		$('.inputEdit').click();
		@endif





	});






</script>

@stop