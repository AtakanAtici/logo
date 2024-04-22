@extends('layouts.main')

@section('title', 'Kasa Detay')

@section('css')
    <link rel="stylesheet" href="../../assets/vendor/libs/apex-charts/apex-charts.css" />
@endsection

@section('content')
    <div class="page-body">
        <div class="container-xl p-2">
            <div class="row ">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-cash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 9m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" /><path d="M14 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M17 9v-2a2 2 0 0 0 -2 -2h-10a2 2 0 0 0 -2 2v6a2 2 0 0 0 2 2h2" /></svg>
                                {{$current->DEFINITION_}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Belge No.</th>
                                        <th>Transfer No.</th>
                                        <th>İşlem Türü</th>
                                        <th>Tarih.</th>
                                        <th>Tutar</th>
                                        <th>Açıklama</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($transactions as $transaction)
                                        <tr>
                                            <td class="text-nowrap">{{$transaction->belge_no}}</td>
                                            <td class="text-nowrap">{{$transaction->numara}}</td>
                                            <td>
                                                {{config('services.types')[$transaction->TRCODE]}}
                                            </td>
                                            <td>{{\Carbon\Carbon::parse($transaction->tarih)->format('d.m.Y')}}</td>
                                            {{-- <td class="text-nowrap">{{$transaction->hareket_turu}}</td> --}}
{{--                                            <td class="text-nowrap">{{$transaction->transactionsType ? $transaction->transactionsType->name :"-"}}</td>--}}
                                            <td>{{number_format($transaction->tutar, '2', '.',',')}}₺</td>
                                           
{{--                                            <td>{{\Illuminate\Support\Str::substr($transaction->aciklama, 0, 12)}}</td>--}}
                                            <td>{{$transaction->aciklama}}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">
                                                <div class="text-center">
                                                    <div><img class="img-fluid" src="/assets/img/not_found.svg" alt="" width="400px">
                                                    </div>
                                                    <div class="mt-2">
                                                        <p class="text-center fs-1">Hiç hareket yok!</p>
                                                        <p class="empty-subtitle text-secondary text-center">
                                                            Bu caride hareket yok
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

