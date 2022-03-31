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
      url: "controllers/charise_newOffenseController.php", // json datasource
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

if ($("#offenseTable").length > 0) {
  let offenseTable = $("#offenseTable").DataTable({
    lengthChange: false,
    searching: false,
    processing: true,
    ordering: false,
    serverSide: true,
    bInfo: false,
    ajax: {
      url: "controllers/charise_newOffenseController.php", // json datasource
      type: "POST", // method  , by default get
      data: { getOffense: true },
      error: function () {
        // error handling
      },
    },
    createdRow: function (data) {},
    columnDefs: [],
    fixedColumns: true,
    deferRender: true,
    scrollY: 500,
    scrollX: false,
    scroller: {
      loadingIndicator: true,
    },
    stateSave: false,
  });
}

$("#offenseForm").on("submit", function (e) {
  e.preventDefault();

  let employee = $("#employee").val();
  let category1 = $("#category1").val();
  let category2 = $("#category2").val();
  let firstOffense = $("input[name='firstOffense']:checked").val();
  let secondOffense = $("input[name='secondOffense']:checked").val();
  let thirdOffense = $("input[name='thirdOffense']:checked").val();
  let employeeName = $("#employee option:selected").text();

  if (employee == "") {
    Swal.fire({
      icon: "error",
      title: "Employee Field is Empty",
      text: "Please select an employee",
    });
  } else if (category2 == "") {
    Swal.fire({
      icon: "error",
      title: "Sub-Offense Field is Empty!",
      text: "Please select a sub-offense",
    });
  } else {
    $.ajax({
      url: "controllers/charise_newOffenseController.php",
      type: "POST",
      data: {
        addOffense: true,
        employee: employee,
        category1: category1,
        category2: category2,
        firstOffense: firstOffense,
        secondOffense: secondOffense,
        thirdOffense: thirdOffense,
      },
      success: function (response) {
        if (response == 1) {
          Swal.fire({
            icon: "success",
            title: "Offense Added",
            text: "Offense has been added to " + employeeName,
          }).then((result) => {
            location.reload();
          });
        } else if (response == 2) {
          Swal.fire({
            icon: "error",
            title: "Something went wrong!",
            text: "There is a problem with the server. Please try again later!",
          });
        }
      },
    });
  }
});
