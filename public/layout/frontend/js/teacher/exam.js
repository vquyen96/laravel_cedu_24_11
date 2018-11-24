
$(document).ready(function(){
    btnEditQues();
    btnDeleteQues();
    btnEditAns();
    btnDeleteAns();
    submitFormEditQues();
    submitFormEditAns();
    nav_run();
    sort_exam();
    show_ans();

    sortQues();
    add_ques();

    validation_exam();
    postAddAns();

    $('form').submit(function () {
        $('.loadingPage').hide();
    });
});
var url = $('.currentUrl').text();
function btnEditQues(){
    $(document).on('click', '.btnEditQues', function(){
        $(this).parent().find('.fa-edit').toggle();
        $(this).parent().find('.fa-times-circle').toggle();
        $(this).parent().find('.fa-trash').toggle();

        $(this).parent().prev().toggle();
        $(this).parent().next().toggle();
    });

}
function btnDeleteQues(){
    $(document).on('click', '.btnDeleteQues', function () {
        if (confirm('Bạn có chắc chắn muốn xóa câu hỏi')){
            var this_ = $(this);
            var src = this_.attr('href');
            $.ajax({
                method: 'POST',
                url: src,
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (resp) {
                    this_.parents('li').remove();
                },
                error: function () {
                    console.log('Lỗi Server')
                }
            });
        }
    });
}
function btnEditAns(){
    $(document).on('click', '.btnEditAns', function () {
        $(this).parent().find('.fa-edit').toggle();
        $(this).parent().find('.fa-times-circle').toggle();
        $(this).parent().find('.fa-trash').toggle();
        $(this).parent().prev().toggle();
        $(this).parent().next().toggle();
    })
    // $('.btnEditAns').click(function(){
    //
    // });

}
function btnDeleteAns(){
    $(document).on('click', '.btnDeleteAns', function () {
        if (confirm('Bạn có chắc chắn muốn xóa câu trả lời?')){
            var this_ = $(this);
            var src = this_.attr('href');
            $.ajax({
                method: 'POST',
                url: src,
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (resp) {
                    this_.parents('.col-md-6').remove();
                },
                error: function () {
                    console.log('Lỗi Server')
                }
            });
        }
    });
}
function submitFormEditQues(){
    $(document).on('submit', ".formEditQues", function(e) {
        var isvalid = $(this).valid();
        var this_form = $(this);
        var list_ans = $(this).parents('.list_ans');

        if (isvalid) {
            e.preventDefault();
            var this_form =  $(this);
            var name = $(this).find('input[name="name"]').val();
            var order = $(this).find('input[name="order"]').val();
            var id = $(this).find('input[name="id"]').val();
            var score = $(this).find('input[name="score"]').val();
            var num_ans = $(this).find('input[name="num_ans"]').val();

            $.ajax({
                method: 'POST',
                url: url+'teacher/edit_question/'+id,
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'name': name,
                    'order' : order,
                    'score' : score,
                    'num_ans' : num_ans
                },
                success: function () {
                    this_form.prev().prev().find('.quesNameContentMain').text(name+" __ ["+score+"]");
                    this_form.prev().find('.btnEditQues.cancle').trigger('click');
                    // $('#cancelEditQues').trigger('click');
                    console.log('done');
                },
                error: function () {
                    console.log('Lỗi Server')
                    return false;
                }
            });
        }
    });
    // $(document).on('click', '.btnSubmitEditQues', function(){
    //     var this_el =  $(this);
    //     var name = $(this).parents('.formEditQues').find('input[name="name"]').val();
    //     var order = $(this).parents('.formEditQues').find('input[name="order"]').val();
    //     var id = $(this).parents('.formEditQues').find('input[name="id"]').val();
    //     var score = $(this).parents('.formEditQues').find('input[name="score"]').val();
    //     var num_ans = $(this).parents('.formEditQues').find('input[name="num_ans"]').val();
    //
    //     $.ajax({
    //         method: 'POST',
    //         url: url+'teacher/edit_question/'+id,
    //         data: {
    //             '_token': $('meta[name="csrf-token"]').attr('content'),
    //             'name': name,
    //             'order' : order,
    //             'score' : score,
    //             'num_ans' : num_ans
    //         },
    //         success: function () {
    //             this_el.parents('.formEditQues').prev().prev().find('.quesNameContentMain').text(name+" __ ["+score+"]");
    //             this_el.parents('.formEditQues').prev().find('.btnEditQues.cancle').trigger('click');
    //             // $('#cancelEditQues').trigger('click');
    //
    //             console.log('done');
    //         },
    //         error: function () {
    //             console.log('Lỗi Server')
    //             return false;
    //         }
    //     });
    // });
    // $('.btnSubmitEditQues').click(function () {
    //
    // });

    // Khi input enter => nut submit sẽ được click
    // $('.formEditQues input').bind("enterKey",function(e){
    //     $(this).parents('.formEditQues').find('.btnSubmitEditQues').trigger('click');
    //     // $('.btnSubmitEditQues').trigger('click');
    //
    //     console.log("enter");
    // });
    // $('.formEditQues input').keyup(function(e){
    //     if(e.keyCode == 13)
    //     {
    //         $(this).trigger("enterKey");
    //
    //     }
    // });
}

