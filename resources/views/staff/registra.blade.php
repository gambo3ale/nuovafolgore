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

$("#registraStaff").submit(function(event){
            event.preventDefault();
            $.post( "{{route('staff.memorizza')}}", {
                            dati: $(this).serialize(),
                            user_id: {{Auth::user()->id}}
                        })
                        .done(function( data ) {
                            alert('Iscrizione registrata con successo!');
                        });
          })


function registraStaff(id)
{
    $("#id_staff").val(id);
    $("#nominativo").text($("#cognome"+id).text()+" "+$("#nome"+id).text());
}
</script>

@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h3>Registra membro dello staff per <b>{{$data['stag']->descrizione}}</b></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <table class="table table-striped table-sm">
                <thead>
                    <th>ID</th><th>Cognome</th><th>Nome</th><th>Ruolo</th><th>Qualifica</th><th></th>
                </thead>
                <tbody>
                    @foreach ($data['staff'] as $s)
                        <tr><td>{{$s->id}}</td><th id="cognome{{$s->id}}">{{$s->cognome}}</th><th id="nome{{$s->id}}">{{$s->nome}}</th><td>{{$s->ruolo}}</td><td>{{$s->qualifica}}</td><td><button class="btn btn-warning btn-sm" onclick="registraStaff({{$s->id}})"><i class="fa-solid fa-business-time"></i></button></td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-5 mr-2 ml-2 p-2">
            <div class="row border border-warning">
                <div class="col-12 text-lg">
                    <h4><b>Registra Staff: Assegna categoria</b></h4>
                    <form id="registraStaff">
                    <div class="row mt-5">
                        <div class="col-3">
                            Membro Selezionato:
                        </div>
                        <div class="col-9">
                            <span class="text-bold" id="nominativo"></span>
                            <input type="hidden" value="-1" id="id_staff" name="id_staff">
                            <input type="hidden" value="{{$data['stag']->id}}" id="id_stagione" name="id_stagione">
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-3">
                            Seleziona categoria:
                        </div>
                        <div class="col-9">
                            <select class="form-select form-select-lg" id="id_categoria" name='id_categoria'>
                                <option value="-1">NESSUNA</option>
                                @foreach ($data['cat'] as $c)
                                    <option value="{{$c->id}}">{{$c->categoria_estesa}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-3">
                            Numero Matricola:
                        </div>
                        <div class="col-9">
                            <input type="text" class="form-control form-control-lg" id="matricola" name="matricola">
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-3">
                            Taglia Kit:
                        </div>
                        <div class="col-9">
                            <select class="form-select form-select-lg" id="taglia_kit" name='taglia_kit'>
                                <option value="NS">NON SPECIFICATA</option>
                                <option value="XS">XS</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                                <option value="XXL">XXL</option>
                                <option value="XXXL">XXXL</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-5 mb-5">
                        <div class="col-5">
                            <button class="btn btn-warning text-bold btn-lg"><i class="fa-regular fa-floppy-disk"></i>&ensp;Registra Staff</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

