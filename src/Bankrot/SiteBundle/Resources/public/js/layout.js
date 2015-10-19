jQuery(function ($) {
    'use strict';

    $('select').selecter();

    $('select[data-toggle-control-visible]').on('change', function (e) {
        var $ele = $('#' + $(this).val());

        //$ele.siblings('.form-control').hide();
        //$ele.show();

        $ele.siblings('.form-control').attr('type','hidden');
        $ele.siblings('.form-control').val(0);
        $ele.attr('type','text');

        e.preventDefault();
    }).trigger('change').each(function () {
        $(this).children('option').each(function () {
            $('#' + $(this).prop('value')).on('change', function () {
                $(this).siblings('.form-control').val(null);
            });
        });
    });



    $('body').on('change', 'select[data-toggle-control-visible]',function (e) {
        var $ele = $('#' + $(this).val());

        //$ele.siblings('.form-control').hide();
        //$ele.show();

        $ele.siblings('.form-control').attr('type','hidden');
        $ele.siblings('.form-control').val('');
        $ele.attr('type','text');

        e.preventDefault();
    }).trigger('change').each(function () {
        $(this).children('option').each(function () {
            $('#' + $(this).prop('value')).on('change', function () {
                $(this).siblings('.form-control').val(null);
            });
        });
    });


    $('[data-inputmask]').each(function () {
        $(this).inputmask($(this).data('inputmask'));
    });

    $('[data-route]').on('click', function (e) {
        window.location.href = $(this).data('route');

        e.preventDefault();
    });
});
