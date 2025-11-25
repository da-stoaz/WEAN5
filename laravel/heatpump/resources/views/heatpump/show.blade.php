@extends("layouts.app")

@section("title", content: "Heatpump " . $heatpump->name)

@section('h1_title', "Heatpump " . $heatpump->name)


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
    <span class="font-medium text-gray-800">{{ $heatpump->name }}</span>
</li>
@endsection

@section('action_button')

<div class="flex flex-row gap-3">
    <a href="{{ route('heatpump.edit', $heatpump) }}"
        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 transition-colors shadow-sm">

        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
        </svg>

        Edit Details
    </a>
    <a href="{{ route('heatpump.delete', $heatpump) }}"
        class="inline-flex items-center capitalize justify-center gap-2 px-5 py-2.5 text-sm font-medium text-gray-700 bg-red-400 border border-gray-300 rounded-lg hover:bg-red-500 focus:ring-4 focus:ring-gray-100 transition-colors shadow-sm">

        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M1 5h22m-8.75-4h-4.5a1.5 1.5 0 0 0-1.5 1.5V5h7.5V2.5a1.5 1.5 0 0 0-1.5-1.5m-4.5 16.75v-7.5m4.5 7.5v-7.5m4.61 11.37A1.49 1.49 0 0 1 17.37 23H6.63a1.49 1.49 0 0 1-1.49-1.38L3.75 5h16.5z" />
        </svg>

        Delete
    </a>
</div>

@endsection

@section("content")

<section>
    <h3 class="text-lg font-medium text-gray-900 mb-4">System Information</h3>

    <dl class="grid grid-cols-[140px_1fr] gap-y-4 text-sm">

        <dt class="font-medium text-gray-500">System ID</dt>
        <dd class="text-gray-900 font-semibold">#{{ $heatpump->id }}</dd>

        <dt class="font-medium text-gray-500">Customer</dt>
        <dd class="text-gray-900">{{ $heatpump->name }}</dd>

        <dt class="font-medium text-gray-500">Type</dt>
        <dd class="text-gray-900">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                {{ $heatpump->type }}
            </span>
        </dd>

        <dt class="font-medium text-gray-500">Last Update</dt>
        <dd class="text-gray-900">
            {{ $heatpump->updated_at->format('d M Y, H:i') }}
        </dd>

    </dl>
</section>

<section class="mt-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b pb-2 gap-2 mb-6">
        <div>
            <h2 class="text-2xl font-bold inline">Logs</h2>
            <span class="text-xs uppercase tracking-wide text-gray-500 ml-0.5 inline-block">(AJAX)</span>
        </div>
        <a href="{{ route('performance.create', $heatpump) }}"
            class="inline-flex items-center justify-center gap-2 px-3 py-1.5 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 shadow-sm">
            Add log
        </a>
    </div>
    <div class="relative overflow-x-auto bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
        <table id="performanceDataTable" class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Outside (°C)</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Inside (°C)</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Supply (°C)</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Return (°C)</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recorded at</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</section>



<script>
    $(document).ready(function() {
        const table = $('#performanceDataTable').DataTable({
            ajax: {
                url: "{{ route('performance.data', absolute: false) }}",
                type: "GET",
                data: function(d) {
                    d.filters = {
                        heatpump_id: "{{ $heatpump->id }}"
                    };
                }
            },
            processing: true,
            serverSide: true,
            stateSave: true,
            pageLength: 10,
            columns: [{
                    data: 'id'
                },
                {
                    data: 'outside_temp'
                },
                {
                    data: 'inside_temp'
                },
                {
                    data: 'supply_temp'
                },
                {
                    data: 'return_temp'
                },
                {
                    data: 'recorded_at'
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(row) {
                        return `<button class="text-red-600 hover:text-red-800 delete-log cursor-pointer border px-2  rounded-md border-red-300" data-id="${row.id}">Delete</button>`;
                    }
                }
            ],
            columnDefs: [
                {
                    targets: "_all",
                    className: "px-3 py-2 text-sm"
                }
            ],
            columnDefs: [
                {
                    targets: "_all",
                    className: "px-3 py-2 text-sm"
                },
                {
                    targets: 5,
                    render: function(data) {
                        if (!data) return '';
                        const date = new Date(data);
                        if (Number.isNaN(date.getTime())) return data;
                        const formatter = new Intl.DateTimeFormat(undefined, {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                        return formatter.format(date);
                    }
                }
            ]
        });

        $('#performanceDataTable').on('click', '.delete-log', function() {
            const id = $(this).data('id');
            if (!confirm('Delete this log?')) return;

            $.ajax({
                url: "{{ route('performance.data.delete', ['performanceData' => '__ID__'], absolute: false) }}".replace('__ID__', id),
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function() {
                    table.ajax.reload(null, false);
                },
                error: function(xhr) {
                    alert('Delete failed');
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>



@endsection
