
<link href="https://kendo.cdn.telerik.com/2021.3.1207/styles/kendo.common.min.css" rel="stylesheet" />
<link href="https://kendo.cdn.telerik.com/2021.3.1207/styles/kendo.default.min.css" rel="stylesheet" />

<script src="https://kendo.cdn.telerik.com/2021.3.1207/js/kendo.all.min.js"></script>

<script>
    function formatDate(dateString) {
                var date = new Date(dateString);
                var day = ("0" + date.getDate()).slice(-2);
                var month = ("0" + (date.getMonth() + 1)).slice(-2);
                var year = date.getFullYear();
                return day + '/' + month + '/' + year;
            }

function onSelectSearchBar(e) {
  //alert(e.dataItem.id);

 $.post( "{{route('giocatore.ottieni')}}", {
                          id: e.dataItem.id
                        })
                        .done(function( data ) {
                            $("#idSEARCH").attr("href","/giocatore/show/"+e.dataItem.id);
                            $("#cercaGiocatore").val(data['gio']['cognome']+" "+data['gio']['nome']);
                        });
}


$(document).ready(function(){
      $("#cercaGiocatore").kendoAutoComplete({
                  dataValueField:"id",
                  dataTextField:"ContactName",
                  headerTemplate: '<div class="dropdown-header">' +
                          '<span class="k-widget k-header">Giocatori</span>' +
                      '</div>',
                      template: kendo.template(
                    '<div class="autocomplete-item">' +
                    '    <img src="./../images/foto/player#= id #.jpg" width="50px" alt="NP" />' +
                    '    <span class="text-bold">#= cognome # #= nome #</span> - #= formatDate(data_nascita) #' +
                    '</div>'
                ),
                  filter: "contains",
                  minLength: 3,
                  select: onSelectSearchBar,
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

$(document).ready(function(){
    $.post( "{{route('giocatore.scadenze')}}", {
        id:0
    }).done(function( data ) {
        console.log(data);
        if(data['notess']>0)
        {
            var nodo='<span class="position-absolute top-20 start-80 translate-middle badge rounded-pill bg-orange">'+data['notess']+'</span>';
            $("#notess").append(nodo);
        }
        if(data['scaduti']>0)
        {
            var nodo='<span class="position-absolute top-20 start-80 translate-middle badge rounded-pill bg-danger">'+data['scaduti']+'</span>';
            $("#scaduto").append(nodo);
        }
        if(data['scadenza']>0)
        {
            var nodo='<span class="position-absolute top-20 start-80 translate-middle badge rounded-pill bg-warning">'+data['scadenza']+'</span>';
            $("#scadenza").append(nodo);
        }
    });

});
</script>

<nav class="main-header navbar navbar-expand navbar-dark text-sm">
    <!-- Left navbar links -->
    <ul class="navbar-nav nav-pills ">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      @yield('navigation')
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-md">
        <input class="form-control form-control-navbar form-control-sm" type="search" placeholder="Cerca Giocatore..." aria-label="Search" id="cercaGiocatore" size="40">
        <div class="input-group-append">
          <input type="hidden" value="-1">
          <a class="btn btn-secondary btn-sm" type="submit" id="idSEARCH" href="">
            <i class="fas fa-search"></i>
          </a>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <li class="nav-item dropdown d-sm-inline-block">
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="nuovoMessaggioDropdown" id="boxMes">
                <!-- Contenuto del dropdown -->
                <form class="px-1 py-1">
                    <div class="form-group">
                        <label for="recipient">Destinatario</label>
                        <select class="form-select form-select-sm" id="recipient">
                            <option value="-1">-----</option>
                            <!-- Aggiungi altre opzioni per selezionare il destinatario -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="messageText">Testo del Messaggio</label>
                        <textarea class="form-control form-control-sm" id="messageText" rows="3"></textarea>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="inviaMessaggio()">Invia</button>
                </form>
            </div>
        </li>



        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link" id="scadenza"><i class="fa-solid fa-stethoscope fa-xl"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link" id="scaduto"><i class="fa-solid fa-user-doctor fa-xl"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link" id="notess"><i class="fa-regular fa-id-card fa-xl"></i></a>
        </li>
      <!-- Messages Dropdown Menu -->
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>
      </li>



    <!-- Form Nascosto per il Logout -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    </ul>
  </nav>
