@extends('layout.index')
@section('content')
    @use(Carbon\Carbon)
    <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary my-3 shadow-0 position-sticky"
        style="top: 60px;z-index: 50;">
        <div class="container-fluid d-flex justify-content-between">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item text-uppercase">
                        <a href="#">{{ env('APP_NAME') }}</a>
                    </li>
                    <li class="breadcrumb-item text-uppercase">
                        <a href="#">accounts</a>
                    </li>
                    <li class="breadcrumb-item text-uppercase active" aria-current="page">
                        <a href="#">entries</a>
                    </li>
                </ol>
            </nav>
            <div class="d-flex">
                @if ($entries->isNotEmpty())
                    <button title="Reconcile Entries" class="btn btn-success reconcile-entries mx-1" disabled>
                        reconcile <i class="fas fa-check ms-1"></i>
                    </button>
                @endif

                <a class="btn btn-info" href="{{ route('entries.create', $account_location->id) }}">create entry</a>
            </div>
        </div>
    </nav>
    <div class="card shadow-1-soft">
        <div class="card-body p-1">
            <div class="table-responsive">
                <table class="table align-middle" id="table-list-entry">
                    <thead class="text-uppercase">
                        <tr>
                            <th>
                                @if ($entries->isNotEmpty())
                                    <button title="delete selected entries" class="btn btn-danger delete-entries py-1 px-2"
                                        disabled>
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                @endif
                            </th>
                            <th scope="col">bank name</th>
                            {{-- <th scope="col">account number</th> --}}
                            {{-- <th scope="col">account type</th> --}}
                            <th scope="col">debit(ghs)</th>
                            <th scope="col">credit(ghs)</th>
                            <th scope="col">description</th>
                            <th scope="col">ref. number</th>
                            <th scope="col">date</th>
                            <th scope="col">actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($entries as $entry)
                            <tr
                                class="border-bottom table-{{ $entry->is_reconciled ? 'secondary' : '' }} border-{{ $entry->entryType->type === 'debit' ? 'danger' : 'success' }}">
                                <td class=" m-0">

                                    <div class="form-check-inline m-0">
                                        <input class="form-check-input check-account"
                                            {{ $entry->is_reconciled ? 'disabled' : '' }}
                                            value="{{ $entry->is_reconciled ? '' : $entry->id }}" type="checkbox" />
                                    </div>
                                </td>
                                <td class="text-uppercase">{{ $entry->account->bank_name }}</td>
                                {{-- <td>{{ $entry->account->account_number }}</td> --}}
                                {{-- <td>{{ $entry->account->accountType->type }}</td> --}}
                                <td>
                                    <span
                                        class="fw-bold text-{{ $entry->entryType->type === 'debit' ? 'danger' : 'success' }}">
                                        @if ($entry->entryType->type === 'debit')
                                            {{ '-' . $entry->amount }}
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="fw-bold text-{{ $entry->entryType->type === 'debit' ? 'danger' : 'success' }}">
                                        @if ($entry->entryType->type === 'credit')
                                            {{ '+' . $entry->amount }}
                                        @endif
                                    </span>
                                </td>
                                <td>{{ $entry->description }}</td>
                                <td>{{ $entry->reference_number }}</td>
                                <td class="text-nowrap">{{ Carbon::parse($entry->created_at)->format('Y-m-d') }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a title="edit" class="btn btn-warning p-1 mx-1"
                                            href="{{ route('entries.edit', [$account_location->id, $entry->id]) }}">
                                            <i class="fas fa-pen-to-square"></i>
                                        </a>
                                        @if (!$entry->is_reconciled)
                                            <button title="delete" data-id="{{ $entry->id }}"
                                                data-url="{{ route('entries.destroy', [$account_location->id, $entry->id]) }}"
                                                class="btn btn-danger p-1 mx-1 delete-entry" href="#">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <script>
        // var ids = [];
        // $('input[type="checkbox"].check-account').on('change', function(e) {
        //     e.currentTarget.checked ? ids.push($(this).val()) : ids.pop($(this).val());
        //     console.log(ids);
        // });
        $(document).ready(function() {
            $('.delete-entry').click(function(e) {
                e.preventDefault();
                var id = $(this).data('id'),
                    url = $(this).data('url');

                if (confirm('Delete this entry?')) {
                    $.ajax({
                        url,
                        type: 'DELETE',
                        success: function(response) {
                            window.open(response.url, '_self');
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                }
            });
            // Initialize button state
            updateButtonState();

            function updateButtonState() {
                const checkboxes = $('table#table-list-entry input[type="checkbox"].check-account:checked');
                const reconcileButton = $('button.reconcile-entries'); // Replace with your button selector
                const deleteButton = $('button.delete-entries'); // Replace with your button selector

                if (checkboxes.length > 0) {
                    reconcileButton.removeAttr('disabled');
                    deleteButton.removeAttr('disabled');
                } else {
                    reconcileButton.attr('disabled', 'disabled');
                    deleteButton.attr('disabled', 'disabled');
                }
                if (checkboxes.length > 1) {
                    deleteButton.removeAttr('disabled');
                } else {
                    deleteButton.attr('disabled', 'disabled');
                }
            }
            var entries = []; // Declare array outside function scope

            // Initialize button state
            updateButtonState();

            // Listen for checkbox changes
            $('table#table-list-entry input[type="checkbox"].check-account').change(function() {
                const checkboxId = $(this).val();
                const isChecked = $(this).is(':checked');

                if (isChecked) {
                    entries.push(checkboxId);
                } else {
                    entries = entries.filter(id => id !== checkboxId);
                }
                updateButtonState();
                console.log(entries);

            });
            $('button.reconcile-entries').click(function() {
                // Reconcile entries
                if (!confirm('Confirm Reconcile Entries')) {
                    return false;
                }
                $.ajax({
                    url: "",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        entries: entries
                    },
                    success: function(response) {
                        window.open(response.url, '_self');
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });
            $('button.delete-entries').click(function() {
                // Delete entries
                if (!confirm('Confirm Delete Entries')) {
                    return false;
                }
                $.ajax({
                    url: "",
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}",
                        entries: entries
                    },
                    success: function(response) {
                        window.open(response.url, '_self');
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
