@extends('admin.layouts.admin-app')

@section('title', 'BackOffice | Administrador | Dashboard')

@section('admin-content')
    <div class="content-wrapper" id="admin-main">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="m-0">Dashboard</h2>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Inicio</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content charts-section">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fi fi-ss-users-alt"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Usuarios Registrados</span>
                                <span class="info-box-number"><small>Total: </small>{{ $totalRegisteredUsers }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fi fi-sr-blog-text"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Blog Posteados</span>
                                <span class="info-box-number">
                                    <small>Total: </small>{{ $totalPostedBlogs }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-danger elevation-1"><i
                                    class="fi fi-sr-feedback-review"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Reseñas</span>
                                <span class="info-box-number">
                                    <small>Total: </small>{{ $totalReviews }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"><i class="fi fi-sr-comment-alt"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Comentarios</span>
                                <span class="info-box-number">
                                    <small>Total: </small>{{ $totalComments }}
                                </span>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="row chart-row">
                    <div class="card registered-user-chart-card">
                        <div class="card-header">
                            <h5 class="card-title chart-title">Total de usuarios registrados</h5>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fi fi-br-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fi fi-br-x"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="chart">
                                    <canvas id="usersChart" class="chartjs-render-monitor">
                                    </canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card admin-users-card">
                            <div class="card-header">
                                <h3 class="card-title">Administradores</h3>
                                <div class="card-tools">
                                    <span class="badge badge-danger">{{ $totalAdminUsers->count() }}</span>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fi fi-br-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fi fi-br-x"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <ul class="users-list clearfix">
                                    @foreach ($totalAdminUsers as $adminUser)
                                        <li>
                                            <img alt="User Image" data-cfsrc="{{ $adminUser->getPhotoUrlAttribute() }}"
                                                src="{{ $adminUser->getPhotoUrlAttribute() }}">
                                            <a class="users-list-name" href="#">{{ $adminUser->name }}</a>
                                            {{-- <span class="users-list-date">{{ $adminUser->email }}</span> --}}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('scripts')
    <script type="module">
        $(document).ready(function() {
            var ctx = document.getElementById('usersChart').getContext('2d');
            var usersChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($totalRegisteredUsersEveryMonth->pluck('month_name')) !!},
                    datasets: [{
                        label: 'Usuarios Registrados',
                        data: {!! $totalRegisteredUsersEveryMonth->pluck('total_registered_users') !!},
                        backgroundColor: 'rgb(255 206 64 / 44%)',
                        borderColor: 'rgb(255 206 64)',
                        pointBackgroundColor: 'rgb(255 206 64 / 44%)',
                        pointBorderColor: 'rgb(255 206 64 / 44%)',
                        borderWidth: 3
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: false
                        }
                    }
                }
            });
        });
    </script>
@endsection
