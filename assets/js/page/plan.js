$(".bootstrapSwitch .switchBox").click(function () {
  if ($(this).is(":checked")) {
    $(this).attr("checked", true);
    $(this).parent().removeClass("checkWrapNO");
    $(this).parent().addClass("checkWrap");
    $(".bootstrapSwitch .checkWrap .checkBoxValue").text("Active");
  } else {
    $(this).removeAttr("checked");
    $(this).parent().removeClass("checkWrap");
    $(this).parent().addClass("checkWrapNO");
    $(".bootstrapSwitch .checkWrapNO .checkBoxValue").append("Not Active");
  }
});

function getUserAccountList() {
  var selected_account = $("#accounts").val();
  $.ajax({
    url: BASE_URL + "/profile/getUserAccountList",
    method: "POST",
    async: false,
    success: function (response) {
      try {
        response = JSON.parse(response);
      } catch (event) {
        // notifyme.showNotification('error', response);
      }
      if (response["status"] == "success") {
        var data = response["data"];

        if ($("#plan_users_list").length > 0) {
          $("#plan_users_list tbody").empty();
          data.map((d) => {
            d.broker = d.broker?d.broker:'';
            d.created_date = d.created_date?d.created_date:'';
            if (d.is_plan_update == "1") {
              const status = `<div class="togglebutton"><label><input class="switchBox" type="checkbox" ${
                d.is_active == "1" ? "checked" : ""
              } onclick="UpdateAccount(this,${
                d.account_id
              })" /><span class="toggle"></span><span class="checkBoxValue"></span></label></div>`;
              const remove = `<button type="button" class="btn btn-danger p-1 deleteAccount" onClick="delectAccount(${d.account_id})"><i class="ion-trash-a" style='font-size: 2.4em;
    padding: 5px;'></i></a></button>`;
              const gmt =
                d.BaseGMT != undefined
                  ? `<small style='color:gray;'>${d.BaseGMT}</small>`
                  : "";
              const account = `
              <tr style='width:100%;'>
                  <td style='border:0;width:14em; white-space:nowrap; font-size:.8em;'>${status}</td>
                  <td style='border:0;width:2em;'>${remove}</td>
              </tr>`;
              if (document.getElementById(`tr-${d.user_id}`)) {
                $(`#td-${d.user_id} table`).append(`${account}`);
              } else {
                $("#plan_users_list").append(`<tr id='tr-${d.user_id}'>
                    <td>${d.email}</td>
                    <td>${d.account_id}</td>
                    <td>${d.broker}</td>
                    <td>${d.created_date}</td>
                    <td>${d.price}</td>
                    <td>${d.end_date}</td>
                    <td id='td-${d.user_id}'>
                      <table style='width:100%;'>${account}</table>
                    </td>
                    </tr>`);
                // <td><div id='user-${d.user_id}' rel='${d.user_id}'>loading ${d.user_id}<script>loadUser('user-${d.user_id}');</script></div></td>
                $(".bootstrapSwitch .switchBox:checked")
                  .parent()
                  .addClass("checkWrap");
                $(".bootstrapSwitch .switchBox:not(:checked)")
                  .parent()
                  .addClass("checkWrapNO");
                $(".bootstrapSwitch .checkWrap .checkBoxValue").text("Active");
                $(".bootstrapSwitch .checkWrapNO .checkBoxValue").text(
                  "Not Active"
                );
                $("#selectAccountIds [value=0]:selected")
                  .parent()
                  .parent()
                  .parent()
                  .addClass("hideStatus");
              }
            } else {
              $("#plan_users_list tbody").append(
                `<tr><td>${d.account_id}</td><td>${
                  d.is_active == "1"
                    ? "<span class='badge badge-success as'>Active</span>"
                    : "<span class='badge badge-danger as'>InActive</span>"
                }</td><td><button type="button" class="btn btn-danger p-1 deleteAccount" id="${
                  d.account_id
                }" onClick="delectAccount(${
                  d.account_id
                })"><i class="ion-trash-a"></i></button></td></tr>`
              );
              $(".bootstrapSwitch .switchBox:checked")
                .parent()
                .addClass("checkWrap");
              $(".bootstrapSwitch .switchBox:not(:checked)")
                .parent()
                .addClass("checkWrapNO");
              $(".bootstrapSwitch .checkWrap .checkBoxValue").text("Active");
              $(".bootstrapSwitch .checkWrapNO .checkBoxValue").text(
                "Not Active"
              );
            }
          });
        }
      } else {
        //notifyme.showNotification(response["status"], response["message"]);
      }
    },
  });
}

