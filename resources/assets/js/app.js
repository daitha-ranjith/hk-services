require('./bootstrap');

let tokenInputs = $("input[type='password']");
$.each(function (input) {
    $(input).hideShowPassword(false, true);
});
