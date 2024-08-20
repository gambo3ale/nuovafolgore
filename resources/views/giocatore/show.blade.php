@extends('layouts.main')

@section('title', 'Scheda Giocatore')

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
@endsection

@section('content')
<div class="container-fluid">
    <h3><b><i class="fa-regular fa-id-card fa-lg"></i>&ensp;Scheda Giocatore:&emsp;<span class="text-danger">{{$data['gio']->cognome}} {{$data['gio']->nome}} [ {{Carbon\Carbon::parse($data['gio']->data_nascita)->format('Y')}} ]</span></b></h3>
    <form id="salvaIscrizione">
        <div class="row mt-3">
            <input type="hidden" id="id_giocatore" value="-1" name="id_giocatore">
            <input type="hidden" id="id_stagione" value="{{$data['stag']->id}}" name="id_stagione">
            <div class="col-7 border border-dark">
                <h4><b>Dati del Giocatore</b></h4>
                <div class="row">
                    <div class="col-3">
                        <img src="/images/foto/player{{$data['gio']->id}}.jpg" alt="NON PRESENTE" width="100%">
                    </div>
                    <div class="col-9">
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
                                    <input type="date" class="form-control" id="data_giocatore" name="data_giocatore" value="{{$data['gio']->data_nascita}}">
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
                        <div class="row mt-2">
                            <div class="col-4">
                                <label>Residente a</label>
                                <input type="text" class="form-control" id="comune_giocatore" name="comune_giocatore" value="{{$data['gio']->comune}}">
                            </div>
                            <div class="col-4">
                                <label>Indirizzo</label>
                                <input type="text" class="form-control" id="indirizzo_giocatore" name="indirizzo_giocatore" value="{{$data['gio']->indirizzo}}">
                            </div>
                            <div class="col-2">
                                <label>CAP</label>
                                <input type="text" class="form-control" id="cap_giocatore" name="cap_giocatore" value="{{$data['gio']->cap}}">
                            </div>
                            <div class="col-2">
                                <label>Prov</label>
                                <input type="text" class="form-control" id="provincia_giocatore" name="provincia_giocatore" value="{{$data['gio']->provincia}}">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Telefono</label>
                                    <input type="text" class="form-control" id="telefono_giocatore" name="telefono_giocatore" value="{{$data['gio']->telefono}}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" id="email_giocatore" name="email_giocatore" value="{{$data['gio']->email}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="col-5 border border-dark table-warning pt-3 pb-5">
                <h4><b>Genitore o chi ne fa le veci (PER DETRAZIONE)</b></h4>
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
                <div class="row mt-2">
                    <div class="col-4">
                        <label>Residente a</label>
                        <input type="text" class="form-control" id="comune_genitore" name="comune_genitore"  value="{{$data['gen']->comune}}">
                    </div>
                    <div class="col-4">
                        <label>Indirizzo</label>
                        <input type="text" class="form-control" id="indirizzo_genitore" name="indirizzo_genitore" value="{{$data['gen']->indirizzo}}">
                    </div>
                    <div class="col-2">
                        <label>CAP</label>
                        <input type="text" class="form-control" id="cap_genitore" name="cap_genitore" value="{{$data['gen']->cap}}">
                    </div>
                    <div class="col-2">
                        <label>Prov</label>
                        <input type="text" class="form-control" id="provincia_genitore" name="provincia_genitore" value="{{$data['gen']->provincia}}">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Telefono</label>
                            <input type="text" class="form-control" id="telefono_genitore" name="telefono_genitore" value="{{$data['gen']->telefono}}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" id="email_genitore" name="email_genitore" value="{{$data['gen']->email}}">
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-12">
                @php $cnt=0; @endphp
                @foreach ($data['sp'] as $sp)
                    <div class="row mt-2 border @if($cnt%2==0) border-danger bg-danger @else bg-white border-dark @endif  rounded-3 p-1">
                        <div class="col-3 text-bold text-lg">
                            <i class="fa-regular fa-futbol"></i>&ensp;{{$sp->stagione->descrizione}}
                        </div>
                        <div class="col-2">
                            <i class="fa-regular fa-calendar-check"></i> Data Iscrizione:&ensp;<b>{{Carbon\Carbon::parse($sp->iscrizione)->format('d/m/Y')}}</b>
                        </div>
                        <div class="col-3">
                            @foreach ($sp->pagamenti as $p)
                                <div class="row">
                                    <div class="col-12">
                                        <i class="fa-solid fa-money-bill-1-wave"></i> Pagato {{$p->tipo}} il {{Carbon\Carbon::parse($p->data)->format('d/m/Y')}}:&ensp;<b>€ {{number_format($p->importo,2,",",".")}}</b>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-3">
                            @foreach ($sp->ricevute as $r)
                                <div class="row">
                                    <div class="col-12">
                                        <i class="fa-solid fa-file-invoice"></i> Ricevuta n° <b>{{$r->numero}}</b> del {{Carbon\Carbon::parse($r->data)->format('d/m/Y')}}: <b>€ {{number_format($r->importo,2,",",".")}}</b>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @php $cnt++; @endphp
                @endforeach
            </div>
        </div>
</div>
@endsection
