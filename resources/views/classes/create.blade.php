@extends('layouts.app')

@section('title', 'Ajouter une Nouvelle Classe')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Ajouter une Nouvelle Classe</h1>
        <a href="{{ route('classes.index') }}" class="text-blue-500 hover:underline">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
    </div>

    <form action="{{ route('classes.store') }}" method="POST">
        @csrf

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <strong>Erreur de validation</strong>
                <ul class="mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6 mb-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nom de la Classe</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" 
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Ex: Classe A" required>
            </div>

            <div>
                <label for="level" class="block text-sm font-medium text-gray-700">Niveau</label>
                <select name="level" id="level" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">Sélectionnez un niveau</option>
                    <option value="1ère année" {{ old('level') == '1ère année' ? 'selected' : '' }}>1ère année</option>
                    <option value="2ème année" {{ old('level') == '2ème année' ? 'selected' : '' }}>2ème année</option>
                    <option value="3ème année" {{ old('level') == '3ème année' ? 'selected' : '' }}>3ème année</option>
                    <option value="4ème année" {{ old('level') == '4ème année' ? 'selected' : '' }}>4ème année</option>
                    <option value="5ème année" {{ old('level') == '5ème année' ? 'selected' : '' }}>5ème année</option>
                </select>
            </div>

            <div>
                <label for="capacity" class="block text-sm font-medium text-gray-700">Capacité</label>
                <input type="number" id="capacity" name="capacity" 
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('capacity', 30) }}" min="1" required>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_active" value="1" 
                       class="h-4 w-4 text-blue-600 border-gray-300 rounded" {{ old('is_active', true) ? 'checked' : '' }}>
                <label for="is_active" class="ml-2 block text-sm text-gray-900">Classe active</label>
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <button type="reset" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                Réinitialiser
            </button>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection 