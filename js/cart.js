/**
 * @author lhornet
 * @date 12.04.2015
 * @doc module
 * @name cart
 * @description 
 * Shopping cart
 *
 * @injections jquery 1.7.2 or older, masked plugin
 */
(function () {
    'use strict';

    $(document).ready(function () {

        //checking inkognito & localstorage support
        function webStorage() {
            try {
                localStorage.setItem("test", "tested");
                return !!localStorage.getItem("test");
            } catch (e) {
                return false;
            }
        }

        $('.message').hide();

        //mask
        var
            i1 = $('input[name=input_name]'),
            i2 = $('input[name=input_product_phone]').mask("+38(999) 999 99 99"),
            i3 = $('input[name=input_phone]').mask("+38(999) 999 99 99"),
            i4 = $('.try30day-phone').mask("+38(999) 999 99 99"),
            //vars
            products = [],
            submit = $('.btn-product').attr('disabled', 'disabled'),
            i = 0,
            sum = 0,
            totalSum = 0;

        /*modal popup redirect to full version*/

        if (webStorage() === false) {
            $('.popup').show();
        } else {
            localStorage.removeItem("test");
        }

        //add to cart from product template
        $('.buy_button').on({
            click:
                function (e) {
                    if (localStorage.length > 0) {
                        var id = $(this).attr('data-id'),
                                d = localStorage.getItem(id),
                                newdata = JSON.parse(d);
                        console.log("newdata", newdata);

                        if (newdata !== null) {
                            var product = {
                                id: $(this).attr('data-id'),
                                name: $(this).attr('data-name'),
                                description: $(this).attr('data-description'),
                                image: $(this).attr('data-image'),
                                price: $(this).attr('data-price'),
                                sum: ($(this).attr('data-price')) * (+($(this).attr('data-count')) + 1),
                                count: +($(this).attr('data-count')) + 1,
                                params: $(this).attr('data-params')
                            };
                        } else {
                            var product = {
                                id: $(this).attr('data-id'),
                                name: $(this).attr('data-name'),
                                description: $(this).attr('data-description'),
                                image: $(this).attr('data-image'),
                                price: $(this).attr('data-price'),
                                sum: ($(this).attr('data-price')) * ($(this).attr('data-count')),
                                count: $(this).attr('data-count'),
                                params: $(this).attr('data-params')
                            };
                        }
                    } else {
                        var product = {
                            id: $(this).attr('data-id'),
                            name: $(this).attr('data-name'),
                            description: $(this).attr('data-description'),
                            image: $(this).attr('data-image'),
                            price: $(this).attr('data-price'),
                            sum: ($(this).attr('data-price')) * ($(this).attr('data-count')),
                            count: $(this).attr('data-count'),
                            params: $(this).attr('data-params')
                        };
                    }

                    products.push(product);
                    localStorage.setItem(product.id, JSON.stringify(products));
                    console.log("localStorage", localStorage);
                }
        });

        //redraw cart
        function drawCart() {

            var arr = [],
			debug = [];
			console.log(localStorage);
            for (var i = 0; i < localStorage.length; i++) {
                var
                    key = localStorage.key(i),
                    pos = key.indexOf("3gstar_"),
					/*debugger*/
					item = localStorage.getItem(key),
					str = "<strong>"+key+"</strong>  "+item+"<br/>";
					debug.push(str);
					/*end debugger*/
					
                if(pos !== -1){
                     arr.push(key);
                }
            }
			
			/*debugger*/
			if(debug !==null){
				$('p.local_debug').html(debug);
			}else{
				$('p.local_debug').html('empty');
			}
			/*end debugger*/
			
            var output = "";
            $(".ordering .row.first-order").remove();
            if(arr.length > 0){
                for (var i = 0; i <  arr.length; i++) {
                    $('.feedback-form').show();
  
                    var d = localStorage.getItem(arr[i]);
                    var data = JSON.parse(d);

                    console.log("data",data);

                    totalSum += data[0].sum;

                    output +=
                            "<div class = 'row first-order'>" +
                            "<div class='col-xs-4'>" +
                            "<img src=" + data[0].image + " class='img-responsive'>" +
                            "</div>" +
                            "<div class='col-xs-6'> " +
                            "<h2>" + data[0].name + "</h2>" +
                            "<div class='form-group' data-id=" + data[0].id + " data-price=" + data[0].price + ">" +
                            "<input 							" +
                            "	type='text'						" +
                            "	value=" + data[0].count + " 		" +
                            "	class='checkout_shop'			" +
                            ">" +
                            "</div>" +
                            "<div class='price pr_cart'>" +
                            "<p>" + data[0].sum + "<span>грн</span></p>" +
                            "</div> " +
                            "</div> " +
                            "<div class='col-xs-2'>" +
                            "<img src='img/close.png' class='img-responsive delete-item'>" +
                            "</div>" +
                            "</div> ";
                    }
                    output += "<div class='price pr_cart'><p>Всего: " + totalSum + " грн</p></div>";
                } else {
                    
                    output = "Ваша корзина пуста";
                    $('.feedback-form').hide();
                }

                

            $(".ordering").html(output);
            totalSum = 0;
        }
        drawCart();

        //change qty item in cart
        $(document.body).on('keyup', '.checkout_shop',
                function (e) {

                    i++;
                    var parent = $(this).parents('.first-order'),
                            countItems = $(this).val(),
                            id = parent.find('.form-group').attr('data-id'),
                            price = parent.find('.form-group').attr('data-price'),
                            d = localStorage.getItem(id),
                            data = JSON.parse(d),
                            sumItems = price * countItems;

                    if (countItems >= 1) {
                        var product = {
                            id: data[0].id,
                            name: data[0].name,
                            description: data[0].description,
                            image: data[0].image,
                            price: data[0].price,
                            count: countItems,
                            sum: sumItems,
                            params: data[0].params
                        };

                        if (i <= 1)
                        {
                            products.push(product);
                            localStorage.setItem(id, JSON.stringify(products));
                        } else {
                            localStorage.setItem(id, JSON.stringify([product]));
                        }

                        drawCart();
                    }
                }
        );

        //delete item in cart
        $(document.body).on('click', '.delete-item',
                function () {
                    var parent = $(this).parents('.first-order'),
                            iditem = parent.find('.form-group').attr('data-id');
                    removeItem(iditem);
                }
        );

        //show error message
        function showMessage(notice, name) {
            var message = $('.message.' + name);

            if (notice !== '') {
                message.show().html(notice);
            } else {
                message.hide();
            }
            ;
        }

        //validate fields
        function validate(value, field) {

            var
                    messages = {
                        Number: 'Использовать только числа!',
                        Required: 'Это поле обязательно к заполнению',
                        Name: 'Необходимо вводить символы'
                    },
            reg = /[0-9]/,
                    regChar = /[A-Za-zА-Яа-я]/,
                    rules = {
                        isNumber: function (val) {
                            if (reg.test(val)) {
                                $('.message').hide();
                                return true;
                            } else {
                                showMessage(messages.Number, 'phone');
                                return false;
                            }
                        },
                        required: function (val) {
                            if (val !== '') {
                                //	$('.message').hide();
                                return true;
                            }
                            else {
                                showMessage(messages.Required, 'required');
                                return false;
                            }
                        },
                        /*isPhone:function(val){
                         
                         },*/
                        isName: function (val) {
                            if (regChar.test(val)) {
                                $('.message').hide();
                                return true;
                            }
                            else {
                                showMessage(messages.Name, 'name');
                                return false;
                            }
                        }
                    };

            switch (field) {
                case 'add_to_cart':
                    rules.isName(value);
                    rules.required(value);
                    break;
                case 'checkout':
                    if (rules.isName(value) &&
                            rules.required(value))
                    {
                        return true;
                    }
                    break;
                case 'required':
                    if (rules.required(value)) {
                        return true;
                    }
                    break;
                case 'recount':
                    rules.isNumber(value);
                    rules.required(value);
                default:
                    '';
            }
        }

        //remove item
        function removeItem(id) {
            localStorage.removeItem(id);
            drawCart();
        }

        //clear Storage
        function clearCart() {
            localStorage.clear();
        }

        //check form
        $('input[name=input_name],input[name=input_phone]').keyup(function () {
            ckeckSubmit();
            if($(this).val()!==''){$(this).parent('.col-sm-10').find('.message').hide()};
        });
        
        //check submit
        function ckeckSubmit() {
            var
                    a1 = i1.val(),
                    a3 = i3.val(),
                    form = {
                        name: a1,
                        phone: a3
                    };

            if (validate(a1, 'checkout') && validate(a3, 'required')) {
                submit.removeAttr('disabled');
                return form;
            } else {
                submit.attr('disabled', 'disabled');
            }
        }

        //checkout
        $('.btn-product').click(
                function (e) {

                    var 
						submit = ckeckSubmit(),
                        orders = [],
                        total = [],
						arr = [],
                        user = [];

						
                    if (localStorage.length > 0) {
					
                        var totalSum = 0;
						
						for (var i = 0; i < localStorage.length; i++) {
							var
								key = localStorage.key(i),
								pos = key.indexOf("3gstar_");
								
							if(pos !== -1){
								 arr.push(key);
							}
						}

						for (var i = 0; i < arr.length; i++) {
							var 
								d = localStorage.getItem(arr[i]),
								data = JSON.parse(d);
								console.log("total: ", data);
								totalSum += data[0].sum;
								orders.push(data);
						}
						
                        total.push({'total': totalSum});
                        user.push({
                            'userName': submit.name,
                            'userPhone': submit.phone
                        });

                        if (
                                orders !== null &&
                                total !== null &&
                                submit.name !== null &&
                                submit.phone !== null
                                ) {
								checkout(orders, total, user);
                        }
                    }
                }
        );

        //ajax checkout
        function checkout(order, total, user) {
            console.log('obj', order, total, user);

            $.ajax({
                url: 'http://m.3gstar.com.ua/ajax/ajax.php',
                type: 'post',
                data: {
                    order: order,
                    total: total,
                    user: user
                },
                success: function () {
                    alert('Ваш заказ оформлен');
                    clearCart();
                    drawCart();

                },
                error: function (data) {
                    console.log("error", data);
                    return;
                }
            });

        }

    });

})();
if(!navigator.cookieEnabled){alert('Включите cookie для комфортной работы с этим сайтом');}