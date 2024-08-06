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
            <div class="card bg-transparent">
                <li class="nav-header {{(request()->is('preventivo*')) ? 'bg-info rounded' : '' }}  {{(request()->is('lavoro*')) ? 'bg-info rounded' : '' }}" data-toggle="collapse" href="#collapseCom"><i class="fa-solid fa-bag-shopping"></i>&emsp;COMMERCIALE</li>
                <div class=" collapse" id="collapseCom">
                  <li class="nav-item has-treeview ">
                    <a href="#" class="nav-link">
                        <i class="fas fa-calculator"></i>
                    <p class="left"> Preventivi</p>
                        <i class="right fas fa-angle-left"></i>

                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                      <a href="#" class="nav-link {{ Request::is('CRM.Task') ? 'active' : '' }}">
                        <i class="fas fa-list-ol nav-icon"></i>
                          <p>Elenco</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-file-medical nav-icon"></i>
                          <p>Nuovo</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa-solid fa-file-circle-plus nav-icon"></i>
                          <p>Preventivatore</p>
                        </a>
                      </li>
                    </ul>

                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link {{ Request::is('lavoro') ? 'active' : '' }}">
                        <i class="fa-solid fa-headset nav-icon"></i>
                      <p>Commesse</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-user-secret nav-icon"></i>
                      <p>C.R.M.</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-chart-column nav-icon"></i>
                      <p>Costo CER</p>
                    </a>
                  </li>
              <li class="nav-item">
                <a href="#" class="nav-link {{ Request::is('lavoro.amministratori') ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar-day nav-icon"></i>
                  <p>Calendarizzazioni</p>
                </a>
              </li>
                </div>
              </div>
        </ul>
    </nav>
</div>
</aside>
