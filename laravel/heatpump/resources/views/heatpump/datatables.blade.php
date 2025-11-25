@extends('layouts.app')

@section('title', 'DataTables')
@section('h1_title', 'DataTables Varianten')

@section('breadcrumbs')
<li class="inline-flex items-center">
    <a href="{{ route('heatpump.list') }}" class="hover:text-blue-600 transition-colors">
        Heatpumps
    </a>
</li>
<li><span class="mx-1 text-gray-400">/</span></li>
<li aria-current="page">
    <span class="font-medium text-gray-800">DataTables</span>
</li>
@endsection

@section('content')
<div class="space-y-10">
    <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-2">1. HTML → DataTable</h2>
        <p class="text-sm text-gray-600 mb-4">Zeilen werden via @@foreach gerendert, DataTable läuft vollständig clientseitig.</p>

        <div class="overflow-x-auto">
            <table id="heatpumpTableStatic" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Updated At</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($heatpumps as $heatpump)
                    <tr>
                        <td class="px-3 py-2 text-sm text-gray-900">{{ $heatpump->id }}</td>
                        <td class="px-3 py-2 text-sm text-gray-900">{{ $heatpump->name }}</td>
                        <td class="px-3 py-2 text-sm text-gray-900">{{ $heatpump->type }}</td>
                        <td class="px-3 py-2 text-sm text-gray-900">{{ $heatpump->updated_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    

    
</div>

<style>
    .column-search {
        width: 100%;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        padding: 6px 8px;
        font-size: 0.875rem;
    }

</style>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        $('#heatpumpTableStatic').DataTable({
            stateSave: true,
            pageLength: 5
        });

        function addColumnSearch(tableSelector) {
            $(`${tableSelector} tfoot th`).each(function() {
                $(this).html('<input type="text" class="column-search" placeholder="Suche..." />');
            });
        }

        addColumnSearch('#heatpumpTableAjax');
        addColumnSearch('#performanceTableServer');

        const showUrl = "{{ route('heatpump.show', ['heatpump' => '__ID__']) }}";
        const editUrl = "{{ route('heatpump.edit', ['heatpump' => '__ID__']) }}";

        const heatpumpAjaxTable = $('#heatpumpTableAjax').DataTable({
            ajax: {
                url: "{{ route('heatpump.data', absolute: false) }}",
                type: "POST"
            },
            processing: true,
            serverSide: false,
            pageLength: 5,
            columns: [{
                    data: 'id'
                },
                {
                    data: 'name'
                },
                {
                    data: 'type'
                },
                {
                    data: 'updated_at'
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        const detailUrl = showUrl.replace('__ID__', row.id);
                        const editHref = editUrl.replace('__ID__', row.id);

                        return `
                            <div class="flex gap-2">
                                <a href="${detailUrl}" class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-white bg-blue-500 rounded hover:bg-blue-600 transition-colors">Show</a>
                                <a href="${editHref}" class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-gray-800 bg-amber-200 rounded hover:bg-amber-300 transition-colors">Edit</a>
                            </div>
                        `;
                    }
                }
            ]
        });

        heatpumpAjaxTable.columns().every(function() {
            const column = this;
            $('input', column.footer()).on('keyup change clear', function() {
                column.search(this.value).draw();
            });
        });

        const performanceTable = $('#performanceTableServer').DataTable({
            processing: false,
            serverSide: true,
            pageLength: 10,
            ajax: {
                url: "{{ route('performance.data', absolute: false) }}",
                type: "POST",
                dataSrc: function(json) {
                    return json.data || [];
                },
                error: function(xhr) {
                    console.error('Performance data load failed', xhr.responseText);
                }
            },
            language: {
                processing: ""
            },
            columns: [{
                    data: 'id'
                },
                {
                    data: 'heatpump_name',
                    defaultContent: ''
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
                }
            ],
            order: [
                [6, 'desc']
            ],
            autoWidth: false
        });

        performanceTable.columns().every(function() {
            const column = this;
            $('input', column.footer()).on('keyup change clear', function() {
                column.search(this.value).draw();
            });
        });
    });
</script>
@endsection
