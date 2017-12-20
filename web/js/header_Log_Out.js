$(function() {


// for the drop down log out settings
  $("#logOutButton").on("click", function() {
    //$("#logOutMenu").slideDown(500);
     $("#logOutMenu").show("slide", { direction: "right" }, 1000);
  });

  $("#logOutCloseButton").on("click", function() {
    $("#logOutMenu").hide("slide", { direction: "right" }, 1000);
  });


// for the drop down home menu
  $("#returnMenu").on("click", function() {
    $("#dropDownOptions").show("slide", { direction: "left" }, 500);
  });

  $("#homeCloseButton").on("click", function() {
    $("#dropDownOptions").hide("slide", { direction: "left" }, 500);
  });

//







  $( window ).resize(function() {
  if (window.innerWidth > 800) {
     $("#dropDownOptions").hide("slide", { direction: "left" }, 500);
  }
});


  });  // CAUTION leave this at the end of the script CAUTION
