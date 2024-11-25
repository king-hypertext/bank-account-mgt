@extends('layout.index')
@section('content')
    @use(Carbon\Carbon)
    <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary my-3 shadow-0 position-sticky d-"
        style="top: 60px;z-index: 50;">
        <div class="container-fluid d-flex justify-content-between">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item text-uppercase">
                        <a href="#">{{ $account_location->name }}</a>
                    </li>
                    <li class="breadcrumb-item text-uppercase">
                        <a href="#">{{ $account->bank_name }}</a>
                    </li>
                    <li class="breadcrumb-item text-uppercase active" aria-current="page">
                        <a href="#">{{ $account->name }}</a>
                    </li>
                </ol>
            </nav>
        </div>
    </nav>
@section('name')
    {{ $account->bank_name . ': ' . $account->account_number }}
@endsection
<style>
    /* @media print {
        .print-table-bordered {
            border-collapse: collapse !important;
            -webkit-print-color-adjust: exact !important;
            -moz-print-color-adjust: exact !important;
            -o-print-color-adjust: exact !important;
        }

        .print-table-bordered th,
        .print-table-bordered td,
        .print-table-bordered {
            border: 1px solid #000;
            border-right: 1px solid #000 !important;
        }

        #table-statements {
            page-break-after: always;
        }

        #table-statements td:nth-child(1) {
            padding: 2px !important;
        }

        #table-statements tr {
            page-break-inside: avoid;
        }

        #table-statements tr:nth-child(even) {
            background-color: #f2f2f2 !important;
        }

        #table-statements tr:last-child {
            page-break-after: avoid;
        }

        #table-statements tr:first-child {
            page-break-before: always;
        }

        #table-statements td:first-child {
            white-space: nowrap !important;
        }

        .text-nowrap {
            white-space: nowrap !important;
        }

    } */
    @media print {
        .p-bold {
            font-weight: 600 !important;
            color: #000000 !important;
            text-transform: uppercase !important;
        }

        table th {
            font-weight: 700 !important;
            color: #000000 !important;
            background: rgb(214, 214, 214);
        }
    }
