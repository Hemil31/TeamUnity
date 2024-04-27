@extends('layouts.master')
@section('title', 'Company')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="mb-4">Company Details</h2>
                <a href="{{ route('companies.create') }}" class="btn btn-success mb-3">Add Company Detail</a>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Logo</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Website</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td style="width: 120px;"> <!-- Adjusted width for the logo -->
                                        <img src="{{ asset('storage/logo/' . $item->logo) }}"
                                            alt="{{ $item->name }} Logo" class="img-thumbnail"
                                            style="width: 100px; height: 100px;">
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td><a href="{{ $item->website }}" target="_blank">{{ $item->website }}</a></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Actions">
                                            <a href="{{ route('companies.edit', $item->id) }}"
                                                class="btn btn-primary">Edit</a>
                                            <a href="{{ route('companies.show', $item->id) }}"
                                                class="btn btn-info">View</a>
                                            <form action="{{ route('companies.destroy', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete?')">Delete</button>
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
