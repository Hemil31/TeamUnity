@extends('layouts.master')
@section('title', 'employee')
@section('page-title', 'Employee Details')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="mb-3 d-flex">
                    <form action="" method="GET" class="form-inline flex-grow-1 mr-2">
                        <div class="form-group flex-grow-1">
                            <input type="text" name="query" class="form-control mr-2 w-30"
                                placeholder="Search by name or email">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </form>
                    <a href="{{ route('employee.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> <!-- Add Icon -->
                        Add Employee Detail
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Sr</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Email</th>

                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->first_name }}</td>
                                    <td>{{ $item->last_name }}</td>
                                    <td>{{ $item->email }}</td>


                                    <td>
                                        <div class="btn-group" aria-label="Actions">
                                            <a href="{{ route('employee.edit', $item->id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> <!-- Edit Icon -->
                                            </a>
                                            <a href="{{ route('employee.show', $item->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> <!-- View Icon -->
                                            </a>
                                            <form action="{{ route('employee.destroy', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete?')">
                                                    <i class="fas fa-trash-alt"></i> <!-- Delete Icon -->
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
