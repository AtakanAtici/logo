@extends('layouts.main')

@section('title', 'Siparişler')

@section('content')
    <div class="card">
        <div class="card-header p-3">
            <div class="row">
                <div class="col">
                    <h5 class="card-title">
                        <i class="fa-solid fa-money-bill-trend-up"></i>
                        Siparişler</h5>
                </div>
                    <div class="col d-flex justify-content-end">
                        {{-- <button data-bs-toggle="modal" data-bs-target="#import-modal" class="btn btn-outline-success me-2" >
                            <i class="fa-solid fa-cloud-arrow-down"></i> &nbsp;İçe Aktar
                        </button> --}}
                        @can('create_order')
                        <a href="{{route('order.create')}}" class="btn btn-primary" >
                            <i class="fa fa-plus"></i> &nbsp; Yeni Sipariş Ekle
                        </a>
                        @endcan
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
                                        <select
                                            name="perpage" aria-controls="DataTables_Table_0"
                                            class="form-select" id="perpage_select">
                                            @foreach(config('pages.perpage') as $key => $perpage)
                                                <option value="{{$key}}"
                                                    {{request('perpage') && request('perpage') == $key ? 'selected' : "" }}
                                                >{{$perpage}}</option>
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
                                        <input type="search"
                                               class="form-control"  placeholder="Ara.." name="search" aria-controls="DataTables_Table_0" value="{{request('search')}}"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <table class="datatables-users table border-top dataTable no-footer dtr-column" id="DataTables_Table_0" >
                    <thead>
                    <tr>
                        <th></th>

                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"   aria-label="User: activate to sort column ascending">
                            @sortableLink('code', 'Sipariş No.')
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"   aria-label="User: activate to sort column ascending">
                            @sortableLink('current_id', 'Cari')
                        </th>
                        {{-- <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"   aria-label="User: activate to sort column ascending">
                            @sortableLink('stock_id', 'Stok')
                        </th> --}}
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Plan: activate to sort column ascending">
                            @sortableLink('order_date', 'Tarih')
                        </th>
                        {{-- <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Plan: activate to sort column ascending">
                            @sortableLink('per_price', 'Birim Fiyat')
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Plan: activate to sort column ascending">
                            @sortableLink('quantity', 'Adet')
                        </th> --}}
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Plan: activate to sort column ascending">
                            Toplam Fiyat
                        </th> 
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"  aria-label="Billing: activate to sort column ascending">
                            @sortableLink('created_at', 'Oluşturulma tarihi')
                        </th>

                    </tr>
                    </thead>
                    <tbody>
                    @forelse($orders as $order)
                        <tr>
                                <td style="width: 160px">
                                        <a href="{{route('order.detail', $order->id)}}" class="btn btn-sm btn-outline-linkedin">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{route('order.xml.create', $order->id)}}" class="btn btn-sm btn-outline-linkedin">
                                            <i class="fa-solid fa-file-export"></i>
                                        </a>
                                        @can('edit_order')
                                        <a href="{{route('order.edit', $order->id)}}" class="btn btn-sm btn-outline-warning">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>
                                        @endcan
                                </td>
                            <td class="">{{$order->code}}</td>
                            {{-- <td>
                                <div
                                    data-bs-toggle="tooltip"
                                    data-bs-offset="0,4"
                                    data-bs-placement="top"
                                    data-bs-html="true"
                                    data-bs-original-title="<i class='fa-solid fa-circle-info'></i> <span>Tahsilat ekle</span>"
                                >
                                    <button class="btn btn-sm btn-outline-linkedin"
                                            data-bs-toggle="modal"
                                            data-bs-target="#add-payment-{{$order->id}}"
                                    >
                                        <i class="fa-solid fa-cash-register"></i>
                                    </button>
                                </div>
                            </td> --}}
                            <td class="sorting_1">{{$order->current->DEFINITION_}}</td>
                            {{-- <td class="sorting_1">{{$order->stock->NAME}}</td> --}}
                            <td><span class="fw-medium">{{\Carbon\Carbon::parse($order->order_date)->format('d.m.Y')}}</span></td>
                            {{-- <td><span class="fw-medium">{{$order->per_price}}₺</span></td>
                            <td><span class="fw-medium">{{$order->quantity}}</span></td>--}}
                            <td><span class="fw-medium">{{number_format($order->items->sum('total_price'), '2', ',','.')}}₺</span></td> 
                            <td><span class="fw-medium">{{\Carbon\Carbon::parse($order->created_at)->format('d.m.Y')}}</span></td>
{{--                            <td>--}}
{{--                                <div class="d-inline-block text-nowrap">--}}
{{--                                    @can('edit_employees')--}}
{{--                                        <a href="{{route('outgoing.edit', $income->id)}}" class="btn btn-sm btn-icon"><i class="bx bx-edit"></i></a>--}}
{{--                                    @endcan--}}
{{--                                    @can('delete_employees')--}}
{{--                                        <button data-bs-toggle="modal" data-bs-target="#remove-modal-{{$income->id}}" class="btn btn-sm btn-icon delete-record"><i class="bx bx-trash"></i></button>--}}
{{--                                    @endcan--}}
{{--                                </div>--}}
{{--                            </td>--}}
                        </tr>
                    @empty
                        <tr>
                            <td colspan="80">
                                <div class="text-center">
                                    <div><img class="img-fluid" src="/assets/img/not_found.svg" alt="" width="400px">
                                    </div>
                                    <div class="mt-2">
                                        <p class="text-center fs-1">Hiç sipariş Yok!</p>
                                        <p class="empty-subtitle text-secondary text-center">
                                            Henüz hiç sipariş kaydı eklemediniz..
                                        </p>
                                    </div>
                                    <div class="empty-action">
                                        @can('create_order')
                                            <a href="{{route('order.create')}}" class="btn btn-outline-success mt-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-credit-card-pay" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 19h-6a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v4.5" /><path d="M3 10h18" /><path d="M16 19h6" /><path d="M19 16l3 3l-3 3" /><path d="M7.005 15h.005" /><path d="M11 15h2" /></svg>
                                                sipariş kaydı oluştur
                                            </a>
                                        @endcan
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{$orders->links('pagination::bootstrap-5')}}
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('#perpage_select').on('change', function (){
            $('#filterForm').submit();
        });
    </script>
@endsection
