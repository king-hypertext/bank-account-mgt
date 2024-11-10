@extends('layout.index')
@section('content')
    @use(Carbon\Carbon)
    <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary my-3 shadow-0 position-sticky d-none"
        style="top: 60px;z-index: 50;">
        <div class="container-fluid d-flex justify-content-between">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item text-uppercase">
                        <a href="#">{{ env('APP_NAME') }}</a>
                    </li>
                    <li class="breadcrumb-item text-uppercase">
                        <a href="#">account name and number</a>
                    </li>
                    <li class="breadcrumb-item text-uppercase active" aria-current="page">
                        <a href="#">entries</a>
                    </li>
                </ol>
            </nav>
            <div class="d-flex">
                {{-- <a class="btn btn-info" href="#">add account</a> --}}
            </div>
        </div>
    </nav>
@section('name')
    {{ $account->bank_name . ': ' . $account->account_number }}
@endsection
<div class="card shadow-1-soft">
    <div class="card-body">
        <!-- Tabs navs -->
        <ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
            <li class="nav-item" role="presentation">
                <a data-mdb-tab-init class="nav-link active" id="ex3-tab-1" href="#ex3-tabs-1" role="tab"
                    aria-controls="ex3-tabs-1" aria-selected="true">bank entries</a>
            </li>
            <li class="nav-item" role="presentation">
                <a data-mdb-tab-init class="nav-link" id="ex3-tab-2" href="#ex3-tabs-2" role="tab"
                    aria-controls="ex3-tabs-2" aria-selected="false">reports</a>
            </li>
            <li class="nav-item" role="presentation">
                {{-- <a data-mdb-tab-init class="nav-link" id="ex3-tab-3" href="#ex3-tabs-3" role="tab"
                    aria-controls="ex3-tabs-3" aria-selected="false">Another link</a> --}}
            </li>
        </ul>
        <!-- Tabs navs -->

        <!-- Tabs content -->
        <div class="tab-content" id="ex2-content">
            <div class="tab-pane fade show active" id="ex3-tabs-1" role="tabpanel" aria-labelledby="ex3-tab-1">
                <div class="d-flex justify-content-end">
                    @if ($account->entries->isNotEmpty())
                        <button title="Reconcile Entries" class="btn btn-success reconcile-entries mx-1" disabled>
                            reconcile <i class="fas fa-check ms-1"></i>
                        </button>
                    @endif
    
                    {{-- <a class="btn btn-info" href="{{ route('entries.create', $account_location->id) }}">create entry</a> --}}
                </div>
                <table class="table align-middle" id="table-list-entry">
                    <thead class="text-uppercase">
                        <tr>
                            <th>
                                @if ($account->entries->isNotEmpty())
                                    <button title="Delete selected entries"
                                        class="btn btn-danger delete-entries py-1 px-2" disabled>
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
                        @forelse ($account->entries as $entry)
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
            <div class="tab-pane fade" id="ex3-tabs-2" role="tabpanel" aria-labelledby="ex3-tab-2">
                Tab 2 content
            </div>
            {{-- <div class="tab-pane fade" id="ex3-tabs-3" role="tabpanel" aria-labelledby="ex3-tab-3">
                Tab 3 content
            </div> --}}
        </div>
        <!-- Tabs content -->
    </div>
</div>
@endsection
