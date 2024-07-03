from django.shortcuts import render, redirect, get_object_or_404
from django.db import connection
from django.views.decorators.csrf import csrf_exempt
from datetime import datetime
from .models import Cliente, Utenza, Lettura, Fattura

# Home view
def home(request):
    return render(request, 'index.html')

# Cliente views
def clienti(request):
    return render(request, 'Pagine/Cliente.html')

# Utenza views
def utenza(request):
    return render(request, 'utenza.html')

def letture(request):
    return render(request, 'Pagine/Lettura.html')

def fatture(request):
    return render(request, 'Pagine/Fattura.html')

# View per visualizzare le utenze con filtro e numero letture
@csrf_exempt
def utenza_view(request):
    Codice = request.POST.get("Codice", "") if request.method == 'POST' else request.GET.get("Codice", "")
    DataAp = request.POST.get("DataAp", "") if request.method == 'POST' else request.GET.get("DataAp", "")
    Indirizzo = request.POST.get("Indirizzo", "")
    Citta = request.POST.get("Citta", "")
    CodCliente = request.POST.get("CodCliente", "") 
    Attiva = 1 if request.POST.get("Attiva") else None
    DataCh = request.POST.get("DataCh", "")

    error = ""
    results = []

    query = """
    SELECT * FROM utenza WHERE 1=1
    """

    params = []

    if Codice:
        query += " AND Codice = %s"
        params.append(Codice)

    if DataAp:
        query += " AND DataAp = %s"
        params.append(DataAp)

    if Indirizzo:
        query += " AND Indirizzo LIKE %s"
        params.append(f'%{Indirizzo}%')

    if Citta:
        query += " AND Citta LIKE %s"
        params.append(f'%{Citta}%')

    if CodCliente:
        query += " AND CodCliente = %s"
        params.append(CodCliente)

    if Attiva is not None:
        query += " AND Attiva = %s"
        params.append(Attiva)

    if DataCh:
        query += " AND DataCh = %s"
        params.append(DataCh)

    query += " ORDER BY Codice"
    print("prova")
    print("query", query, params)

    try:
        with connection.cursor() as cursor:
            cursor.execute(query, params)
            columns = [col[0] for col in cursor.description]
            results = [dict(zip(columns, row)) for row in cursor.fetchall()]
    except Exception as e:
        error = str(e)

    for result in results:
        query = "SELECT COUNT(*) as Numero FROM lettura WHERE CodUtenza = %s"
        try:
            with connection.cursor() as cursor:
                cursor.execute(query, [result['Codice']])
                result['Numero_letture'] = cursor.fetchone()[0]
        except Exception as e:
            error = str(e)

        result['DataAp'] = result['DataAp'].strftime('%Y-%m-%d')
        if result['DataCh']:
            result['DataCh'] = result['DataCh'].strftime('%Y-%m-%d')
        #print(result)

        query = "SELECT RagSoc FROM cliente WHERE Codice = %s"
        params = [result['CodCliente']]
        try:
            with connection.cursor() as cursor:
                cursor.execute(query, [result['CodCliente']])
                result['RagSoc'] = cursor.fetchone()[0]
        except Exception as e:
            error = str(e)

    print(result)
    context = {
        'Codice': Codice,
        'DataAp': DataAp,
        'Indirizzo': Indirizzo,
        'Città': Citta,
        'CodCliente': CodCliente,
        'Attiva': Attiva,
        'DataCh': DataCh,
        'result': results,
        'error': error,
    }
    return render(request, 'utenza.html', context)

def utenza_detail(request, cod_utenza):
    #utenza = get_object_or_404(Utenza, Codice=cod_utenza)
    print("test")

    return render(request, 'utenza.html', {'Codice': cod_utenza})

