$(function() {


// for the drop down log out settings
  $("#logOutButton").on("click", function() {
    //$("#logOutMenu").slideDown(500);
     $("#logOutMenu").show("slide", { direction: "right" }, 300);
  });

  $("#logOutCloseButton").on("click", function() {
    $("#logOutMenu").hide("slide", { direction: "right" }, 300);
  });


// for the drop down home menu
  $("#returnMenu").on("click", function() {
    $("#dropDownOptions").show("slide", { direction: "left" }, 300);
  });

  $("#homeCloseButton").on("click", function() {
    $("#dropDownOptions").hide("slide", { direction: "left" }, 300);
  });

//







  $( window ).resize(function() {
  if (window.innerWidth > 800) {
     $("#dropDownOptions").hide("slide", { direction: "left" }, 500);
  }
});
$( window ).resize(function() {
if (window.innerWidth > 800) {
   $("#logOutMenu").hide("slide", { direction: "right" }, 500);
}
});

$( window ).resize(function() {
if (window.innerWidth > 800) {
   $("#header").hide();
   $("#nav").show();
}
});
$( window ).resize(function() {
if (window.innerWidth < 800) {
   $("#header").show();
   $("#nav").hide();
}
});




  });  // CAUTION leave this at the end of the script CAUTION
