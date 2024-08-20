@extends('layouts.main')

@section('title', 'Calendario Partite')

@section('style')
<link href="https://kendo.cdn.telerik.com/themes/8.0.1/default/default-main.css" rel="stylesheet" />
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.3.1207/styles/kendo.common.min.css" />
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.3.1207/styles/kendo.default.min.css" />
<style>
    #calendar {
    max-width: 100%; /* Imposta la larghezza massima */
    max-height: 85vh; /* Imposta l'altezza massima */
    margin: 0 auto;    /* Centra il calendario */
    overflow-y: auto;  /* Abilita lo scrolling verticale */
}
</style>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2023.1.117/js/jszip.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2021.3.1207/js/kendo.all.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2022.1.119/js/kendo.timezones.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2022.1.119/js/cultures/kendo.culture.it-IT.min.js"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek', // Vista settimanale predefinita
        locale: 'it',  // Imposta la lingua italiana
        headerToolbar: {
            left: 'prev,next today', // Controlli per navigazione
            center: 'title',         // Mostra il titolo (es. Agosto 2024)
            right: 'dayGridDay,timeGridWeek' // Opzioni per vista giornaliera e settimanale
        },
        height: 'auto',
        slotMinTime: '08:00:00',  // Ora di inizio
        slotMaxTime: '20:00:00',  // Ora di fine
        events: function(fetchInfo, successCallback, failureCallback) {
            $.ajax({
                url: "{{ route('partita.getPartite') }}",
                dataType: 'json',
                success: function(data) {
                    var events = data.map(function(item) {
                        return {
                            id: item.id,
                            title: item.sigla + " vs " + item.avversario,
                            start: item.start,
                            end: item.end,
                            backgroundColor: item.id_campo == 1 ? '#CCFFCC' : item.id_campo == 2 ? '#FFFFCC' : '#CCFFFF',
                            extendedProps: {
                                campo: item.campo,
                                sigla: item.sigla,
                                avversario: item.avversario,
                                id_campo: item.id_campo,
                                campionato: item.campionato,
                                data: item.data, // Aggiunge la data
                                ora: item.ora
                            }
                        };
                    });
                    successCallback(events);
                }
            });
        },
        eventClick: function(info) {
            // Gestione del doppio clic sull'evento
            if (info.jsEvent.detail === 2) { // 2 = doppio clic
                $('#editEventModal').modal('show');
                // Popola i campi del form con i dati dell'evento
                $('#eventId').val(info.event.id);
                $('#eventTitle').val(info.event.extendedProps.avversario);
                $('#eventCampo').val(info.event.extendedProps.campo);
                $('#eventDate').val(info.event.extendedProps.data);
                $('#eventTime').val(info.event.extendedProps.ora);
            }
        },
        eventContent: function(arg) {
            let currentView = arg.view.type;
            let bgColorClass = '';

            // Definizione dei colori in base alla sigla
            switch(arg.event.extendedProps.sigla) {
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

            let innerHtml = '';
            if (currentView === 'timeGridWeek') {
                innerHtml = `
                    <div class="template-container">
                        <div class="row m-1">
                            <div class="col-2 text-bold text-sm text-center ${bgColorClass}">
                                ${arg.event.extendedProps.sigla}
                            </div>
                            <div class="col-9">
                                <span class="text-bold text-xs text-primary ">${arg.event.extendedProps.avversario}</span><br>
                                <span class="text-xs text-muted">${arg.event.extendedProps.ora}</span>
                            </div>
                        </div>
                    </div>
                `;
            } else if (currentView === 'dayGridDay') {
                innerHtml = `
                    <div class="template-container">
                        <div class="row m-1">
                            <div class="col-2 text-bold text-md text-center ${bgColorClass}">
                                ${arg.event.extendedProps.sigla}
                            </div>
                            <div class="col-9">
                                <span class="text-bold text-md text-primary ">${arg.event.extendedProps.avversario}</span><br>
                                <span class="text-md text-primary ">${arg.event.extendedProps.campo}</span><br>
                                <span class="text-md text-muted">${arg.event.extendedProps.ora}</span>
                            </div>
                        </div>
                    </div>
                `;
            }

            let customEl = document.createElement('div');
            customEl.innerHTML = innerHtml;

            return { domNodes: [customEl] };
        }
    });

    calendar.render();
});
</script>



@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div id="scheduler"></div>
            <div id="calendar"></div>
        </div>
    </div>
</div>


<!-- Modale per modificare l'evento -->
<div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editEventModalLabel">Modifica Evento</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editEventForm">
            <input type="hidden" id="eventId">
            <div class="mb-3">
              <label for="eventTitle" class="form-label">Avversario</label>
              <input type="text" class="form-control" id="eventTitle">
            </div>
            <div class="mb-3">
              <label for="eventCampo" class="form-label">Campo</label>
              <input type="text" class="form-control" id="eventCampo">
            </div>
            <div class="mb-3">
              <label for="eventDate" class="form-label">Data</label>
              <input type="date" class="form-control" id="eventDate">
            </div>
            <div class="mb-3">
              <label for="eventTime" class="form-label">Ora</label>
              <input type="time" class="form-control" id="eventTime">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
          <button type="button" class="btn btn-primary" id="saveEventBtn">Salva modifiche</button>
        </div>
      </div>
    </div>
  </div>
@endsection
