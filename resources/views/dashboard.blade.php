@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-success text-white me-2">
                <i class="mdi mdi-view-dashboard"></i>
            </span> Dashboard
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-success align-middle"></i>
                </li>
            </ul>
        </nav>
    </div>

    {{-- Stat Cards --}}
    <div class="row">
        <div class="col-md-3 stretch-card grid-margin">
            <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">
                        Total Instructors
                        <i class="mdi mdi-account-tie mdi-24px float-end"></i>
                    </h4>
                    <h2 class="mb-5">{{ $totalInstructors }}</h2>
                    <h6 class="card-text">Active instructors</h6>
                </div>
            </div>
        </div>

        <div class="col-md-3 stretch-card grid-margin">
            <div class="card bg-gradient-warning card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">
                        Total Students
                        <i class="mdi mdi-account-school mdi-24px float-end"></i>
                    </h4>
                    <h2 class="mb-5">{{ $totalStudents }}</h2>
                    <h6 class="card-text">Enrolled students</h6>
                </div>
            </div>
        </div>

        <div class="col-md-3 stretch-card grid-margin">
            <div class="card bg-gradient-primary card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">
                        Total Batches
                        <i class="mdi mdi-layers mdi-24px float-end"></i>
                    </h4>
                    <h2 class="mb-5">{{ $totalBatches }}</h2>
                    <h6 class="card-text">Active batches</h6>
                </div>
            </div>
        </div>

        <div class="col-md-3 stretch-card grid-margin">
            <div class="card bg-gradient-dark card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">
                        Total Categories
                        <i class="mdi mdi-tag-multiple mdi-24px float-end"></i>
                    </h4>
                    <h2 class="mb-5">{{ $totalCategories }}</h2>
                    <h6 class="card-text">Program categories</h6>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Tables --}}
    <div class="row">
        <div class="col-md-7 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Recent Batches</h4>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Start Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentBatches as $batch)
                                    <tr>
                                        <td>{{ $batch->name }}</td>
                                        <td>{{ \Str::limit($batch->description, 30) }}</td>
                                        <td>{{ $batch->start_date ?? '-' }}</td>
                                        <td>
                                            <label class="badge
                                                @if($batch->status === 'upcoming') badge-gradient-warning
                                                @elseif($batch->status === 'ongoing') badge-gradient-success
                                                @else badge-gradient-dark
                                                @endif">
                                                {{ ucfirst($batch->status) }}
                                            </label>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No batches yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-5 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Recent Students</h4>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentStudents as $student)
                                    <tr>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->email }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">No students yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
