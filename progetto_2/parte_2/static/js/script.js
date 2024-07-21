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

const checkbox = document.getElementById('IdAttiva');
if (checkbox != null) {
  checkbox.addEventListener('change', gestioneDataCh);
}

function setEliminazione(codice) {
  document.getElementById('Err').style.display = 'block';

  const elimButton = document.getElementById('elimPuls');

  const handleElimination = function () {
    document.getElementById('Err').style.display = 'none';
    //window.location.href = "{% url 'elimina_utenza'  %}"+codice+"\\";
    window.location.replace("\elimina_utenza\\" + codice + "\\");
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

function controllo(cliente,codice_clienti,data_ap,data_ch,attiva){
  //alert("Ora cerchiamo se esiste il cliente");
  console.log("Ora cerchiamo se esiste il cliente "+codice_clienti+" "+cliente)
  var codice = codice_clienti.replace(/[\[\]\s]/g, '').split(",");
  var nome = cliente;
  var trovato=false;
  for(let i=0;i<codice.length;i++){
    console.log("Codice cliente: ["+codice[i]+"] Cliente: ["+cliente+"]");
    if(codice[i]==cliente){
      //console.log("Codice cliente esistente");
      //alert("Codice cliente esistente");
      trovato=true;
    }

  }
  if(trovato==false){
    alert("Codice cliente non esistente");
    return false;
  }
  //controllo le date e la loro validità
  var data_apertura = data_ap;
  var data_chiusura = data_ch;
  var attiva = attiva;
  //alert("Ora controllo le date "+attiva+" "+" "+data_apertura+" "+data_chiusura)
  if(attiva==0){
    if(data_apertura<=data_chiusura){
      //alert("Date perfette "+data_apertura+" "+data_chiusura)
      return true;
    }else{
      alert("Data di applicazione maggiore di quella di chiusura");
      return false;
    }
  }else{
    return true;
  }


  alert("Riconstrolla i dati inseriti");

  return false;
}
/*
jQuery(document).ready(function($) {
  $("#IdDataApMod").datepicker({
    minDate: 'dateToday',
    onSelect: function(date) {
      $("#IdDataChMod").datepicker('option', 'minDate', date);
    }
  });
  
  $("#IdDataChMod").datepicker();
});
*/