def mostra_utenza(request, codice):
    query = "SELECT * FROM utenza WHERE Codice = %s"
    try:
        with connection.cursor() as cursor:
            cursor.execute(query, [codice])
            columns = [col[0] for col in cursor.description]
            results = [dict(zip(columns, row)) for row in cursor.fetchall()]
    except Exception as e:
        error = str(e)

    context = {
        'Codice': codice,
        'result': results[0],
        'error': error,
    }

    return render(request, 'utenza.html', context)

# View per modificare un'utenza
@csrf_exempt
def modifica_utenza(request, codice):
    error = None
    context = {}
    results={}
    if request.method == 'POST':
        data_ap = request.POST.get('DataAp', '')
        indirizzo = request.POST.get('Indirizzo', '')
        citta = request.POST.get('Citta', '')
        cod_cliente = request.POST.get('CodCliente', '')
        attiva = 'Attiva' in request.POST
        data_ch = request.POST.get('DataCh', '') if not attiva else None

        try:
            data_ap_dt = datetime.strptime(data_ap, '%Y-%m-%d') if data_ap else None
            data_ch_dt = datetime.strptime(data_ch, '%Y-%m-%d') if data_ch else None
        except ValueError:
            error = "Formato data non valido"
            data_ap_dt = None
            data_ch_dt = None

        is_valid = controllo(attiva, data_ch_dt, data_ap_dt)

        if is_valid:
            query = """
                UPDATE utenza SET DataAp = %s, Indirizzo = %s, Città = %s, CodCliente = %s, Attiva = %s, DataCh = %s 
                WHERE Codice = %s
            """
            params = (data_ap, indirizzo, citta, cod_cliente, attiva, data_ch, codice)
            try:
                with connection.cursor() as cursor:
                    cursor.execute(query, params)
            except Exception as e:
                error = str(e)

            return redirect('utenza')
        else:
            error = "Errore nei dati inseriti"

    else:
        query = "SELECT * FROM utenza WHERE Codice = %s"
        try:
            with connection.cursor() as cursor:
                cursor.execute(query, [codice])
                columns = [col[0] for col in cursor.description]
                results = [dict(zip(columns, row)) for row in cursor.fetchall()]
        except Exception as e:
            error = str(e)

        clienti_codici = []
        query = "SELECT Codice, RagSoc FROM cliente"
        try:
            with connection.cursor() as cursor:
                cursor.execute(query)
                clienti_codici = [row[0] for row in cursor.fetchall()]
        except Exception as e:
            error = str(e)

        result = results[0] if results else {}
        result['DataAp'] = result['DataAp'].strftime('%Y-%m-%d')
        if result.get('DataCh'):
            result['DataCh'] = result['DataCh'].strftime('%Y-%m-%d')

        context = {
            'Codice': codice,
            'result': result,
            'Indirizzo': result.get('Indirizzo'),
            'Citta': result.get('Città'),
            'CodCliente': result.get('CodCliente'),
            'Attiva': result.get('Attiva'),
            'DataCh': result.get('DataCh'),
            'DataAp': result.get('DataAp'),
            'Clienti': clienti_codici,
            'id_cliente': clienti_codici,
            'error': error,
        }
    print(result)
    return render(request, 'modifica_utenza.html', context)


