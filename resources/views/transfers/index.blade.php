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
                        <a href="#">transfers</a>
                    </li>
                </ol>
            </nav>
            <div class="d-flex">
                <a class="btn btn-info" href="{{ route('transfers.create', $account_location->id) }}">create transfer</a>
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
                            <th scope="col">from account</th>
                            <th scope="col">to account</th>
                            <th scope="col">account type</th>
                            <th scope="col">description</th>
                            <th scope="col">debit</th>
                            <th scope="col">credit</th>
                            {{-- <th scope="col">ref. number</th> --}}
                            <th scope="col">date</th>
                            <th scope="col">actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transfers as $transfer)
                            <tr class="border-bottom border-{{ $transfer->transferType->type === "debit" ? "danger" : "success" }}">
                                {{-- <td>
                                    <div class="form-check-inline">
                                        <input class="form-check-input check-account" value="{{ $transfer->id }}"
                                            type="checkbox" />
                                    </div>
                                </td> --}}
                                <td>{{ $transfer->fromAccount->bank_name }}</td>
                                <td>{{ $transfer->toAccount->bank_name }}</td>
                                <td>{{ $transfer->notes }}</td>
                                <td>
                                    @if ($transfer->transferType->type === 'debit')
                                        {{ $transfer->amount }}
                                    @endif
                                </td>
                                <td>
                                    @if ($transfer->transferType->type === 'credit')
                                        {{ $transfer->amount }}
                                    @endif
                                </td>
                                {{-- <td>{{ $transfer->reference_number }}</td> --}}
                                <td>{{ Carbon::parse($transfer->created_at)->format('Y-m-d') }}</td>
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
