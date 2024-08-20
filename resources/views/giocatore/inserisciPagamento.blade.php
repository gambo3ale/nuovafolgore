@extends('layouts.main')

@section('title', 'Pagamento Giocatore')

@section('style')
<link href="https://kendo.cdn.telerik.com/themes/8.0.1/default/default-main.css" rel="stylesheet" />
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.3.1207/styles/kendo.common.min.css" />
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.3.1207/styles/kendo.default.min.css" />
<style>
    /* Stili aggiuntivi per l'immagine nella lista */
    .autocomplete-item {
        display: flex;
        align-items: center;
    }
    .autocomplete-item img {
        width: 50px; /* Modifica la dimensione dell'immagine secondo necessità */
        height: 50px;
        margin-right: 10px;
    }
</style>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2023.1.117/js/jszip.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2021.3.1207/js/kendo.all.min.js"></script>

<script>
    var ric="";
    $("#inserisciPagamento").submit(function(event){
            event.preventDefault();
            $.post( "{{route('giocatore.registraPagamento')}}", {
                            dati: $(this).serialize(),
                            user_id: {{$data['ut']}}
                        })
                        .done(function( data ) {
                            alert('Pagamento registrato e ricevuta creata!');
                            $("#salva").prop("disabled", true);
                            if(data!=null)
                            {
                                $("#stampa").prop("disabled", false);
                                ric=data['id'];
                            }
                        });
          })


    function stampaRicevuta(ev)
    {
        ev.preventDefault();
        $.post( "{{route('document.stampaRicevuta')}}", {
                            id: ric
                        }).done(function( data ) {
                            if (data.url) {
                                var link = document.createElement('a');
                                link.href = data.url;
                                link.download = 'ricevuta.pdf';
                                document.body.appendChild(link);
                                link.click();
                                document.body.removeChild(link);
                            }
                        });
    }
</script>
@endsection

@section('content')
<form id="inserisciPagamento">
<div class="container-fluid">
    <div class="row">
        <h4><b>Inserisci Pagamento</b></h4>
    </div>
    <input type="hidden" value="{{$data['gio']->id}}" id="id_giocatore" name="id_giocatore">
    <input type="hidden" value="{{$data['sp']->id}}" id="id_season_player" name="id_season_player">
    <input type="hidden" value="{{$data['gen']->id}}" id="id_genitore" name="id_genitore">
    <input type="hidden" value="{{$data['sp']->id_stagione}}" id="id_stagione" name="id_stagione">
    <div class="row border border-success p-1 rounded-3">
        <div class="col-12">
            <div class="row">
                <div class="col-2 bg-success rounded-3 p-1">
                    <i class="fa-regular fa-futbol fa-lg"></i>&ensp;<b>Dati Giocatore</b>
                </div>
            </div>
            <div class="row">
                <div class="row mt-3">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Cognome</label>
                            <input type="text" class="form-control" id="cognome_giocatore" name="cognome_giocatore" value="{{$data['gio']->cognome}}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" class="form-control" id="nome_giocatore" name="nome_giocatore" value="{{$data['gio']->nome}}">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-4">
                        <div class="form-group">
                            <label>Data di Nascita</label>
                            <input type="date" class="form-control" id="data_giocatore" name="data_giocatore"  value="{{$data['gio']->data_nascita}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Luogo di Nascita</label>
                            <input type="text" class="form-control" id="luogo_giocatore" name="luogo_giocatore" value="{{$data['gio']->luogo_nascita}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Codice Fiscale</label>
                            <input type="text" class="form-control" id="codice_giocatore" name="codice_giocatore" value="{{$data['gio']->codice_fiscale}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row border border-primary p-1 rounded-3 mt-3">
        <div class="col-12">
            <div class="row">
                <div class="col-2 bg-primary rounded-3 p-1">
                    <i class="fa-solid fa-user-tie fa-lg"></i>&ensp;<b>Dati Genitore</b>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-6">
                    <div class="form-group">
                        <label>Cognome</label>
                        <input type="text" class="form-control" id="cognome_genitore" name="cognome_genitore" value="{{$data['gen']->cognome}}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" class="form-control" id="nome_genitore" name="nome_genitore" value="{{$data['gen']->nome}}">
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-4">
                    <div class="form-group">
                        <label>Data di Nascita</label>
                        <input type="date" class="form-control" id="data_genitore" name="data_genitore" value="{{$data['gen']->data_nascita}}">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label>Luogo di Nascita</label>
                        <input type="text" class="form-control" id="luogo_genitore" name="luogo_genitore" value="{{$data['gen']->luogo_nascita}}">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label>Codice Fiscale</label>
                        <input type="text" class="form-control" id="codice_genitore" name="codice_genitore" value="{{$data['gen']->codice_fiscale}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row border border-warning p-1 rounded-3 mt-3">
        <div class="col-12">
            <div class="row">
                <div class="col-2 bg-warning rounded-3 p-1">
                    <i class="fa-solid fa-cash-register fa-lg"></i>&ensp;<b>Dettagli Pagamento</b>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-3">
                    <div class="form-group">
                        <label>Metodo di Pagamento</label>
                        <select class="form-select" id="bonifico" name="bonifico">
                            <option value="0">Bancomat</option>
                            <option value="1">Bonifico</option>
                            <option value="2">Assegno</option>
                            <option value="3">Voucher</option>
                            <option value="4">Contanti</option>
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label>Data Pagamento</label>
                        <input type="date" class="form-control" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" id="data_pagamento" name="data_pagamento">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label>Importo [€]</label>
                        <input type="number" step="0.01" class="form-control" id="importo" name="importo">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label>Rata/Saldo/Iscrizione</label>
                        <select class="form-select" id="tipo" name="tipo">
                            <option value="RATA">Rata</option>
                            <option value="SALDO">Saldo</option>
                            <option value="ISCRIZIONE">Iscrizione</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row border border-danger p-1 rounded-3 mt-3">
        <div class="col-12">
            <div class="row">
                <div class="col-2 bg-danger rounded-3 p-1">
                    <i class="fa-solid fa-file-invoice fa-lg"></i>&ensp;<b>Dettagli Ricevuta</b>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-3">
                    <div class="form-group">
                        <label>Intestatario Ricevuta</label>
                        <select class="form-select" id="intestato" name="intestato">
                            <option value="0">Genitore sopra indicato</option>
                            <option value="1">Cooperativa sociale polo9</option>
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label>Data Ricevuta</label>
                        <input type="date" class="form-control" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" id="data_ricevuta" name="data_ricevuta">
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label>Numero Ricevuta</label>
                        <input type="number" class="form-control" id="numero" name="numero" value="{{$data['num']}}">
                    </div>
                </div>
                <div class="col-2">
                    <b><i class="fa-solid fa-triangle-exclamation text-danger"></i>&ensp;N.B:</b>&ensp;<i>Il numero che esce in automatico è il numero successivo all'ultima ricevuta emessa per l'anno corrente</i>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-6">
            <button class="btn btn-success btn-lg text-bold" type="submit" id="salva"><i class="fa-regular fa-floppy-disk"></i>&ensp;Inserisci Pagamento</button>
        </div>
        <div class="col-6">
            <button class="btn btn-primary btn-lg text-bold" onclick="stampaRicevuta(event)" id="stampa" disabled><i class="fa-solid fa-print"></i>&ensp;Stampa Ricevuta</button>
        </div>
    </div>
</div>

</form>
@endsection
