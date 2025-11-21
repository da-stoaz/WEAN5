@extends("layouts.app")

{{-- Set the page title to just the action, as the name is now in the breadcrumb --}}
@section("title", "Edit Heatpump " . $heatpump->name)

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
        Heatpump {{ $heatpump->name }}
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
<h1>Editing: {{ $heatpump->name }}</h1>

@endsection