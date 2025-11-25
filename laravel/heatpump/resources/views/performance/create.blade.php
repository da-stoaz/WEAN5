@extends('layouts.app')

@section('title', 'Add Performance Log')
@section('h1_title', 'Add Performance Log')

@section('breadcrumbs')
<li class="inline-flex items-center">
    <a href="{{ route('heatpump.list') }}" class="hover:text-blue-600 transition-colors">
        Heatpumps
    </a>
</li>
<li><span class="mx-1 text-gray-400">/</span></li>
<li class="inline-flex items-center">
    <a href="{{ route('heatpump.show', $heatpump) }}" class="hover:text-blue-600 transition-colors">
        {{ $heatpump->name }}
    </a>
</li>
<li><span class="mx-1 text-gray-400">/</span></li>
<li aria-current="page">
    <span class="font-medium text-gray-800">Add Log</span>
</li>
@endsection

@section('content')
<div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 max-w-3xl">
    <h2 class="text-xl font-semibold mb-4">New Log for {{ $heatpump->name }}</h2>

    <form method="POST" action="{{ route('performance.store', $heatpump) }}" class="space-y-5">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Outside temperature (°C)</label>
                <input type="number" step="0.1" name="outside_temp" value="{{ old('outside_temp') }}"
                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 @error('outside_temp') border-red-500 @enderror"
                    required>
                @error('outside_temp')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Inside temperature (°C)</label>
                <input type="number" step="0.1" name="inside_temp" value="{{ old('inside_temp') }}"
                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 @error('inside_temp') border-red-500 @enderror"
                    required>
                @error('inside_temp')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Supply line temperature (°C)</label>
                <input type="number" step="0.1" name="supply_temp" value="{{ old('supply_temp') }}"
                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 @error('supply_temp') border-red-500 @enderror"
                    required>
                @error('supply_temp')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Return line temperature (°C)</label>
                <input type="number" step="0.1" name="return_temp" value="{{ old('return_temp') }}"
                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 @error('return_temp') border-red-500 @enderror"
                    required>
                @error('return_temp')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Recorded at</label>
            <input type="datetime-local" name="recorded_at" value="{{ old('recorded_at') }}"
                class="w-full sm:w-64 rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 @error('recorded_at') border-red-500 @enderror">
            <p class="text-xs text-gray-500 mt-1">Leave empty to use the current time.</p>
            @error('recorded_at')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('heatpump.show', $heatpump) }}"
                class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit"
                class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-md hover:bg-blue-700">
                Save log
            </button>
        </div>
    </form>
</div>
@endsection
