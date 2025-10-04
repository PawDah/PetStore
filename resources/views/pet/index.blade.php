@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Pet Store API Client </h1>

        {{-- Sekcja Komunikatów (Sukces/Błąd/Walidacja) --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">Sukces! {{ session('success') }}</span>
            </div>
        @endif
        @if(session('error') || $error)
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">Błąd! {{ session('error') ?? $error }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <p class="font-bold">Proszę poprawić następujące błędy walidacji:</p>
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex flex-col md:flex-row gap-8">

            <div class="md:w-1/2">

                <h2 class="text-2xl font-semibold mb-4 text-indigo-600">Pobierz/Wyświetl Zwierzaka (GET)</h2>

                {{-- Formularz Pobierania --}}
                <form action="{{ route('pet.index') }}" method="GET" class="bg-white p-6 rounded-lg shadow-md mb-6">
                    <div class="mb-4">
                        <label for="get_id" class="block text-gray-700 text-sm font-bold mb-2">ID Zwierzaka:</label>
                        <input type="number" id="get_id" name="id" value="{{ $pet?->id ?? old('id') }}" required min="1" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Pobierz</button>
                </form>

                @if($pet instanceof \App\DTO\PetDTO)
                    {{-- Wyświetlanie Danych (GET) --}}
                    <div class="pet-data bg-white p-6 rounded-lg shadow-xl border-t-4 border-indigo-500 mb-6">
                        <h3 class="text-xl font-bold mb-3 text-indigo-700">Dane Zwierzaka (ID: {{ $pet->id }})</h3>
                        <p><strong>Imię:</strong> {{ $pet->name }}</p>
                        <p><strong>Status:</strong> {{ $pet->status }}</p>
                        <p><strong>URL Zdjęcia:</strong>
                            @if(!empty($pet->photoUrls[0]))
                                <a href="{{ $pet->photoUrls[0] }}" target="_blank" class="text-blue-500 hover:text-blue-700 break-words">{{ $pet->photoUrls[0] }}</a>
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                @endif

                {{-- SEKCJA DODAWANIA (POST) --}}
                <h2 class="text-2xl font-semibold mb-4 text-blue-600">Dodaj Nowego Zwierzaka (POST)</h2>
                <form action="{{ route('pet.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-lg">
                    @csrf

                    <div class="mb-4">
                        <label for="add_id" class="block text-gray-700 text-sm font-bold mb-2">ID Zwierzaka (opcjonalne/generowane):</label>
                        <input type="number" id="add_id" name="id" value="{{ old('id', time()) }}" min="1" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="mb-4">
                        <label for="add_name" class="block text-gray-700 text-sm font-bold mb-2">Imię*:</label>
                        <input type="text" id="add_name" name="name" value="{{ old('name') }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="mb-4">
                        <label for="add_photo_url" class="block text-gray-700 text-sm font-bold mb-2">URL Zdjęcia*:</label>
                        <input type="url" id="add_photo_url" name="photo_url" value="{{ old('photo_url') }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="mb-6">
                        <label for="add_status" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
                        <select id="add_status" name="status" required class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @foreach(['available', 'pending', 'sold'] as $statusOption)
                                <option value="{{ $statusOption }}" {{ old('status') == $statusOption ? 'selected' : '' }}>{{ ucfirst($statusOption) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Dodaj Zwierzaka</button>
                </form>
            </div>

            <div class="md:w-1/2">

                {{-- SEKCJA EDYCJI (PUT) --}}
                <h2 class="text-2xl font-semibold mb-4 text-green-600">Edytuj Zwierzaka Po ID (PUT)</h2>
                <form action="{{ route('pet.update-post') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md mb-6">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="edit_id" class="block text-gray-700 text-sm font-bold mb-2">ID Zwierzaka do Edycji*:</label>
                        <input type="number" id="edit_id" name="id" value="{{ old('id') }}" required min="1" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="mb-4">
                        <label for="edit_name" class="block text-gray-700 text-sm font-bold mb-2">Nowe Imię*:</label>
                        <input type="text" id="edit_name" name="name" value="{{ old('name') }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="mb-4">
                        <label for="edit_photo_url" class="block text-gray-700 text-sm font-bold mb-2">Nowy URL Zdjęcia*:</label>
                        <input type="url" id="edit_photo_url" name="photo_url" value="{{ old('photo_url') }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="mb-6">
                        <label for="edit_status" class="block text-gray-700 text-sm font-bold mb-2">Nowy Status:</label>
                        <select id="edit_status" name="status" required class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @foreach(['available', 'pending', 'sold'] as $statusOption)
                                <option value="{{ $statusOption }}" {{ old('status') == $statusOption ? 'selected' : '' }}>{{ ucfirst($statusOption) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Aktualizuj Zwierzaka</button>
                </form>

                {{-- SEKCJA USUWANIA (DELETE) --}}
                <h2 class="text-2xl font-semibold mb-4 text-red-600">Usuń Zwierzaka Po ID (DELETE)</h2>
                <form action="{{ route('pet.destroy-post') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
                    @csrf
                    @method('DELETE')

                    <div class="mb-4">
                        <label for="delete_id" class="block text-gray-700 text-sm font-bold mb-2">ID Zwierzaka do Usunięcia:</label>
                        <input type="number" id="delete_id" name="id" value="{{ old('id') }}" required min="1" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <button type="submit" onclick="return confirm('Czy na pewno chcesz usunąć tego zwierzaka?')" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Usuń</button>
                </form>
            </div>
        </div>
    </div>
@endsection