# View per aggiungere una nuova utenza
@csrf_exempt
def aggiungi_utenza(request):
    error = None
    clienti_codici = []

    if request.method == 'POST':
        data_ap = request.POST.get('DataAp', '')
        indirizzo = request.POST.get('Indirizzo', '')
        citta = request.POST.get('Citta', '')
        cod_cliente = request.POST.get('CodCliente', '')
        attiva = 'Attiva' in request.POST
        data_ch = request.POST.get('DataCh', '') if not attiva else None

        try:
            data_ap_dt = datetime.strptime(data_ap, '%Y-%m-%d') if data_ap else None
            data_ch_dt = datetime.strptime(data_ch, '%Y-%m-%d') if data_ch else None
        except ValueError:
            error = "Formato data non valido"
            print(error)
            data_ap_dt = None
            data_ch_dt = None

        is_valid = controllo(attiva, data_ch_dt, data_ap_dt)

        if is_valid:
            query = """
                INSERT INTO utenza (DataAp, Indirizzo, Città, CodCliente, Attiva, DataCh) 
                VALUES (%s, %s, %s, %s, %s, %s)
            """
            params = (data_ap, indirizzo, citta, cod_cliente, attiva, data_ch)
            try:
                with connection.cursor() as cursor:
                    cursor.execute(query, params)
            except Exception as e:
                error = str(e)
                print("Errore! "+error)
            
            print("Utente inserito correttamente, con questi valori",params)
            return redirect('utenza')
        else:
            error = "Errore nei dati inseriti"
            print(error)
            #return("modifica_utenza")
            #return render(request, 'modifica_utenza.html', context)
    else:
        query = "SELECT Codice, RagSoc FROM cliente"
        try:
            with connection.cursor() as cursor:
                cursor.execute(query)
                clienti_codici = [row[0] for row in cursor.fetchall()]
        except Exception as e:
            error = str(e)

    context = {
        'utenza': None,
        'clienti': Cliente.objects.all(),
        'error': error,
        'id_cliente': clienti_codici,
    }

    return render(request, 'modifica_utenza.html', context)

# Controllo dati utenza
def controllo(attiva, data_ch, data_ap):
    if attiva and data_ch:
        print("c'è la data ma è attivo")
        return False
    if not attiva and not data_ch:
        print("non è attivo e non c'è la data")
        return False
    if data_ap and data_ch and data_ap > data_ch:
        print("La data di chiusura è antecedente a quella d'inserimento")
        return False
    return True

# View per eliminare un'utenza
def elimina_utenza(request, codice):
    query = "DELETE FROM utenza WHERE Codice = %s"
    try:
        with connection.cursor() as cursor:
            cursor.execute(query, [codice])
    except Exception as e:
        error = str(e)
        return redirect('utenza', {'error': error})

    return redirect('utenza')

# Lettura views
def get_lettura(numero, codutenza, data, valore, numfattura):
    query = "SELECT * FROM lettura WHERE 1=1"
    params = []

    if numero:
        query += " AND Numero = %s"
        params.append(numero)
    if codutenza:
        query += " AND CodUtenza = %s"
        params.append(codutenza)
    if data:
        query += " AND Data = %s"
        params.append(data)
    if valore:
        query += " AND Valore = %s"
        params.append(valore)
    if numfattura:
        query += " AND NumFattura = %s"
        params.append(numfattura)

    return query, params

@csrf_exempt
def lettura_view(request):
    numero = request.POST.get("Numero", "") 
    codutenza = request.POST.get("CodUtenza", "") if request.method == 'POST' else request.GET.get("CodUtenza", "")
    data = request.POST.get("Data", "")
    valore = request.POST.get("Valore", "")
    numfattura = request.POST.get("NumFattura", "") if request.method == 'POST' else request.GET.get("NumFattura", "")

    query, params = get_lettura(numero, codutenza, data, valore, numfattura)
    results = []
    error = ""

    try:
        with connection.cursor() as cursor:
            cursor.execute(query, params)
            columns = [col[0] for col in cursor.description]
            results = [dict(zip(columns, row)) for row in cursor.fetchall()]
    except Exception as e:
        error = str(e)

    for result in results:
        result['Data'] = result['Data'].strftime('%Y-%m-%d')

    context = {
        'Numero': numero,
        'CodUtenza': codutenza,
        'Data': data,
        'Valore': valore,
        'NumFattura': numfattura,
        'results': results,
        'error': error,
    }

    return render(request, 'lettura.html', context)

from django.shortcuts import render
from django.db import connection
from django.views.decorators.csrf import csrf_exempt

