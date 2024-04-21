@extends('layouts.main')
@section('title', 'Cari Listesi')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                Cari Listesi
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Carı Kodu</th>
                            <th>Carı Adı</th>
                            <th>Borç</th>
                            <th>Alacak</th>
                            <th>Telefon</th>
                            <th>E-posta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($current_list as $current)
                            <tr>
                                <td>
                                    <a href="{{route('current.detail', $current->CODE)}}" class="btn btn-sm btn-outline-linkedin">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>
                                <td>{{ $current->CODE }}</td>
                                <td>{{ $current->DEFINITION_ }}</td>
                                <td>{{ number_format($current->borc, '2', ',','.') }}₺</td>
                                <td>{{ number_format($current->alacak, '2', ',','.') }}₺</td>
                                <td class="">{{$current->TELNRS1 ?? "-"}}</td>
                            <td class="">{{$current->EMAILADDR2 ?? "-"}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%">Kayıt Bulunamadı!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
        <div class="p-3">
            {{ $current_list->links("pagination::bootstrap-5") }}
        </div>
    </div>
@endsection
