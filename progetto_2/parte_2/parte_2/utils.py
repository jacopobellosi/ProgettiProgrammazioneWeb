# utils.py
from .models import Utenza, Cliente, Lettura, Fattura

def get_utenze(Codice='', DataAp='', Indirizzo='', Citta='', CodCliente='', Attiva=None, DataCh=''):
    utenze = Utenza.objects.all()

    if Codice:
        utenze = utenze.filter(Codice=Codice)
    if DataAp:
        utenze = utenze.filter(DataAp__icontains=DataAp)
    if Indirizzo:
        utenze = utenze.filter(Indirizzo__icontains=Indirizzo)
    if Citta:
        utenze = utenze.filter(Citta__icontains=Citta)
    if CodCliente:
        utenze = utenze.filter(CodCliente=CodCliente)
    if Attiva is not None:
        utenze = utenze.filter(Attiva=Attiva)
    if DataCh:
        utenze = utenze.filter(DataCh__icontains=DataCh)

    return utenze.order_by('Codice')

def get_cliente(Codice='', CF='', RagSoc='', Indirizzo='', citta=''):
    clienti = Cliente.objects.all()

    if Codice:
        clienti = clienti.filter(Codice=Codice)
    if CF:
        clienti = clienti.filter(CF=CF)
    if RagSoc:
        clienti = clienti.filter(RagSoc__icontains=RagSoc)
    if Indirizzo:
        clienti = clienti.filter(Indirizzo__icontains=Indirizzo)
    if citta:
        clienti = clienti.filter(Citta__icontains=citta)

    return clienti.order_by('Codice')

def get_lettura(Numero='', CodUtenza='', Data='', Valore='', NumFattura=''):
    letture = Lettura.objects.all()

    if Numero:
        letture = letture.filter(Numero=Numero)
    if Data:
        letture = letture.filter(Data__icontains=Data)
    if CodUtenza:
        letture = letture.filter(CodUtenza=CodUtenza)
    if Valore:
        letture = letture.filter(Valore=Valore)
    if NumFattura:
        letture = letture.filter(NumFattura=NumFattura)

    return letture.order_by('Numero')

def get_fattura(Numero='', Imponibile='', Data='', Iva='', Totale=''):
    fatture = Fattura.objects.all()

    if Numero:
        fatture = fatture.filter(Numero=Numero)
    if Data:
        fatture = fatture.filter(Data__icontains=Data)
    if Imponibile:
        fatture = fatture.filter(Imponibile=Imponibile)
    if Iva:
        fatture = fatture.filter(Iva=Iva)
    if Totale:
        fatture = fatture.filter(Totale=Totale)

    return fatture.order_by('Numero')

# utils.py continued
from django.urls import reverse

def riferimento_cliente(nome, CodCliente):
    if not CodCliente:
        return ""
    return f"<a href='{reverse('cliente_detail', args=[CodCliente])}'>{nome}</a>"

def riferimento_utenza(CodUtenza):
    if not CodUtenza:
        return ""
    return f"<a href='{reverse('utenza_detail', args=[CodUtenza])}'>{CodUtenza}</a>"

def riferimento_fattura(NumFattura):
    if not NumFattura:
        return ""
    return f"<a href='{reverse('fattura_detail', args=[NumFattura])}'>{NumFattura}</a>"

def modifica_utenza(Codice):
    if not Codice:
        return ""
    return f"<a href='{reverse('modifica_utenza', args=[Codice])}'><img src='/static/img/Modifica.png' alt='Modifica' class='icona'></a>"

def link_elimina_utenza(Codice):
    if not Codice:
        return ""
    return f"<a href='{reverse('elimina_utenza', args=[Codice])}'>Elimina</a>"

# utils.py continued
def set_utenze(Codice, DataAp, Indirizzo, Citta, CodCliente, Attiva, DataCh):
    utenza = Utenza.objects.get(Codice=Codice)
    utenza.DataAp = DataAp
    utenza.Indirizzo = Indirizzo
    utenza.Citta = Citta
    utenza.CodCliente = CodCliente
    utenza.Attiva = Attiva
    if DataCh != "NULL":
        utenza.DataCh = DataCh
    utenza.save()

def insert_utenze(DataAp, Indirizzo, Citta, CodCliente, Attiva, DataCh):
    utenza = Utenza(
        DataAp=DataAp,
        Indirizzo=Indirizzo,
        Citta=Citta,
        CodCliente=CodCliente,
        Attiva=Attiva,
        DataCh=DataCh if DataCh != "NULL" else None
    )
    utenza.save()
# utils.py continued
def controllo(Attiva, DataCh, DataAp):
    if Attiva == 1 and DataCh != "NULL":
        response = "NON E' POSSIBILE METTERE LA DATA DI CHIUSURA SE E' ANCORA ATTIVA"
        return False, response
    elif (Attiva == 0 and DataCh == "NULL") or (DataAp >= DataCh):
        response = "NECESSARIO INSERIRE DATI CORRETTI"
        return False, response
    else:
        return True, ""

def numero_utenza(Codice):
    return Utenza.objects.filter(CodCliente=Codice).count()

def riferimento_numero_utenze(numero, CodCliente):
    if not CodCliente:
        return ""
    return f"<a href='{reverse('utenza_list', args=[CodCliente])}'>{numero}</a>"

def numero_letture(Codice):
    return Lettura.objects.filter(CodUtenza=Codice).count()

def riferimento_numero_lettura(numero, CodUtenza):
    if not CodUtenza:
        return ""
    return f"<a href='{reverse('lettura_list', args=[CodUtenza])}'>{numero}</a>"

def numero_letture_da_fattura(Numero):
    return Lettura.objects.filter(NumFattura=Numero).count()

def riferimento_numero_lettura_da_fattura(numero, NumeroFattura):
    if not NumeroFattura:
        return ""
    return f"<a href='{reverse('lettura_list_by_fattura', args=[NumeroFattura])}'>{numero}</a>"

def nome_cliente(CodCliente):
    cliente = Cliente.objects.get(Codice=CodCliente)
    return cliente.RagSoc