@csrf_exempt
def clienti(request):
    Codice = request.POST.get("Codice", "") if request.method == 'POST' else request.GET.get("Codice", "")
    CF = request.POST.get("CF", "") if request.method == 'POST' else request.GET.get("CF", "")
    RagSoc = request.POST.get("RagSoc", "") if request.method == 'POST' else request.GET.get("RagSoc", "")
    Indirizzo = request.POST.get("Indirizzo", "")
    Citta = request.POST.get("Citta", "")
    error = None
    results = []

    query = getCliente(Codice, CF, RagSoc, Indirizzo, Citta)
    try:
        with connection.cursor() as cursor:
            cursor.execute(query)
            columns = [col[0] for col in cursor.description]
            results = [dict(zip(columns, row)) for row in cursor.fetchall()]
    except Exception as e:
            error = str(e)

    for result in results:
        query = "SELECT COUNT(*) as NumeroUtenze FROM utenza WHERE CodCliente = %s"
        try:
            with connection.cursor() as cursor:
                cursor.execute(query, [result['Codice']])
                result['NumeroUtenze'] = cursor.fetchone()[0]
        except Exception as e:
            error = str(e)

    context = {
        'Codice': Codice,
        'CF': CF,
        'RagSoc': RagSoc,
        'Indirizzo': Indirizzo,
        'Citta': Citta,
        'results': results,
        'error': error,
    }
    print(query)
    print(results)
    return render(request, 'cliente.html', context)

def getCliente(Codice, CF, RagSoc, Indirizzo, Citta):
    query = """
    SELECT Codice, CF, RagSoc, Indirizzo, Citta FROM cliente WHERE 1=1
    """
    if Codice:
        query += f" AND Codice = {Codice}"
    if CF:
        query += f" AND CF LIKE '%{CF}%'"
    if RagSoc:
        query += f" AND RagSoc LIKE '%{RagSoc}%'"
    if Indirizzo:
        query += f" AND Indirizzo LIKE '%{Indirizzo}%'"
    if Citta:
        query += f" AND Citta LIKE '%{Citta}%'"
    return query


from django.shortcuts import render
from django.db import connection
from django.views.decorators.csrf import csrf_exempt

@csrf_exempt
def fatture(request):
    Numero = request.POST.get("Numero", "") if request.method == 'POST' else request.GET.get("Numero", "")
    Data = request.POST.get("Data", "")
    Imponibile = request.POST.get("Imponibile", "")
    Iva = request.POST.get("Iva", "")
    Totale = request.POST.get("Totale", "")
    error = None
    results = []

    query = getFattura(Numero, Imponibile, Data, Iva, Totale)
    try:
        with connection.cursor() as cursor:
            cursor.execute(query)
            columns = [col[0] for col in cursor.description]
            results = [dict(zip(columns, row)) for row in cursor.fetchall()]
    except Exception as e:
        error = str(e)

    for result in results:
        query = "SELECT COUNT(*) as NumeroLetture FROM lettura WHERE NumFattura = %s"
        try:
            with connection.cursor() as cursor:
                cursor.execute(query, [result['Numero']])
                result['NumeroLetture'] = cursor.fetchone()[0]
        except Exception as e:
            error = str(e)

    context = {
        'Numero': Numero,
        'Data': Data,
        'Imponibile': Imponibile,
        'Iva': Iva,
        'Totale': Totale,
        'results': results,
        'error': error,
    }
    return render(request, 'fattura.html', context)

def getFattura(Numero, Imponibile, Data, Iva, Totale):
    query = """
    SELECT Numero, Data, Imponibile, Iva, Totale FROM fattura WHERE 1=1
    """
    if Numero:
        query += f" AND Numero = {Numero}"
    if Data:
        query += f" AND Data = '{Data}'"
    if Imponibile:
        query += f" AND Imponibile = {Imponibile}"
    if Iva:
        query += f" AND Iva = {Iva}"
    if Totale:
        query += f" AND Totale = {Totale}"
    return query
