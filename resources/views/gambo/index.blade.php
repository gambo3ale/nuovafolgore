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
    var idUtente={{$data['id_ut']}}
    function visualizzaLog(id)
    {
        idUtente=id;
        var grid = $("#grid").data("kendoGrid");
        // Ricarica i dati della Grid
        grid.dataSource.read();
        grid.refresh();
    }
</script>
<script>

    kendo.culture("it-IT");
    $(document).ready(function () {
        $("#grid").kendoGrid({
          dataSource: {
            transport: {
              read: function(options)
                    {
                        $.post( "{{route('gambo.visualizzaLog')}}", {
                          id: idUtente
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
                  cognome: {field: "cognome_giocatore", type:"string"},
                  nome: {field: "nome_giocatore", type:"string"},
                  azione: {field: "azione", type:"string"},
                  data_azione: {field: "created_at", type:"date"},
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
                fileName: "log.xlsx",
                proxyURL: "https://demos.telerik.com/kendo-ui/service/export",
                filterable: true,
                allPages: true
            },
          columns: [
            { field: "id", title: "ID", width:"5%",  filterable: { multi: true } },
            { field: "id_season_player", title: "ID_sp", width:"5%",  filterable: { multi: true } },
            { field: "cognome", title: "Cognome" , width:"15%"},
            { field: "nome", title: "Nome" , width:"15%"},
            { field: "azione", title: "Azione" , width:"40%"},
            { field: "data_azione", title: "Data", format: "{0:dd/M/yyyy}" , width:"10%"},
          ],
        });
      });
        </script>
@endsection


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-4">
            <table class="table-sm table-striped">
                <thead><th>ID</th><th>Name</th><th>Email</th><th>Stato</th><th>Ultimo Accesso</th><th></th></thead>
                <tbody>
                    @foreach ($data['user'] as $u)
                        <tr>
                            <td>{{ $u['id'] }}</td>
                            <td>{{ $u['name'] }}</td>
                            <td>{{ $u['email'] }}</td>
                            <td>
                                @if($u['isOnline'])
                                    <span class="text-bold text-success">Online</span>
                                @else
                                    <span class="text-bold text-danger">Offline</span>
                                @endif
                            </td>
                            <td>{{ $u['lastSeen'] }}</td>
                            <td><button class="btn btn-primary" onclick="visualuizzaLog({{$u['id']}})"><i class="fa-solid fa-receipt"></i></button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-8">
            <div id="grid"></div>
        </div>
    </div>
</div>
@endsection
