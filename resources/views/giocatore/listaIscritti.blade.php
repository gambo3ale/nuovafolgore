@extends('layouts.main')

@section('title', 'Lista Iscritti')

@section('style')
<link href="https://kendo.cdn.telerik.com/themes/8.0.1/default/default-main.css" rel="stylesheet" />
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.3.1207/styles/kendo.common.min.css" />
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.3.1207/styles/kendo.default.min.css" />
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
                        $.post( "{{route('giocatore.listaStagione')}}", {
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
                  id: {field:"id", type: "number" },
                  idPlayer: {field:"id_giocatore", type: "number" },
                  anno: {field:"anno_nascita", type: "number" },
                  cognome: {field: "cognome", type:"string"},
                  nome: {field: "nome", type:"string"},
                  nascita: {field: "data_nascita", type:"date"},
                  scadenza: {field: "scadenza", type:"date"},
                  matricola: {field: "matricola", type:"string"},
                  taglia_kit: {field: "taglia_kit", type:"string"},
                  pagato: {field: "pagato", type: "number" }
                }
              }
            },
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
          columns: [
			{ field: "id", title: "Az.", width:"3%", template: function(dataItem) {
				return '<button name="elimina" type="button" class="btn btn-xs btn-light" id="'+dataItem.id+'" data-toggle="tooltip" data-placement="bottom" title="Elimina Giocatore" onclick="eliminaIscrizione('+dataItem.id+')" ><i class="fa fa-user-times text-danger"></i></button>';
			}},
            { field: "anno", title: "Anno", width:"5%",  filterable: { multi: true } },
			{ field: "idPlayer",	title: "Foto",	template: '<img src="./../images/foto/player#= idPlayer #.jpg" alt="NP" width="40" height="50" />'},
            { field: "cognome", title: "Cognome" , width:"15%"},
            { field: "nome", title: "Nome" , width:"15%"},
            { field: "nascita", title: "Data Nascita", format: "{0:dd/M/yyyy}" , width:"8%"},
            { field: "scadenza", title: "Certificato", format: "{0:dd/M/yyyy}" , width:"8%",
            filterable: {
            operators: {
                date: {
                    lte: "Data antecedente o uguale a", // "minore o uguale a" è il "minore di o uguale a" in italiano
                    gte: "Data successiva o uguale a", // "maggiore o uguale a" è il "maggiore di o uguale a" in italiano
                }
            }
			}, template: function(dataItem) {
				var dataInput=new Date(Date.parse(dataItem.scadenza));
				var oggi=new Date();
				if(dataInput<oggi)
				{
					return '<span class="text-bold bg-danger p-1 text-white"><b>'+kendo.toString(dataItem.scadenza, "d")+"</b></span>";
				}
				else
				{
					oggi.setMonth(oggi.getMonth()+1);
					if(dataInput<oggi)
					{
						return '<span class="text-bold bg-warning p-1"><b>'+kendo.toString(dataItem.scadenza, "d")+"</b></span>";
					}
					else if(dataItem.scadenza!=null)
					{
						return kendo.toString(dataItem.scadenza, "d");
					}
					else
						return '<span class="text-bold text-danger p-1 text-xs"><b>ASSENTE</b></span>';
				}

					}},
            { field: "matricola", title: "N.Matricola" , width:"8%"},
            { field: "taglia_kit", title: "Taglia" , width:"4%", template: "<b class='text-lg'>#= taglia_kit != null ? taglia_kit : '' #</b>"},
            { field: "pagato", title: "Quota" , width:"8%", template: "<b class='text-lg'>#= pagato != null ? kendo.toString(pagato, 'n2') + ' €' : '' #</b>"},
            { field: "id", title: "Az.", width:"15%", template: function(dataItem) {

                return '<a name="ricevuta" type="button" class="btn btn-sm btn-warning btn-table" id="'+dataItem.id+'" href="/giocatore/inserisciPagamento/'+dataItem.id+'" data-toggle="tooltip" data-placement="bottom" title="Pagamento"><i class="fas fa-cash-register"></i></a> ' +
'<button name="certificato" type="button" class="btn btn-sm btn-danger btn-table" id="'+dataItem.id+'" data-toggle="tooltip" data-placement="bottom" title="Certificato" onclick="inserisciCertificato('+dataItem.id+')"><i class="fas fa-diagnoses"></i></button> ' +
'<button name="tesseramento" onclick="inserisciTesseramento('+dataItem.id+')" type="button" class="btn btn-sm btn-success btn-table" id="'+dataItem.id+'" data-toggle="tooltip" data-placement="bottom" title="Tesseramento"><i class="fas fa-id-card"></i></button> ' +
'<a name="riepilogo" type="button" class="btn btn-sm btn-primary btn-table" id="'+dataItem.id+'" href="/giocatore/show/'+dataItem.idPlayer+'" data-toggle="tooltip" data-placement="bottom" title="Scheda Gioc."><i class="fas fa-file-invoice"></i></a>';
                }},
          ],
          pageable: true // Abilita la paginazione
        });
      });
    </script>

<script>
    function inserisciTesseramento(id)
    {
    var mat = prompt("Inserisci numero di matricola");
    $.post( "{{route('giocatore.modificaMatricola')}}", {
                          id: id,
                          mat: mat,
                          user_id: {{Auth::user()->id}}
                        })
                        .done(function( data ) {
                            $("#grid").data("kendoGrid").dataSource.read();
                            $('#grid').data('kendoGrid').refresh();
                                    });
    }

    function inserisciCertificato(id)
    {
        var dat = prompt("Inserisci data di scadenza", "gg/mm/aaaa");
        $.post( "{{route('giocatore.modificaCertificato')}}", {
                          id: id,
                          dat: dat,
                          user_id: {{Auth::user()->id}}
                        })
                        .done(function( data ) {
                            alert(data);
                            $("#grid").data("kendoGrid").dataSource.read();
                            $('#grid').data('kendoGrid').refresh();
                                    });
    }

    function eliminaIscrizione(id)
    {
        if(!confirm("Eliminare il giocatore selezionato?"))
            return 0;
        $.post( "{{route('giocatore.eliminaIscrizione')}}", {
            id: id,
            user_id: {{Auth::user()->id}}
        }).done(function( data ) {
                alert("Iscrizione Eliminata!")
                $("#grid").data("kendoGrid").dataSource.read();
                $('#grid').data('kendoGrid').refresh();
                        });
    }
</script>
@endsection


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div id="grid"></div>
        </div>
    </div>
</div>
@endsection