function AddAccount() {
  if ($("#txtAccountId").val() == "") {
    notifyme.showNotification("error", "Please write account to add.");
    return false;
  }
  $.ajax({
    url: BASE_URL + "profile/addAccount",
    method: "POST",
    data: { account_id: $("#txtAccountId").val() },
    success: function (response) {
      response = JSON.parse(response);
      if (response["status"] == "success") {
        // notifyme.showNotification(response["status"], response["message"]);

        getUserAccountList();
      } else {
        // notifyme.showNotification(response["status"], response["message"]);z
      }
    },
  });
}

function UpdateAccount(Sender, AccountId) {
  var Status = $(Sender).is(":checked") ? "Activate" : "DeActivate";
  if (confirm("Are you sure you want to " + Status + " the account?")) {
    $.ajax({
      url: BASE_URL + "profile/updateAccountStatus",
      method: "POST",
      data: {
        account_id: AccountId,
        status: $(Sender).is(":checked"),
      },
      success: function (response) {
        response = JSON.parse(response);
        if (response["status"] == "success") {
          // notifyme.showNotification(response["status"], response["message"]);
        } else {
          // notifyme.showNotification(response["status"], response["message"]);
        }

        getUserAccountList();
      },
    });
  } else {
    if ($(Sender).is(":checked")) {
      $(Sender).prop("checked", false);
    } else {
      $(Sender).prop("checked", true);
    }
  }
}

function delectAccount(account_id) {
  if (confirm("Are you sure you want to delete this account?")) {
    $.ajax({
      url: BASE_URL + "profile/delectAccount",
      method: "POST",
      async: false,
      data: {
        account_id: account_id,
      },
      success: function (response) {
        response = JSON.parse(response);
        if (response["status"] == "success") {
          // notifyme.showNotification(response["status"], response["message"]);
        } else if (response["status"] == "error") {
          // notifyme.showNotification(response["status"], response["message"]);
        }
        getUserAccountList();
      },
    });
  }
}

function getUserInvoices(current_account_id) {
  var cDate = new Date();
  $("#plan_invoice_list").DataTable({
    language: {
      paginate: {
        next: "&#62;", // or '→'
        previous: "&#60;", // or '←'
      },
    },
    destroy: true,
    order: [[3, "desc"]],
    ajax: function (data, callback, settings) {
      $.ajax({
        url: BASE_URL + "profile/getUserInvoices",
        method: "POST",
        success: function (response) {
          response = JSON.parse(response);
          callback(response);
        },
      });
    },
    columns: [
      { data: "payment_reference_id" },
      {
        render: function (data, type, full, meta) {
          if (
            typeof full.invoice_date != "undefined" &&
            full.invoice_date != null
          ) {
            var invoice_date =
              full.invoice_date == "" ? "-" : full.invoice_date.split(" ")[0];
            return invoice_date;
          } else {
            return "-";
          }
        },
      },
      {
        //data: "invoice_date"
        render: function (data, type, full, meta) {
          return full.start_date.split(" ")[0];
        },
      },
      {
        data: "end_date",
      },
      { data: "amount" },
      {
        render: function (data, type, full, meta) {
          var payment_status =
            full.payment_reference_id == "" ? "Unpaid" : "Paid";
          return payment_status;
        },
      },
    ],
  });
}

$("#addaccount").click(function () {
  AddAccount();
});

$(document).ready(function () {
  getUserAccountList();
  getUserInvoices();
});