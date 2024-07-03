# Nel file views.py della tua app
from django.shortcuts import render

def home(request):
    return render(request, 'index.html')

def clienti(request):
    return render(request, 'Pagine/Cliente.html')

def utenze(request):
    return render(request, 'Pagine/Utenza.html')

def letture(request):
    return render(request, 'Pagine/Lettura.html')

def fatture(request):
    return render(request, 'Pagine/Fattura.html')