function submitFormEditAns(){
    $(document).on('submit', ".formEditAns", function(e) {
        var isvalid = $(this).valid();
        var this_form = $(this);
        var list_ans = $(this).parents('.list_ans');
        e.preventDefault();
        if (isvalid) {
            var name = this_form.find('input[name="name"]').val();
            // var correct = this_form.find('input[name="correct"]').val();
            var id = this_form.find('input[name="id"]').val();
            if (this_form.find('input[type="checkbox"]').is(":checked"))
            {
                var correct = 1;
            }
            else{
                var correct = 0;
            }
            $.ajax({
                method: 'POST',
                url: url+'teacher/edit_ans/'+id,
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'name': name,
                    'correct' : correct
                },
                success: function (resp) {
                    correct == 1 ? correct = true : correct = false;
                    this_form.prev().prev().find('input[name="name"]').val(name);
                    this_form.prev().prev().find('input[type="checkbox"]').attr('checked',correct);
                    this_form.prev().find('.btnEditAns.cancel').trigger('click');
                    // $('#cancelEditQues').trigger('click');
                    console.log('done');
                },
                error: function () {
                    console.log('Lỗi Server')
                    return false;
                }
            });
        }
    });
    // $(document).on('click', '.btnSubmitEditAns', function(){
    //
    // });
    // $('.btnSubmitEditAns').click(function () {
    //
    // });
    // $('.formEditAns input').bind("enterKey",function(e){
    //     this_form.find('.btnSubmitEditAns').trigger('click');
    //
    //     console.log("enter");
    // });
    // $('.formEditAns input').keyup(function(e){
    //     if(e.keyCode == 13)
    //     {
    //         $(this).trigger("enterKey");
    //
    //     }
    // });
}

function nav_run(){
    var current_key = localStorage.getItem('key_nav');
    nav_active(current_key);

    $('.exam_head ul li').click(function () {
        let key = $('.exam_head ul li').index($(this));
        localStorage.setItem('key_nav', key);
        nav_active(key);
    })
}

function nav_active(key){
    $('.exam_head ul li').eq(key).attr('class', 'active');
    $('.exam_head ul li').eq(key).siblings().attr('class', '');
    $('.mainItem').eq(key).fadeIn();
    $('.mainItem').eq(key).siblings().hide();
}

function sort_exam(){
    $('.list_ques').sortable({
        placeholder         : 'sort-highlight',
        handle              : '.handle',
        forcePlaceholderSize: true,
        zIndex              : 999999,
        update : function () {
            $('.list_ques li').each(function (e) {
                $(this).find('.quesNameContent input[type="number"]').val(e + 1);
                $('.btnSort').attr('class', 'btn btn-yell btnSort');
            })
        }
    });
}


function show_ans(){
    $(document).on('click', '.btnShowAns', function(){
        if ($(this).parents('.que_item').find('.panel-body.list_ans').is(":hidden")){
            $(this).css('transform','rotate(-90deg)');
        }
        else{
            $(this).css('transform','rotate(0deg)');
        }
        $(this).parents('.que_item').find('.panel-body.list_ans').slideToggle();
        var que_item = $(this).parents('li').siblings();
        for (var i = 0; i < que_item.length; i++){
            que_item.eq(i).find('.panel-body.list_ans').slideUp();
            que_item.eq(i).find('.btnShowAns').css('transform','rotate(0deg)');
        }
        localStorage.setItem('key_ques', $(this).attr('id_quess'));

    });
    let key_ques = localStorage.getItem('key_ques');
    let btnShowAns = $('.btnShowAns');
    for (var i = 0; i< btnShowAns.length; i++){
        console.log( btnShowAns.eq(i).attr('id_quess'));
        btnShowAns.eq(i).attr('id_quess') == key_ques ? btnShowAns.eq(i).click() : '' ;
    }
}

