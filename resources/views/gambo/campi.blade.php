@extends('layouts.main')

@section('title', 'Dashboard')

@section('style')
<link href="https://kendo.cdn.telerik.com/themes/8.0.1/default/default-main.css" rel="stylesheet" />
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.3.1207/styles/kendo.common.min.css" />
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.3.1207/styles/kendo.default.min.css" />
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    td, th {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: left;
        vertical-align: middle; /* Centra verticalmente */
    }
</style>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2023.1.117/js/jszip.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2021.3.1207/js/kendo.all.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2022.1.119/js/cultures/kendo.culture.it-IT.min.js"></script>
<script>
    $("#nuovoCampo").submit(function(event){
            event.preventDefault();
            $.post( "{{route('gambo.salvaCampo')}}", {
                            dati: $(this).serialize(),
                            user_id: {{Auth::user()->id}}
                        })
                        .done(function( data ) {
                            alert('Impianto registrato con successo!');
                            $("#grid").data("kendoGrid").dataSource.read();
                        });
          })

          $("#nuovaSquadra").submit(function(event){
            event.preventDefault();
            $.post( "{{route('gambo.salvaSquadra')}}", {
                            dati: $(this).serialize(),
                            user_id: {{Auth::user()->id}}
                        })
                        .done(function( data ) {
                            alert('Squadra registrato con successo!');
                            $("#grid2").data("kendoGrid").dataSource.read();
                        });
          })
