@extends('layouts.app')

@section('title', 'Panel de Pasante - ' . $intern->name)

@section('content')
<div class="mb-6 flex items-center gap-4">
    <a href="{{ route('interns.index') }}" class="text-gray-500 hover:text-primary transition-colors">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    </a>
    <h1 class="text-3xl font-bold text-gray-900">{{ $intern->name }}</h1>
</div>

<!-- Dashboard Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="glass-card p-6 border-l-4 border-primary">
        <h3 class="text-gray-500 text-sm font-semibold uppercase tracking-wider mb-2">Meta de Horas</h3>
        <p class="text-3xl font-bold text-gray-900">{{ $intern->max_hours }} hrs</p>
    </div>
    
    <div class="glass-card p-6 border-l-4 border-green-500">
        <h3 class="text-gray-500 text-sm font-semibold uppercase tracking-wider mb-2">Horas Realizadas</h3>
        <p class="text-3xl font-bold text-green-600" id="stat-logged">{{ $logged_hours }} hrs</p>
    </div>

    <div class="glass-card p-6 border-l-4 border-accent">
        <h3 class="text-gray-500 text-sm font-semibold uppercase tracking-wider mb-2">Horas Restantes</h3>
        <p class="text-3xl font-bold text-accent" id="stat-remaining">{{ $remaining_hours }} hrs</p>
    </div>
</div>

<!-- Progress Bar -->
<div class="glass-card p-6 mb-8">
    <div class="flex justify-between mb-2">
        <span class="text-sm font-semibold text-gray-700">Progreso</span>
        <span class="text-sm font-semibold text-gray-700" id="stat-percent">{{ $intern->max_hours > 0 ? round(($logged_hours / $intern->max_hours) * 100, 1) : 0 }}%</span>
    </div>
    <div class="w-full bg-gray-200 rounded-full h-4 dark:bg-gray-700 overflow-hidden">
        <div id="progress-bar" class="bg-primary h-4 rounded-full transition-all duration-500 ease-out" style="width: {{ $intern->max_hours > 0 ? min(($logged_hours / $intern->max_hours) * 100, 100) : 0 }}%"></div>
    </div>
</div>

<!-- Calendar Area -->
<div class="glass-card p-6">
    <h2 class="text-xl font-bold text-gray-900 mb-4">Registro de Actividades</h2>
    <div id="calendar"></div>
</div>

<!-- Tailwind Modal for Event -->
<div id="event-modal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full backdrop-blur-sm transition-opacity" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</div>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Registrar Horas</h3>
                    <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Cerrar</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                
                <form id="log-form">
                    <input type="hidden" id="log-id">
                    <input type="hidden" id="log-date">
                    
                    <div class="mb-4">
                        <label for="date-display" class="block text-sm font-medium text-gray-700">Fecha</label>
                        <input type="text" id="date-display" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm border p-2" disabled>
                    </div>

                    <div class="mb-4">
                        <label for="hours" class="block text-sm font-medium text-gray-700">Horas Realizadas</label>
                        <input type="number" id="hours" step="0.5" min="0.5" max="24" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="activity" class="block text-sm font-medium text-gray-700">Actividad Realizada</label>
                        <textarea id="activity" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2" required></textarea>
                    </div>
                </form>
            </div>
            
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="btn-save" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                    Guardar
                </button>
                <button type="button" id="btn-delete" class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm hidden transition-colors">
                    Eliminar
                </button>
                <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet" />
