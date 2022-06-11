(function ($) {
  "use strict";

    //url formatla http://fuatgormez.de/
    const base_url = window.location.origin + "/" + window.location.pathname.split("/")[0] + "";

  $(document).on("click", ".getPage", function (e) {
    e.preventDefault();
    var getPage = $(this).data("page");

    $("#largeModal").modal("show");

    // Ajax Submit
    $.ajax({
        type: "POST",
        url: base_url + getPage,
        dataType: "json",
  
        beforeSend: function () {},
        success: function (res) {
            console.log(res);
            $("#largeModal #largeModalLabel").html(res.head);
            $("#largeModal .modal-body").html(res.content);
        },
        complete: function (res) {},
        error: function (xhr, status, res) {},
      }); //end ajax
   
  });
}.apply(this, [jQuery]));
