@extends("layouts.app")

{{-- 1. Sets the browser title tag only --}}
@section("title", "Create Heatpump")

{{-- 2. Sets the main <h1> heading using the new section --}}
@section('h1_title', 'Create New Heatpump') 

@section('breadcrumbs')
    
    {{-- A. Link back to the Heatpump List --}}
    <li class="inline-flex items-center">
        <a href="{{ route('heatpump.list') }}" class="hover:text-blue-600 transition-colors">
            Heatpumps
        </a>
    </li>
    
    {{-- Separator --}}
    <li><span class="mx-1 text-gray-400">/</span></li>

    {{-- B. The Final, Active Item --}}
    <li aria-current="page">
        <span class="font-medium text-gray-800">Create</span>
    </li>
@endsection

@section("content")

    {{-- BEST PRACTICE: Include the partial. Do not hardcode alerts here. --}}
    @include('partials.flash')

    <form id="create-heatpump-form" action="{{ route('heatpump.store') }}" method="POST" class="flex flex-col gap-4 max-w-md">
        @csrf
        
        {{-- Name Field --}}
        <div>
            <label for="name" class="block font-bold mb-1 text-gray-700">Name:</label>
            <input 
                class="border rounded-md p-2 w-full focus:ring-2 focus:ring-blue-400 outline-none 
                @error('name') border-red-500 focus:ring-red-500 @enderror" 
                type="text" 
                name="name" 
                id="name"
                value="{{ old('name') }}" 
                placeholder="e.g. Alpha Unit 1"
            >
            {{-- Inline Validation Error --}}
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Type Field --}}
        <div>
            <label for="type" class="block font-bold mb-1 text-gray-700">Type:</label>
            <select 
                class="border rounded-md p-2 w-full bg-white focus:ring-2 focus:ring-blue-400 outline-none
                @error('type') border-red-500 focus:ring-red-500 @enderror" 
                name="type" 
                id="type"
            >
                <option value="" disabled selected>-- Select a Heatpump Type --</option>
                @foreach(\App\Enums\HeatpumpType::cases() as $type)
                    <option 
                        value="{{ $type->value }}"
                        {{ old('type') == $type->value ? 'selected' : '' }}
                    >
                        {{ $type->value }}
                    </option>
                @endforeach
            </select>
            {{-- Inline Validation Error --}}
            @error('type')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit Button with Spinner --}}
        <button id="submit-btn" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md flex items-center justify-center transition-all shadow-sm" type="submit">
            
            <svg id="spinner" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            
            <span id="btn-text">Create Heatpump</span>
        </button>
    </form>

    {{-- Frontend Interaction Logic --}}
    <script>
        document.getElementById('create-heatpump-form').addEventListener('submit', function() {
            const btn = document.getElementById('submit-btn');
            const spinner = document.getElementById('spinner');
            const text = document.getElementById('btn-text');

            // Disable button and show spinner
            btn.disabled = true;
            btn.classList.add('opacity-75', 'cursor-not-allowed');
            spinner.classList.remove('hidden');
            text.innerText = 'Saving...';
        });
    </script>

@endsection