$(function() {
  $(".menuHidden").on("click", function() {
    $("#logOutButton").removeClass('menuHidden')
    $("#logOutButton").addClass('menuShown')
    $("#logOutMenu").slideDown(500);

  });
  $("#closeButton, .menuShown").on("click", function() {
    $("#logOutButton").removeClass('menuShown')
    $("#logOutButton").addClass('menuHidden')
    $("#logOutMenu").slideUp(500);

  });


  $( window ).resize(function() {
  if (window.innerWidth > 800) {
     $("#logOutMenu").slideUp(500);
  }
});


  });  // CAUTION leave this at the end of the script CAUTION
