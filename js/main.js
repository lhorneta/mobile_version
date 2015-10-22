$(function () {

    var API = $("nav#menu").mmenu({
        // Options
        slidingSubmenus: true
    }).data("mmenu");


    $(".resize_one.parent_category").click(function (e) {
        e.preventDefault();
        API.open();
    });

    $("ul.catalog.on_index.oll-m li").click(function () {
 
        API.open();

        var el = $(this).index() + 1;

        $('a.mm-subopen[href=#mm-' + el + ']').click();

    });

    /*Форма Получить консультацию у специалиста*/
    $('.btn-product-specialist').click(function (e) {
        e.preventDefault();
        var
            phone = $('#inputEmail1').val(),
            form = $('input[name=form]').val();
        if (phone !== '') {
            $('.min_form,.form-horizontal').hide();
            $('.min_form_load').show();
            $.ajax({
                url: 'ajax/ajax.php',
                type: 'post',
                data: {consulting_specialist: phone, form: form},
                success: function (data) {
                    $('.min_form_load').hide();
                    $('.min_form_succ').show();
                    $('#inputEmail1').val('');
                }
            });
        }

    });
    /*end Форма Получить консультацию у специалиста*/

    /*Форма с экспертом*/
    $('.btn-product-request').click(function (e) {
        e.preventDefault();
        var
            phone = $('#inputEmail3').val(),
            form = $('input[name=form]').val();
        if (phone !== '') {
            $('.min_form,.form-horizontal').hide();
            $('.min_form_load').show();
            $.ajax({
                url: 'ajax/ajax.php',
                type: 'post',
                data: {consulting_engineer: phone, form: form},
                success: function (data) {
                    $('.min_form_load').hide();
                    $('.min_form_succ').show();
                    $('#inputEmail3').val('');
                }
            });
        }

    });
    /*end Форма с экспертом*/

    /*Попробуй на 30 дней бесплатно*/
    $('.button_try30_pr').click(function (e) {
        e.preventDefault();
        var inpphone = $('.try30day-phone').val(),
        form_name = $('input[name=form_name]').val();
        if (inpphone !== '') {
            $('.button_try30_pr,.try30day_help_text,.try30day-phone').hide();
            $('.min_form_load2').show();
            $.ajax({
                url: 'ajax/ajax.php',
                type: 'post',
                data: {try_30_day: inpphone, form: form_name},
                success: function (data) {
                    $('.min_form_load2').hide();
                    $('.min_form_succ2').show();
                    $('input[name=form_name]').val('');
                }
            });
        }
    });
    /*end Попробуй на 30 дней бесплатно*/

    /*mobile detected*/
    if(
        navigator.userAgent.match(/Android/i)
        || navigator.userAgent.match(/webOS/i)
        || navigator.userAgent.match(/iPhone/i)
        || navigator.userAgent.match(/iPad/i)
        || navigator.userAgent.match(/iPod/i)
        || navigator.userAgent.match(/BlackBerry/i)
        || navigator.userAgent.match(/Windows Phone/i)
    ) {
       $('.debug').hide();
    }
    /*end mobile detected*/
});

var step = $('.pagination').attr('data-count'),
max = $('.pagination').attr('data-count-max');
if(max<step){$('.pagination,.show_load').remove();}

$('.pagination').click(function(){
    
    var ajax = {
        key:{
            data    :'pagination',
            id      :$(this).attr('data-category-id'),
            count   :$(this).attr('data-count')           
        }
    },
    loader = $('.pagination img');
    
    loader.show();

    $.ajax({
        type: 'post',
        data: ajax,
        success: function (data) {
            var step = $('.pagination').attr('data-count'),
            max = $('.pagination').attr('data-count-max'),
            steps = (+step)+15;
            $('.category').append(data);
            step = (+step)+15;
            $('.pagination').attr('data-count',step);
            $('.show_load span').text(step);
            console.log("steps",max,steps);
            loader.hide();
            if(max<=step){
            $('.pagination,.show_load').remove();}
        }
    });
});