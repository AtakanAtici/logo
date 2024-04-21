@extends('layouts.main')
@section('title', 'Cari Listesi')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                Stok Listesi
            </div>
            <div class="">
                <form id="filterForm">
                    <div class="mb-3 col-12 col-lg-4">
                        <label class="form-label">Grup Kodu</label>
                        <div class="position-relative">
                            <select name="group_code" class="select2" id="code_select">
                                <option value="0">Seçiniz</option>
                                @foreach ($group_codes as $group_code)
                                    <option 
                                        {{ request()->get('group_code') == $group_code ? 'selected' : '' }}
                                    value="{{ $group_code }}">{{ $group_code }}</option>
                                @endforeach
                            </select>
                        </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Stok Kodu</th>
                            <th>Stok Adı</th>
                            <th>Grup Kodu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($stock_list as $stock)
                            <tr>
                                <td>{{ $stock->CODE }}</td>
                                <td>{{ $stock->NAME }}</td>
                                <td>{{ $stock->STGRPCODE }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%">Kayıt Bulunamadı!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-3">
                {{ $stock_list->links("pagination::bootstrap-5") }}
            </div>
        </div>
    </div>
@endsection

@section('js')

    <script>
        $(document).ready(function() {
            $('#code_select').change(function() {
                $('#filterForm').submit();
            });
        });
    </script>

@endsection
