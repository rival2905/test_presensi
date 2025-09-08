@extends('layouts.app_fix')

@section('content')
<div class="main-content">
    <section class="section">
        <!-- Header -->
        <div class="section-header mb-4">
            <h1 class="h3 fw-bold">Dashboard</h1>
        </div>

        <div class="row g-4">
            <!-- Berita -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card h-100 shadow-sm border-0">
                    <div class="d-flex align-items-center p-3">
                        <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center me-3"
                             style="width:60px; height:60px;">
                            <i class="fa-solid fa-book-open fa-lg"></i>
                        </div>
                        <div class="flex-fill">
                            <h6 class="text-muted mb-1">BERITA</h6>
                            <h4 class="fw-bold mb-0">0</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Agenda -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card h-100 shadow-sm border-0">
                    <div class="d-flex align-items-center p-3">
                        <div class="bg-danger text-white rounded d-flex align-items-center justify-content-center me-3"
                             style="width:60px; height:60px;">
                            <i class="fa-solid fa-bell fa-lg"></i>
                        </div>
                        <div class="flex-fill">
                            <h6 class="text-muted mb-1">AGENDA</h6>
                            <h4 class="fw-bold mb-0">0</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tags -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card h-100 shadow-sm border-0">
                    <div class="d-flex align-items-center p-3">
                        <div class="bg-warning text-white rounded d-flex align-items-center justify-content-center me-3"
                             style="width:60px; height:60px;">
                            <i class="fa-solid fa-tags fa-lg"></i>
                        </div>
                        <div class="flex-fill">
                            <h6 class="text-muted mb-1">TAGS</h6>
                            <h4 class="fw-bold mb-0">0</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card h-100 shadow-sm border-0">
                    <div class="d-flex align-items-center p-3">
                        <div class="bg-success text-white rounded d-flex align-items-center justify-content-center me-3"
                             style="width:60px; height:60px;">
                            <i class="fa-solid fa-users fa-lg"></i>
                        </div>
                        <div class="flex-fill">
                            <h6 class="text-muted mb-1">USERS</h6>
                            <h4 class="fw-bold mb-0">{{ App\Models\User::count() ?? '0' }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