</script>
<script>

    kendo.culture("it-IT");
    $(document).ready(function () {
        $("#grid").kendoGrid({
          dataSource: {
            transport: {
              read: function(options)
                    {
                        $.post( "{{route('gambo.visualizzaCampi')}}", {
                          id: 1
                        })
                        .done(function( data ) {
                            options.success(data);
                                    });
                    },
            },
            schema: {
              model: {
                fields: {
                  id: {field:"id", type: "number" },
                  titolo: {field: "titolo", type:"string"},
                  abbreviato: {field: "abbreviato", type:"string"},
                  indirizzo: {field: "indirizzo", type:"string"},
                  comune: {field: "comune", type:"string"},
                  fondo: {field: "fondo", type:"string"},
                  cap: {field: "cap", type:"string"},
                  provincia: {field: "provincia", type:"string"},
                }
              }
            },
            //pageSize: 30 // Numero di righe per pagina
          },
          height: 800, // Altezza del Grid
          sortable: true,
          pageable: false,
          filterable: true,
          toolbar:["search","excel"],
            search: {
                fields: ["titolo","abbreviato"] // Or, specify multiple fields by adding them to the array, e.g ["name", "age"]<i class="fa-solid fa-circle-check text-success"></i>
            },
            excel: {
                fileName: "campi.xlsx",
                proxyURL: "https://demos.telerik.com/kendo-ui/service/export",
                filterable: true,
                allPages: true
            },
          columns: [
            { field: "id", title: "ID", width:"5%",  filterable: { multi: true } },
            { field: "titolo", title: "Titolo" , width:"25%"},
            { field: "abbreviato", title: "Abbreviato" , width:"15%"},
            { field: "fondo", title: "Sup" , width:"5%", template: function(dataItem){
                if(dataItem.fondo=="ERBA")
                    return '<i class="fa-solid fa-e fa-lg text-success"></i>';
                else if(dataItem.fondo=="SINTETICO")
                    return '<i class="fa-solid fa-s fa-lg text-primary"></i>';
                else if(dataItem.fondo=="TERRA")
                    return '<i class="fa-solid fa-t fa-lg text-orange"></i>';
            }},
            { field: "indirizzo", title: "Indirizzo" , width:"20%"},
            { field: "comune", title: "comune" , width:"15%"},
            { field: "cap", title: "Cap" , width:"8%"},
            { field: "provincia", title: "Prov" , width:"5%"},
          ],
        });
      });

      $(document).ready(function () {
        $("#grid2").kendoGrid({
          dataSource: {
            transport: {
              read: function(options)
                    {
                        $.post( "{{route('gambo.visualizzaSquadre')}}", {
                          id: 1
                        })
                        .done(function( data ) {
                            options.success(data);
                                    });
                    },
            },
            schema: {
              model: {
                fields: {
                  id: {field:"id", type: "number" },
                  nome: {field: "nome", type:"string"},
                  comune: {field: "comune", type:"string"},
                  ranking: {field: "ranking", type:"number"},
                  provincia: {field: "provincia", type:"string"},
                }
              }
            },
            //pageSize: 30 // Numero di righe per pagina
          },
          height: 800, // Altezza del Grid
          sortable: true,
          pageable: false,
          filterable: true,
          toolbar:["search","excel"],
            search: {
                fields: ["nome","abbreviato"] // Or, specify multiple fields by adding them to the array, e.g ["name", "age"]<i class="fa-solid fa-circle-check text-success"></i>
            },
            excel: {
                fileName: "squadre.xlsx",
                proxyURL: "https://demos.telerik.com/kendo-ui/service/export",
                filterable: true,
                allPages: true
            },
          columns: [
            { field: "id", title: "ID", width:"5%",  filterable: { multi: true } },
            { field: "nome", title: "Nome" , width:"30%"},
            { field: "ranking", title: "Ranking" , width:"15%" ,template: function(dataItem){
                if(dataItem.ranking==0)
                    return "SCONOSCIUTO";
                else if(dataItem.ranking==1)
                    return '<i class="fa-solid fa-star fa-lg text-orange"></i><i class="fa-regular fa-star fa-lg text-orange"></i><i class="fa-regular fa-star fa-lg text-orange"></i><i class="fa-regular fa-star fa-lg text-orange"></i><i class="fa-regular fa-star fa-lg text-orange"></i>';
                else if(dataItem.ranking==2)
                    return '<i class="fa-solid fa-star fa-lg text-orange"></i><i class="fa-solid fa-star fa-lg text-orange"></i><i class="fa-regular fa-star fa-lg text-orange"></i><i class="fa-regular fa-star fa-lg text-orange"></i><i class="fa-regular fa-star fa-lg text-orange"></i>';
                else if(dataItem.ranking==3)
                    return '<i class="fa-solid fa-star fa-lg text-orange"></i><i class="fa-solid fa-star fa-lg text-orange"></i><i class="fa-solid fa-star fa-lg text-orange"></i><i class="fa-regular fa-star fa-lg text-orange"></i><i class="fa-regular fa-star fa-lg text-orange"></i>';
                else if(dataItem.ranking==4)
                    return '<i class="fa-solid fa-star fa-lg text-orange"></i><i class="fa-solid fa-star fa-lg text-orange"></i><i class="fa-solid fa-star fa-lg text-orange"></i><i class="fa-solid fa-star fa-lg text-orange"></i><i class="fa-regular fa-star fa-lg text-orange"></i>';
                else if(dataItem.ranking==5)
                    return '<i class="fa-solid fa-star fa-lg text-orange"></i><i class="fa-solid fa-star fa-lg text-orange"></i><i class="fa-solid fa-star fa-lg text-orange"></i><i class="fa-solid fa-star fa-lg text-orange"></i><i class="fa-solid fa-star fa-lg text-orange"></i>';
            }},
            { field: "comune", title: "Comune" , width:"20%"},
            { field: "provincia", title: "Prov" , width:"5%"},
          ],
        });
      });
        </script>
