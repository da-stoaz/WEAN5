@extends("layouts.app")

{{-- Set the page title to just the action, as the name is now in the breadcrumb --}}
@section("title", "Edit Heatpump " . $heatpump->name)

@section("h1_title", "Edit Heatpump " . $heatpump->name)


@section('breadcrumbs')
{{-- 1. Link back to the Heatpump List --}}
<li class="inline-flex items-center">
    <a href="{{ route('heatpump.list') }}" class="hover:text-blue-600 transition-colors">
        Heatpumps
    </a>
</li>

{{-- Separator --}}
<li><span class="mx-1 text-gray-400">/</span></li>

{{-- 2. Link back to the Heatpump Details (if you had a show page) --}}
<li class="inline-flex items-center">
    {{-- Assuming you will create a 'heatpump.show' route later --}}
    <a href="{{ route('heatpump.show', $heatpump->id) }}" class="hover:text-blue-600 transition-colors">
        {{ $heatpump->name }}
    </a>
</li>

{{-- Separator --}}
<li><span class="mx-1 text-gray-400">/</span></li>

{{-- 3. The Final, Active Item --}}
<li aria-current="page">
    <span class="font-medium text-gray-800">Edit</span>
</li>
@endsection

@section("content")
@include("partials.flash")

<form id="edit-heatpump-form" class="flex flex-col gap-4 max-w-md" method="post" action="{{ route("heatpump.update", $heatpump) }}">
    @csrf
    @method("PUT")
    <div>
        <label for="name" class="block font-bold mb-1 text-gray-700">Name:</label>
        <input
            name="name"
            class="border rounded-md p-2 w-full focus:ring-2 focus:ring-blue-400 outline-none"
            value="{{ $heatpump->name }}"
            type="text">
    </div>

    <div>
        <label for="type" class="block font-bold mb-1 text-gray-700">Type: </label>
        <select
            class="border rounded-md p-2 w-full bg-white focus:ring-2 focus:ring-blue-400 outline-none
                @error('type') border-red-500 focus:ring-red-500 @enderror"
            name="type"
            id="type">
            @foreach(\App\Enums\HeatpumpType::cases() as $type)
            <option
                value="{{ $type->value }}"
                {{ old('type') == $type->value ? 'selected' : '' }}>
                {{ $type->value }}
            </option>
            @endforeach
        </select>
    </div>

    <button id="submit-btn" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md flex items-center justify-center transition-all shadow-sm" type="submit">
        Update Heatpump
    </button>
</form>


@endsection