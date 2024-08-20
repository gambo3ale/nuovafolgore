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
                        $.post( "{{route('staff.listaStagione')}}", {
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
                  idStaff: {field:"id_staff", type: "number" },
                  anno: {field:"anno_nascita", type: "number" },
                  cognome: {field: "cognome", type:"string"},
                  nome: {field: "nome", type:"string"},
                  telefono: {field: "telefono", type:"string"},
                  email: {field: "email", type:"string"},
                  taglia_kit: {field: "taglia_kit", type:"string"},
                  nascita: {field: "data_nascita", type:"date"},
                  qualifica: {field: "qualifica", type:"string"},
                  matricola: {field: "matricola", type:"string"},
                  categorie_estese: {field: "categorie_estese", type:"string"},
                  sigle: {field: "sigle", type:"string"},
                  ruolo: {field: "ruolo", type: "string" }
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
			{ field: "idStaff",	title: "Foto",	template: '<img src="./../images/foto/staff#= idStaff #.jpg" alt="NP" width="40" height="50" />'},
            { field: "cognome", title: "Cognome" , width:"12%", template: "<b>#: cognome#</b>"},
            { field: "nome", title: "Nome" , width:"12%"},
            { field: "nascita", title: "Data Nascita", format: "{0:dd/M/yyyy}" , width:"6%"},
            { field: "telefono", title: "Telefono" , width:"6%"},
            { field: "email", title: "Email" , width:"12%"},
            { field: "taglia_kit", title: "Taglia" , width:"4%", template: "<b class='text-lg'>#: taglia_kit#</b>"},
            { field: "matricola", title: "N.Matricola" , width:"8%"},
            { field: "qualifica", title: "Qualifica" , width:"8%"},
            { field: "ruolo", title: "Ruolo" , width:"8%"},
            { field: "categorie_estese", title: "Categoria" , width:"12%", template: function(dataItem){
                if(dataItem.sigle!=null)
                {
                    let str="";
                    let sigle=dataItem.sigle.split(', ');
                    let categorie=dataItem.categorie_estese.split(', ');
                    if(sigle!=null)
                    {
                        for(var i=0; i<sigle.length; i++)
                        {
                            let bgColorClass="";
                            switch(sigle[i]) {
                            case "A08":
                                bgColorClass = 'bg-danger';
                                break;
                            case "A09":
                                bgColorClass = 'bg-orange';
                                break;
                            case "G10":
                                bgColorClass = 'bg-warning';
                                break;
                            case "G11":
                                bgColorClass = 'bg-success';
                                break;
                            case "E12":
                                bgColorClass = 'bg-primary';
                                break;
                            case "E13":
                                bgColorClass = 'bg-info';
                                break;
                            case "P14":
                                bgColorClass = 'bg-indigo';
                                break;
                            case "P15":
                                bgColorClass = 'bg-pink';
                                break;
                            case "PC":
                                bgColorClass = 'bg-dark';
                                break;
                            case "PA":
                                bgColorClass = 'bg-secondary';
                                break;
                            }
                            str+="<span class='p-1 rounded-3 text-bold "+bgColorClass+"'>"+categorie[i]+"</span><br>";
                        }
                    }

                return str;
                }
                else
                    return "";
            }},
            { field: "id", title: "Az.", width:"5%", template: function(dataItem) {
                return '<a name="riepilogo" type="button" class="btn btn-sm btn-primary btn-table" id="'+dataItem.idStaff+'" href="/giocatore/show/'+dataItem.idStaff+'" data-toggle="tooltip" data-placement="bottom" title="Scheda Staff"><i class="fas fa-file-invoice"></i></a>';
                }},
          ],
          pageable: true // Abilita la paginazione
        });
      });
    </script>

<script>
    function eliminaIscrizione(id)
    {
        if(!confirm("Eliminare il giocatore selezionato?"))
            return 0;
        $.post( "{{route('staff.eliminaIscrizione')}}", {
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
