@extends('layouts.main')

@section('title', 'Iscrizione Giocatore')

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

$("#salvaIscrizione").submit(function(event){
            event.preventDefault();
            $.post( "{{route('staff.store')}}", {
                            dati: $(this).serialize(),
                            user_id: {{Auth::user()->id}}
                        })
                        .done(function( data ) {
                            alert('Iscrizione registrata con successo!');
                            $("#salva").prop("disabled", true);
                            $("#stampa").prop("disabled", false);
                            $("#id_giocatore").val(data['id']);
                        });
          })
</script>

@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h3><b>Nuovo membro dello staff</b></h3>
        </div>
    </div>
<form id="salvaIscrizione">
    <div class="row mt-5">
        <input type="hidden" id="id_stagione" value="{{$data['stag']->id}}" name="id_stagione">
        <div class="col-3">
            <div class="form-group">
                <label>Cognome</label>
                <input type="text" class="form-control" id="cognome" name="cognome">
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label>Nome</label>
                <input type="text" class="form-control" id="nome" name="nome">
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label>Ruolo</label>
                <select class="form-select" id="ruolo" name="ruolo">
                    <option value="NON SPECIFICATO">NON SPECIFICATO</option>
                    <option value="ALLENATORE">ALLENATORE</option>
                    <option value="COLLABORATORE TECNICO">COLLABORATORE TECNICO</option>
                    <option value="PREPARATORE ATLETICO">PREPARATORE ATLETICO</option>
                    <option value="PREPARATORE PORTIERI">PREPARATORE PORTIERI</option>
                    <option value="DIRIGENTE">DIRIGENTE</option>
                    <option value="SEGRETARIO">SEGRETARIO</option>
                    <option value="MAGAZZINIERE">MAGAZZINIERE</option>
                </select>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label>Qualifica</label>
                <select class="form-select" id="qualifica" name="qualifica">
                    <option value="NESSUNA">NESSUNA</option>
                    <option value="UEFA B">UEFA B</option>
                    <option value="UEFA C">UEFA C</option>
                    <option value="UEFA C">LICENZA D</option>
                    <option value="CONI/FIGC">CONI/FIGC</option>
                    <option value="ALTRO">ALTRO</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-3">
            <div class="form-group">
                <label>Telefono</label>
                <input type="text" class="form-control" id="telefono" name="telefono">
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" id="email" name="email">
            </div>
        </div>
        <div class="col-4">
            <button class="btn btn-success btn-lg" id="salva" type="submit"><i class="fa-regular fa-floppy-disk"></i>&emsp;Salva Membro dello Staff</button>
        </div>
    </div>
</form>
</div>
@endsection

