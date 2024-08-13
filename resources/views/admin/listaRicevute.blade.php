@extends('layouts.main')

@section('title', 'Archivio Ricevute')

@section('style')
<link href="https://kendo.cdn.telerik.com/themes/8.0.1/default/default-main.css" rel="stylesheet" />
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.3.1207/styles/kendo.common.min.css" />
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.3.1207/styles/kendo.default.min.css" />
<style>
    .k-grid {
    font-size: 16px;
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

      var id={{$data['cor']->id}};
      kendo.culture("it-IT");
      $(document).ready(function () {
        $("#grid").kendoGrid({
          dataSource: {
            transport: {
              read: function(options)
                    {
                        $.post( "{{route('giocatore.ricevuteStagione')}}", {
                          id: id
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
				  id_season_player: {field:"id_season_player", type: "number" },
                  anno: {field:"anno", type: "number" },
                  numero: {field:"numero", type: "number" },
                  dataR: {field: "data", type:"date"},
                  dataBon: {field: "data_bonifico", type:"date"},
                  cognome: {field: "cognome_giocatore", type:"string"},
                  codice: {field: "codice_giocatore", type:"string"},
                  nome: {field: "nome_giocatore", type:"string"},
                  telefono: {field: "telefono", type:"string"},
                  telefono_genitore: {field: "telefono_genitore", type:"string"},
                  nascita: {field: "data_giocatore_n", type:"date"},
                  tipo: {field: "tipo", type: "number" },
                  importo: {field: "importo", type: "number" },
                  intestato: {field: "intestato", type: "number" },
                  bonifico: {field: "bonifico", type: "number" }
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
                fields: ["cognome","nome"] // Or, specify multiple fields by adding them to the array, e.g ["name", "age"]<i class="fa-solid fa-circle-check text-success"></i>
            },
            excel: {
                fileName: "ricevute.xlsx",
                proxyURL: "https://demos.telerik.com/kendo-ui/service/export",
                filterable: true,
                allPages: true
            },
          columns: [
            { field: "numero", title: "Num.", width:"5%",  filterable: { multi: true } },
            { field: "anno", title: "Anno", width:"5%",  filterable: { multi: true } },
            { field: "dataR", title: "Data", format: "{0:dd/M/yyyy}" , width:"8%"},
            { field: "cognome", title: "Cognome" , width:"15%"},
            { field: "nome", title: "Nome" , width:"15%"},
            { field: "codice", title: "Codice Fiscale" , width:"15%"},
            { field: "nascita", title: "Data Nascita", format: "{0:dd/M/yyyy}" , width:"8%"},
            { field: "importo", title: "Importo", format:"{0:c2}" , width:"8%"},
            { field: "bonifico", title: "C/B", width:"5%", template: function(dataItem) {
				if(dataItem.bonifico==0)
				{
					return '<i style="color:green" class="fas fa-money-bill-wave"></i>';
				}
				else if(dataItem.bonifico==1)
				{
					return '<i style="color:navy" class="fas fa-money-check-alt"></i>';
				}
				else if(dataItem.bonifico==3)
				{
					return '<i style="color:red" class="fas fa-file-invoice-dollar"></i>';
				}
				else
					return '<i style="color:coral" class="far fa-credit-card"></i>';

                }},
            { field: "dataBon", title: "Data Pagamento", format: "{0:dd/M/yyyy}" , width:"8%"},
            { field: "intestato", title: "Int.", width:"5%", template: function(dataItem) {
				if(dataItem.intestato==0)
					return '';
				else
					return '<i style="color:darkorange" class="far fa-copyright"></i>';

            }},
            { field: "tipo", title: "MJC", width:"5%", template: function(dataItem) {
				if(dataItem.tipo==3)
					return '<i class="fab fa-markdown" style="color:red"></i>';
				else
					return '';
            }},
            { field:"id",title:"",width:"3%",template:function(dataItem){
            var x=new Date(dataItem.dataR);
            var strDR=x.getFullYear()+"-"+(x.getMonth()*1+1)+"-"+x.getDate();
            var y=new Date(dataItem.dataBon);
            var strDB=y.getFullYear()+"-"+(y.getMonth()*1+1)+"-"+y.getDate();
            return '<button type="button" class="btn btn-xs btn-warning" data-bs-toggle="modal" data-bs-target="#modRic" onclick="modificaRicevuta('+dataItem.id+','+dataItem.numero+',`'+kendo.toString(dataItem.dataR, "yyyy-MM-dd")+'`,`'+kendo.toString(dataItem.dataBon, "yyyy-MM-dd")+'`)" ><i class="far fa-edit"></i></button>';
            }},
            { field:"id",title:"",width:"3%",template:function(dataItem){
                return '<button type="button" class="btn btn-xs btn-success" onclick="stampaRicevuta(event,'+dataItem.id+')"><i class="fa-solid fa-print"></i></button>';
            }},
          ],
        });
      });


function modificaRicevuta(id,num,dataR,dataBon)
{
    $("#idR").val(id);
    $("#nR").val(num);
    $("#eR").val(dataR);
    $("#pR").val(dataBon);
   // var modal = document.getElementById('modRic');
    //    modal.style.display = 'block';
    $("#modRic").modal('show');
}

function salvaModifiche()
{
	$.post( "{{route('admin.modificaRicevuta')}}", {
                    id: $("#idR").val(),
					num: $("#nR").val(),
					dataR: $("#eR").val(),
					dataB: $("#pR").val()
                    })
                    .done(function( data ) {
						alert("RICEVUTA MODIFICATA!");
                        $("#grid").data("kendoGrid").dataSource.read();
						$("#modRic").modal('hide');
                    });
}

function stampaRicevuta(ev,id)
{
    ev.preventDefault();
    $.post( "{{route('document.stampaRicevuta')}}", {
                        id: id
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
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h4><b><i class="fa-solid fa-file-invoice fa-lg"></i>&ensp;Elenco Ricevute - {{$data['cor']->descrizione}}</b></h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div id="grid"></div>
        </div>
    </div>
</div>

	<!-- Modal -->
    <div class="modal" id="modRic" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modifica Ricevuta</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="chiudiModal()"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                  <input type="hidden" id="idR" value="-1">
                  <div class="row">
                      <div class="col-6">Numero:</div>
                      <div class="col-6"><input type="number" class="form-control" id="nR"></div>
                  </div>
                  <div class="row">
                      <div class="col-6">Emessa il:</div>
                      <div class="col-6"><input type="date" class="form-control" id="eR"></div>
                  </div>
                  <div class="row">
                      <div class="col-6">Pagato il:</div>
                      <div class="col-6"><input type="date" class="form-control" id="pR"></div>
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" onclick="chiudiModal()" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="salvaModifiche()">Salva Modifiche</button>
            </div>
          </div>
        </div>
      </div>
@endsection
