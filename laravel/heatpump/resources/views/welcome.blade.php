@extends('layouts.app')

{{-- 1. Title sets the H1 and the Browser Tab title --}}
@section('title', 'Dashboard')


{{-- 3. Optional: A global dashboard action --}}
@section('action_button')
    <button onclick="window.location.reload()" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-sm transition-colors">
        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
        </svg>
        Refresh Data
    </button>
@endsection

@section('content')

    <div class="space-y-6">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            
            <div class="p-5 bg-white rounded-lg border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Systems</p>
                    
                    <p class="text-3xl font-bold text-gray-900 mt-1">
                        {{ $total_systems }}
                    </p>
                </div>
                <div class="p-3 bg-blue-50 rounded-full text-blue-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
            </div>

            <div class="p-5 bg-white rounded-lg border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Operational</p>
                    <p class="text-3xl font-bold text-emerald-600 mt-1">
                        {{ $operational }}
                    </p>
                </div>
                <div class="p-3 bg-emerald-50 rounded-full text-emerald-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

            <div class="p-5 bg-white rounded-lg border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Inactive</p>
                    <p class="text-3xl font-bold text-amber-600 mt-1">
                        {{ $inactive }}
                    </p>
                </div>
                <div class="p-3 bg-amber-50 rounded-full text-amber-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            
            {{-- Replace # with route('heatpumps.index') --}}
            <a href="{{ route("heatpump.list") }}" class="group block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-blue-400 hover:ring-1 hover:ring-blue-400 transition-all">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-blue-100 text-blue-600 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Manage Heatpumps</h3>
                        <p class="text-sm text-gray-500">View list, create new entries, or edit existing units.</p>
                    </div>
                </div>
            </a>

            <a href="#" class="group block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:border-blue-400 hover:ring-1 hover:ring-blue-400 transition-all">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-purple-100 text-purple-600 rounded-lg group-hover:bg-purple-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">System Reports</h3>
                        <p class="text-sm text-gray-500">Check efficiency logs and error history.</p>
                    </div>
                </div>
            </a>

        </div>

        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h3 class="font-semibold text-gray-800">Recent System Alerts</h3>
                <a href="#" class="text-sm text-blue-600 hover:underline">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Heatpump ID</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Timestamp</th>
                            <th scope="col" class="px-6 py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">HP-1024 (Delhi North)</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-medium text-red-700 bg-red-100 rounded-full">Pressure Low</span>
                            </td>
                            <td class="px-6 py-4">Today, 10:23 AM</td>
                            <td class="px-6 py-4 text-right">
                                <a href="#" class="font-medium text-blue-600 hover:underline">Inspect</a>
                            </td>
                        </tr>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">HP-1009 (Connaught Place)</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-medium text-amber-700 bg-amber-100 rounded-full">Maintenance Due</span>
                            </td>
                            <td class="px-6 py-4">Yesterday, 4:00 PM</td>
                            <td class="px-6 py-4 text-right">
                                <a href="#" class="font-medium text-blue-600 hover:underline">Schedule</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection