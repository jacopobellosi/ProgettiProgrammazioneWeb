"""
URL configuration for progetto2PW24 project.

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/4.2/topics/http/urls/
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
    path('admin/', admin.site.urls),
    path('', views.home, name='home'),  # Rende questa la home page
    # Altri percorsi per le pagine clienti, utenze, letture, fatture, ecc.
    path('clienti/', views.clienti, name='clienti'),
    path('utenze/', views.utenze, name='utenze'),
    path('letture/', views.letture, name='letture'),
    path('fatture/', views.fatture, name='fatture'),
]