</style>
<div class="card shadow-1-soft">
    <div class="card-body">
        <!-- Tabs navs -->
        <ul class="nav nav-tabs n mb-3" id="accountTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button data-mdb-tab-init class="nav-link" id="account-tab" role="tab" aria-controls="account"
                    aria-selected="false" data-mdb-target="#account">account</button>
            </li>
            <li class="nav-item" role="presentation">
                <button data-mdb-tab-init class="nav-link" id="entries-tab" role="tab" aria-controls="entries"
                    aria-selected="true" data-mdb-target="#entries">bank entries</button>
            </li>
            <li class="nav-item" role="presentation">
                <button data-mdb-tab-init class="nav-link" id="reports-tab" role="tab" aria-controls="reports"
                    aria-selected="false" data-mdb-target="#reports">reports & statements</button>
            </li>
        </ul>
        <!-- Tabs navs -->

        <!-- Tabs content -->
        <div class="tab-content" id="account-tab-content">
            <div class="tab-pane fade" id="entries" role="tabpanel" aria-labelledby="entries">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="table-action-btns">
                        <button id="excelButton" class="btn text-white me-1" data-mdb-ripple-init
                            style="background-color: #438162;" title="Export table to excel" type="button">
                            <i class="fas fa-print me-1"></i>
                            Excel
                        </button>
                        {{-- <button id="pdfButton" class="btn text-white mx-1" data-mdb-ripple-init
                            style="background-color: #ee4a60;" title="Save table as PDF" type="button">
                            <i class="fas fa-file-pdf me-1"></i>
                            PDF
                        </button> --}}
                        <button id="printButton" class="btn text-white ms-1" data-mdb-ripple-init
                            style="background-color: #1179ce;" title="Click to print table" type="button">
                            <i class="fas fa-print me-1"></i>
                            print
                        </button>
                    </div>
                    <div class="">
                        @if ($account->accountStatus->status === 'open')
                            <a role="button" class="btn btn-info"
                                href="{{ route('entries.create', [$account_location->id, 'account' => $account->id]) }}">
                                create entry
                            </a>
                        @endif
                        <button title="Reconcile Entries" class="btn btn-success reconcile-entries mx-1" disabled>
                            reconcile <i class="fas fa-check ms-1"></i>
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle text-uppercase" id="table-account-entries">
                        <thead class="text-uppercase p-bold">
                            <tr>
                                <th scope="col" title="REFERENCE NUMBER">ref. number</th>
                                <th scope="col">description</th>
                                <th scope="col" title="PAYMENT DATE">pay. date</th>
                                <th scope="col" title="VALUE DATE">value date</th>
                                <th scope="col">debit</th>
                                <th scope="col">credit</th>
                                <th scope="col" title="ACCOUNT BALANCE">balance</th>
                                <th scope="col">actions</th>
                                <th>
                                    <div class="form-check">
                                        <input class="form-check-input" name="check-all" id="check-all"
                                            title="Select all" type="checkbox" />
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($account->entries as $entry)
                                <tr
                                    class="border-bottom table-{{ $entry->is_reconciled ? 'secondary' : '' }} border-{{ $entry->entryType->type === 'debit' ? 'danger' : 'success' }}">
                                    <td>{{ $entry->reference_number }}</td>
                                    <td>{{ $entry->description }}</td>
                                    <td class="text-nowrap">{{ Carbon::parse($entry->created_at)->format('d-M-Y') }}
                                    </td>
                                    <td class="text-nowrap">{{ Carbon::parse($entry->value_date)->format('d-M-Y') }}
                                    </td>
                                    <td align="right"
                                        class="fw-bold text-{{ $entry->entryType->type === 'debit' ? 'danger' : 'success' }}">
                                        @if ($entry->entryType->type === 'debit')
                                            {{ '-' . number_format($entry->amount, 2, '.', ',') }}
                                        @else
                                            --
                                        @endif
                                    </td>
                                    <td align="right"
                                        class="fw-bold text-{{ $entry->entryType->type === 'debit' ? 'danger' : 'success' }}">
                                        @if ($entry->entryType->type === 'credit')
                                            {{ number_format($entry->amount, 2, '.', ',') }}
                                        @else
                                            --
                                        @endif
                                    </td>
                                    <td class="fw-bold">

                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a title="Edit" class="btn text-warning p-1 mx-1"
                                                href="{{ route('entries.edit', [$account_location->id, $entry->id]) }}">
                                                <i class="fas fa-pen-to-square"></i>
                                            </a>
                                            @if (!$entry->is_reconciled)
                                                <button title="Delete" data-id="{{ $entry->id }}"
                                                    data-url="{{ route('entries.destroy', [$account_location->id, $entry->id]) }}"
                                                    class="btn text-danger p-1 mx-1 delete-entry" href="#">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="m-0">
                                        @if (!$entry->is_reconciled)
                                        <div class="form-check-inline m-0">
                                            <input class="form-check-input check-account-entry" autocomplete="off"
                                                {{ $entry->is_reconciled ? 'disabled' : '' }}
                                                value="{{ $entry->is_reconciled ? '' : $entry->id }}" type="checkbox" />
                                        </div>
                                    @endif
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-start">Total:</th>
                                <th id="total-debit"></th>
                                <th id="total-credit"></th>
                                <th id="total-balance"></th>
                                <th colspan="2"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="reports" role="tabpanel" aria-labelledby="reports">
                <div class="table-responsive">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="table-action-btns">
                            <button id="excelButtonStatement" class="btn text-white me-1" data-mdb-ripple-init
                                style="background-color: #438162;" title="Export table to excel" type="button">
                                <i class="fas fa-print me-1"></i>
                                Excel
                            </button>
                            <button id="printButtonStatement" class="btn text-white ms-1" data-mdb-ripple-init
                                style="background-color: #1179ce;" title="Click to print table" type="button">
                                <i class="fas fa-print me-1"></i>
                                print
                            </button>
                        </div>
                        <form id="filter-statement" class="d-flex justify-content-end">
                            <div class="input-group mb-3">
                                <span class="input-group-text border-0" id="search-addon">start date</i></span>
                                <input required type="date" name="start_date" class="form-control rounded"
                                    id="startDate" onchange="updateMinEndDate()"
                                    min="{{ Carbon::parse($entries->min('date'))->format('d-m-Y') }}"
                                    max="{{ Carbon::parse($entries->max('date'))->format('d-m-Y') }}"
                                    aria-label="Search" aria-describedby="search-addon" />
                                <span class="input-group-text border-0" id="search-addon">end date</i></span>
                                <input required type="date" name="end_date" class="form-control rounded"
                                    id="endDate" max="{{ Carbon::parse($entries->max('date'))->format('d-m-Y') }}"
                                    aria-label="Search" aria-describedby="search-addon" />
                                <button type="submit" class="btn btn-primary mx-2 rounded-1">filter</button>
                            </div>
                            <script>
                                function updateMinEndDate() {
                                    const startDate = document.getElementById('startDate').value;
                                    document.getElementById('endDate').min = startDate;
                                }
                            </script>
                        </form>
                    </div>

                    <table class="table print-table-bordered align-middle text-capitalize" id="table-statements">
                        <thead class="text-capitalize p-bold">
                            <tr>
                                <th scope="col" title="PAYMENT DATE">date</th>
                                <th scope="col">description</th>
                                <th scope="col" title="REFERENCE NUMBER">ref. number</th>
                                <th scope="col" title="VALUE DATE">value date</th>
                                <th scope="col">debit</th>
                                <th scope="col">credit</th>
                                <th scope="col" title="ACCOUNT BALANCE">balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($entries as $entry)
                                <tr
                                    class="border-bottom table-{{ $entry->is_reconciled ? 'secondary' : '' }} border-{{ $entry->entryType->type === 'debit' ? 'danger' : 'success' }}">
                                    <td class="text-nowrap">{{ Carbon::parse($entry->created_at)->format('d-M-Y') }}
                                    </td>
                                    <td>{{ $entry->description }}</td>
                                    <td>{{ $entry->reference_number }}</td>
                                    <td class="text-nowrap">{{ Carbon::parse($entry->value_date)->format('d-M-Y') }}
                                    </td>
                                    <td align="right"
                                        class="fw-bold text-{{ $entry->entryType->type === 'debit' ? 'danger' : 'success' }}">
                                        @if ($entry->entryType->type === 'debit')
                                            {{ '-' . number_format($entry->amount, 2, '.', ',') }}
                                        @else
                                            --
                                        @endif
                                    </td>
                                    <td align="right"
                                        class="fw-bold text-{{ $entry->entryType->type === 'debit' ? 'danger' : 'success' }}">
                                        @if ($entry->entryType->type === 'credit')
                                            {{ number_format($entry->amount, 2, '.', ',') }}
                                        @else
                                            --
                                        @endif
                                    </td>
                                    <td></td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-start">Total:</th>
                                <th id="total-debit"></th>
                                <th id="total-credit"></th>
                                <th id="total-balance"></th>
                                <th colspan="2"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="account">
                <div class="container-fluid mt-5">
                    <div class="d-flex justify-content-between mt-5">
                        <div class="row">
                            <div class="col-md-4 d-flex align-items-center">
                                <span class="p-3 shadow-1-strong">
                                    <i class="fa-solid fa-2xl fa-building-columns"></i>
                                </span>
                            </div>
                            <div class="col-md-8 d-flex align-items-center">
                                <ul class="list-unstyled mb-0 fw-semibold">
                                    <li>{{ $account->account_number }}</li>
                                    <li class="text-nowrap text-uppercase">{{ $account->bank_name }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <span
                                class="btn btn-{{ $account->accountStatus->status === 'open' ? 'success' : 'danger' }}">{{ $account->accountStatus->status }}</span>
                        </div>
                    </div>
                    <div class="row mt-5">
                        {{-- <h5>details</h5> --}}
                        <div class="col-4">
                            <table class="table table-bordered align-middle">
                                <tbody class="text-uppercase">
                                    <tr class="">
                                        <th scope="col">account type</th>
                                        <td class="fw-semibold" scope="col">{{ $account->accountType->type }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">currency</th>
                                        <td class="fw-semibold">{{ $account->currency }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">initial deposit</th>
                                        <td class="fw-semibold">{{ number_format($account->initial_amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">current balance</th>
                                        <td class="fw-semibold">{{ number_format($account->balance, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-6"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get('tab');
        if (tab) {
            let tabContent = tab.toString().replace(/-tab/, '');
            $(`#${tab}`).addClass('show active');
            $(`.tab-pane#${tabContent}`).addClass('show active');
        } else {
            $('#account-tab').addClass('show active');
            $('.tab-pane#account').addClass('show active');
        }

        // Update query parameter on tab change
        $('#accountTab button[data-mdb-tab-init]').on('click', function(e) {
            const tabIndex = $(e.target).attr('id');
            history.pushState({}, '', `?tab=${tabIndex}`);
            // location.reload();
        });
        $('#filter-statement').submit(function(e) {
            e.preventDefault();
            const formData = $(this).serialize();
            const currentUrl = window.location.href;
            const updatedUrl = `${currentUrl}&${formData}`;
            window.location.href = updatedUrl;
        });
        if (urlParams.get('start_date') && urlParams.get('end_date')) {
            $('[name="start_date"]').val(urlParams.get('start_date'));
            $('[name="end_date"]').val(urlParams.get('end_date'));
        }
        const formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'GHS',
        });
        var $balance = 0;
        $('#table-account-entries tbody tr').each(function() {
            var debit = Number.parseFloat(
                $(this).find('td').eq(4).text().replace('--', '0')
                .replace(',', '').replace('-', '').trim());
            var credit = Number.parseFloat(
                $(this).find('td').eq(5).text().replace('--', '0')
                .replace(',', '').trim());

            $balance += (credit - debit);

            $(this).find('td').eq(6).text(formatter.format($balance.toFixed(2))
                .toString().replace('GHS', ''));
        });
        const ACCOUNT_WITH_ENTRIES_TABLE = new DataTable('#table-account-entries', {
            // responsive: true,
            order: [
                // [0, 'desc']
                false
            ],
            columnDefs: [{
                    targets: [7],
                    orderable: false
                },
                {
                    targets: [8],
                    orderable: false
                }
            ],
            pageLength: 50,
            // buttons: ['copy', 'excel', 'pdf', 'csv', 'print'],
            footerCallback: function(row, data, start, end, display) {
                var api = this.api(),
                    data;
                var intVal = function(i) {
                    if (typeof i === 'string') {
                        return i.replace(/[\$,-]/g, '') * 1.00;
                    } else if (typeof i === 'number') {
                        return i.toString().replace(/-/g, '') * 1.00;
                    }
                };
                var total = api.column(5).data().reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0.00);
                var formatter = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'GHS',
                });
                var debitTotal = api.column(4, {
                    page: 'current'
                }).data().reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0.00);
                var creditTotal = api.column(5, {
                    page: 'current'
                }).data().reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0.00);
                var balanceTotal = creditTotal - debitTotal;
                $(api.column(4).footer()).addClass('text-danger fw-semibold d-inline-block').html(
                    formatter.format(debitTotal));
                $(api.column(5).footer()).addClass('text-success fw-semibold').html(formatter
                    .format(creditTotal));
                $(api.column(6).footer()).addClass('fw-semibold').html(formatter.format(
                    balanceTotal));
            },
            buttons: [{
                    extend: 'excel',
                    title: '{{ strtoupper($account_location->name . ' - ' . $account->bank_name) }} Entries   ',
                    filename: 'entries.excel',
                    text: '<i class="fas fa-print me-1"></i> excel',
                    className: 'btn text-white ms-1',
                    message: 'Printed on ' + new Date().toLocaleString(),
                    attr: {
                        "style": 'background-color: #438162;color: #fff',
                        "data-mdb-ripple-init": '',
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'pdf',
                    title: '{{ strtoupper($account_location->name . ' - ' . $account->bank_name) }} Entries   ',
                    filename: 'entries.pdf',
                    orientation: 'portrait',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6],
                    },
                    text: '<i class="fas fa-print me-1"></i> pdf',
                    className: 'btn text-white ms-1',
                    message: 'Printed on ' + new Date().toLocaleString(),
                    attr: {
                        "style": 'background-color: #ee4a60;color: #fff',
                        "data-mdb-ripple-init": '',
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print me-1"></i> print',
                    className: 'btn text-white ms-1',
                    title: '<span class="text-uppercase text-center"> {{ $account_location->name . ' - ' . $account->bank_name }} Entries </span>',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6],
                    },
                    orientation: 'portrait',
                    message: 'Printed on ' + new Date().toLocaleString(),
                    attr: {
                        "style": 'background-color: #44abff;color: #fff',
                        "data-mdb-ripple-init": '',
                    }
                }
            ],
            language: {
                paginate: {
                    first: 'First',
                    previous: 'Prev',
                    next: 'Next',
                    last: 'Last',
                }
            }
        });
        $('#pdfButton').on('click', function() {
            ACCOUNT_WITH_ENTRIES_TABLE.button(1).trigger();
        });
        $('#excelButton').on('click', function() {
            ACCOUNT_WITH_ENTRIES_TABLE.buttons(0).trigger();
        });
        $('#printButton').on('click', function() {
            ACCOUNT_WITH_ENTRIES_TABLE.button(2).trigger();
        });
        $('button.delete-entry').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id'),
                url = $(this).data('url');

            if (confirm('Delete this entry?')) {
                $.ajax({
                    url,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        window.open(response.url, '_self');
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            }
        });

        updateButtonState();

        function updateButtonState() {
            const checkboxes = $(
                'table#table-account-entries input[type="checkbox"].check-account-entry:checked');
            const reconcileButton = $('button.reconcile-entries'); // Replace with your button selector
            const deleteButton = $('button.delete-entries'); // Replace with your button selector
            console.log(checkboxes);

            if (checkboxes.length > 0) {
                reconcileButton.removeAttr('disabled');
                deleteButton.removeAttr('disabled');
            } else {
                reconcileButton.attr('disabled', 'disabled');
                deleteButton.attr('disabled', 'disabled');
            }
        }
        var entries = []; // Declare array outside function scope
        $('input[name="check-all"]').change(function() {
            const checkAll = $(this).is(':checked');
            console.log(checkAll);

            $('table#table-account-entries input[type="checkbox"].check-account-entry').each(
        function() {
                $(this).prop('checked', checkAll);
                if (checkAll) {
                    entries.push($(this).val());
                }
            });
            if (!checkAll) {
                entries = [];
            }
            updateButtonState();
        });
        $('table#table-account-entries input[type="checkbox"].check-account-entry').change(function() {
            const checkboxId = $(this).val();
            const isChecked = $(this).is(':checked');

            if (isChecked) {
                entries.push(checkboxId);
            } else {
                entries = entries.filter(id => id !== checkboxId);
                if (entries.length == 0) {
                    $('input[name="check-all"]').prop('checked', false);
                }
            }
            updateButtonState();
        });

        $('button.reconcile-entries').click(function() {
            // Reconcile entries
            if (!confirm('Confirm Reconcile Entries')) {
                return false;
            }
            $.ajax({
                url: "{{ route('entries.reconcile', $account_location->id) }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    entries
                },
                success: function(response) {
                    window.open(response.url, '_self');
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
        var $statementBalance = 0;
        $('#table-statements tbody tr').each(function() {
            var debit = Number.parseFloat(
                $(this).find('td').eq(4).text().replace('--', '0')
                .replace(',', '').replace('-', '').trim());
            var credit = Number.parseFloat(
                $(this).find('td').eq(5).text().replace('--', '0')
                .replace(',', '').trim());
            $statementBalance += (credit - debit);

            $(this).find('td').eq(6).text(formatter.format($statementBalance.toFixed(2))
                .toString().replace('GHS', ''));
        });
        const REPORTS_TABLE = new DataTable('#table-statements', {
            // responsive: true,
            order: [
                // [0, 'desc']
                false
            ],
            columnDefs: [{
                    targets: [6],
                    orderable: false
                },
                {
                    targets: [6],
                    orderable: false
                }
            ],
            pageLength: 50,
            // buttons: ['copy', 'excel', 'pdf', 'csv', 'print'],
            footerCallback: function(row, data, start, end, display) {
                var api = this.api(),
                    data;
                var intVal = function(i) {
                    if (typeof i === 'string') {
                        return i.replace(/[\$,-]/g, '') * 1.00;
                    } else if (typeof i === 'number') {
                        return i.toString().replace(/-/g, '') * 1.00;
                    }
                };
                var total = api.column(5).data().reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0.00);
                var formatter = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'GHS',
                });
                var debitTotal = api.column(4, {
                    page: 'current'
                }).data().reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0.00);
                var creditTotal = api.column(5, {
                    page: 'current'
                }).data().reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0.00);
                var balanceTotal = creditTotal - debitTotal;
                $(api.column(4).footer()).addClass('text-danger fw-semibold d-inline-block').html(
                    formatter.format(debitTotal));
                $(api.column(5).footer()).addClass('text-success fw-semibold').html(formatter
                    .format(creditTotal));
                $(api.column(6).footer()).addClass('fw-semibold').html(formatter.format(
                    balanceTotal));
            },
            buttons: [{
                    extend: 'excel',
                    title: '{{ strtoupper($account_location->name . ' - ' . $account->bank_name) }} STATEMENT   ',
                    filename: 'entries.excel',
                    text: '<i class="fas fa-print me-1"></i> excel',
                    className: 'btn text-white ms-1',
                    message: 'Printed on ' + new Date().toLocaleString(),
                    attr: {
                        "style": 'background-color: #438162;color: #fff',
                        "data-mdb-ripple-init": '',
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'pdf',
                    title: '{{ strtoupper($account_location->name . ' - ' . $account->bank_name) }} STATEMENT   ',
                    filename: 'entries.pdf',
                    orientation: 'portrait',
                    pageSize: 'Letter',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6],
                    },
                    text: '<i class="fas fa-print me-1"></i> pdf',
                    className: 'btn text-white ms-1',
                    message: 'Printed on ' + new Date().toLocaleString(),
                    attr: {
                        "style": 'background-color: #ee4a60;color: #fff',
                        "data-mdb-ripple-init": '',
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print me-1"></i> print',
                    className: 'btn text-white ms-1',
                    title: '<span class="text-uppercase text-center"> {{ $account_location->name . ' - ' . $account->bank_name }} STATEMENT </span>',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6],
                    },
                    orientation: 'portrait',
                    message: 'Printed on ' + new Date().toLocaleString(),
                    attr: {
                        "style": 'background-color: #44abff;color: #fff',
                        "data-mdb-ripple-init": '',
                    },
                    // customize: function(win) {
                    //     // Set paper margin
                    //     // $(win.document).find('table').addClass('print-table-bordered');
                    //     // $(win.document).find('table').addClass('print-table-bordered');
                    //     $(win.document.body).css('margin-left', '0').css('margin-right', '0')
                    //         .css('padding', '0');

                    //     // Add table borders
                    // },
                    messageBottom: "Statement of entries"
                }
            ],
            language: {
                paginate: {
                    first: 'First',
                    previous: 'Prev',
                    next: 'Next',
                    last: 'Last',
                }
            }
        });
        $('#excelButtonStatement').on('click', function() {
            REPORTS_TABLE.buttons(0).trigger();
        });
        $('#printButtonStatement').on('click', function() {
            REPORTS_TABLE.button(2).trigger();
        });
    });
</script>
@endsection
