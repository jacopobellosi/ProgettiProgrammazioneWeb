const dataOdierna = new Date();
const dataOdiernaFormattata = dataOdierna.toISOString().slice(0, 10);
const inputDataAp = document.getElementById('IdDataAp');
inputDataAp.value = dataOdiernaFormattata;

const inputDataCh = document.getElementById('IdDataCh');
inputDataCh.value = dataOdiernaFormattata;



function gestioneDataCh() {
  const checkbox = document.getElementById('IdAttiva');
  const dataChInput = document.getElementById('IdDataCh');

  if (checkbox.checked) {
    dataChInput.disabled = true;
  } else {
    dataChInput.disabled = false;
  }
}

const checkbox = document.getElementById('IdAttiva');
checkbox.addEventListener('change', gestioneDataCh);
