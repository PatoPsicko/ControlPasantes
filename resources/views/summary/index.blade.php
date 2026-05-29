@extends('layouts.app')

@section('title', 'Resumen General')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Resumen General</h1>
    <p class="text-gray-500 mt-1">Vista general del estado y horas de todos los practicantes registrados.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($interns as $intern)
    <div class="glass-card p-6 flex flex-col h-full border-t-4 {{ $intern->remaining_hours <= 0 ? 'border-green-500' : 'border-primary' }}">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h3 class="text-xl font-bold text-gray-900">{{ $intern->name }}</h3>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mt-2">
                    {{ $intern->assigned_unit ?? 'Unidad no asignada' }}
                </span>
            </div>
        </div>
        
        <div class="mb-6 flex-grow">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <p class="text-sm text-gray-600"><strong>Encargado:</strong> {{ $intern->supervisor_name }}</p>
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                <p class="text-sm text-gray-600"><strong>Universidad:</strong> {{ $intern->university ?? 'N/A' }}</p>
            </div>
        </div>

        <!-- Progress Section -->
        <div class="mt-auto pt-4 border-t border-gray-100">
            <div class="flex justify-between items-end mb-2">
                <span class="text-sm font-medium text-gray-700">Progreso de Horas</span>
                <span class="text-2xl font-bold {{ $intern->remaining_hours <= 0 ? 'text-green-600' : 'text-primary' }} leading-none">{{ $intern->progress_percent }}%</span>
            </div>
            
            <div class="relative w-full bg-gray-200 rounded-full h-4 mb-4 overflow-hidden shadow-inner">
                <div class="{{ $intern->remaining_hours <= 0 ? 'bg-green-500' : 'bg-primary' }} h-4 rounded-full transition-all duration-1000 ease-out flex items-center justify-end pr-2" style="width: {{ $intern->progress_percent }}%">
                    @if($intern->progress_percent > 10)
                        <svg class="w-3 h-3 text-white opacity-75" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                    @endif
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4 text-center">
                <div class="bg-gray-50 rounded-lg p-2 border border-gray-100">
                    <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold mb-1">Realizadas</p>
                    <p class="text-lg font-bold text-gray-800">{{ $intern->logged_hours }}</p>
                </div>
                <div class="bg-blue-50 rounded-lg p-2 border border-blue-100">
                    <p class="text-xs text-blue-500 uppercase tracking-wide font-semibold mb-1">Restantes</p>
                    <p class="text-lg font-bold {{ $intern->remaining_hours <= 0 ? 'text-green-600' : 'text-accent' }}">{{ $intern->remaining_hours }}</p>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full glass-card p-12 text-center">
        <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        <h3 class="text-xl font-medium text-gray-900 mb-1">No hay practicantes registrados</h3>
        <p class="text-gray-500 mb-4">Aún no hay practicantes en el sistema para mostrar su resumen de horas.</p>
        <a href="{{ route('interns.create') }}" class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary transition ease-in-out duration-150">
            Registrar Primer Practicante
        </a>
    </div>
    @endforelse
</div>
@endsection
