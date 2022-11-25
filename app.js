$("#signupform").css("display", "none");

$("#navsign").click(function () {
    $("#loginform").hide();
    $("#signupform").show();
});

$("#navlogin").click(function () {
    $("#loginform").show();
    $("#signupform").hide();
});