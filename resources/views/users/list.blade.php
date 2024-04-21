@extends('layouts.main')

@section('title', 'Kullanıcılar')

@section('content')
    <div class="card">
        <div class="card-header p-3">
            <div class="row">
                <div class="col">
                    <h5 class="card-title">
                        <i class="fa fa-users"></i>
                        Kullanıcılar
                    </h5>
                </div>
                <div class="col d-flex justify-content-end">
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#createModal">
                        <i class="fa fa-plus"></i> &nbsp;Kullanıcı Oluştur
                    </button>
                </div>
            </div>

            <!--
                <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0">
                     filters
                </div>
                -->
        </div>
        <div class="card-datatable table-responsive">
            <div id="DataTables_Tabe_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <form id="filterForm">
                    <div class="row  p-2">
                        <div class="col-md-2">
                            <div class="me-3">
                                <div class="dataTables_length" id="DataTables_Table_0_length">
                                    <label>
                                        <select name="perpage" aria-controls="DataTables_Table_0" class="form-select"
                                            id="perpage_select">
                                            @foreach (config('pages.perpage') as $key => $perpage)
                                                <option value="{{ $key }}"
                                                    {{ request('perpage') && request('perpage') == $key ? 'selected' : '' }}>
                                                    {{ $perpage }}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-10">
                            <div
                                class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0">
                                <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>
                                        <input type="search" class="form-control" placeholder="Ara.." name="search"
                                            aria-controls="DataTables_Table_0" value="{{ request('search') }}"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <table class="datatables-users table border-top dataTable no-footer dtr-column" id="DataTables_Table_0">
                    <thead>
                        <tr>

                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="User: activate to sort column ascending">
                                @sortableLink('name', 'Kullanıcı')
                            </th>
                            <th class="sorting sorting_desc" tabindex="0" aria-controls="DataTables_Table_0"
                                rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending"
                                aria-sort="descending">
                                Rol
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Plan: activate to sort column ascending">
                                @sortableLink('email', 'E-posta')
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Billing: activate to sort column ascending">
                                @sortableLink('status', 'Durum')
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Billing: activate to sort column ascending">
                                @sortableLink('created_at', 'Tarih')
                            </th>
                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 145px;"
                                aria-label="Actions"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="">
                                    <div class="d-flex justify-content-start align-items-center user-name">
                                        <div class="avatar-wrapper">
                                            <div class="avatar avatar-sm me-3">
                                                <img src="../../assets/img/default-avatar.png" alt="Avatar"
                                                    class="rounded-circle">
                                            </div>
                                        </div>

                                        <div class="d-flex flex-column">
                                            <a href="JavaScript:void(1)" class="text-body text-truncate">
                                                <span class="fw-medium">{{ $user->name }}</span>
                                            </a>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="sorting_1">
                                    <span class="text-truncate d-flex align-items-center">
                                        <span class="badge badge-center rounded-pill bg-label-warning w-px-30 h-px-30 me-2">
                                            <i class="bx bx-user bx-xs"></i>
                                        </span>{{ isset($user->getRoleNames()[0]) ? $user->getRoleNames()[0] : '-' }}</span>
                                </td>
                                <td><span class="fw-medium">{{ $user->email }}</span></td>
                                <td><span class="badge bg-label-{{ $user->status_color }}">{{ $user->status_text }}</span>
                                </td>
                                <td><span
                                        class="fw-medium">{{ \Carbon\Carbon::parse($user->created_at)->format('d.m.Y') }}</span>
                                </td>
                                <td>
                                    <div class="d-inline-block text-nowrap">
                                            <button data-bs-toggle="modal" data-bs-target="#editModal-{{ $user->id }}"
                                                class="btn btn-sm btn-icon"><i class="bx bx-edit"></i></button>
                                            <button data-bs-toggle="modal" data-bs-target="#removeModal-{{ $user->id }}"
                                                class="btn btn-sm btn-icon delete-record"><i class="bx bx-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @include('users.editModal')
                            @include('users.removeModal')
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>
    @include('users.createModal')
@endsection

@section('js')
    <script>
        $('#perpage_select').on('change', function() {
            $('#filterForm').submit();
        });
    </script>
@endsection
