@extends('layouts.master')

@section('title', 'Company')
@section('page-title', 'Company')

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
                    <a href="{{ route('companies.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> <!-- Add Icon -->
                        Add Company Detail
                    </a>
                </div>
                <form action="{{ route('companies.index') }}" method="GET" class="mb-3">
                    @csrf
                    @method('PUT')
                    <select name="category" style="width: 150px;float: right;" onchange="this.form.submit()">
                        <option value="" {{ request('category') == '' ? 'selected' : '' }}>Select Category</option>
                        <option value="active" {{ request('category') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('category') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </form>
                <br><br>
                <div class="table">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Logo</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Website</th>
                                <th scope="col">Status</th>
                                <th scope="col">Updated Date</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td style="width: 120px;">
                                        <img src="{{ asset('storage/logo/' . $item->logo) }}" alt="{{ $item->name }} Logo"
                                            class="img-fluid img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td style="max-width: 100px; word-wrap: break-word;  "><a href="{{ $item->website }}"
                                            target="_blank">{{ $item->website }}</a></td>
                                    <td>
                                        @if ($item->status == 'active')
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->updated_at->format('d-m-Y') }}</td>
                                    <td>
                                        @if ($item->status == 'active')
                                            <div class="btn-group" aria-label="Actions">
                                                <a href="{{ route('companies.edit', $item->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i> <!-- Edit Icon -->
                                                </a>&nbsp;&nbsp;
                                                <a href="{{ route('companies.show', $item->id) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> <!-- View Icon -->
                                                </a>&nbsp;&nbsp;
                                                <form action="{{ route('companies.destroy', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete?')">
                                                        <i class="fas fa-trash-alt"></i> <!-- Delete Icon -->
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <form action="{{ route('companies.restore', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-success"
                                                    onclick="return confirm('Are you sure you want to restore?')">
                                                    <i class="fas fa-undo"></i> <!-- Restore Icon -->
                                                    Restore
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
