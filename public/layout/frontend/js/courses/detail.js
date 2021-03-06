$( document ).ready(function(){
	getRateChart();

	if ($(window).width() >= 768){
        tagScroll();
	}
    $('.rateStar .fa-star').hover(function(){
        $(this).prevAll().addClass('starActive');
        $(this).addClass('starActive');
        $(this).nextAll().removeClass('starActive');
    });

	postRate();
	showDetailCourse();
	showMore();
	getAff();
	getdiscount();
    scrollVideo();

});

function getRateChart (){
	var rate = $('.rateChartRightItem');
	for (var i = 0; i < rate.length; i++) {
		var rateValue = rate.eq(i).find('.rateChartRightItemValue').text();
		rateValue *= 100;
		rate.eq(i).find('.rateChartRightItemLineActive').css('width', rateValue+'%');

	}
}

function tagScroll(){
	var courseTag = $('.courseTag').offset().top;
	var footer = $('footer').offset().top;
	// console.log(courseTag);
	$( document ).scroll(function(){
		var top = $(document).scrollTop();
		// console.log(top);
		if ($(window).width() == 768){
            if (top > courseTag-100 && top < footer - $(window).height() + 200) {
                $('.courseTag').css('margin-top', top-courseTag+100);
            }
		}
		else{
            if (top > courseTag-10 && top < footer - $(window).height() + 200) {
                $('.courseTag').css('margin-top', top-courseTag+10);
            }
		}

		
	    // console.log($(document).scrollTop());
	});
}

function postRate(){
	// $('.startLast').hover(function(){
 //    	$(this).prevAll().addClass('starActive');
	//     $(this).addClass('starActive');
	//     $(this).nextAll().removeClass('starActive'); 
	//     // var numItems = $('.startLast.starActive').length;
 //    },function(){
 //    	$(this).prevAll().removeClass('starActive');
 //    	$(this).removeClass('starActive');
 //    });

    $('.startLast').click(function(){

    	$(this).prevAll().addClass('starActive');
	    $(this).addClass('starActive');
	    $(this).nextAll().removeClass('starActive'); 
	    
    });
    $('.rateMainItemContentBtn').click(function(){
    	var star = $('.startLast.starActive').length;
    	var content = $('.rateMainItemContentBody textarea').val();
    	var cou_id = $('.cou_id').text();
    	var ava_bg = $(this).parents('.rateMainItem').find('.rateMainItemAvaImg').attr('style');
    	var name = $(this).parents('.rateMainItem').find('.rateMainItemAvaName').text();
    	console.log(ava_bg);

    	var url = $('.currentUrl').text();
    	$.ajax({
	      method: 'POST',
	      url: url+'courses/rate',
	      data: {
	          '_token': $('meta[name="csrf-token"]').attr('content'),
	          'star': star,
	          'content' : content,
	          'cou_id' : cou_id
	      },
	      success: function () {
	      	$('.rateMainItem.form').remove();
			var model = $('.rateMainItem').eq(0).html();
			console.log($('.rateMainItem').length);
			if ($('.rateMainItem').length == 0){
				location.reload();
			}
			$('.rateMain').append('<div class="rateMainItem">'+model+'</div>');
			var last_item = $('.rateMainItem').eq($('.rateMainItem').length - 1);

			last_item.find('.rateMainItemAvaImg').attr('style', ava_bg);
			last_item.find('.rateMainItemAvaName').text(name);
			last_item.find('.rateMainItemAvaTime').text('Bây giờ');
			last_item.find('.rateMainItemContentBody').text(content);
			var stars = last_item.find('.rateMainItemContentStarContent .fa-star');
			for (var i = 0; i < stars.length ; i++){
				if (i < star ) {
					stars.eq(i).attr('class','fa fa-star starActive');
                }
				else {
					stars.eq(i).attr('class','fa fa-star');
                }
			}
	      	// location.reload();
	       	return true;
	      },
	      error: function () {
	      	console.log('Lỗi Server')
	        return false;
	      }
	    });
    });
}

function showDetailCourse(){
	$(document).on('click', '.lessonMainPart' , function(){
		if ($(this).next().is(":hidden")) {
			$(this).find('.lessonMainPartIcon i:first-child').css('transform', 'translateY(-50%) rotate(180deg)');
		}
		else{
			$(this).find('.lessonMainPartIcon i:first-child').css('transform', 'translateY(-50%) rotate(90deg)');
		}
		$(this).next().slideToggle();
	});
}

