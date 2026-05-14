@extends('layouts.app')

@section('title', 'Editar Pasante')

@section('content')
<div class="mb-8 flex items-center gap-4">
    <a href="{{ route('interns.index') }}" class="text-gray-500 hover:text-primary transition-colors">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    </a>
    <h1 class="text-3xl font-bold text-gray-900">Editar Pasante</h1>
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
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                <input type="text" name="name" id="name" value="{{ old('name', $intern->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2" required>
            </div>
            
            <div>
                <label for="dui" class="block text-sm font-medium text-gray-700">DUI</label>
                <input type="text" name="dui" id="dui" value="{{ old('dui', $intern->dui) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2" required>
            </div>

            <div>
                <label for="max_hours" class="block text-sm font-medium text-gray-700">Meta de Horas</label>
                <input type="number" name="max_hours" id="max_hours" value="{{ old('max_hours', $intern->max_hours) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2" required min="1">
            </div>

            <div>
                <label for="supervisor_name" class="block text-sm font-medium text-gray-700">Nombre del Encargado</label>
                <input type="text" name="supervisor_name" id="supervisor_name" value="{{ old('supervisor_name', $intern->supervisor_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2" required>
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
