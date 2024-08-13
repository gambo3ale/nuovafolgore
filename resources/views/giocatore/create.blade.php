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
    function onSelect2(e) {
  //alert(e.dataItem.id);

 $.post( "{{route('giocatore.ottieni')}}", {
                          id: e.dataItem.id
                        })
                        .done(function( data ) {
                            console.log(data);
                            $("#id_giocatore").val(data['gio']['id']);

                            $("#cognome_giocatore").val(data['gio']['cognome']);
                            $("#nome_giocatore").val(data['gio']['nome']);
                            $("#data_giocatore").val(data['gio']['data_nascita']);
                            $("#luogo_giocatore").val(data['gio']['luogo_nascita']);
                            $("#codice_giocatore").val(data['gio']['codice_fiscale']);
                            $("#comune_giocatore").val(data['gio']['comune']);
                            $("#indirizzo_giocatore").val(data['gio']['indirizzo']);
                            $("#cap_giocatore").val(data['gio']['cap']);
                            $("#provincia_giocatore").val(data['gio']['provincia']);
                            $("#telefono_giocatore").val(data['gio']['telefono']);
                            $("#email_giocatore").val(data['gio']['email']);

                            $("#cognome_genitore").val(data['gio']['genitore']['cognome']);
                            $("#nome_genitore").val(data['gio']['genitore']['nome']);
                            $("#data_genitore").val(data['gio']['genitore']['data_nascita']);
                            $("#luogo_genitore").val(data['gio']['genitore']['luogo_nascita']);
                            $("#codice_genitore").val(data['gio']['genitore']['codice_fiscale']);
                            $("#comune_genitore").val(data['gio']['genitore']['comune']);
                            $("#indirizzo_genitore").val(data['gio']['genitore']['indirizzo']);
                            $("#cap_genitore").val(data['gio']['genitore']['cap']);
                            $("#provincia_genitore").val(data['gio']['genitore']['provincia']);
                            $("#telefono_genitore").val(data['gio']['genitore']['telefono']);
                            $("#email_genitore").val(data['gio']['genitore']['email']);

                            if(data['sp']!=null)
                            {
                                $("#messaggio").text("ATTENZIONE! Giocatore già iscritto per la stagione sportiva corrente!!");
                                $("#salva").prop("disabled", true);
                                $("#stampa").prop("disabled", false);
                            }
                            else
                            {
                                $("#messaggio").text("");
                                $("#salva").prop("disabled", false);
                                $("#stampa").prop("disabled", true);
                            }
                                    });


};
</script>
<script>
    function formatDate(dateString) {
                var date = new Date(dateString);
                var day = ("0" + date.getDate()).slice(-2);
                var month = ("0" + (date.getMonth() + 1)).slice(-2);
                var year = date.getFullYear();
                return day + '/' + month + '/' + year;
            }

  $(document).ready(function(){
      $("#giocatore").kendoAutoComplete({
                  dataValueField:"id",
                  dataTextField:"ContactName",
                  headerTemplate: '<div class="dropdown-header">' +
                          '<span class="k-widget k-header">Giocatori</span>' +
                      '</div>',
                      template: kendo.template(
                    '<div class="autocomplete-item">' +
                    '    <img src="./../images/foto/player#= id #.jpg" alt="NP" />' +
                    '    <span class="text-bold">#= cognome # #= nome #</span> - #= formatDate(data_nascita) #' +
                    '</div>'
                ),
                  filter: "contains",
                  minLength: 3,
                  select: onSelect2,
                  dataSource: {
                      dataType: "json",
                      serverFiltering: true,
                      transport: {
                          read: "{{route('giocatore.cerca')}}",
                          //dataType: 'json'
                      }
                  },
                  schema: {
                          parse: function(response) {
                              console.log(response)
                              $.each(response, function(idx, elem) {
                              elem.ContactName = elem.cognome + " " + elem.nome+" - "+elem.data_nascita;

                              });
                              return response;
                          }
                      }
              });
          });

          $("#salvaIscrizione").submit(function(event){
            event.preventDefault();
            $.post( "{{route('giocatore.store')}}", {
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

          $("#stampa").click(function(event){
            event.preventDefault();
            alert("stampa");
            $.post( "{{route('document.moduloIscrizione')}}", {
                            id_giocatore: $("#id_giocatore").val(),
                            id_stagione: $("#id_stagione").val(),
                        })
                        .done(function( data ) {
                            alert('Modulo creato!');
                            $("#salva").prop("disabled", true);
                            $("#stampa").prop("disabled", false);
                            if (data.url) {
                                var link = document.createElement('a');
                                link.href = data.url;
                                link.download = 'modulo_iscrizione.pdf';
                                document.body.appendChild(link);
                                link.click();
                                document.body.removeChild(link);
                            }
                        });
          })
      </script>
@endsection


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h3><b>Nuova Iscrizione per {{$data['stag']->descrizione}}</b></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-3">In caso di rinnovo, ricerca qua il giocatore:</div>
        <div class="col-4">
            <input type="text" class="form-control" id="giocatore">

        </div>
        <div class="col-4">
            <span class="text-danger text-lg text-bold" id="messaggio"></span>
        </div>
    </div>
    <form id="salvaIscrizione">
    <div class="row mt-5">
        <input type="hidden" id="id_giocatore" value="-1" name="id_giocatore">
        <input type="hidden" id="id_stagione" value="{{$data['stag']->id}}" name="id_stagione">
        <div class="col-6 border border-dark table-warning pt-3 pb-5">
            <h4><b>Genitore o chi ne fa le veci (PER DETRAZIONE)</b></h4>
            <div class="row mt-3">
                <div class="col-6">
                    <div class="form-group">
                        <label>Cognome</label>
                        <input type="text" class="form-control" id="cognome_genitore" name="cognome_genitore">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" class="form-control" id="nome_genitore" name="nome_genitore">
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-4">
                    <div class="form-group">
                        <label>Data di Nascita</label>
                        <input type="date" class="form-control" id="data_genitore" name="data_genitore">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label>Luogo di Nascita</label>
                        <input type="text" class="form-control" id="luogo_genitore" name="luogo_genitore">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label>Codice Fiscale</label>
                        <input type="text" class="form-control" id="codice_genitore" name="codice_genitore">
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-4">
                    <label>Residente a</label>
                    <input type="text" class="form-control" id="comune_genitore" name="comune_genitore">
                </div>
                <div class="col-4">
                    <label>Indirizzo</label>
                    <input type="text" class="form-control" id="indirizzo_genitore" name="indirizzo_genitore">
                </div>
                <div class="col-2">
                    <label>CAP</label>
                    <input type="text" class="form-control" id="cap_genitore" name="cap_genitore">
                </div>
                <div class="col-2">
                    <label>Prov</label>
                    <input type="text" class="form-control" id="provincia_genitore" name="provincia_genitore">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6">
                    <div class="form-group">
                        <label>Telefono</label>
                        <input type="text" class="form-control" id="telefono_genitore" name="telefono_genitore">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" id="email_genitore" name="email_genitore">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 border border-dark">
            <h4><b>Dati del minore</b></h4>
            <div class="row mt-3">
                <div class="col-6">
                    <div class="form-group">
                        <label>Cognome</label>
                        <input type="text" class="form-control" id="cognome_giocatore" name="cognome_giocatore">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" class="form-control" id="nome_giocatore" name="nome_giocatore">
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-4">
                    <div class="form-group">
                        <label>Data di Nascita</label>
                        <input type="date" class="form-control" id="data_giocatore" name="data_giocatore">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label>Luogo di Nascita</label>
                        <input type="text" class="form-control" id="luogo_giocatore" name="luogo_giocatore">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label>Codice Fiscale</label>
                        <input type="text" class="form-control" id="codice_giocatore" name="codice_giocatore">
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-4">
                    <label>Residente a</label>
                    <input type="text" class="form-control" id="comune_giocatore" name="comune_giocatore">
                </div>
                <div class="col-4">
                    <label>Indirizzo</label>
                    <input type="text" class="form-control" id="indirizzo_giocatore" name="indirizzo_giocatore">
                </div>
                <div class="col-2">
                    <label>CAP</label>
                    <input type="text" class="form-control" id="cap_giocatore" name="cap_giocatore">
                </div>
                <div class="col-2">
                    <label>Prov</label>
                    <input type="text" class="form-control" id="provincia_giocatore" name="provincia_giocatore">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6">
                    <div class="form-group">
                        <label>Telefono</label>
                        <input type="text" class="form-control" id="telefono_giocatore" name="telefono_giocatore">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" id="email_giocatore" name="email_giocatore">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-4">
            <button class="btn btn-success btn-lg" id="salva" type="submit"><i class="fa-regular fa-floppy-disk"></i>&emsp;Salva Iscrizione</button>
        </div>
        <div class="col-4">
            <button class="btn btn-primary btn-lg" id="stampa" disabled><i class="fa-regular fa-floppy-disk"></i>&emsp;Stampa Modulo</button>
        </div>
    </div>
    </form>
</div>
@endsection
