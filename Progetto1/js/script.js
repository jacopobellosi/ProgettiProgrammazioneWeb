const dataOdierna = new Date();
const dataOdiernaFormattata = dataOdierna.toISOString().slice(0, 10);
const inputDataAp = document.getElementById('IdDataAp');
if (inputDataAp != null) {
  inputDataAp.value = dataOdiernaFormattata;
}

var inputDataCh = document.getElementById('IdDataCh');
if (inputDataCh != null) {
  inputDataCh.value = dataOdiernaFormattata;
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
  const primaBr = document.getElementById('IdCodCliente');

  if (larghezzaSchermoCorrente < 900) {
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

const checkbox = document.getElementById('IdAttiva');
checkbox.addEventListener('change', gestioneDataCh);

const larghezzaSchermoIniziale = window.innerWidth;
window.addEventListener('resize', aggiornaHTML);
aggiornaHTML();