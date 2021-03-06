@extends('frontend.master')
@section('title','Hợp tác')
@section('main')
<link rel="stylesheet" type="text/css" href="css/partner/partner.css">
<link rel="stylesheet" href="css/owlcarousel/owl.carousel.min.css">
<link rel="stylesheet" href="css/owlcarousel/owl.theme.default.min.css">
<section id="banner" style="background: url('@if(isset($banner)) {{asset('lib/storage/app/banner/'.$banner->ban_img) }}@endif') no-repeat center/cover;">
	<div class="container">
		<div class="main-top">
			<div class="heading">
				<h1>Trở thành đối tác của Cedu</h1>
				<p>Chúng tôi cung cấp cho các bạn những khoá học đa dạng và chất lượng nhất</p>
			</div>
			<div class="button">
				<a href="{{ asset('affiliate') }}" target="_blank" class="ctv">
					Đăng kí trở thành CTV
				</a>
				<a href="{{asset('doitacgiaovien')}}" target="_blank" class="ctv">
					Đăng kí trở thành giảng viên
				</a>
			</div>
		</div>
	</div>
</section>

<section id="content">
	<div id="content-1">
		<div class="container">
			<div class="heading-1">
				<h2>Tại sao nên hợp tác cùng chúng tôi</h2>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-3 col-sm-3 col-12">
					<div class="ly-do">
						
						<div class="images">
							<img src="../frontend/img/icons8-handshake-heart-96.png">
							<p class="test">Đối tác chuyên nghiệp</p>
						</div>
						<div class="summary">
							<p>Cedu cam kết về một môi trường cùng phát triển và hợp tác chuyên nghiệp. Mọi hoạt động đều dựa trên lợi ích của cả hai bên và chính học viên.</p>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-3 col-12">
					<div class="ly-do">
						
						<div class="images">
							<img src="../frontend/img/icons8-connect-96.png">
							<p>Kết nối tri thức</p>
						</div>
						<div class="summary">
							<p>Cedu cam kết về một môi trường cùng phát triển và hợp tác chuyên nghiệp. Mọi hoạt động đều dựa trên lợi ích của cả hai bên và chính học viên.</p>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-3 col-12">
					<div class="ly-do">
						<div class="images">
							<img src="../frontend/img/icons8-training-96.png">
							<p>Giảng viên tài năng</p>
						</div>
						<div class="summary">
							<p>Cedu cam kết về một môi trường cùng phát triển và hợp tác chuyên nghiệp. Mọi hoạt động đều dựa trên lợi ích của cả hai bên và chính học viên.</p>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-3 col-12">
					<div class="ly-do">
						
						<div class="images">
							<img src="../frontend/img/icons8-money-96.png">
							<p>Chiết khấu hấp dẫn</p>
						</div>
						<div class="summary">
							<p>Cedu cam kết về một môi trường cùng phát triển và hợp tác chuyên nghiệp. Mọi hoạt động đều dựa trên lợi ích của cả hai bên và chính học viên.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="content-2">
		<div class="container">
			<div class="heading-1">
				<h2>Quy trình chia sẻ đam mê cùng Cedu</h2>
				<p>Chúng tôi cung cấp cho các bạn những khoá học đa dạng và chất lượng nhất</p>
			</div>
		</div>

		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="quy-trinh">
						<div class="quy-trinh-item">
							<h3>Trở thành giáo viên</h3>
							<div class="cac-buoc">
								<span>Bước 1</span>
								<p>Đăng kí</p>
								{{--<div class="summary-2">Tất cả những gì bạn cần làm là để lại một số thông tin cơ bản, chúng tôi sẽ liên lạc với bạn trong vòng 3 ngày</div>--}}
								<div class="summary-2">Thủ tục đăng ký nhanh chóng chỉ trong 1 phút</div>
							</div>
							<div class="cac-buoc">
								<span>Bước 2</span>
								<p>Soạn đề cương</p>
								{{--<div class="summary-2">Hãy thật tự nhiên, thoải mái chia sẻ kiến thức và là chính bản thân mình. Nếu bạn biết tự quay phim và dựng phim, đó sẽ là một lợi thế không nhỏ</div>--}}
								<div class="summary-2">Xây dựng đề cương chất lượng, hấp dẫn học viên.</div>
							</div>
							<div class="cac-buoc">
								<span>Bước 3</span>
								<p>Dựng video</p>
								{{--<div class="summary-2">Chia sẻ kiến thức, tạo ra những giá trị đích thực và nhận lại nguồn thu nhập trong mơ</div>--}}
								<div class="summary-2">Toàn bộ khâu dựng, hậu kỳ sẽ được CEDU hỗ trợ, tư vấn.</div>
							</div>
							<div class="cac-buoc">
								<span>Bước 4</span>
								<p>Phát hành</p>
								<div class="summary-2">CEDU sẽ chịu trách nhiệm phát hành và quảng bá khóa học.</div>
							</div>
							<div class="cac-buoc">
								<span>Bước 5</span>
								<p>Thu nhập</p>
								<div class="summary-2">Giảng viên sẽ được chia sẻ lợi nhuận trên từng khóa học.</div>
							</div>
						</div>
						<div class="quy-trinh-item">
							<h3>Trở thành CTV</h3>
							<div class="cac-buoc">
								<span>Bước 1</span>
								<p>Đăng kí</p>
								<div class="summary-2">Sau khi đăng ký thành công, sẽ có đại diện bộ phận nhân sự xác nhận qua điện thoại.</div>
							</div>
							<div class="cac-buoc">
								<span>Bước 2</span>
								<p>Lấy link</p>
								<div class="summary-2">Lựa chọn khóa học bạn yêu thích. Sau đó, click link AFFILIATE dành riêng cho bạn.</div>
							</div>
							<div class="cac-buoc">
								<span>Bước 3</span>
								<p>Chia sẻ khóa học</p>
								<div class="summary-2">Chia sẽ link vừa nhận trên các website, blog hay các trang mạng xã hội.</div>
							</div>
							<div class="cac-buoc">
								<span>Bước 4</span>
								<p>Nhận hoa hồng</p>
								<div class="summary-2">Bạn sẽ nhận được hoa hồng >=35% khi khách hàng vào link AFFILIATE của bạn để mua khóa học.</div>
							</div>
						</div>
					</div>

				</div>

			</div>
		</div>
	</div>

	<div class="teacher">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="teacherTitle">
						<div class="teacherTitleLeft">
							Đối tác tiêu biểu
						</div>
						<div class="teacherTitleRight">
							Những giao viên trẻ tài năng chất lương luôn tìm tòi nhưng phương pháp sáng tạo nhất để giảng dạy.
						</div>
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="owl-carousel">
						@foreach($teacher as $item)
						<div class="owlItem">
							<a href="{{ asset('teacher/'.$item->acc->email) }}" class="owlItemImg" style="background: url('{{ asset('lib/storage/app/avatar/'.$item->acc->img) }}') no-repeat center /cover ;">
							</a>
							<a href="{{ asset('teacher/'.$item->acc->email) }}" class="owlItemName">
								{{ $item->acc->name }}
							</a>
							<div class="owlItemContent">
								{!! cut_string($item->acc->content, 200) !!}
							</div>
						</div>
						@endforeach
					</div>
					
				</div>
			</div>
		</div>
	</div>
