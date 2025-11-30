@extends("layouts.app")

@section("h1_title", content: "Performance Data")

@section("title", "Performance Data")

@section("breadcrumbs")
<li class="inline-flex items-center" id="breadcrumb">
    <a href="{{ route('performance.list') }}" class="hover:text-blue-600 transition-colors">
        Performance Data
    </a>
</li>
@endsection


@section("content")

<div id="performanceTableWrapper" class="space-y-4">
    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-3">
            <h3 class="text-base font-semibold text-gray-800">Filter</h3>
            <button type="button"
                class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700"
                id="addLogShortcut"
                data-url-template="{{ route('performance.create', ['heatpump' => '__HEATPUMP__']) }}">
                Add log
            </button>
        </div>
        <form id="performanceFilters" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-3">
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Heatpump</label>
                <select name="heatpump_id" id="heatpumpSelect"
                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All heatpumps</option>
                    @foreach($heatpumps as $heatpumpOption)
                    <option value="{{ $heatpumpOption->id }}">{{ $heatpumpOption->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Heatpump name contains</label>
                <input type="text" name="heatpump" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Name contains…">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Outside °C (min/max)</label>
                <div class="flex gap-2">
                    <input type="number" step="0.1" name="outside_min" class="w-1/2 rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="min">
                    <input type="number" step="0.1" name="outside_max" class="w-1/2 rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="max">
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Inside °C (min/max)</label>
                <div class="flex gap-2">
                    <input type="number" step="0.1" name="inside_min" class="w-1/2 rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="min">
                    <input type="number" step="0.1" name="inside_max" class="w-1/2 rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="max">
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Supply °C (min/max)</label>
                <div class="flex gap-2">
                    <input type="number" step="0.1" name="supply_min" class="w-1/2 rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="min">
                    <input type="number" step="0.1" name="supply_max" class="w-1/2 rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="max">
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Return °C (min/max)</label>
                <div class="flex gap-2">
                    <input type="number" step="0.1" name="return_min" class="w-1/2 rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="min">
                    <input type="number" step="0.1" name="return_max" class="w-1/2 rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="max">
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Recorded from</label>
                <input type="date" name="recorded_from" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Recorded to</label>
                <input type="date" name="recorded_to" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div class="flex items-end gap-2">
                <button type="button" id="resetFilters" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200">Reset</button>
            </div>
        </form>
    </div>

    <div class="relative overflow-x-auto bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
        <table id="performanceTableServer" class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Heatpump</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Outside (°C)</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Inside (°C)</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Supply (°C)</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Return (°C)</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recorded at</th>
                </tr>
            </thead>
            <tbody>
                {{-- Server-Side DataTable füllt die Zeilen --}}
            </tbody>
        </table>
    </div>
    <div class="flex justify-end mt-3">
        <button type="button" id="backToTopBtn" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200">
            Back to top
        </button>
    </div>
</div>

<style>
</style>

<script>
    $(document).ready(function() {
        const $filters = $('#performanceFilters');
        const $backToTop = $('#backToTopBtn');
        const addLogBtn = $('#addLogShortcut');
        const heatpumpSelect = $('#heatpumpSelect');

        const performanceTable = $('#performanceTableServer').DataTable({
            processing: false,
            serverSide: true,
            pageLength: 10,
            stateSave: true,
            ajax: {
                url: "{{ route('performance.data', absolute: false) }}",
                type: "GET",
                data: function(d) {
                    const formData = Object.fromEntries(new FormData($filters[0]));
                    d.filters = formData;
                },
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
                    defaultContent: '',
                    render: function(data, type, row) {
                        if (!row.heatpump_id || !data) return data || '';
                        const url = "{{ route('heatpump.show', ['heatpump' => '__ID__']) }}".replace('__ID__', row.heatpump_id);
                        return `<a href="${url}" class="text-blue-600 hover:underline">${data}</a>`;
                    }
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
                    data: 'recorded_at',
                    render: function(data) {
                        if (!data) return '';
                        const date = new Date(data);
                        if (Number.isNaN(date.getTime())) return data;
                        const formatter = new Intl.DateTimeFormat(undefined, {
                            dateStyle: 'medium',
                            timeStyle: 'short'
                        });
                        return formatter.format(date);
                    }
                }
            ],
            order: [
                [6, 'desc']
            ],
            autoWidth: false,
            initComplete: function() {
                toggleBackToTop();
            },
            drawCallback: function() {
                toggleBackToTop();
            }
        });

        function toggleBackToTop() {
            const wrapper = document.getElementById('performanceTableWrapper');
            if (!wrapper) return;
            const rect = wrapper.getBoundingClientRect();
            const needsButton = rect.height > window.innerHeight * 0.8;
            $backToTop.toggle(needsButton);
        }
        toggleBackToTop();
        $(window).on('resize', toggleBackToTop);
        $backToTop.on('click', function() {
            $('html, body').animate({ scrollTop: $('#breadcrumb').offset().top }, 300);
        });

        $filters.on('change', 'input, select', function() {
            performanceTable.draw();
        });

        $('#resetFilters').on('click', function() {
            $filters[0].reset();
            performanceTable.draw();
        });

        addLogBtn.on('click', function() {
            const selectedId = heatpumpSelect.val();
            if (!selectedId) {
                alert('Please choose a heatpump first.');
                return;
            }

            const url = addLogBtn.data('url-template').replace('__HEATPUMP__', selectedId);
            window.location = url;
        });
    });
</script>
@endsection
