$(document).ready(function () {
  $("#category2Group").addClass("d-none");
  $("#category3Group").addClass("d-none");
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

// MODIFY END
