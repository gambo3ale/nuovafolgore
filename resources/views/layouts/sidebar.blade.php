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
                    <i class="fa-regular fa-pen-to-square nav-icon"></i>
                  <p>Iscrizioni</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('giocatore.listaIscritti')}}" class="nav-link">
                    <i class="fa-solid fa-users nav-icon"></i>
                  <p>Lista Iscritti</p>
                </a>
              </li>
              <li class="nav-item has-treeview ">
                <a href="]" class="nav-link">
                    <i class="fa-solid fa-folder-tree nav-icon"></i>
                <p class="left"> Archivio</p>
                    <i class="right fas fa-angle-left"></i>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                  <a href="{{route('admin.archivioIscritti')}}" class="nav-link {{ Request::is('admin.archivioIscritti') ? 'active' : '' }}">
                    <i class="fa-solid fa-users nav-icon"></i>
                      <p>Iscritti</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('admin.archivioRicevute')}}" class="nav-link">
                        <i class="fa-solid fa-file-invoice nav-icon"></i>
                      <p>Ricevute</p>
                    </a>
                  </li>
                </ul>

              </li>
        </ul>
    </nav>
</div>
</aside>
