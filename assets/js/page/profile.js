function ChoosePlan(id, current_plan, amount) {
  $("#paypal-button-container").html("");
  if (amount == 0) {
    UpdateStatus(id, "free", "COMPLETED", "Paypal");
  } else {
    paypal
      .Buttons({
        // Set up the transaction
        createOrder: function (data, actions) {
          return actions.order.create({
            purchase_units: [
              {
                amount: {
                  value: amount,
                },
              },
            ],
          });
        },

        // Finalize the transaction
        onApprove: function (data, actions) {
          return actions.order.capture().then(function (orderData) {
            // // Successful capture! For demo purposes:
            console.log(
              "Capture result",
              orderData,
              JSON.stringify(orderData, null, 2)
            );

            var transaction = orderData.purchase_units[0].payments.captures[0];
            if (transaction.status == "COMPLETED") {
              UpdateStatus(
                id,
                transaction.id,
                transaction.status,
                "Paypal",
                amount
              );
            } else {
              // notifyme.showNotification("error", "Payment not completed.");
            }
          });
        },
      })
      .render("#paypal-button-container");

    $("#modalPaymentMethod").modal();
    if (current_plan == 1) {
      $(".already-plan-message").html(
        '<p style="color:#ffffff;">You have a ' +
          current_plan +
          " month currently active. <br/> Would you like to purchase another plan that will begin at the end of your current plan?<p>"
      );
    } else if (current_plan == 2 || current_plan == 3) {
      $(".already-plan-message").html(
        '<p style="color:#ffffff;">You already have an existing plan. Please wait for the plan to complete before purchasing a new one.<p>'
      );
      $("#paypal-button-container").hide();
    }
  }
}

$("#AccountListingGridGrouped").submit(function (event) {
  event.preventDefault();

  var fname = $("#fname_setting").val();
  var lname = $("#lname_setting").val();
  var phone = $("#phone_setting").val();
  var street = $("#street_setting").val();
  var city = $("#city_setting").val();
  var state = $("#state_setting").val();
  var country = $("#country_setting").val();
  var zipcode = $("#zipcode_setting").val();
  console.log(zipcode);
  $.ajax({
    url: BASE_URL + "profile/updateUserProfile",
    method: "POST",
    data: {
      fname: fname,
      lname: lname,
      phone: phone,
      street: street,
      city: city,
      state: state,
      country: country,
      zipcode: zipcode,
    },
    success: function (response) {
      response = JSON.parse(response);
      if (response["status"] == "success") {
        window.location = BASE_URL + "/profile/profile";
      } else {
      }
    },
  });
});

$("#modalUsernameForm").submit(function (event) {
  event.preventDefault();

  var username = $("#modalUsernameForm #username").val();
  $.ajax({
    url: BASE_URL + "/profile/changeUsername",
    method: "POST",
    data: {
      username: username,
    },
    success: function (response) {
      response = JSON.parse(response);
      if (response["status"] == "success") {
        setTimeout(function () {
          window.location.href = BASE_URL + "profile/profile";
        }, 1000);
      } else {
      }
    },
  });
});

$('#user_time_zone').change(function(){
  $.ajax({
    url: BASE_URL + "/profile/changeTimezone",
    method: "POST",
    data: {
      timezone: $('#user_time_zone').val(),
    },
    success: function (response) {
      window.location.href = BASE_URL + "profile/profile";
    },
  });
})

$(document).ready(function(){
  $('#user_time_zone').val(_baseGMT);
});