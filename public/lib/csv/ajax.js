$(function () {
    $('.overlay').submit(function () {
        $.LoadingOverlay("show");
    });
});

$(document).ready(function () {
    $('.alert-success').delay(5000).fadeOut();
});

$(document).ready(function () {
    $('.alert-info').delay(5000).fadeOut();
});
