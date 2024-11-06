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
                        <a href="#">create</a>
                    </li>
                </ol>
            </nav>
            {{-- <div class="d-flex">
                <a class="btn btn-info" href="#">add account</a>
            </div> --}}
        </div>
    </nav>
    <div class="card shadow-1-soft">
        <div class="card-body">
            <h5 class="card-title text-capitalize mb-4">create bank account</h5>
            <div class="list-group">
                <!-- Add recent activity items here -->
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row mb-3">
                    <label for="ref" class="col-sm-2 col-form-label text-uppercase">ref</label>
                    <div class="col-sm-10">
                        <input type="ref" class="form-control" id="ref">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="bank_namme" class="col-sm-2 col-form-label text-uppercase">bank namme</label>
                    <div class="col-sm-10">
                        <input type="bank_namme" class="form-control" id="bank_namme">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="account_name" class="col-sm-2 col-form-label text-uppercase">account name</label>
                    <div class="col-sm-10">
                        <input type="account_name" class="form-control" id="account_name">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="account_type" class="col-sm-2 col-form-label text-uppercase">account type</label>
                    <div class="col-auto">
                        <select name="account_type" class="form-select" id="account_type">
                            {{-- {{-- @forelse ($categories as $category) --}}
                            <option value="">savings</option>
                            <option value="">current</option>
                            {{-- @empty 
                        @endforelse --}}
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="account_address" class="col-form-label text-uppercase col-sm-2 pt-0">account address</label>
                    <div class="col-sm-10">
                        <input type="account_address" class="form-control" id="account_address" />
                    </div>
                </div> 
                <div class="row mb-3">
                    <label for="initial_amount" class="col-form-label text-uppercase col-sm-2 pt-0">initial amount</label>
                    <div class="col-sm-10">
                        <input type="initial_amount" class="form-control" id="initial_amount" />
                    </div>
                </div>
                <fieldset class="row mb-3">
                    <label for="status" class="col-form-label text-uppercase col-sm-2 pt-0">status</label>
                    <div class="col-auto">
                        <div class="mb-3">
                            <select class="form-select select2" name="status" id="status">
                                {{-- {{-- @forelse ($districts as $district) --}}
                                <option value="">open</option>
                                <option value="">close</option>
                                {{-- @empty 
                            @endforelse --}}
                            </select>
                        </div>

                    </div>
                </fieldset>
                <fieldset class="row mb-3">
                    <label for="date" class="col-form-label text-uppercase col-sm-2 pt-0">date</label>
                    <div class="col-sm-10">
                        <input type="date" value="{{ now()->format('Y-m-d') }}" class="form-control" name="date"
                            id="date" placeholder="" />
                    </div>
                </fieldset>
                <div class="d-flex justify-content-end mb-3">

                    <button type="button" class="btn btn-primary">save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
