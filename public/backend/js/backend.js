$(function () {
  "use strict";

  const base_url =
    window.location.origin + "/" + window.location.pathname.split("/")[0] + "v2/";

  // function getYYYYMMDD(d0) {
  //   const d = new Date(d0);
  //   return new Date(d.getTime() - d.getTimezoneOffset() * 60 * 1000)
  //     .toISOString()
  //     .split("T")[0];
  // }

  function reset_from ()
  {
    $('.customer_name').val('');
    $('.customer_email').val('');
    $('.customer_phone').val('');
    $('.description').summernote('code', '');
  }

  $(document).on('click', '.new_customer',function(){
    $("#new_customer").modal("show");
    reset_from();
    $(".add_customer").removeClass('hidden');
    $(".edit_customer").addClass('hidden');
    $(".modal_title").html('Neue Kunde hinzufügen');
  });

  $(document).on('click', '.add_customer', function (e) {
    e.preventDefault();

    let customer_name = $(".customer_name").val();
    let customer_email = $(".customer_email").val();
    let customer_phone = $(".customer_phone").val();
    let description = $(".description").summernote('code');

    if(customer_name == '' && customer_email == '' && customer_phone == '')
    {
      Swal.fire({
        position: "top-end",
        icon: "warning",
        title: "Bos kayit ekleyemezsiniz!",
        showConfirmButton: true,
        timer: 5000,
        backdrop: `rgba(244,67,54,0.4) left top no-repeat`,
      });
      return;
    }

    $.ajax({
      type: "POST",
      url: base_url + "backend/customer/liste/add",
      data: { customer_name, customer_email, customer_phone, description },
      dataType: "json",

      success: function (res) {
        if (res.status === "is_added") {
          Swal.fire({
            position: "top-end",
            icon: "warning",
            title: "Bu müsteri zaten ekli!",
            showConfirmButton: true,
            timer: 5000,
            backdrop: `rgba(244,67,54,0.4) left top no-repeat`,
          });
          $('#new_customer').modal('hide');
        }

        Swal.fire({
          position: "top-end",
          icon: "success",
          title: "",
          showConfirmButton: false,
          timer: 1000,
          backdrop: `rgba(0,80,170,0.4) left top no-repeat`,
        });
        
        if (res.status == 200) {
          location.reload();
        }
      },
      complete: function (res) {},
      error: function (xhr, status, res) {},
    }); //end ajax

    return false;
  });

  $(document).on('click','.edit_customer', function () {
    let id = $(this).data("id");
    let customer_name = $(".customer_name").val();
    let customer_email = $(".customer_email").val();
    let customer_phone = $(".customer_phone").val();
    let description = $(".description").summernote('code');

    $.ajax({
      type: "POST",
      url: base_url + "backend/customer/liste/update",
      data: { id, customer_name, customer_email, customer_phone, description },
      dataType: "json",

      success: function (res) {
        console.log(res);
        if (res.status == 200) {
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Kayit güncellendi!",
            showConfirmButton: false,
            timer: 1000,
            backdrop: `rgba(0,80,170,0.4) left top no-repeat`,
          });

          location.reload();
        }
      },
      complete: function (res) {},
      error: function (xhr, status, res) {},
    }); //end ajax
  });

  $(document).on('click', '.get_data_customer', function () {
    let id = $(this).data("id");

    reset_from();
    $(".add_customer").addClass('hidden');
    $(".edit_customer").removeClass('hidden');

    $(".modal_title").html('Kunde Bearbeiten');

    $.ajax({
      type: "POST",
      url: base_url + "backend/customer/liste/get_data",
      data: { id },
      dataType: "json",

      success: function (res) {
        console.log(res);
        if (res.status == 200) {
          $("#new_customer").modal("show");
          $(".edit_customer").attr('data-id', res.get_data.id);
          $(".customer_name").val(res.get_data.customer_name);
          $(".customer_email").val(res.get_data.customer_email);
          $(".customer_phone").val(res.get_data.customer_phone);
          $(".description").summernote('code', res.get_data.description);
        }
      },
      complete: function (res) {},
      error: function (xhr, status, res) {},
    }); //end ajax
  });
  
  $(document).on('click', '.buchhaltungModal',function(){
    $("#buchhaltungModal").modal("show");
    $('.income').val('');
    $('.expense').val('');
    $('.comment').val('');
    $('.modal_date').text(new Date().toISOString().split('T')[0]);

    $(".add_buchhaltung").removeClass('hidden');
    $(".edit_buchhaltung").addClass('hidden');
  });

  $(document).on('change','.select_month', function () {
    let monthText = $(this).val();
    window.location = base_url + "backend/buchhaltung/liste/index/0/" + monthText;
  });
  
  $(document).on('change', '.select_day', function () {
    let dayText = $(this).val();
    window.location = base_url + "backend/buchhaltung/liste/index/" + dayText;
  });

  $(document).on('click','.get_data_buchhaltung', function () {
    let id = $(this).data("id");

    $(".add_buchhaltung").addClass('hidden');
    $(".edit_buchhaltung").removeClass('hidden');
    
    $.ajax({
      type: "POST",
      url: base_url + "backend/buchhaltung/liste/get_data",
      data: { id },
      dataType: "json",

      success: function (res) {
        console.log(res);
        if (res.status == 200) {
          $("#buchhaltungModal").modal("show");
          $(".edit_buchhaltung").attr('data-id', res.get_data.id);
          $(".income").val(res.get_data.income);
          $(".expense").val(res.get_data.expense);
          $(".comment").val(res.get_data.comment);
          $(".modal_date").text(res.get_data.date);
        }
      },
      complete: function (res) {},
      error: function (xhr, status, res) {},
    }); //end ajax
  });

  $(document).on('click','.add_buchhaltung', function (e) {
    e.preventDefault();

    let income = parseFloat($(".income").val()).toFixed(2);
    let expense = parseFloat($(".expense").val()).toFixed(2);
    let comment = $(".comment").val();

    if (income === "NaN" && expense === "NaN") {
      alert("Gelir ya da gider tutarini giriniz!");
      return false;
    }

    $.ajax({
      type: "POST",
      url: base_url + "backend/buchhaltung/liste/add",
      data: { income, expense, comment },
      dataType: "json",

      success: function (res) {
        if (res.status === "is_added") {
          Swal.fire({
            position: "top-end",
            icon: "warning",
            title: "Bugun zaten giriş yapmışsınız düzenlemek isterseniz listeden düzenleyiniz!",
            showConfirmButton: true,
            timer: 5000,
            backdrop: `rgba(244,67,54,0.4) left top no-repeat`,
          });
          $('#buchhaltungModal').modal('hide');
        }
        
        if (res.status == 200) {
          location.reload();
        }
      },
      complete: function (res) {},
      error: function (xhr, status, res) {},
    }); //end ajax

    return false;
  });

  $(document).on('click','.edit_buchhaltung', function (e) {
    e.preventDefault();

    let id = $(this).data("id");
    let income = parseFloat($(".income").val()).toFixed(2);
    let expense = parseFloat($(".expense").val()).toFixed(2);
    let comment = $(".comment").val();

    if (income === "NaN" && expense === "NaN") {
      alert("Gelir ya da gider tutarini giriniz!");
      return false;
    }

    $.ajax({
      type: "POST",
      url: base_url + "backend/buchhaltung/liste/update",
      data: { id, income, expense, comment },
      dataType: "json",

      success: function (res) {
        
        
        if (res.status == 200) {
          location.reload();
        }
      },
      complete: function (res) {},
      error: function (xhr, status, res) {},
    }); //end ajax

    return false;
  });

  $(".select_all_data").on("change", function () {
    if ($(this).prop("checked")) {
      $(".toogle_select_data").each(function () {
        $(this).prop("checked", true).trigger("change");
      });
    } else {
      $(".toogle_select_data").each(function () {
        $(this).prop("checked", false).trigger("change");
      });
    }
  });

  $(document).on("change", ".all_store", function () {
    let checkbox = $(this).data("all");

    if ($(this).is(":checked")) {
      $("." + checkbox + " > option").prop("selected", "selected");
      $("." + checkbox)
        .prop("checked", true)
        .trigger("change");
    } else {
      $("." + checkbox + " > option").removeAttr("selected");
      $("." + checkbox)
        .prop("checked", false)
        .trigger("change");
    }
  });

  $(document).on("change", "#discount_type", function () {
    let value = this.value;
    let percent = $("#percent");
    let percent_ = $("#percent_");
    let amount = $("#amount");
    let amount_ = $("#amount_");

    if (value === "fixed_cart") {
      percent_.attr({ style: "display:none" });
      percent.removeAttr("required");
      amount_.removeAttr("style");
      amount.attr("required", true);
    } else if (value === "percentage") {
      amount_.attr({ style: "display:none" });
      amount.removeAttr("required");
      percent_.removeAttr("style");
      percent.attr("required", true);
    } else {
      percent_.attr({ style: "display:none" });
      percent.removeAttr("required");
      amount_.removeAttr("style");
      amount.attr("required", true);
    }
  });

  $(".labelprint1").on("click", function (e) {
    e.preventDefault();

    //   let type = $(this).data('type');
    //   let csrf_fg = $("input[name=csrf_fg]").val();

    let data = "fuat";
    $.ajax({
      type: "POST",
      url: "http://localhost:8888/irisshot_new_shop/v3/backend/printer",
      data: { data: data },
      // dataType: "json",

      success: function (res) {},
      complete: function (res) {},
      error: function (xhr, status, res) {},
    }); //end ajax

    return false;
  });
});
