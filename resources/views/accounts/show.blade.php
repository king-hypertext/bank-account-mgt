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
                        <a href="#">account name and number</a>
                    </li>
                    <li class="breadcrumb-item text-uppercase active" aria-current="page">
                        <a href="#">entries</a>
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
            {{-- <h5 class="card-title text-capitalize mb-4">create bank account</h5> --}}
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="text-uppercase">
                        <tr>
                            <th>
                                #
                            </th>
                            <th scope="col">ref</th>
                            <th scope="col">description</th>
                            <th scope="col">entries date</th>
                            <th scope="col">value date</th>
                            <th scope="col">credit</th>
                            <th scope="col">debit</th>
                            <th scope="col">
                                <div class="form-check">
                                    <input class="form-check-input" name="" id="" type="checkbox"
                                        value="check-all" aria-label="Text for screen reader" />
                                </div>
                            </th>
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
                            <td>32324</td>
                            <td>lorem ipsum dolet</td>
                            <td>{{ now()->format('Y-m-d') }}</td>
                            <td>{{ now()->format('Y-m-d') }}</td>
                            <td class="text-success">$1000.00</td>
                            <td class="text-danger">
                                0
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" name="" id="" type="checkbox"
                                        value="check-all" aria-label="Text for screen reader" />
                                </div>
                            </td>
                        </tr>
                        <tfoot>
                            <tr>
                                <td colspan="2" align="right">
                                    Total
                                </td>
                                <td colspan="4" align="right">
                                    $1000.00
                                </td>
                                <td colspan="2">
                                    $1000.00
                                </td>
                            </tr>
                        </tfoot>
                        </tfoot>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
