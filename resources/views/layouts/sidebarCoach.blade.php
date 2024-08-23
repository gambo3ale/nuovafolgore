<script>
$(document).ready(function () {
    $.post("{{route('allenatore.getCategorie')}}", {
                          id: {{Auth::user()->id}}
                        })
                        .done(function( data ) {
                            data.forEach(el => {
                                var nodo='<div class="card bg-transparent mt-2"><li class="nav-header">';
                                nodo+='<span class="text-warning text-bold text-lg">'+el['categoria']['categoria_estesa']+'</span></li>';
                                nodo+="<li class='nav-item'><a href='/allenatore/squadra/"+el['categoria']['id']+"' class='nav-link'><i class='fa-solid fa-users nav-icon fa-lg'></i> <p>Rosa</p></a></li>";
                                nodo+="<li class='nav-item'><a href='/giocatore/squadra/"+el['categoria']['id']+"' class='nav-link'><i class='fa-regular fa-futbol nav-icon fa-lg'></i> <p>Allenamenti</p></a></li>";
                                nodo+="<li class='nav-item'><a href='/giocatore/squadra/"+el['categoria']['id']+"' class='nav-link'><i class='fa-solid fa-trophy nav-icon fa-lg'></i> <p>Partite</p></a></li>";
                                nodo+='</div>';
                                $("#squadre").append(nodo);
                            });
                                    });
});
</script>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboardAllenatore') }}" class="brand-link">
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
        <a href="{{ route('dashboardAllenatore')}}" >{{Auth::user()->name}}</a>&emsp;&emsp;
      </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        @if(Auth::user()->hasRole('allenatore'))
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" id="squadre">

        </ul>
        @endif
    </nav>
</div>
</aside>