function sortQues(){
    $(document).on('click', '.btnSort.btn-yell', function () {
        let this_ = $(this);
        var input_order = $('input[name="order"]');
        var arr_order = [];
        for (var i = 0; i < input_order.length; i++){
            arr_order.push(input_order.eq(i).val()+"--"+input_order.eq(i).next().val());
            console.log(input_order.eq(i).val()+"--"+input_order.eq(i).next().val());
        }
        $('span.icon_load').show();
        $.ajax({
            method: 'POST',
            url: url+'teacher/sort_ques',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'data': arr_order
            },
            success: function (resp) {
                $('span.icon_load').hide();
                this_.attr('class', 'btn btn-blue btnSort');
                // setTimeout(function () {
                //
                // },500);

                console.log('done');
            },
            error: function () {
                console.log('Lỗi Server')
            }
        });
    });
}
var index = 4
function add_ques(){
    $(document).on('click', ".btn_add_ans", function () {
        var content = '<div class="col-md-6">' +
                        '<div class="input-group mb-3">' +
                            '<span class="input-group-addon">' +
                                '<input type="checkbox" name="ans[correct_'+index+'">' +
                            '</span>' +
                            '<input type="text" class="form-control" name="ans[name_'+index+']" placeholder="Câu trả lời">' +
                        '</div>' +
                    '</div>';
        $(this).parent().prev().append(content);
        index++;
    });
}


function validation_exam(){
    $(".form_edit_exam").validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        rules: {
            "name": {
                required: true
            },
            "time": {
                required: true,
                digits: true
            },
            "pass": {
                required: true,
                digits: true,
                max: 100
            }
        },
        messages: {
            "name": {
                required: "Bắt buộc nhập tên bài kiểm tra"
            },
            "time": {
                required: "Bắt buộc phải điền thời gian làm bài",
                digits: "Thời gian là số nguyên dương"
            },
            "pass": {
                required: "Bắt buộc phải điền tỷ lệ qua bài",
                digits: "Tỷ lệ là số nguyên dương",
                max: "Tỷ lệ vượt quá giới hạn"
            }
        }
    });


    $(".form_add_ques").validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        rules: {
            "que[name]": {
                required: true
            },
            "que[score]": {
                required: true,
                digits: true
            }
        },
        messages: {
            "que[name]": {
                required: "Bắt buộc nhập câu hỏi"
            },
            "que[score]": {
                required: "Bắt buộc phải điền điểm cho câu hỏi",
                digits: "Điểm là số nguyên dương"
            }
        }
    });
    $(".formEditQues").validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        rules: {
            "name": {
                required: true
            },
            "score": {
                required: true,
                digits: true
            }
        },
        messages: {
            "name": {
                required: "Bắt buộc nhập câu hỏi"
            },
            "score": {
                required: "Bắt buộc phải điền điểm cho câu hỏi",
                digits: "Điểm là số nguyên dương"
            }
        }
    });
    $('.form_add_ans, .formEditAns').each(function() {  // attach to all form elements on page
        $(this).validate({       // initialize plugin on each form
            onfocusout: false,
            onkeyup: false,
            onclick: false,
            rules: {
                "name": {
                    required: true
                }
            },
            messages: {
                "name": {
                    required: "Bắt buộc nhập câu trả lời"
                }
            }
        });
    });




    // $(".formEditAns").validate({
    //     onfocusout: false,
    //     onkeyup: false,
    //     onclick: false,
    //     rules: {
    //         "name": {
    //             required: true
    //         }
    //     },
    //     messages: {
    //         "name": {
    //             required: "Bắt buộc nhập câu trả lời"
    //         }
    //     }
    // });
}

function postAddAns(){
    $(document).on('submit', ".form_add_ans", function(e) {
        var isvalid = $(this).valid();
        var this_form = $(this);
        var list_ans = $(this).parents('.list_ans');
        // console.log(isvalid);
        if (isvalid) {
            e.preventDefault();
            // alert($(this).find('input[name="name"]').val());
            var name = $(this).find('input[name="name"]').val();
            var src = $(this).attr('action');
            if ($(this).find('input[type="checkbox"]').is(':checked')) {
                var correct = 1;
            }
            else{
                var correct = 0;
            }
            $.ajax({
                method: 'POST',
                url: src,
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'name': name,
                    'correct' : correct
                },
                success: function (resp) {
                    this_form.parent().before(resp);
                    this_form.find('input[name="name"]').val("");
                    this_form.find('input[type="checkbox"]').prop('checked', false);

                    // list_ans.find('.row').append('<div class="col-md-6 col-xs-12">'+this_form.html()+'</div>');
                    console.log('done');
                },
                error: function (resp) {
                    alert(resp);
                    console.log('Lỗi Server')
                }
            });
        }
    });
}