function showMore(){
    $('.descriptionContent').height('242px');
    var height_content = $('.descriptionContentItem').height();
	$(document).on('click', '.btnShowMoreDescription' , function(){
		$(this).prev().css('height', height_content+40);
		$(this).next().css('display', 'block');
		$(this).css('display', 'none');
	});
	$(document).on('click', '.btnShowLessDescription' , function(){
		$(this).prev().prev().css('height', '242px');
		$(this).prev().css('display', 'block');
		$(this).css('display', 'none');
	});
}

function getAff(){
	$(document).on('click', '.formCodeAff' , function(){
		$('.get_aff').css({'height':'0' , 'padding': '0'});
		var cou_slug = $('.cou_slug').text();
		var url = $('.currentUrl').text();
		var code = $(this).prev().val();
		console.log(code);
		$.ajax({
	      method: 'POST',
	      url: url+'courses/get_aff',
	      data: {
	          '_token': $('meta[name="csrf-token"]').attr('content'),
	          'code': code,
	      },
	      success: function (resp) {
	      	if (resp == 'error') {
	      		$('.get_aff').html('<div class="aff_name">Không tìm thấy</div>');
	      		$('.get_aff').css({'height':'auto' , 'padding': '5px 15px'});
	      	}else{
	      		$('.get_aff').html(resp);
		      	$('.get_aff').css({'height':'auto' , 'padding': '5px 15px'});
		      	history.pushState(null, '', url+'/courses/detail/'+cou_slug+'?aff='+code);
		      	$('.courseTagContentAddCart a').attr('href', url+'cart/add/'+cou_slug+'?aff='+code);
	      	}
		      	
	      	
	      },
	      error: function () {
	      	console.log('Lỗi Server')
	        return false;
	      }
	    });
	});


}
function getdiscount(){
	$(document).on('click', '.formDis' , function(){
		$('.get_dis').css({'height':'0' , 'padding': '0'});
		var price = $('.courseTagNewPrice_raw').text();
		var url = $('.currentUrl').text();
		var code = $('input[name="dis"]').val();
		var url_add = $('.courseTagContentAddCart a').attr('href');
        var url_buy = $('.courseTagContentBuy a').attr('href');
		console.log(code);
		$.ajax({
	      method: 'POST',
	      url: url+'check_discount',
	      data: {
	          '_token': $('meta[name="csrf-token"]').attr('content'),
	          'code': code,
	      },
	      success: function (resp) {
	      	console.log(resp);
	      	$('.get_dis .aff_name').text(resp.name+' -'+resp.percent+'%');
		  	$('.get_dis .aff_deny').hide();
		  	$('.get_dis .aff_check').show();
		  	$('.get_dis').css({'height':'auto' , 'padding': '5px 15px'});
		  	url_add.split("?") == 1 ? $('.courseTagContentAddCart a').attr('href', url_add+'?dis='+code) : $('.courseTagContentAddCart a').attr('href', url_add+'&dis='+code);
		  	url_buy.split("?") == 1 ? $('.courseTagContentBuy a').attr('href', url_buy+'?dis='+code) : $('.courseTagContentBuy a').attr('href', url_buy+'&dis='+code);

		  	$('.courseTagOldPrice del').text(price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));
		  	$('.courseTagNewPrice').text((price*(100-resp.percent)/100).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));


          },
	      error: function (resp) {
	      	console.log(resp.responseText);
	      	$('.get_dis .aff_name').text(resp.responseText);
			$('.get_dis .aff_deny').show();
			$('.get_dis .aff_check').hide();
	      	$('.get_dis').css({'height':'auto' , 'padding': '5px 15px'});
	        return false;
	      }
	    });
	});


}

function scrollVideo() {
    console.log($(window).width());
    var courseBigVideo_height = $('.courseBigVideo').height();
    console.log(courseBigVideo_height);
    if ($(window).width()>768){
        $(window).scroll(function(){
            var eTop = $('.lesson').offset().top;
            console.log(eTop - $(window).scrollTop());
            if (eTop - $(window).scrollTop() < 125){
                $('.courseHeadVideo').css({'position': 'fixed', 'width': '40%', 'bottom': '10px', 'right': '10px', 'z-index': '9'});
                $('.courseBigVideo:after').css({'padding-bottom': '56%'});
            }
            else{
                $('.courseHeadVideo').css({'position': 'unset', 'width': '100%'});
                $('.courseBigVideo').css({'height': courseBigVideo_height});
            }
        });
    }

}