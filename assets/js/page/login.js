function loginValidation() {
  var valid = true;
  $("#username").removeClass("error-field");
  $("#password").removeClass("error-field");

  var UserName = $("#username").val();
  var Password = $("#password").val();

  $("#username-info").html("").hide();

  if (UserName.trim() == "") {
    valid = false;
  }
  if (Password.trim() == "") {
    valid = false;
  }

  return valid;
}

$("#loginForm").submit(function (e) {
  e.preventDefault();

  if (!loginValidation()) return false;

  $.ajax({
    url: "login/checkAuth",
    method: "POST",
    data: $(this).serialize(),
    success: function (response) {
       response = JSON.parse(response);
       console.log('response', response);
	   if (response["status"] == "success") {
        if( response["data"].type == 1){
          window.location.href = BASE_URL + "dashboard";
        }else{
          window.location.href = BASE_URL + "dashboard/general";
        }
       
      } else {
        // notifyme.showNotification(response["status"], response["message"]);
      }
    },
  });
});
