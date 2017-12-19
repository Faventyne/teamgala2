$(function() {
  $(".menuHidden").on("click", function() {
    $("#logOutButton").removeClass('menuHidden')
    $("#logOutButton").addClass('menuShown')
    $("#logOutMenu").fadeIn(500);

  });
  $("#closeButton, .menuShown").on("click", function() {
    $("#logOutButton").removeClass('menuShown')
    $("#logOutButton").addClass('menuHidden')
    $("#logOutMenu").fadeOut(500);

  });

  });  // CAUTION leave this at the end of the script CAUTION
