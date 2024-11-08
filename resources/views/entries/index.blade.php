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
                <a class="btn btn-info" href="{{ route('entries.create', $account_location->id) }}">create entry</a>
            </div>
        </div>
    </nav>
    <div class="card shadow-1-soft">
        <div class="card-body">
            {{-- {{ $accounts }} --}}
            {{-- <h5 class="card-title text-capitalize mb-4">create bank account</h5> --}}
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="text-uppercase">
                        <tr>
                            <th>
                                {{-- <div class="form-check">
                                    <input readonly class="form-check-input" id="check-all-accounts" type="checkbox" />
                                </div> --}}
                            </th>
                            <th scope="col">bank name</th>
                            <th scope="col">account number</th>
                            <th scope="col">account type</th>
                            <th scope="col">debit</th>
                            <th scope="col">credit</th>
                            <th scope="col">description</th>
                            <th scope="col">ref. number</th>
                            <th scope="col">date</th>
                            <th scope="col">actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($entries as $entry)
                            <tr
                                class="border-bottom border-{{ $entry->entryType->type === 'debit' ? 'danger' : 'success' }}">
                                <td>
                                    <div class="form-check-inline">
                                        <input class="form-check-input check-account" value="{{ $entry->id }}"
                                            type="checkbox" />
                                    </div>
                                </td>
                                <td>{{ $entry->account->bank_name }}</td>
                                <td>{{ $entry->account->account_number }}</td>
                                <td>{{ $entry->account->accountType->type }}</td>
                                <td>
                                    <span class="text-{{ $entry->entryType->type === 'debit' ? 'danger' : 'success' }}">
                                        @if ($entry->entryType->type === 'debit')
                                            {{ '-' . $entry->amount }}
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <span class="text-{{ $entry->entryType->type === 'debit' ? 'danger' : 'success' }}">
                                        @if ($entry->entryType->type === 'credit')
                                            {{ $entry->amount }}
                                        @endif
                                    </span>
                                </td>
                                <td>{{ $entry->description }}</td>
                                <td>{{ $entry->reference_number }}</td>
                                <td>{{ Carbon::parse($entry->created_at)->format('Y-m-d') }}</td>
                                <td>
                                    <a title="view" class="btn" href="#"><i class="fas fa-eye"></i></a>
                                    <a title="edit" class="btn" href="#"><i class="fas fa-pen-to-square"></i></a>
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
        var ids = [];
        $('input[type="checkbox"].check-account').on('change', function(e) {
            e.currentTarget.checked ? ids.push($(this).val()) : ids.pop($(this).val());
            console.log(ids);
        });
    </script>
@endsection
