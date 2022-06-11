$(function () {
  "use strict";

  //url formatla http://irispicture/
  const base_url =
    window.location.origin + "/" + window.location.pathname.split("/")[0] + "";

  $(document).on("change", ".is_printed", function (e) {
    e.preventDefault();

    let item_id = $(this).data("item-id");
    let type = $(this).data("type");
    let order_number = $("#f_u_order_number").text();
    let is_printed = $(this).prop('checked');
    
    

    $.ajax({
      type: "POST",
      url: base_url + "backend/ajax/shop/order/is_printed_item",
      data: { item_id, order_number, is_printed, type},
      dataType: "json",

      beforeSend: function (){
        $('.loadermodern').removeClass('hidden');
      },
      
      success: function (response) {
        if (response.status === "access_denied") {
          Swal.fire({
            position: "top-end",
            icon: "warning",
            title: "Access Denied!",
            showConfirmButton: true,
            timer: 2000,
            backdrop: `rgba(244,67,54,0.4) left top no-repeat`,
          });
          return;
        }
        if (response.status == 200) {
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "",
            showConfirmButton: false,
            timer: 1000,
            backdrop: `rgba(0,80,170,0.4) left top no-repeat`,
          });
          return;
        }
        
      },
      complete: function ()
      {
        $('.loadermodern').addClass('hidden');
      },
      error: function () {},
    });
  });

  $(document).on("click", ".delete_order_note", function (e) {
    e.preventDefault();

    let note_id = $(this).data("note-id");
    let order_number = $("#f_u_order_number").text();

    if (confirm("Are you sure you want to delete note")) {
      $.ajax({
        type: "POST",
        url: base_url + "backend/ajax/shop/order/delete_order_note",
        data: { note_id, order_number },
        dataType: "json",

        beforeSend: function (){
          $('.loadermodern').removeClass('hidden');
        },
        success: function (response) {
          if (response.status === "access_denied") {
            Swal.fire({
              position: "top-end",
              icon: "warning",
              title: "Access Denied!",
              showConfirmButton: true,
              timer: 2000,
              backdrop: `rgba(244,67,54,0.4) left top no-repeat`,
            });
            return;
          }
          $("#note_id_" + note_id).remove();
        },
        complete: function ()
        {
          $('.loadermodern').addClass('hidden');
        },
        error: function () {},
      });
    }
  });

  $(document).on("click", ".add_oder_note", function (e) {
    e.preventDefault();

    let note_id = $(this).data("note-id");
    let note = $(".order_note_text").val();
    let order_number = $("#f_u_order_number").text();

    $.ajax({
      type: "POST",
      url: base_url + "backend/ajax/shop/order/add_order_note",
      data: { order_number, note },
      dataType: "json",

      beforeSend: function (){
        $('.loadermodern').removeClass('hidden');
      },
      success: function (response) {
        if (response.status === "access_denied") {
          Swal.fire({
            position: "top-end",
            icon: "warning",
            title: "Access Denied!",
            showConfirmButton: true,
            timer: 2000,
            backdrop: `rgba(244,67,54,0.4) left top no-repeat`,
          });
          return;
        }

        $("#all_order_notes").append(
          '<div class="callout callout-info"> \
              <div class="box box-default"> \
                  <div class="box-header with-border"> \
                      <p>' +
            ' <span class="pull-right">' +
            response.user +
            " - " +
            response.date +
            '</span></p> \
                  </div> \
                  <div class="box-body text-black"> \
                      ' +
            note +
            " \
                  </div>\
              </div>\
          </div>"
        );

        $(".order_note_text").val("");
      },
      complete: function ()
      {
        $('.loadermodern').addClass('hidden');
      },
      error: function () {},
    });
  });

  $(document).on("click", ".photoshop_delete", function (e) {
    e.preventDefault();
    let image_id = $(this).data("id");

    if (confirm("Are you sure you want to delete image")) {
      $.ajax({
        type: "POST",
        url: base_url + "backend/ajax/shop/order/photoshop_delete",
        data: { image_id },
        dataType: "json",

        beforeSend: function (){
          $('.loadermodern').removeClass('hidden');
        },
        success: function (res) {
          if (res.status === "success") {
            $("#done_img_" + image_id).remove();
            return;
          }
          if (res.status === "access_denied") {
            Swal.fire({
              position: "top-end",
              icon: "warning",
              title: "Access Denied!",
              showConfirmButton: true,
              timer: 2000,
              backdrop: `rgba(244,67,54,0.4) left top no-repeat`,
            });
            return;
          }
        },
        complete: function ()
        {
          $('.loadermodern').addClass('hidden');
        },
        error: function () {},
      });
    }
  });

  $(document).on("click", "#photoshop_upload", function (e) {
    //f_u = for upload
    let order_number = $("#f_u_order_number").text();
    let land_name = $("#f_u_land_name").text();
    let store_name = $("#f_u_store_name").text();
    let store_id = $("#f_u_store_id").text();
    let date = $("#f_u_date").text();

    let form_data = new FormData();

    form_data.append("order_number", order_number);
    form_data.append("land_name", land_name);
    form_data.append("store_name", store_name);
    form_data.append("store_id", store_id);
    form_data.append("date", date);

    // Read selected files
    var totalfiles = document.getElementById("photos").files.length;
    for (var index = 0; index < totalfiles; index++) {
      form_data.append(
        "photos[]",
        document.getElementById("photos").files[index]
      );
    }

    $.ajax({
      url: base_url + "backend/ajax/shop/order/photoshop_upload",
      type: "POST",
      data: form_data,
      dataType: "json",
      contentType: false,
      processData: false,
      beforeSend: function (){
        $('.loadermodern').removeClass('hidden');
      },
      success: function (response) {
        if (response.status == 100) {
          Swal.fire({
            position: "top-end",
            icon: "warning",
            title: "The customer did not do a photo shoot.!",
            showConfirmButton: true,
            timer: 5000,
            backdrop: `rgba(244,67,54,0.4) left top no-repeat`,
          });
          return;
        }

        if (response.status === "access_denied") {
          Swal.fire({
            position: "top-end",
            icon: "warning",
            title: "Access Denied!",
            showConfirmButton: true,
            timer: 2000,
            backdrop: `rgba(244,67,54,0.4) left top no-repeat`,
          });
          return;
        }

        let colHTML = "";
        $.each(response.images, function (i, item) {
          colHTML +=
            '<div class="col-md-6"> \
        <div class="polaroid"> \
            <div class="relative_img"> \
            <a href="' +
            base_url +
            item.image +
            '" data-toggle="lightbox" data-gallery="for-printer-gallery">\
            <img class="img-responsive" width="100%" height="250" src="' +
            base_url +
            item.image +
            '"></a> \
                <div class="is_extra"> \
                    <small class="label bg-blue">Upload by ' +
            item.user +
            '</small> \
                </div> \
                <div class="is_selected"> \
                    <small class="label bg-yellow">' +
            item.date +
            "</small> \
                </div>\
            </div>\
            <span>" +
            item.image_name +
            "</span>\
        </div>\
    </div>";
          // $("#files").val("");
        });
        $("#uploaded_images").append(colHTML);
      },
      complete: function ()
      {
        $('.loadermodern').addClass('hidden');
      },
    });
  });

  //bu simdilik iptal sonra tekrar bak link verildi direkt indirme için
  $(".photoshop_download").on("click", function (e) {
    e.preventDefault();
    // let image_id = $(this).data("id");
    let paid = $("#f_u_paid").text();
    let order_number = $(this).data("order-number");

    if (paid !== "isPaid") {
      Swal.fire({
        position: "top-end",
        icon: "warning",
        title: "Payment has not been done. You cannot download photos!",
        showConfirmButton: true,
        timer: 5000,
        backdrop: `rgba(244,67,54,0.4) left top no-repeat`,
      });
      return;
    }

    window.location.href =
      base_url + "backend/ajax/download/order_images_download/" + order_number;
    return;

    $.ajax({
      type: "POST",
      url: base_url + "backend/ajax/download/order_image_donwload",
      data: { order_number },
      dataType: "json",

      success: function (res) {},
      error: function () {},
    });
  });

  $(document).on("click", ".quick_order_tbl_tr", function () {
    window.location = $(this).data("href");
  });

  // $(".order-search-input").focusout(function () {
  //   $(".order-search-bg").addClass("hide").fadeOut();
  // });

  $(".order-search-input").keyup(function (e) {
    let term = $(this).val();
    let order_search_bg = ".order-search-bg";

    if (term.length > 0) {
      $(order_search_bg).removeClass("hide").fadeIn();

      $.ajax({
        type: "POST",
        url: base_url + "backend/ajax/shop/order/quick_search",
        data: { term },
        dataType: "json",

        success: function (response) {
          if (response.status === "access_denied") {
            Swal.fire({
              position: "top-end",
              icon: "warning",
              title: "Access Denied!",
              showConfirmButton: true,
              timer: 2000,
              backdrop: `rgba(244,67,54,0.4) left top no-repeat`,
            });
            return;
          }

          $("#quick_search").text("");
          let trHTML = "";

          $.each(response, function (i, item) {
            trHTML +=
              '<tr class="quick_order_tbl_tr" data-href="' +
              base_url +
              "backend/shop/order/detail/" +
              item.order_id +
              "/" +
              item.order_number +
              '"><td>' +
              item.order_id +
              "</td><td>" +
              item.order_number +
              "</td><td>" +
              item.billing_firstname +
              "</td><td>" +
              item.billing_street +
              "</td><td>" +
              item.total +
              "</td><td>" +
              item.paid +
              "</td></tr>";
          });
          $("#quick_search").append(trHTML);
        },
        error: function () {},
      });
    } else {
      $(order_search_bg).addClass("hide").fadeOut();
    }
  });

  $(document).on("click", ".re_send_email", function (e) {
    e.preventDefault();

    let lang_code = $(this).parent().data("lang-code");
    let message_type = $(this).parent().data("message-type");
    let email = $(this).parent().data("email");
    let order_number = $(this).parent().data("order-number");

    if (confirm("Are you sure you want to send an e-mail?")) {
      $.ajax({
        type: "POST",
        url: base_url + "backend/ajax/shop/order/re_send_email",
        data: { lang_code,message_type,email,order_number },
        dataType: "json",

        beforeSend: function (){
          $('.loadermodern').removeClass('hidden');
        },
        success: function (res) {
          if (res.status === "access_denied") {
            Swal.fire({
              position: "top-end",
              icon: "warning",
              title: "Access Denied!",
              showConfirmButton: true,
              timer: 2000,
              backdrop: `rgba(244,67,54,0.4) left top no-repeat`,
            });
            return;
          }

          if (res.status == 200) {
            Swal.fire({
              position: "top-end",
              icon: "success",
              title: "Email has been sent again!",
              showConfirmButton: false,
              timer: 1500,
              backdrop: `rgba(0,80,170,0.4) left top no-repeat`,
            });
          }
        },
        complete: function ()
        {
          $('.loadermodern').addClass('hidden');
        },
        error: function () {},
      });
    }
  });

  $(".status_process").on("click", function (e) {
    e.preventDefault();

    let status_process = $(this).data("status-process");
    let order_number = $(this).parent().data("order-number");

    if (confirm("Are you sure you want to mark it as .....?")) {
      $.ajax({
        type: "POST",
        url: base_url + "backend/ajax/shop/order/status_process ",
        data: { order_number, status_process },
        dataType: "json",

        beforeSend: function (){
          $('.loadermodern').removeClass('hidden');
        },
        success: function (res) {
          if (res.status === "access_denied") {
            Swal.fire({
              position: "top-end",
              icon: "warning",
              title: "Access Denied!",
              showConfirmButton: true,
              timer: 2000,
              backdrop: `rgba(244,67,54,0.4) left top no-repeat`,
            });
            return;
          }

          if (res.status == 200) {
            window.location.reload();
          }
        },
        complete: function ()
        {
          $('.loadermodern').addClass('hidden');
        },
        error: function () {},
      });
    }
  });

  $(".confirm_paid,.confirm_paid_update").on("click", function (e) {
    e.preventDefault();
    // $("#confirm_paid").modal("show");

    let paid = $(this).data("paid");
    let amount = $(this).data("amount");
    let order_number = $(this).data("order-number");

    // if (amount < 1) {
    //   alert("Amounts have to be big 0.00!");
    //   return;
    // }

    if (confirm("Are you sure you want to mark it as paid?")) {
      $.ajax({
        type: "POST",
        url: base_url + "backend/ajax/shop/order/process_paid",
        data: { order_number, paid, amount },
        dataType: "json",

        beforeSend: function (){
          $('.loadermodern').removeClass('hidden');
        },
        success: function (res) {
          if (res.status === "access_denied") {
            Swal.fire({
              position: "top-end",
              icon: "warning",
              title: "Access Denied!",
              showConfirmButton: true,
              timer: 2000,
              backdrop: `rgba(244,67,54,0.4) left top no-repeat`,
            });
            return;
          }
          if (res.status == 100) {
            Swal.fire({
              position: "top-end",
              icon: "warning",
              title: "status already paid",
              showConfirmButton: true,
              timer: 2000,
              backdrop: `rgba(244,67,54,0.4) left top no-repeat`,
            });
            return;
          }
          if (res.status == 101) {
            Swal.fire({
              position: "top-end",
              icon: "warning",
              title: "status already paid_update",
              showConfirmButton: true,
              timer: 2000,
              backdrop: `rgba(244,67,54,0.4) left top no-repeat`,
            });
            return;
          }

          if (res.status == 200) {
            window.location.reload();
          }
        },
        complete: function ()
        {
          $('.loadermodern').addClass('hidden');
        },
        error: function () {},
      });
    }
  });

  $(".delete_allow_product").on("click", function (e) {
    e.preventDefault();
    let product_id = $(this).data("product-id");
    let product_allow = $(this).data("product-allow");
    let unique_row_id = $(this).data("row-id");

    $.ajax({
      type: "POST",
      url: "../delete_allow_product",
      data: { product_id, product_allow },

      beforeSend: function (){
        $('.loadermodern').removeClass('hidden');
      },
      success: function (res) {
        $("." + unique_row_id).remove();
      },
      complete: function ()
      {
        $('.loadermodern').addClass('hidden');
      },
      error: function () {},
    });
  });

  $(".ajax_request").on("click", function (e) {
    e.preventDefault();

    let button = $(e.target);
    let form_data = button.parents("form").serialize();
    let form_url = button.parents("form").attr("action");
    let form_name = button.parents("form").attr("name");

    let button_id = button.attr("id");

    $.ajax({
      type: "POST",
      url: form_url,
      data: form_data,
      dataType: "json",
      beforeSend: function (xhr, settings) {
        settings.data += "&" + form_name + "=" + form_name;
      },
      success: function (res) {
        //ajax post redirect url
        if (res[0].url !== undefined) {
          window.location.href = res[0].url;
          return false;
        }

        let new_csrf_code = res[0].csrf_fg;

        $('input[name="csrf_fg"]').val(new_csrf_code);
      },
      complete: function (res) {
        //sweetalert start
        Swal.fire({
          position: "top-end",
          icon: "success",
          title: res.responseJSON[0].responseMessage,
          showConfirmButton: false,
          timer: 1500,
          backdrop: `rgba(0,80,170,0.4) left top no-repeat`,
        });
        //sweetalert end
      },
      error: function (xhr, status, res) {
        Swal.fire({
          position: "top-end",
          icon: "error",
          title: "error",
          showConfirmButton: false,
          timer: 1500,
          backdrop: `rgba(244,67,54,0.4) left top no-repeat`,
        });
      },
    }); //end ajax

    return false;
  });

  $(".ajax_request_row").on("click", function (e) {
    e.preventDefault();
    alert();
    return;

    let button = $(e.target);
    let form_data = button.parents("form").serialize();
    let form_url = button.parents("form").attr("action");

    let form_name = button.parents("form").attr("name");

    $.ajax({
      type: "POST",
      url: form_url,
      data: form_data,
      dataType: "json",
      beforeSend: function (xhr, settings) {
        settings.data += "&" + form_name + "=" + form_name;
      },
      success: function (res) {
        //ajax post redirect url
        if (res[0].url !== undefined) {
          window.location.href = res[0].url;
          return false;
        }

        let new_csrf_code = res[0].csrf_fg;

        $('input[name="csrf_fg"]').val(new_csrf_code);
      },
      complete: function (res) {
        //sweetalert start
        Swal.fire({
          position: "top-end",
          icon: "success",
          title: res.responseJSON[0].responseMessage,
          showConfirmButton: false,
          timer: 1500,
          backdrop: `rgba(0,80,170,0.4) left top no-repeat`,
        });
        //sweetalert end
      },
      error: function (xhr, status, res) {
        Swal.fire({
          position: "top-end",
          icon: "error",
          title: "error",
          showConfirmButton: false,
          timer: 1500,
          backdrop: `rgba(244,67,54,0.4) left top no-repeat`,
        });
      },
    }); //end ajax

    return false;
  });

  /*

  $(".ajax_request").on("click", function (e) {
    e.preventDefault();

    let button = $(e.target);
    let form_data = button.parents("form").serialize();
    let form_url = button.parents("form").attr("action");
    let form_name = button.parents("form").attr("name");

    let button_id = button.attr("id");

    $.ajax({
      type: "POST",
      url: form_url,
      data: form_data,
      dataType: "json",
      beforeSend: function (xhr, settings) {
        settings.data += "&" + form_name + "=" + form_name;
      },
      success: function (res) {
        //ajax post redirect url
        if (res[0].url !== undefined) {
          window.location.href = res[0].url;
          return false;
        }

        let new_csrf_code = res[0].csrf_fg;

        $('input[name="csrf_fg"]').val(new_csrf_code);
      },
      complete: function (res) {
        //sweetalert start
        Swal.fire({
          position: "top-end",
          icon: "success",
          title: res.responseJSON[0].responseMessage,
          showConfirmButton: false,
          timer: 1500,
          backdrop: `rgba(0,80,170,0.4) left top no-repeat`,
        });
        //sweetalert end
      },
      error: function (xhr, status, res) {
        Swal.fire({
          position: "top-end",
          icon: "error",
          title: "error",
          showConfirmButton: false,
          timer: 1500,
          backdrop: `rgba(244,67,54,0.4) left top no-repeat`,
        });
      },
    }); //end ajax

    return false;
  });

  $(".ajax_request_row").on("click", function (e) {
    e.preventDefault();
    alert();
    return;

    let button = $(e.target);
    let form_data = button.parents("form").serialize();
    let form_url = button.parents("form").attr("action");

    let form_name = button.parents("form").attr("name");

    $.ajax({
      type: "POST",
      url: form_url,
      data: form_data,
      dataType: "json",
      beforeSend: function (xhr, settings) {
        settings.data += "&" + form_name + "=" + form_name;
      },
      success: function (res) {
        //ajax post redirect url
        if (res[0].url !== undefined) {
          window.location.href = res[0].url;
          return false;
        }

        let new_csrf_code = res[0].csrf_fg;

        $('input[name="csrf_fg"]').val(new_csrf_code);
      },
      complete: function (res) {
        //sweetalert start
        Swal.fire({
          position: "top-end",
          icon: "success",
          title: res.responseJSON[0].responseMessage,
          showConfirmButton: false,
          timer: 1500,
          backdrop: `rgba(0,80,170,0.4) left top no-repeat`,
        });
        //sweetalert end
      },
      error: function (xhr, status, res) {
        Swal.fire({
          position: "top-end",
          icon: "error",
          title: "error",
          showConfirmButton: false,
          timer: 1500,
          backdrop: `rgba(244,67,54,0.4) left top no-repeat`,
        });
      },
    }); //end ajax

    return false;
  });
  */
});
