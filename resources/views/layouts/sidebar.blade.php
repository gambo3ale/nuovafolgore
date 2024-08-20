<script>
$(document).ready(function () {
    $.post("{{route('admin.getCategorie')}}", {
                          id: 0
                        })
                        .done(function( data ) {
                            data.forEach(el => {
                                var nodo="<li class='nav-item'><a href='/giocatore/squadra/"+el['id']+"' class='nav-link'><i class='fa-regular fa-flag nav-icon fa-lg'></i><p>";
                                    nodo+=el['categoria_estesa']+"</p></a></li>";
                                    $("#squadre").append(nodo);
                            });
                                    });
});
</script>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
      <img src="/dist/img/logo.png" class="brand-image">
      <span class="brand-text font-weight-light"><b>A.C. Nuova Folgore</b></span>
    </a>

<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="/dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="{{ route('dashboard')}}" >{{Auth::user()->name}}</a>&emsp;&emsp;
        <a href="#">
          <span class="btn btn-md btn-trasparent text-white border-white position-relative" id="eventi"><i class="far fa-calendar-alt fa-bounce fa-lg"></i>
        </a>
      </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{route('giocatore.create')}}" class="nav-link">
                    <i class="fa-regular fa-pen-to-square nav-icon fa-lg"></i>
                  <p>Iscrizioni</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('giocatore.listaIscritti')}}" class="nav-link">
                    <i class="fa-solid fa-users nav-icon fa-lg"></i>
                  <p>Lista Iscritti</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.listaRicevute')}}" class="nav-link">
                    <i class="fa-solid fa-file-invoice nav-icon fa-lg"></i>
                  <p>Ricevute</p>
                </a>
              </li>

              <li class="nav-item has-treeview">
                <a href="]" class="nav-link">
                    <i class="fa-solid fa-people-group nav-icon fa-lg"></i>
                <p class="left"> Squadre</p>
                    <i class="right fas fa-angle-left"></i>
                </a>
                <ul class="nav nav-treeview" id="squadre">

                </ul>

              </li>

              <li class="nav-item has-treeview">
                <a href="]" class="nav-link">
                    <i class="fa-solid fa-chalkboard-user nav-icon fa-lg"></i>
                <p class="left"> Staff</p>
                    <i class="right fas fa-angle-left"></i>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('staff.index')}}" class="nav-link">
                            <i class="fa-regular fa-address-book nav-icon fa-lg"></i>
                          <p>Lista Staff</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{route('staff.create')}}" class="nav-link">
                            <i class="fa-solid fa-user-plus nav-icon fa-lg"></i>
                          <p>Aggiungi Membro</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{route('staff.registra')}}" class="nav-link">
                            <i class="fa-solid fa-business-time nav-icon fa-lg"></i>
                          <p>Registra Membro</p>
                        </a>
                      </li>
                </ul>

              </li>

              <li class="nav-item has-treeview">
                <a href="]" class="nav-link">
                    <i class="fa-regular fa-futbol nav-icon fa-lg"></i>
                <p class="left"> Partite</p>
                    <i class="right fas fa-angle-left"></i>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('partita.create')}}" class="nav-link">
                            <i class="fa-regular fa-square-plus nav-icon fa-lg"></i>
                          <p>Aggiungi</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{route('partita.calendario')}}" class="nav-link">
                            <i class="fa-regular fa-calendar-days nav-icon fa-lg"></i>
                          <p>Calendario</p>
                        </a>
                      </li>
                </ul>

              </li>

              <li class="nav-item has-treeview text-warning">
                <a href="]" class="nav-link">
                    <i class="fa-solid fa-folder-tree nav-icon text-warning"></i>
                <p class="left text-warning"> Archivio</p>
                    <i class="right fas fa-angle-left text-warning"></i>
                </a>
                <ul class="nav nav-treeview table-warning">
                  <li class="nav-item text-warning table-warning">
                  <a href="{{route('admin.archivioIscritti')}}" class="nav-link {{ Request::is('admin.archivioIscritti') ? 'active' : '' }}">
                    <i class="fa-solid fa-users nav-icon fa-lg table-warning"></i>
                      <p class="table-warning">Iscritti</p>
                    </a>
                  </li>
                  <li class="nav-item text-warning table-warning">
                    <a href="{{route('admin.archivioRicevute')}}" class="nav-link">
                        <i class="fa-solid fa-file-invoice nav-icon fa-lg table-warning"></i>
                      <p class="table-warning">Ricevute</p>
                    </a>
                  </li>
                </ul>

              </li>


              @if(Auth::user()->id==1)
              <li class="nav-item has-treeview text-info">
                <a href="]" class="nav-link">
                    <i class="fa-solid fa-crown nav-icon text-info"></i>
                <p class="left text-info"> Amministratore</p>
                    <i class="right fas fa-angle-left text-info"></i>
                </a>
                <ul class="nav nav-treeview table-primary">
                  <li class="nav-item text-info table-primary">
                  <a href="{{route('gambo.index')}}" class="nav-link {{ Request::is('gambo.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-users nav-icon fa-lg table-primary"></i>
                      <p class="table-primary">Utenti e Log</p>
                    </a>
                  </li>
                  <li class="nav-item text-warning table-primary">
                    <a href="{{route('gambo.campi')}}" class="nav-link">
                        <i class="fa-solid fa-building-flag nav-icon fa-lg table-primary"></i>
                      <p class="table-primary">Impianti e Squadre</p>
                    </a>
                  </li>
                </ul>

              </li>
              @endif
        </ul>
    </nav>
</div>
</aside>
