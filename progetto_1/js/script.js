const dataOdierna = new Date();
const dataOdiernaFormattata = dataOdierna.toISOString().slice(0, 10);
const inputDataAp = document.getElementById('IdDataAp');

if (inputDataAp != null) {
  inputDataAp.value = dataOdiernaFormattata;
}

function gestioneDataCh() {
  const checkbox = document.getElementById('IdAttiva');
  var inputDataCh = document.getElementById('IdDataCh');

  if (inputDataCh == null) {
    inputDataCh = document.getElementById('IdDataChMod');

    if (inputDataCh == null) {
      inputDataCh = document.getElementById('IdDataChRic');
    }
  }

  if (checkbox.checked) {
    inputDataCh.disabled = true;
    inputDataCh.value = null;
  } else {
    inputDataCh.disabled = false;
    inputDataCh.value = dataOdiernaFormattata;
  }
}

function aggiornaHTML() {
  const larghezzaSchermoCorrente = window.innerWidth;

  if (document.getElementById('IdCodCliente') != null && document.getElementById('IdCodCliente').tagName != "DATALIST") {
    const primaBr = document.getElementById('IdCodCliente');

    if (larghezzaSchermoCorrente < 960) {
      const brElementi = primaBr.nextElementSibling;

      if (!brElementi || brElementi.tagName !== 'BR' || brElementi.nextElementSibling.tagName !== 'BR') {
        primaBr.insertAdjacentHTML('afterend', '<br><br>');
      }
    } else {
      const brElemento1 = primaBr.nextElementSibling;
      const brElemento2 = brElemento1 && brElemento1.nextElementSibling;

      if (brElemento1 && brElemento1.tagName === 'BR' && brElemento2 && brElemento2.tagName === 'BR') {
        primaBr.parentNode.removeChild(brElemento1);
        primaBr.parentNode.removeChild(brElemento2);
      }
    }
  }
}

const checkbox = document.getElementById('IdAttiva');
if (checkbox != null) {
  checkbox.addEventListener('change', gestioneDataCh);
}

const larghezzaSchermoIniziale = window.innerWidth;
window.addEventListener('resize', aggiornaHTML);
aggiornaHTML();

function setEliminazione(codice) {
  document.getElementById('Err').style.display = 'block';

  const elimButton = document.getElementById('elimPuls');

  const handleElimination = function () {
    document.getElementById('Err').style.display = 'none';
    window.location.href = 'EliminaUtenza.php?Codice=' + codice;
  };

  elimButton.addEventListener('click', handleElimination);
}

document.addEventListener("DOMContentLoaded", function () {
  var form = document.getElementById("searchForm");
  var resetButton = document.getElementById("reset");

  resetButton.addEventListener("click", function () {

    var inputs = form.querySelectorAll('input[type="number"], input[type="date"], input[type="text"], input[type="checkbox"]');
    inputs.forEach(function (input) {
      input.value = "";
    });

    var checkboxes = form.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(function (checkbox) {
      checkbox.checked = false;
    });
  });
});

function sortTableUtenza(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTableUtenza");
  switching = true;
  dir = "asc";  //direzione sort

  while (switching) {
    switching = false;
    rows = table.rows;

    for (i = 1; i < (rows.length - 1); i++) {
      shouldSwitch = false;

      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];

      if (n == 0 || n == 7) {
        if (dir == "asc") {
          if (Number(x.innerHTML) > Number(y.innerHTML)) {
            shouldSwitch = true;
            break;
          }
        } else if (dir == "desc") {
          if (Number(x.innerHTML) < Number(y.innerHTML)) {
            shouldSwitch = true;
            break;
          }
        }
      } else {
        if (dir == "asc") {
          if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
            shouldSwitch = true;
            break;
          }
        } else if (dir == "desc") {
          if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
            shouldSwitch = true;
            break;
          }
        }
      }
    }

    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      switchcount++;
    } else {
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}

function sortTableCliente(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTableCliente");
  switching = true;
  //Set the sorting direction to ascending:
  dir = "asc";
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    //get rows of table
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/

      if (n == 0 || n == 5) {
        if (dir == "asc") {
          if (Number(x.innerHTML) > Number(y.innerHTML)) {
            //if so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
          }
        } else if (dir == "desc") {
          if (Number(x.innerHTML) < Number(y.innerHTML)) {
            //if so, mark as a switch and break the    loop:
            shouldSwitch = true;
            break;
          }
        }
      } else {
        if (dir == "asc") {
          if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
            //if so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
          }
        } else if (dir == "desc") {
          if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
            //if so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
          }
        }
      }


    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount++;
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}
function sortTableLettura(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTableLettura");
  switching = true;
  //Set the sorting direction to ascending:
  dir = "asc";
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    //get rows of table
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/

      if (n == 0 || n == 4) {
        if (dir == "asc") {
          if (Number(x.innerHTML) > Number(y.innerHTML)) {
            //if so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
          }
        } else if (dir == "desc") {
          if (Number(x.innerHTML) < Number(y.innerHTML)) {
            //if so, mark as a switch and break the    loop:
            shouldSwitch = true;
            break;
          }
        }
      } else {
        if (dir == "asc") {
          if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
            //if so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
          }
        } else if (dir == "desc") {
          if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
            //if so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
          }
        }
      }


    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount++;
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}

function sortTableFattura(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTableFattura");
  switching = true;
  //Set the sorting direction to ascending:
  dir = "asc";
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    //get rows of table
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/

      if (n != 1) {
        if (dir == "asc") {
          if (Number(x.innerHTML) > Number(y.innerHTML)) {
            //if so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
          }
        } else if (dir == "desc") {
          if (Number(x.innerHTML) < Number(y.innerHTML)) {
            //if so, mark as a switch and break the    loop:
            shouldSwitch = true;
            break;
          }
        }
      } else {
        if (dir == "asc") {
          if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
            //if so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
          }
        } else if (dir == "desc") {
          if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
            //if so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
          }
        }
      }


    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount++;
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}