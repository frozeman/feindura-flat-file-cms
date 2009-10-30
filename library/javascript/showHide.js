// created by Fabian Vogelsteller [frozeman.de]
//
// Show/Hide
// showHide.js version 0.2

function showHide(show,hide) {  

  if(show != '') {
    // Checks if hide is an HTMl Element given with this
    if (show != undefined && show.style != undefined) {
      show.style.display = "block";
    } else if(typeof(show) == 'string') {
      if (document.getElementById) { // DOM3 = IE5, NS6
        document.getElementById(show).style.display = "block";
      } else {
        if (document.layers) { // Netscape 4
          document.show.display = "block";
        } else { // IE 4
          document.all.show.style.display = "block";
        }
      }
    }
  }

  if(hide != '') {
    // Checks if hide is an HTMl Element given with this
    if (hide != undefined && hide.style != undefined) {
      hide.style.display = "none";
    } else if(typeof(hide) == 'string'){
      if (document.getElementById) { // DOM3 = IE5, NS6
        document.getElementById(hide).style.display = "none";
      } else {
        if (document.layers) { // Netscape 4
          document.hide.display = "none";
        } else { // IE 4
          hide.style.display = "none";
        }
      }
    }
  }
}
