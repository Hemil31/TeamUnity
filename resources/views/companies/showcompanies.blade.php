@extends('layouts.master')
@section('title', 'Company Profile')
@section('page-title', 'Company Profile')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card mb-4">
                    <div class="card-header">
                        Company Details
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <h5 class="card-title">{{ $company->name }}</h5>
                                <p class="card-text">E-mail: {{ $company->email }}</p>
                                <p class="card-text">Website: <a href="{{ $company->website }}"
                                        target="_blank">{{ $company->website }}</a></p>
                                <!-- Add other company details here -->
                                <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-primary">Edit Company
                                    Profile</a>
                            </div>
                            <div class="col-md-3 text-right">
                                <img src="{{ asset('/storage/logo/' . $company->logo) }}" alt="{{ $company->name }} Logo"
                                    class="img-fluid" style="max-width: 150px; max-height: 150px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="mb-3 d-flex">

                    <div class="form-group flex-grow-1">
                        <a href="{{ route('employee.create', ['id' => encrypt($company->id)]) }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> <!-- Add Icon -->
                            Add Employee Detail
                        </a>
                    </div>
                    @if ($company->employees->count() > 0)
                        <a href="{{ route('excel', ['id' => $company->id]) }}"
                            class="btn btn-success form-group flex-grow">Download Excel</a>
                    @endif

                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="employee-show-table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Sr</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#employee-show-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('companies.show', $company->id) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'first_name',
                        name: 'first_name'
                    },
                    {
                        data: 'last_name',
                        name: 'last_name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
@endsection
