@extends("layouts.app")

{{-- Set the page title to just the action, as the name is now in the breadcrumb --}}
@section("title", "Delete Heatpump " . $heatpump->name)

@section("h1_title", "Delete Heatpump " . $heatpump->name)


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
    <span class="font-medium text-gray-800">Delete</span>
</li>
@endsection

@section("content")

<p class="mb-2">Are you sure you want to delete this heatpump?</p>


<div class="flex flex-row gap-3">


    <a href="{{ route('heatpump.show', $heatpump) }}"
        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 transition-colors shadow-sm">

        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
        </svg>

        Cancel (go back)
    </a>


    <form action="{{ route('heatpump.destroy', $heatpump) }}" method="POST" class="contents">
        @csrf
        @method('DELETE')
        <button type="submit"
            class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-medium text-gray-700 bg-red-400 border border-gray-300 rounded-lg hover:bg-red-500 focus:ring-4 focus:ring-gray-100 transition-colors shadow-sm">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M1 5h22m-8.75-4h-4.5a1.5 1.5 0 0 0-1.5 1.5V5h7.5V2.5a1.5 1.5 0 0 0-1.5-1.5m-4.5 16.75v-7.5m4.5 7.5v-7.5m4.61 11.37A1.49 1.49 0 0 1 17.37 23H6.63a1.49 1.49 0 0 1-1.49-1.38L3.75 5h16.5z" />
            </svg>

            Delete (irreversible)
        </button>
    </form>
</div>

@endsection