</section>
@stop
@section('script')
<script type="text/javascript" src="js/partner.js"></script>
<script type="text/javascript" src="js/home.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script>
    var owl = $(".owl-carousel");
    owl.owlCarousel({
        loop: true,
        autoplay: false,
        items: 3,
        nav:true,
        navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
        animateOut: 'fadeOut'
    });
    owl.on('changed.owl.carousel',function(property){
        $(property.target).find(".owl-item").find('.owlItemImg').css({'width': '184px', 'margin': '50px auto 20px'});
        $(property.target).find(".owl-item").find('.owlItemContent').css('display', 'none');
        var current = property.item.index;
        // $(property.target).find(".owl-item").eq(current).find('.owlItemImg').css('width', '184px');
        // $(property.target).find(".owl-item").eq(current).find('.owlItemContent').css('display', 'none');

        $(property.target).find(".owl-item").eq(current+1).find('.owlItemImg').css({'width': '250px', 'margin': '0 auto 40px'});
        $(property.target).find(".owl-item").eq(current+1).find('.owlItemContent').css('display', 'block');

        // $(property.target).find(".owl-item").eq(current+2).find('.owlItemImg').css('width', '184px');
        // $(property.target).find(".owl-item").eq(current+2).find('.owlItemContent').css('display', 'none');

    });
    $('.owl-next').click();
</script>
@stop


