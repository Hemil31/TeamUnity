    @extends('layouts.master')
    @section('title', 'Company')

    @section('content')
        <div><br>
            <button type="button" class="btn btn-success" data-mdb-ripple-init>Add Company Detail</button>
            <form action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control">
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control">
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="logo">Logo (minimum 100x100)</label>
                    <input type="file" name="logo" id="logo" class="form-control-file">
                    @error('logo')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="website">Website</label>
                    <input type="text" name="website" id="website" class="form-control">
                    @error('website')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        @foreach ($data as $item)
            <div class="card" style="width: 18rem;">
                <img src="{{ asset('storage/logo/' . $item->logo) }}" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">{{ $item->name }}</h5>
                    <p class="card-text">{{ $item->email }}</p>
                    <p class="card-text">{{ $item->website }}</p>
                    <a href="{{ route('companies.edit', $item->id) }}" class="btn btn-primary">Edit</a>
                </div>
        @endforeach
    @endsection
