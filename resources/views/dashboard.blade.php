@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
    <!-- Content section -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Companies</h5>
                    <p class="card-text">Manage Companies</p>
                    <a href="#" class="btn btn-light">View</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Employees</h5>
                    <p class="card-text">Manage Employees</p>
                    <a href="#" class="btn btn-light">View</a>
                </div>
            </div>
        </div>
    </div>
@endsection
