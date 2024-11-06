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
                        <a href="#">account</a>
                    </li>
                    <li class="breadcrumb-item text-uppercase active" aria-current="page">
                        <a href="#">list</a>
                    </li>
                </ol>
            </nav>
            <div class="d-flex">
                <a class="btn btn-info" href="#">add account</a>
            </div>
        </div>
    </nav>
    <div class="card shadow-1-soft">
        <div class="card-body">
            {{ $accounts }}
            {{-- <h5 class="card-title text-capitalize mb-4">create bank account</h5> --}}
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="text-uppercase">
                        <tr>
                            <th>
                                <div class="form-check">
                                    <input class="form-check-input" name="" id="" type="checkbox"
                                        value="check-all" aria-label="Text for screen reader" />
                                </div>
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
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" name="" id="" type="checkbox"
                                        value="check-all" aria-label="Text for screen reader" />
                                </div>
                            </td>
                            <td>HDFC Bank</td>
                            <td>1234567890</td>
                            <td>savings</td>
                            <td>active</td>
                            <td>$1000.00</td>
                            <td>
                                <a title="view" class="btn"
                                    href="{{ route('account.show', [$account->id ?? 1, 1]) }}"><i
                                        class="fas fa-eye"></i></a>

                                <a title="edit" class="btn"
                                    href="{{ route('account.edit', [$account->id ?? 1, 1]) }}"><i
                                        class="fas fa-pen-to-square"></i></a>
                            </td>
                        </tr>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
