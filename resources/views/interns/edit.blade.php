@extends('layouts.app')

@section('title', 'Editar Practicante')

@section('content')
<div class="mb-8 flex items-center gap-4">
    <a href="{{ route('interns.index') }}" class="text-gray-500 hover:text-primary transition-colors">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    </a>
    <h1 class="text-3xl font-bold text-gray-900">Editar Practicante</h1>
</div>

<div class="glass-card max-w-2xl mx-auto p-8">
    @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('interns.update', $intern) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre de Universidad -->
                <div>
                    <label for="university" class="block text-sm font-medium text-gray-700">Nombre de Universidad <span class="text-gray-400 cursor-help" title="Nombre completo de la institución educativa.">&#9432;</span></label>
                    <input type="text" name="university" id="university" value="{{ old('university', $intern->university) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2">
                </div>

                <!-- Correlativo -->
                <div>
                    <label for="request_number" class="block text-sm font-medium text-gray-700">N° Correlativo de Solicitud <span class="text-gray-400 cursor-help" title="Debe contener únicamente números.">&#9432;</span></label>
                    <input type="number" name="request_number" id="request_number" value="{{ old('request_number', $intern->request_number) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2">
                </div>

                <!-- Nombre -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre Completo <span class="text-gray-400 cursor-help" title="Nombres y apellidos completos del practicante.">&#9432;</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $intern->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2" required>
                </div>

                <!-- Correo -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico <span class="text-gray-400 cursor-help" title="Debe ser un correo válido, ej: correo@ejemplo.com">&#9432;</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email', $intern->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2">
                </div>

                <!-- Teléfono -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Teléfono <span class="text-gray-400 cursor-help" title="Formato requerido: 0000-0000 (8 números con guion).">&#9432;</span></label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $intern->phone) }}" placeholder="0000-0000" pattern="\d{4}-\d{4}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2">
                </div>
                
                <!-- DUI -->
                <div>
                    <label for="dui" class="block text-sm font-medium text-gray-700">DUI <span class="text-gray-400 cursor-help" title="Formato requerido: 00000000-0 (8 números, guion y 1 número).">&#9432;</span></label>
                    <input type="text" name="dui" id="dui" value="{{ old('dui', $intern->dui) }}" placeholder="00000000-0" pattern="\d{8}-\d{1}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2" required>
                </div>

                <!-- Fecha de Nacimiento -->
                <div>
                    <label for="birth_date" class="block text-sm font-medium text-gray-700">Fecha de Nacimiento <span class="text-gray-400 cursor-help" title="Selecciona desde el calendario o escribe en formato DD/MM/AAAA.">&#9432;</span></label>
                    <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $intern->birth_date) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2">
                </div>

                <!-- Sexo -->
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700">Sexo <span class="text-gray-400 cursor-help" title="Selecciona Hombre o Mujer.">&#9432;</span></label>
                    <select name="gender" id="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2 bg-white">
                        <option value="">Seleccione...</option>
                        <option value="Hombre" {{ old('gender', $intern->gender) == 'Hombre' ? 'selected' : '' }}>Hombre</option>
                        <option value="Mujer" {{ old('gender', $intern->gender) == 'Mujer' ? 'selected' : '' }}>Mujer</option>
                    </select>
                </div>

                <!-- Número de horas a realizar -->
                <div>
                    <label for="max_hours" class="block text-sm font-medium text-gray-700">Número de Horas a Realizar <span class="text-gray-400 cursor-help" title="Debe contener únicamente números enteros.">&#9432;</span></label>
                    <input type="number" name="max_hours" id="max_hours" value="{{ old('max_hours', $intern->max_hours) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2" required min="1">
                </div>

                <!-- Unidad Asignada -->
                <div>
                    <label for="assigned_unit" class="block text-sm font-medium text-gray-700">Unidad Asignada <span class="text-gray-400 cursor-help" title="Área del TEG donde estará el practicante.">&#9432;</span></label>
                    <input type="text" name="assigned_unit" id="assigned_unit" value="{{ old('assigned_unit', $intern->assigned_unit) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2">
                </div>

                <!-- Nombre del Encargado (Supervisor) -->
                <div>
                    <label for="supervisor_name" class="block text-sm font-medium text-gray-700">Nombre del Encargado <span class="text-gray-400 cursor-help" title="Nombre de la persona responsable del practicante en el TEG.">&#9432;</span></label>
                    <input type="text" name="supervisor_name" id="supervisor_name" value="{{ old('supervisor_name', $intern->supervisor_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2" required>
                </div>

                <!-- Fecha de Inicialización -->
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Fecha de Inicialización <span class="text-gray-400 cursor-help" title="Día en que inician las prácticas.">&#9432;</span></label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $intern->start_date) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2">
                </div>

                <!-- Fecha de Finalización -->
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">Fecha de Finalización <span class="text-gray-400 cursor-help" title="Día estimado en que finalizan las prácticas.">&#9432;</span></label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $intern->end_date) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2">
                </div>

                <!-- Horario -->
                <div>
                    <label for="schedule" class="block text-sm font-medium text-gray-700">Horario de asistencia <span class="text-gray-400 cursor-help" title="Ejemplo: De 08:00 AM a 12:00 PM">&#9432;</span></label>
                    <input type="text" name="schedule" id="schedule" value="{{ old('schedule', $intern->schedule) }}" placeholder="De 08:00 AM a 12:00 PM" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2">
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-primary hover:bg-secondary text-white font-medium py-2 px-6 rounded-lg shadow transition-colors">
                    Actualizar Registro
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