@endsection


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-2">
            <div class="row">
                <div class="col-12 border border-success table-success pb-2 pt-2">
            <form id="nuovoCampo">
                <h5><b>Inserisci nuovo impanto Sportivo</b></h5>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Titolo</label>
                        <input type="text" class="form-control" class="form-control" name="titolo" id="titolo">
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <div class="form-group">
                        <label>Abbreviazione</label>
                        <input type="text" class="form-control" class="form-control" name="abbreviato" id="abbreviato">
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="form-group">
                    <label>Superficie di gioco</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fondo" id="inlineRadio1" value="ERBA">
                        <label class="form-check-label" for="inlineRadio1">ERBA</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fondo" id="inlineRadio1" value="SINTETICO">
                        <label class="form-check-label" for="inlineRadio1">SINTETICO</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fondo" id="inlineRadio1" value="TERRA">
                        <label class="form-check-label" for="inlineRadio1">TERRA</label>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-9">
                    <div class="form-group">
                        <label>Inidirizzo</label>
                        <input type="text" class="form-control" class="form-control" name="indirizzo" id="indirizzo">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label>Cap</label>
                        <input type="text" class="form-control" class="form-control" name="cap" id="cap">
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-9">
                    <div class="form-group">
                        <label>Comune</label>
                        <input type="text" class="form-control" class="form-control" name="comune" id="comune">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label>Prov.</label>
                        <input type="text" class="form-control" class="form-control" name="provincia" id="provincia">
                    </div>
                </div>
            </div>
            <button class="btn btn-success"><i class="fa-solid fa-building-flag"></i>&ensp; Inserisci impianto sportivo</button>
            </form>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12 col-12 border border-primary table-info pb-2 pt-2">
                    <form id="nuovaSquadra">
                        <h5><b>Inserisci nuova Squadra</b></h5>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Nome</label>
                                    <input type="text" class="form-control" class="form-control" name="nome" id="nome">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label>Ranking</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="ranking" id="exampleRadios1" value="0" checked>
                                    <label class="form-check-label" for="exampleRadios1">
                                        <i class="fa-regular fa-star text-orange"></i><i class="fa-regular fa-star text-orange"></i><i class="fa-regular fa-star text-orange"></i><i class="fa-regular fa-star text-orange"></i><i class="fa-regular fa-star text-orange"></i>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="ranking" id="exampleRadios1" value="1">
                                    <label class="form-check-label" for="exampleRadios1">
                                        <i class="fa-solid fa-star text-orange"></i><i class="fa-regular fa-star text-orange"></i><i class="fa-regular fa-star text-orange"></i><i class="fa-regular fa-star text-orange"></i><i class="fa-regular fa-star text-orange"></i>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="ranking" id="exampleRadios1" value="2">
                                    <label class="form-check-label" for="exampleRadios1">
                                        <i class="fa-solid fa-star text-orange"></i><i class="fa-solid fa-star text-orange"></i><i class="fa-regular fa-star text-orange"></i><i class="fa-regular fa-star text-orange"></i><i class="fa-regular fa-star text-orange"></i>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="ranking" id="exampleRadios1" value="3">
                                    <label class="form-check-label" for="exampleRadios1">
                                        <i class="fa-solid fa-star text-orange"></i><i class="fa-solid fa-star text-orange"></i><i class="fa-solid fa-star text-orange"></i><i class="fa-regular fa-star text-orange"></i><i class="fa-regular fa-star text-orange"></i>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="ranking" id="exampleRadios1" value="4">
                                    <label class="form-check-label" for="exampleRadios1">
                                        <i class="fa-solid fa-star text-orange"></i><i class="fa-solid fa-star text-orange"></i><i class="fa-solid fa-star text-orange"></i><i class="fa-solid fa-star text-orange"></i><i class="fa-regular fa-star text-orange"></i>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="ranking" id="exampleRadios1" value="5">
                                    <label class="form-check-label" for="exampleRadios1">
                                        <i class="fa-solid fa-star text-orange"></i><i class="fa-solid fa-star text-orange"></i><i class="fa-solid fa-star text-orange"></i><i class="fa-solid fa-star text-orange"></i><i class="fa-solid fa-star text-orange"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-9">
                                <div class="form-group">
                                    <label>Comune</label>
                                    <input type="text" class="form-control" class="form-control" name="comune" id="comune2">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Prov.</label>
                                    <input type="text" class="form-control" class="form-control" name="provincia" id="provincia2">
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary"><i class="fa-regular fa-flag"></i>&ensp; Inserisci squadra</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-6">
            <h5><b>Lista Impianti Sportivi</b></h5>
            <div id="grid"></div>
        </div>
        <div class="col-4">
            <h5><b>Lista Squadre</b></h5>
            <div id="grid2"></div>
        </div>
    </div>
</div>
@endsection
