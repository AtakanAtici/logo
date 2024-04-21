@extends('layouts.main')

@section('title', 'Roller')

@section('content')
    <div class="row g-4">
        @foreach ($roles as $role)
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <h6 class="fw-normal">Toplam {{ $role->users->count() }} kullanıcı</h6>
                            <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                @foreach ($role->users as $user)
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        title="{{ $user->name }}" class="avatar avatar-sm pull-up">
                                        <img class="rounded-circle" src="../../assets/img/default-avatar.png"
                                            alt="Avatar" />
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="d-flex justify-content-between align-items-end">
                            <div class="role-heading">
                                <h4 class="mb-1">{{ $role->name }}</h4>
                                <a href="javascript:;" data-bs-toggle="modal"
                                    data-bs-target="#editRoleModal-{{ $role->id }}"
                                    class="role-edit-modal"><small>Düzenle</small>
                                </a>
                            </div>
                            <a href="javascript:void(0);" class="text-muted" data-bs-toggle="modal"
                                data-bs-target="#removeModal-{{ $role->id }}">
                                <i class="text-danger bx bx-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @include('roles.editModal')
            @include('roles.removeModal')
        @endforeach

        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="card h-100">
                <div class="row h-100">
                    <div class="col-sm-5">
                        <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-3">
                            <img src="../../assets/img/illustrations/sitting-girl-with-laptop-light.png" class="img-fluid"
                                alt="Image" width="120"
                                data-app-light-img="illustrations/sitting-girl-with-laptop-light.png"
                                data-app-dark-img="illustrations/sitting-girl-with-laptop-dark.png" />
                        </div>
                    </div>

                    <div class="col-sm-7">
                        <div class="card-body text-sm-end text-center ps-sm-0">
                            <button data-bs-target="#addRoleModal" data-bs-toggle="modal"
                                class="btn btn-primary mb-3 text-nowrap add-new-role">
                                Yeni rol ekle
                            </button>
                            <p class="mb-0">Rol eklemek için tıklayın..</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- add modal -->
        @include('roles.createModal')
    </div>
@endsection
