/**
 * Created by manfred on 07.11.14.
 */

(function($){
    $.showCustomerData = function(reservationId){
        var pageId = $('body').attr('id').split('-');
        if(pageId.length == 2){
            pageId = parseInt(pageId[1]);
        }
        $.fancybox.showLoading();
        $.ajax({
            async: 'true',
            url: 'index.php',
            type: 'POST',

            data: {
                eID: "bjrfeadmin",
                request: {
                    pluginName:  'Reservation',
                    controller:  'Reservation',
                    action:      'showCustomer',
                    arguments: {
                        'pageId': pageId,
                        'reservation': reservationId
                    }
                }
            },
            //dataType: "json",
            dataType: 'html',
            success: function(result) {
                konsole(result);
                $.fancybox(result, {'width': 400});
            },
            error: function(error) {
                konsole(error);
            }
        });
    }


    $.sendMail = function(reservationId, option){
        var pageId = $('body').attr('id').split('-');
        if(pageId.length == 2){
            pageId = parseInt(pageId[1]);
        }
        $.fancybox.showLoading();
        $.ajax({
            async: 'true',
            url: 'index.php',
            type: 'POST',

            data: {
                eID: "bjrfeadmin",
                request: {
                    pluginName:  'Reservation',
                    controller:  'Reservation',
                    action:      'sendMail',
                    arguments: {
                        'pageId': pageId,
                        'reservation': reservationId,
                        'mailType' :  option.mailType
                    }
                }
            },
            //dataType: "json",
            dataType: 'html',
            success: function(result) {
                konsole(result);
                $.fancybox(result, {'width': 400});
                window.location.reload(true);
            },
            error: function(error) {
                konsole(error);
            }
        });
    }


    $.showReservations = function(articleId){
        var pageId = $('body').attr('id').split('-');
        if(pageId.length == 2){
            pageId = parseInt(pageId[1]);
        }
        $.fancybox.showLoading();
        $.ajax({
            async: 'true',
            url: 'index.php',
            type: 'POST',

            data: {
                eID: "bjrfeadmin",
                request: {
                    pluginName:  'Article',
                    controller:  'Article',
                    action:      'showReservations',
                    arguments: {
                        'pageId': pageId,
                        'article': articleId
                    }
                }
            },
            //dataType: "json",
            dataType: 'html',
            success: function(result) {
                konsole(result);
                $.fancybox(result, {'width': 400});
                $( "#datepicker" ).datepicker({
                    numberOfMonths: 3,
                    beforeShowDay: initDates
                });
            },
            error: function(error) {
                konsole(error);
            }
        });
    }


    $('.show-customer').click(function(event){
        $.showCustomerData($(this).data('reservationid'));
        event.preventDefault();
        });

    $('.confirm-reservation').click(function(event){
        $.sendMail($(this).data('reservationid'), {'mailType': 'confirm'});
        event.preventDefault();
    });

    $('.reject-reservation').click(function(event){
        $.sendMail($(this).data('reservationid'), {'mailType': 'reject'});
        event.preventDefault();
    });

    $('.remove-reservation').click(function(event){
        event.preventDefault();
        if(confirm('Wollen Sie wirklich löschen?')){
            var url = $(this).attr('href');
            window.location.href = url;
        }

    });

    $('.show-reservations').click(function(event){
        event.preventDefault();
        $.showReservations($(this).data('articleuid'));

    });

})(jQuery);


