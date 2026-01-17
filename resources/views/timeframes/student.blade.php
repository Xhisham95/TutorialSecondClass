@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">
        <h2 class="mb-4">Ongoing Timeframes</h2>

        @if(count($timeframes) > 0)
            <!-- Enhanced Search Filter -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="mdi mdi-filter-variant"></i> Filter Timeframes
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="searchFilter" class="form-label fw-bold">
                                <i class="mdi mdi-magnify"></i> Event Type
                            </label>
                            <input type="text" class="form-control" id="searchFilter" placeholder="Type to filter timeframes...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">
                                <i class="mdi mdi-chart-timeline-variant"></i> Status
                            </label>
                            <select class="form-select" id="statusFilter">
                                <option value="all">All Status</option>
                                <option value="ongoing">Ongoing</option>
                                <option value="upcoming">Upcoming</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">
                                <i class="mdi mdi-calendar-start"></i> Start Date From
                            </label>
                            <input type="date" class="form-control" id="startDateFilter">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button class="btn btn-secondary w-100" id="clearFilter">
                                <i class="mdi mdi-refresh"></i> Clear
                            </button>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">
                                <i class="mdi mdi-calendar-end"></i> End Date To
                            </label>
                            <input type="date" class="form-control" id="endDateFilter">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">
                                <i class="mdi mdi-sort"></i> Sort By
                            </label>
                            <select class="form-select" id="sortFilter">
                                <option value="default">Default Order</option>
                                <option value="name-asc">Name (A-Z)</option>
                                <option value="name-desc">Name (Z-A)</option>
                                <option value="date-asc" selected>Start Date (Earliest)</option>
                                <option value="date-desc">Start Date (Latest)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="mt-4 text-end">
                                <small class="text-muted">
                                    <i class="mdi mdi-information"></i> 
                                    Showing <strong id="resultCount">{{ count($timeframes) }}</strong> timeframe(s)
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="timeline-wrapper">
                @php
                    $today = now();
                    $allDates = $timeframes->flatMap(function($tf) {
                        return [\Carbon\Carbon::parse($tf->Start_Date), \Carbon\Carbon::parse($tf->End_Date)];
                    });
                    $minDate = $allDates->min()->startOfDay();
                    $maxDate = $allDates->max()->endOfDay();
                    $totalDays = $minDate->diffInDays($maxDate) + 1;
                @endphp

                <!-- Calendar Header -->
                <div class="timeline-header">
                    <div class="timeline-months">
                        @php
                            $currentMonth = null;
                            $monthSpans = [];
                            for ($i = 0; $i < $totalDays; $i++) {
                                $date = $minDate->copy()->addDays($i);
                                $month = $date->format('M Y');
                                if ($month !== $currentMonth) {
                                    if ($currentMonth !== null) {
                                        $monthSpans[] = ['month' => $currentMonth, 'days' => $dayCount];
                                    }
                                    $currentMonth = $month;
                                    $dayCount = 1;
                                } else {
                                    $dayCount++;
                                }
                            }
                            if ($currentMonth !== null) {
                                $monthSpans[] = ['month' => $currentMonth, 'days' => $dayCount];
                            }
                        @endphp
                        @foreach($monthSpans as $span)
                            <div class="month-label" style="flex: {{ $span['days'] }};">
                                {{ $span['month'] }}
                            </div>
                        @endforeach
                    </div>
                    <div class="timeline-days">
                        @for ($i = 0; $i < $totalDays; $i++)
                            @php
                                $date = $minDate->copy()->addDays($i);
                                $isToday = $date->isSameDay($today);
                                $isWeekend = $date->isWeekend();
                            @endphp
                            <div class="day-cell {{ $isToday ? 'today' : '' }} {{ $isWeekend ? 'weekend' : '' }}">
                                <div class="day-number">{{ $date->format('d') }}</div>
                                <div class="day-name">{{ $date->format('D') }}</div>
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Timeline Bars -->
                <div class="timeline-body">
                    @foreach($timeframes as $index => $timeframe)
                        @php
                            $start = \Carbon\Carbon::parse($timeframe->Start_Date);
                            $end = \Carbon\Carbon::parse($timeframe->End_Date);
                            $startOffset = $minDate->diffInDays($start);
                            $duration = $start->diffInDays($end) + 1;
                            $leftPercent = ($startOffset / $totalDays) * 100;
                            $widthPercent = ($duration / $totalDays) * 100;
                            $isOngoing = $today->between($start, $end);
                            $isUpcoming = $today->lt($start);
                            // Assign colors based on status
                            if ($isOngoing) {
                                $colorSet = ['bg' => '#4CAF50', 'text' => '#ffffff'];
                                $statusClass = 'ongoing';
                            } elseif ($isUpcoming) {
                                $colorSet = ['bg' => '#2196F3', 'text' => '#ffffff'];
                                $statusClass = 'upcoming';
                            } else {
                                $colorSet = ['bg' => '#9E9E9E', 'text' => '#ffffff'];
                                $statusClass = 'completed';
                            }
                        @endphp

                        <div class="timeline-row" 
                             data-event-type="{{ strtolower($timeframe->Event_Type) }}" 
                             data-status="{{ $statusClass }}"
                             data-start-date="{{ $timeframe->Start_Date }}"
                             data-end-date="{{ $timeframe->End_Date }}"
                             data-semester="{{ $timeframe->Semester }}">
                            <div class="timeline-bar-pill" 
                                 style="left: {{ $leftPercent }}%; 
                                        width: {{ $widthPercent }}%; 
                                        background: {{ $colorSet['bg'] }};
                                        color: {{ $colorSet['text'] }};">
                                <div class="pill-content">
                                    <span class="pill-title">{{ $timeframe->Event_Type }}</span>
                                    <span class="pill-badge">
                                        @if($isOngoing)
                                            <i class="mdi mdi-clock-outline"></i>
                                        @elseif($isUpcoming)
                                            <i class="mdi mdi-calendar-clock"></i>
                                        @else
                                            <i class="mdi mdi-check-circle"></i>
                                        @endif
                                    </span>
                                </div>
                                <div class="pill-dates">
                                    {{ $start->format('M d') }} - {{ $end->format('M d') }}
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Today Indicator Line -->
                    @if($today->between($minDate, $maxDate))
                        <div class="today-line" style="left: {{ ($minDate->diffInDays($today) / $totalDays) * 100 }}%;"></div>
                    @endif
                </div>

                <div class="timeline-legend mt-3">
                    <span class="legend-item">
                        <span class="legend-dot" style="background: #4CAF50;"></span>
                        Ongoing
                    </span>
                    <span class="legend-item">
                        <span class="legend-dot" style="background: #2196F3;"></span>
                        Upcoming
                    </span>
                    <span class="legend-item">
                        <span class="legend-dot" style="background: #9E9E9E;"></span>
                        Completed
                    </span>
                    <span class="legend-item">
                        <span class="today-indicator-small"></span>
                        Today
                    </span>
                </div>
            </div>

            <!-- Details Table -->
            <div class="mt-5">
                <h4>Timeframe Details</h4>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Event Type</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Duration</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($timeframes as $timeframe)
                                    @php
                                        $start = \Carbon\Carbon::parse($timeframe->Start_Date);
                                        $end = \Carbon\Carbon::parse($timeframe->End_Date);
                                        $isOngoing = now()->between($start, $end);
                                        $isUpcoming = now()->lt($start);
                                    @endphp
                                    <tr>
                                        <td><strong>{{ $timeframe->Event_Type }}</strong></td>
                                        <td>{{ $start->format('M d, Y') }}</td>
                                        <td>{{ $end->format('M d, Y') }}</td>
                                        <td>{{ $start->diffInDays($end) + 1 }} days</td>
                                        <td>
                                            @if($isOngoing)
                                                <span class="badge" style="background-color: #4CAF50; color: white;">
                                                    <i class="mdi mdi-clock-outline"></i> Ongoing
                                                </span>
                                            @elseif($isUpcoming)
                                                <span class="badge" style="background-color: #2196F3; color: white;">
                                                    <i class="mdi mdi-calendar-clock"></i> Upcoming
                                                </span>
                                            @else
                                                <span class="badge" style="background-color: #757575; color: white;">
                                                    <i class="mdi mdi-check-circle"></i> Completed
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info">
                <i class="mdi mdi-information"></i> No ongoing timeframes at the moment.
            </div>
        @endif
    </div>

    <style>
        .timeline-wrapper {
            background: #ffffff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            overflow-x: auto;
        }

        .timeline-header {
            border-bottom: 2px solid #e0e0e0;
            margin-bottom: 24px;
        }

        .timeline-months {
            display: flex;
            border-bottom: 1px solid #e0e0e0;
        }

        .month-label {
            padding: 12px 8px;
            text-align: center;
            font-weight: 600;
            font-size: 14px;
            color: #455a64;
            text-transform: uppercase;
            background: #f5f5f5;
        }

        .timeline-days {
            display: flex;
        }

        .day-cell {
            flex: 1;
            min-width: 50px;
            padding: 8px 4px;
            text-align: center;
            border-right: 1px solid #eeeeee;
            background: #fafafa;
            transition: background 0.2s;
        }

        .day-cell:hover {
            background: #f0f0f0;
        }

        .day-cell.today {
            background: #e3f2fd;
            border-right: 1px solid #2196F3;
            border-left: 1px solid #2196F3;
        }

        .day-cell.weekend {
            background: #fafafa;
        }

        .day-number {
            font-weight: 600;
            font-size: 16px;
            color: #212121;
        }

        .day-name {
            font-size: 11px;
            color: #757575;
            text-transform: uppercase;
        }

        .timeline-body {
            position: relative;
            min-height: 300px;
            padding: 16px 0;
            display: flex;
            flex-direction: column;
        }

        .timeline-row {
            position: relative;
            height: 60px;
            margin-bottom: 16px;
        }

        .timeline-bar-pill {
            position: absolute;
            height: 50px;
            border-radius: 25px;
            padding: 12px 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
            cursor: pointer;
            z-index: 1;
        }

        .timeline-bar-pill:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.25);
            z-index: 2;
        }

        .pill-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .pill-title {
            font-weight: 600;
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .pill-badge {
            width: 24px;
            height: 24px;
            background: rgba(255,255,255,0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .pill-dates {
            font-size: 11px;
            opacity: 0.9;
            margin-top: 2px;
        }

        .today-line {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 3px;
            background: #f44336;
            z-index: 10;
            box-shadow: 0 0 10px rgba(244, 67, 54, 0.5);
        }

        .today-line::before {
            content: 'TODAY';
            position: absolute;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            background: #f44336;
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
            white-space: nowrap;
            box-shadow: 0 2px 8px rgba(244, 67, 54, 0.3);
        }

        .timeline-legend {
            display: flex;
            gap: 24px;
            padding-top: 16px;
            border-top: 1px solid #e0e0e0;
            flex-wrap: wrap;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #616161;
        }

        .legend-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
        }

        .today-indicator-small {
            width: 3px;
            height: 16px;
            background: #f44336;
            display: inline-block;
            border-radius: 2px;
        }

        @media (max-width: 768px) {
            .timeline-wrapper {
                padding: 16px;
            }
            
            .day-cell {
                min-width: 40px;
            }

            .pill-title {
                font-size: 12px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchFilter');
            const statusFilter = document.getElementById('statusFilter');
            const startDateFilter = document.getElementById('startDateFilter');
            const endDateFilter = document.getElementById('endDateFilter');
            const sortFilter = document.getElementById('sortFilter');
            const clearBtn = document.getElementById('clearFilter');
            const resultCount = document.getElementById('resultCount');
            const timelineRows = document.querySelectorAll('.timeline-row');
            const tableRows = document.querySelectorAll('tbody tr');

            function filterTimeframes() {
                const searchTerm = searchInput.value.toLowerCase();
                const statusValue = statusFilter.value;
                const startDate = startDateFilter.value ? new Date(startDateFilter.value) : null;
                const endDate = endDateFilter.value ? new Date(endDateFilter.value) : null;
                let visibleCount = 0;

                // Create array to hold rows with their data for sorting
                let rowsData = [];

                // First, hide all rows
                timelineRows.forEach((row, index) => {
                    row.style.display = 'none';
                    if (tableRows[index]) tableRows[index].style.display = 'none';
                });

                // Filter timeline rows
                timelineRows.forEach((row, index) => {
                    const eventType = row.getAttribute('data-event-type');
                    const status = row.getAttribute('data-status');
                    const rowStartDate = new Date(row.getAttribute('data-start-date'));
                    const rowEndDate = new Date(row.getAttribute('data-end-date'));
                    const tableRow = tableRows[index];
                    
                    const matchesSearch = eventType.includes(searchTerm);
                    const matchesStatus = statusValue === 'all' || status === statusValue;
                    
                    // Check date range
                    let matchesDate = true;
                    if (startDate && rowEndDate < startDate) {
                        matchesDate = false;
                    }
                    if (endDate && rowStartDate > endDate) {
                        matchesDate = false;
                    }
                    
                    const isVisible = matchesSearch && matchesStatus && matchesDate;
                    
                    if (isVisible) {
                        visibleCount++;
                        rowsData.push({
                            timelineRow: row,
                            tableRow: tableRow,
                            eventType: eventType,
                            startDate: rowStartDate,
                            originalIndex: index
                        });
                    }
                });

                // Sort rows based on selected option
                const sortValue = sortFilter.value;
                if (sortValue !== 'default') {
                    rowsData.sort((a, b) => {
                        switch(sortValue) {
                            case 'name-asc':
                                return a.eventType.localeCompare(b.eventType);
                            case 'name-desc':
                                return b.eventType.localeCompare(a.eventType);
                            case 'date-asc':
                                return a.startDate - b.startDate;
                            case 'date-desc':
                                return b.startDate - a.startDate;
                            default:
                                return a.originalIndex - b.originalIndex;
                        }
                    });
                }

                // Show filtered and sorted rows by reordering them in the DOM
                const timelineBody = document.querySelector('.timeline-body');
                const tableBody = document.querySelector('tbody');
                
                rowsData.forEach((data, newIndex) => {
                    data.timelineRow.style.display = '';
                    data.timelineRow.style.order = newIndex;
                    if (data.tableRow) {
                        data.tableRow.style.display = '';
                    }
                });

                // Update result count
                resultCount.textContent = visibleCount;
            }

            searchInput.addEventListener('input', filterTimeframes);
            statusFilter.addEventListener('change', filterTimeframes);
            startDateFilter.addEventListener('change', filterTimeframes);
            startDateFilter.addEventListener('input', filterTimeframes);
            endDateFilter.addEventListener('change', filterTimeframes);
            endDateFilter.addEventListener('input', filterTimeframes);
            sortFilter.addEventListener('change', filterTimeframes);
            
            clearBtn.addEventListener('click', function() {
                searchInput.value = '';
                statusFilter.value = 'all';
                startDateFilter.value = '';
                endDateFilter.value = '';
                sortFilter.value = 'default';
                filterTimeframes();
            });
            
            // Apply default sorting on page load
            filterTimeframes();
        });
    </script>
@endsection
