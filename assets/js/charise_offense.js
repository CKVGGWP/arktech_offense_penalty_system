$(document).ready(function () {
  $("#category1Group").addClass("d-none");
  $("#category2Group").addClass("d-none");
  $("#category3Group").addClass("d-none");
});

$("#employee").on("change", function () {
  $("#category1Group").removeClass("d-none");
});

$("#category1").on("change", function () {
  $("#category2").empty();
  $("#category3").empty();
  let id = $(this).val();
  $.ajax({
    url: "controllers/charise_newOffenseController.php",
    type: "POST",
    data: { categorySelect1: true, category1: id },
    dataType: "json",
    success: function (data) {
      $("#category2Group").removeClass("d-none");
      $("#category2").html(data);
      $("#category3Group").addClass("d-none");
    },
  });
});

$("#category2").on("change", function () {
  $("#category3").empty();
  let id = $(this).val();
  $.ajax({
    url: "controllers/charise_newOffenseController.php",
    type: "POST",
    data: { categorySelect2: true, category2: id },
    dataType: "json",
    success: function (data) {
      $("#category3Group").removeClass("d-none");
      $("#category3").html(data);
    },
  });
});

$("#employee").on("change", function () {
  let employee = $(this).val();

  $("#userTable").DataTable().clear().destroy();
  $("#userTable").DataTable().destroy();

  let dataTable = $("#userTable").DataTable({
    lengthChange: false,
    searching: false,
    processing: true,
    ordering: false,
    serverSide: true,
    bInfo: false,
    // Get the data from the controller
    ajax: {
      url: "controllers/val_notificationsController.php", // json datasource
      type: "POST", // method , by default get
      data: { employeeName: 1, employee: employee },
      error: function () {
        // error handling
      },
    },
    createdRow: function (row, data, index) {},
    columnDefs: [],
    fixedColumns: false,
    deferRender: true,
    scrollY: 500,
    scrollX: false,
    scroller: {
      loadingIndicator: true,
    },
    stateSave: false,
  });
});
