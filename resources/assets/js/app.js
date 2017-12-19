require('./bootstrap');

$('.secret-password').each(function() {
    $(this).hideShowPassword(false, true);
});
