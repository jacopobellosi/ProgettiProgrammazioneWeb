# models.py
from django.db import models

class Cliente(models.Model):
    Codice = models.CharField(max_length=10, primary_key=True)
    CF = models.CharField(max_length=16)
    RagSoc = models.CharField(max_length=255)
    Indirizzo = models.CharField(max_length=255)
    Citta = models.CharField(max_length=255)
    nome = models.CharField(max_length=100)

    
class Utenza(models.Model):
    Codice = models.IntegerField( primary_key=True)
    DataAp = models.DateField()
    Indirizzo = models.CharField(max_length=255)
    Città = models.CharField(max_length=255)
    CodCliente = models.ForeignKey(Cliente, on_delete=models.CASCADE)
    Attiva = models.BooleanField()
    DataCh = models.DateField(null=True, blank=True)
    class Meta:
        db_table = 'utenza'

class Lettura(models.Model):
    Numero = models.CharField(max_length=10, primary_key=True)
    CodUtenza = models.ForeignKey(Utenza, on_delete=models.CASCADE)
    Data = models.DateField()
    Valore = models.FloatField()
    NumFattura = models.CharField(max_length=10)

class Fattura(models.Model):
    Numero = models.CharField(max_length=10, primary_key=True)
    Imponibile = models.FloatField()
    Data = models.DateField()
    Iva = models.FloatField()
    Totale = models.FloatField()
