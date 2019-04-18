$(document).ready(function (e) {
    $windowwidth = $(window).width();
    if ($(window).width() < '768') {
        $('body').addClass('admin-menu-collapsed');
    }

    $(window).on('resize', function () {
        if ($(window).width() < '768') {
            $('body').addClass('admin-menu-collapsed');
        } else {
            $('body').removeClass('admin-menu-collapsed');
        }
    });

    $pathname = window.location;
    $current = $('#admin-menu #menu li a[href="' + $pathname + '"]');
    $current.parent().addClass('active');

    $('#admin-menu-toggle').click(function (event) {
        //event.preventDefault();
        $('body').toggleClass('admin-menu-collapsed');
    });
    
});
