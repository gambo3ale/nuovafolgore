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

    kendo.culture("it-IT");
          $(document).ready(function () {
            $("#grid").kendoGrid({
              dataSource: {
                transport: {
                  read: function(options)
                        {
                            $.post( "{{route('magazzino.lista')}}", {
                              id: {{$data['stag']->id}}
                            })
                            .done(function( data ) {
                                options.success(data);
                                        });
                        },
                },
                schema: {
                  model: {
                    fields: {
                      id: {field:"id", type: "number" , editable:"false"},
                      cognome: {field: "cognome", type:"string", editable:"false"},
                      nome: {field: "nome", type:"string", editable:"false"},
                      nascita: {field: "data_nascita", type:"date", editable:"false"},
                      taglia_kit: {field: "taglia_kit", type:"string"},
                      consegna_kit: {field: "consegna_kit", type:"number", editable:"false"},
                      note: {field: "note", type:"string"},
                    }
                  }
                },
                batch: true,
                pageSize: 30 // Numero di righe per pagina
              },
              height: 800, // Altezza del Grid
              sortable: true,
              pageable: true,
              filterable: true,
              toolbar:["search","excel"],
                search: {
                    fields: ["cognome","nome"] // Or, specify multiple fields by adding them to the array, e.g ["name", "age"]<i class="fa-solid fa-circle-check text-success"></i>
                },
                excel: {
                    fileName: "iscritti.xlsx",
                    proxyURL: "https://demos.telerik.com/kendo-ui/service/export",
                    filterable: true,
                    allPages: true
                },
                editable: true,
                save: function(e) {
                    console.log(e.values);
                    console.log(e.values.note);
                    console.log(e.model.note);
                    console.log(e.model.id);
                    if(e.values.note!=e.model.note && e.values.hasOwnProperty('note'))
                    {
                        $.post( "{{route('magazzino.aggiornaNote')}}", {
                                    idc: e.model.id,
                                    note: e.values.note,
                                })
                                .done(function( data ) {
                                    //alert("Note inserita");
                                    $("#grid").data("kendoGrid").dataSource.read();
                                    $('#grid').data('kendoGrid').refresh();
                                            });
                    }
                    if(e.values.taglia_kit!=e.model.taglia_kit && e.values.hasOwnProperty('taglia_kit'))
                    {
                        $.post( "{{route('magazzino.aggiornaTaglia')}}", {
                                    idc: e.model.id,
                                    taglia_kit: e.values.taglia_kit,
                                })
                                .done(function( data ) {
                                    //alert("Note inserita");
                                    $("#grid").data("kendoGrid").dataSource.read();
                                    $('#grid').data('kendoGrid').refresh();
                                            });
                    }
                },
              columns: [
                { field: "id", title: "Az.", editable:"false", width:"8%", template: function(dataItem) {
                    if(dataItem.consegna_kit!=1)
                    return '<button name="tesseramento" onclick="registraConsegna('+dataItem.id+',event)" type="button" class="btn btn-sm btn-success btn-table text-bold" id="'+dataItem.id+'" data-toggle="tooltip" data-placement="bottom" title="Tesseramento"><i class="fa-solid fa-check fa-lg"></i> <i class="fa-solid fa-shirt"></i></button> ';
                    else
                    return '<button name="tesseramento" onclick="annullaConsegna('+dataItem.id+',event)" type="button" class="btn btn-sm btn-danger btn-table text-bold" id="'+dataItem.id+'" data-toggle="tooltip" data-placement="bottom" title="Tesseramento"><i class="fa-solid fa-xmark fa-lg"></i></button>';
                    }},
                { field: "cognome", title: "Cognome", editable:"false" , width:"15%"},
                { field: "nome", title: "Nome", editable:"false" , width:"15%"},
                { field: "nascita", title: "Data Nascita", editable:"false", format: "{0:dd/M/yyyy}" , width:"8%"},
                { field: "taglia_kit", title: "Taglia", width:"6%", template: "<b class='text-lg'>#= taglia_kit != null && taglia_kit != 'NS' ? taglia_kit : '' #</b>"},
                { field: "consegnato", title: "Consegnato", editable:"false" , width:"10%", template: function(dataItem) {
                    if(dataItem.consegna_kit==1)
                        return '<span class="text-susccess text-bold bg-success p-1 rounded-3"><i class="fa-regular fa-circle-check fa-lg"></i> CONSEGNATO</span>';
                    else
                        return "";
                }},
                { field: "note", title: "Note" , width:"50%"},
              ],
              pageable: true // Abilita la paginazione
            });
          });


          function registraConsegna(id,ev)
          {
              ev.preventDefault();
              $.post( "{{route('magazzino.registraConsegna')}}", {
                                    id: id,
                                }).done(function( data ) {
                                    //alert("Note inserita");
                                    $("#grid").data("kendoGrid").dataSource.read();
                                    $('#grid').data('kendoGrid').refresh();
                                            });

          }

          function annullaConsegna(id,ev)
          {
              ev.preventDefault();
              $.post( "{{route('magazzino.annullaConsegna')}}", {
                                    id: id,
                                }).done(function( data ) {
                                    //alert("Note inserita");
                                    $("#grid").data("kendoGrid").dataSource.read();
                                    $('#grid').data('kendoGrid').refresh();
                                            });

          }
        </script>

@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-3"><img src="/dist/img/sportlife.png" width="250px"></div>
        <div class="col-4 text-xl"><b>Gestione consegna Kit</b></div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <div id="grid"></div>
        </div>
    </div>
</div>
@endsection
