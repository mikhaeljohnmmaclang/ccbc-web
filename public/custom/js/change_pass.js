$(document).ready(function() {

    Parsley.addAsyncValidator("check_password", function(xhr) {
        return xhr.responseText === 'false' ? false : true;
    }, "/check_password");

    $("#save_btn").on("click", function(e) {
        e.preventDefault();

        Parsley._remoteCache = {};
        Parsley.addAsyncValidator("check_password", function(xhr) {
            return xhr.responseText === 'false' ? false : true;
        }, "/check_password");

        $(this).crud_click();
    })

});