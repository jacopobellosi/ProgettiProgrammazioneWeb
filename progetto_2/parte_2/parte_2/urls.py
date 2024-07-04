"""
URL configuration for parte_2 project.

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/5.0/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  path('', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  path('', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.urls import include, path
    2. Add a URL to urlpatterns:  path('blog/', include('blog.urls'))
"""
from django.contrib import admin
from django.urls import path
from . import views

urlpatterns = [
    path('', views.home, name='home'),  # Rende questa la home page
    # Altri percorsi per le pagine clienti, utenze, letture, fatture, ecc.
    #path('clienti/', views.clienti, name='clienti'),
    #path('utenza/', views.utenza_view, name='utenza'),
    #path('utenza/<int:cod_utenza>/', views.utenza_view, name='utenza_view'),
    #path('fatture/', views.fatture, name='fatture'),
    #path('modifica_utenza/<int:codice>/', views.modifica_utenza, name='modifica_utenza'),
    #path('aggiungi_utenza/', views.aggiungi_utenza, name='aggiungi_utenza'),
    #path('utenza/elimina_utenza/<int:codice>/', views.elimina_utenza, name='elimina_utenza'),
    #path('lettura/', views.lettura_view, name='lettura'),
    ####CHATGTP
    # Pagine clienti, utenze, letture, fatture
    path('cliente/', views.clienti, name='cliente'),
    path('utenza/', views.utenza_view, name='utenza'),
    path('letture/', views.letture, name='letture'),
    path('fattura/', views.fatture, name='fattura'),

    # Visualizzazione utenza specifica


    # Modifica, aggiungi e elimina utenza
    path('modifica_utenza/<int:codice>/', views.modifica_utenza, name='modifica_utenza'),
    path('aggiungi_utenza/', views.aggiungi_utenza, name='aggiungi_utenza'),
    path('utenza/elimina_utenza/<int:codice>/', views.elimina_utenza, name='elimina_utenza'),


    # Visualizzazione lettura
    path('lettura/', views.lettura_view, name='lettura'),
]
