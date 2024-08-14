@extends('layouts.main')

@section('title', 'Aggiungi Partita')

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
function onSelect2(e) {
    //alert(e.dataItem.id);
    $("#id_avversario").val(e.dataItem.id);
    $("#avversario").val(e.dataItem.nome);
}

    $(document).ready(function(){
      $("#avversario").kendoAutoComplete({
                  dataValueField:"id",
                  dataTextField:"ContactName",
                  headerTemplate: '<div class="dropdown-header">' +
                          '<span class="k-widget k-header">Squadre</span>' +
                      '</div>',
                      template: kendo.template(
                    '<div class="autocomplete-item">' +
                    '    <span class="text-bold">#= nome #</span> - #= comune #' +
                    '</div>'
                ),
                  filter: "contains",
                  minLength: 3,
                  select: onSelect2,
                  dataSource: {
                      dataType: "json",
                      serverFiltering: true,
                      transport: {
                          read: "{{route('partita.cercaAvversario')}}",
                          //dataType: 'json'
                      }
                  },
                  schema: {
                          parse: function(response) {
                              console.log(response)
                              $.each(response, function(idx, elem) {
                              elem.ContactName = elem.nome+" - "+elem.comune;

                              });
                              return response;
                          }
                      }
              });
          });
</script>

<script>
    function onSelect3(e) {
        //alert(e.dataItem.id);
        $("#id_campo").val(e.dataItem.id);
        $("#campo").val(e.dataItem.titolo);
    }

        $(document).ready(function(){
          $("#campo").kendoAutoComplete({
                      dataValueField:"id",
                      dataTextField:"ContactName",
                      headerTemplate: '<div class="dropdown-header">' +
                              '<span class="k-widget k-header">Campo</span>' +
                          '</div>',
                          template: kendo.template(
                        '<div class="autocomplete-item">' +
                        '    <span class="text-bold">#= titolo #</span> - #= abbreviato #' +
                        '</div>'
                    ),
                      filter: "contains",
                      minLength: 3,
                      select: onSelect3,
                      dataSource: {
                          dataType: "json",
                          serverFiltering: true,
                          transport: {
                              read: "{{route('partita.cercaCampo')}}",
                              //dataType: 'json'
                          }
                      },
                      schema: {
                              parse: function(response) {
                                  console.log(response)
                                  $.each(response, function(idx, elem) {
                                  elem.ContactName = elem.titolo+" - "+elem.abbreviato;

                                  });
                                  return response;
                              }
                          }
                  });
              });
    </script>
    <script>
        $("#inserisciPartita").submit(function(event){
            event.preventDefault();
            $.post( "{{route('partita.store')}}", {
                            dati: $(this).serialize(),
                            user_id: {{Auth::user()->id}}
                        })
                        .done(function( data ) {
                            alert('Partita registrata con successo!');
                        });
          })
    </script>
@endsection


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h3><b>Nuova Partita per {{$data['stag']->descrizione}}</b></h3>
        </div>
    </div>
    <form id="inserisciPartita">
    <div class="row mt-2">
        <div class="col-3">
            <div class="form-group">
                <label>Categoria</label>
                <select id="id_categoria" name="id_categoria" class="form-select">
                    @foreach ($data['cat'] as $cat)
                        <option value="{{$cat->id}}">{{$cat->categoria_estesa}}</option>
                    @endforeach
                </select>
                <input type="hidden" id="id_stagione" name="id_stagione" value="{{$data['stag']->id}}">
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label>Squadra</label>
                <select id="squadra" name="squadra" class="form-select">
                    <option value="0">Sq. A</option>
                    <option value="1">Sq. B</option>
                    <option value="2">Sq. C</option>
                    <option value="3">Sq. D</option>
                </select>
            </div>
        </div>

    </div>
    <div class="row mt-2">
        <div class="col-2">
            <div class="form-group">
                <label>Data</label>
                <input type="date" class="form-control" id="data" name="data">
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label>Ora</label>
                <input type="time" class="form-control" id="ora" name="ora">
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label>Avversaria</label><br>
                <input type="text" class="form-control" id="avversario" name="avversario" style="width: 100%">
                <input type="hidden" id="id_avversario" name="id_avversario">
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label>Campo</label><br>
                <input type="text" class="form-control" id="campo" name="campo" style="width: 100%">
                <input type="hidden" id="id_campo" name="id_campo">
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-3">
            <div class="form-group">
                <label>Competizione</label>
                <select id="campionato" name="campionato" class="form-select">
                    <option value="0">Campionato</option>
                    <option value="1">Amichevole</option>
                    <option value="2">Torneo</option>
                </select>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label>Girone</label>
                <input type="text" id="girone" name="girone" class="form-control">
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label>Giornata</label>
                <input type="text" id="giornata" name="giornata" class="form-control">
            </div>
        </div>
        <div class="col-5">
            <div class="form-group">
                <label>Note</label>
                <input type="text" id="descrizione" name="descrizione" class="form-control">
            </div>
        </div>
    </div>
    <button class="btn btn-primary" type="submit"><i class="fa-regular fa-square-plus"></i>&ensp;Inserisci Partita</button>
    </form>
</div>
@endsection