<style>
    /* FullCalendar customizations to look premium */
    .fc-theme-standard .fc-scrollgrid { border-color: #e5e7eb; border-radius: 0.5rem; overflow: hidden; }
    .fc-theme-standard th { background-color: #f9fafb; padding: 12px 0; font-weight: 600; text-transform: uppercase; font-size: 0.85rem; color: #6b7280; }
    .fc-daygrid-day-number { color: #374151; font-weight: 500; padding: 8px !important; }
    .fc-event { border: none !important; border-radius: 6px !important; padding: 3px 6px !important; cursor: pointer; transition: transform 0.1s; }
    .fc-event:hover { transform: scale(1.02); }
    .fc .fc-button-primary { background-color: #1E3A8A !important; border-color: #1E3A8A !important; border-radius: 0.375rem !important; font-weight: 500 !important; text-transform: capitalize !important; transition: all 0.2s; }
    .fc .fc-button-primary:hover { background-color: #3B82F6 !important; border-color: #3B82F6 !important; }
    .fc .fc-button-primary:not(:disabled):active, .fc .fc-button-primary:not(:disabled).fc-button-active { background-color: #1e40af !important; border-color: #1e40af !important; }
    .fc-day-today { background-color: #eff6ff !important; }
</style>
@endpush

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.11/locales/es.global.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    const internId = {{ $intern->id }};
    const maxHours = {{ $intern->max_hours }};
    let calendar;
    
    // Convert existing logs to events
    const initialLogs = @json($intern->timeLogs);
    const events = initialLogs.map(log => ({
        id: log.id,
        title: `${log.hours_logged} hrs - ${log.activity_description}`,
        start: log.date,
        extendedProps: {
            hours: log.hours_logged,
            activity: log.activity_description
        },
        backgroundColor: '#3B82F6',
        textColor: '#ffffff'
    }));

    document.addEventListener('DOMContentLoaded', function() {
        // CSRF Token setup for axios
        axios.defaults.headers.common['X-CSRF-TOKEN'] = '{{ csrf_token() }}';

        var calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'es',
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth'
            },
            events: events,
            dateClick: function(info) {
                openModal(info.dateStr);
            },
            eventClick: function(info) {
                openModal(
                    info.event.startStr, 
                    info.event.id, 
                    info.event.extendedProps.hours, 
                    info.event.extendedProps.activity
                );
            },
            height: 'auto',
            contentHeight: 600
        });
        calendar.render();

        // Modal Save Action
        document.getElementById('btn-save').addEventListener('click', saveLog);
        
        // Modal Delete Action
        document.getElementById('btn-delete').addEventListener('click', deleteLog);
    });

    const modal = document.getElementById('event-modal');
    
    function openModal(date, id = null, hours = '', activity = '') {
        document.getElementById('log-date').value = date;
        
        // Format date for display
        const dateObj = new Date(date + 'T00:00:00');
        document.getElementById('date-display').value = dateObj.toLocaleDateString('es-SV', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        
        document.getElementById('log-id').value = id || '';
        document.getElementById('hours').value = hours;
        document.getElementById('activity').value = activity;
        
        if (id) {
            document.getElementById('modal-title').innerText = 'Editar Registro de Horas';
            document.getElementById('btn-delete').classList.remove('hidden');
        } else {
            document.getElementById('modal-title').innerText = 'Registrar Horas';
            document.getElementById('btn-delete').classList.add('hidden');
        }
        
        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
        document.getElementById('log-form').reset();
    }

    function updateStatsLocally() {
        // Calculate from calendar events
        const allEvents = calendar.getEvents();
        let total = 0;
        allEvents.forEach(evt => {
            total += parseFloat(evt.extendedProps.hours || 0);
        });
        
        const remaining = maxHours - total;
        const percent = maxHours > 0 ? (total / maxHours) * 100 : 0;
        const cappedPercent = Math.min(percent, 100);
        
        // Update DOM
        document.getElementById('stat-logged').innerText = `${total.toFixed(2)} hrs`;
        document.getElementById('stat-remaining').innerText = `${remaining.toFixed(2)} hrs`;
        document.getElementById('stat-percent').innerText = `${percent.toFixed(1)}%`;
        document.getElementById('progress-bar').style.width = `${cappedPercent}%`;
        
        // Change colors if complete
        if(total >= maxHours) {
            document.getElementById('progress-bar').classList.remove('bg-primary');
            document.getElementById('progress-bar').classList.add('bg-green-500');
        } else {
            document.getElementById('progress-bar').classList.remove('bg-green-500');
            document.getElementById('progress-bar').classList.add('bg-primary');
        }
    }

    async function saveLog() {
        const id = document.getElementById('log-id').value;
        const date = document.getElementById('log-date').value;
        const hours = document.getElementById('hours').value;
        const activity = document.getElementById('activity').value;

        if (!hours || !activity) {
            Swal.fire('Error', 'Debe completar todos los campos', 'error');
            return;
        }

        const data = {
            intern_id: internId,
            date: date,
            hours_logged: hours,
            activity_description: activity
        };

        try {
            let res;
            if (id) {
                res = await axios.put(`/time_logs/${id}`, data);
            } else {
                res = await axios.post(`/time_logs`, data);
            }

            if (res.data.success) {
                const log = res.data.log;
                
                // Update calendar
                if (id) {
                    const evt = calendar.getEventById(id);
                    evt.setProp('title', `${log.hours_logged} hrs - ${log.activity_description}`);
                    evt.setExtendedProp('hours', log.hours_logged);
                    evt.setExtendedProp('activity', log.activity_description);
                } else {
                    calendar.addEvent({
                        id: log.id,
                        title: `${log.hours_logged} hrs - ${log.activity_description}`,
                        start: log.date,
                        extendedProps: {
                            hours: log.hours_logged,
                            activity: log.activity_description
                        },
                        backgroundColor: '#3B82F6',
                        textColor: '#ffffff'
                    });
                }

                updateStatsLocally();
                closeModal();
                Swal.fire({
                    icon: 'success',
                    title: 'Guardado',
                    text: 'El registro se guardó correctamente',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        } catch (error) {
            Swal.fire('Error', 'Ocurrió un problema al guardar el registro', 'error');
        }
    }

    async function deleteLog() {
        const id = document.getElementById('log-id').value;
        if(!id) return;

        Swal.fire({
            title: '¿Eliminar registro?',
            text: "Se restarán estas horas de tu total.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const res = await axios.delete(`/time_logs/${id}`);
                    if (res.data.success) {
                        calendar.getEventById(id).remove();
                        updateStatsLocally();
                        closeModal();
                        Swal.fire({
                            icon: 'success',
                            title: 'Eliminado',
                            text: 'El registro fue eliminado',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                } catch(err) {
                    Swal.fire('Error', 'No se pudo eliminar el registro', 'error');
                }
            }
        })
    }
</script>
@endpush
