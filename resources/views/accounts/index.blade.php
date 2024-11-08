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
                        <a href="#">bank list</a>
                    </li>
                    <li class="breadcrumb-item text-uppercase active" aria-current="page">
                        <a href="#">accounts</a>
                    </li>
                </ol>
            </nav>
            <div class="d-flex">
                <a class="btn btn-info clone-btn me-2" data-url="{{ route('l.clone', $account_location->id) }}"
                    title="clone accounts">clone
                    <i class="fa-regular fa-clone"></i>
                </a>
                <a class="btn btn-info" href="{{ route('account.create', $account_location->id) }}">add account</a>
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
                            <th scope="col">account status</th>
                            <th scope="col">balance</th>
                            <th scope="col">operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($accounts as $account)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input check-account" value="{{ $account->id }}"
                                            type="checkbox" />
                                    </div>
                                </td>
                                <td>{{ $account->bank_name }}</td>
                                <td>{{ $account->account_number }}</td>
                                <td>{{ $account->accountType->type }}</td>
                                <td>{{ $account->accountStatus->status }}</td>
                                <td>{{ $account->currency . ' ' . $account->balance }}</td>
                                <td>
                                    {{-- <a title="view" class="btn" href="#"><i class="fas fa-eye"></i></a> --}}
                                    <a title="edit" class="btn"
                                        href="{{ route('account.edit', [$account_location->id, $account->id]) }}"><i
                                            class="fas fa-pen-to-square"></i></a>
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
@section('script')
    <script>
        $(document).ready(function() {
            $('.clone-btn').click(function() {
                if (!confirm('Confirm cloning accounts?')) {
                    return false;
                }
                const url = $(this).data('url');
                const $button = $(this);
                const $loader = $('.loader-overlay');

                $.ajax({
                    url,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function() {
                        $button.prop('disabled', true);
                        $loader.show().find('.loader-text').text('Cloning...');
                    },
                    success: function(response) {
                        if (response.success) {
                            window.open(response.url, '_blank');
                        } else {
                            alert(`Failed to clone model: ${response.message}`);
                        }
                        $button.prop('disabled', false);
                        $loader.hide();
                    },
                    error: function(xhr, status, error) {
                        alert(`An error occurred: ${xhr.responseText}`);
                        $button.prop('disabled', false);
                        $loader.hide();
                    }
                });
            });
        });
    </script>
@endsection
