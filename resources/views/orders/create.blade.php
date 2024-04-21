@extends('layouts.main')

@section('title', 'Sipariş Oluştur')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Sipariş Oluştur
                    </h2>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl card p-4">
                <div class="row row-cards">
                        <div class="row">
                            <div class="col-12 col-lg-6 mt-2" >
                                <div class="form-group">
                                    <label for="">Sipariş Kodu</label>
                                    <input type="text" id="code" name="code" class="form-control" value="" required>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 mt-2">
                                <div class="form-group">
                                    <label for="">Tarih</label>
                                    <input type="date" id="order_date" name="order_date" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 col col-lg-6">
                            <label for="name" class="form-label">Cari</label>
                            <select class="select2 form-control stock_select" id="current_id" required>
                                <option value="0">Seçiniz..</option>
                                @foreach($currents as $current)
                                <option
                                    value="{{$current->CODE}}">{{$current->DEFINITION_}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-12 col-lg-6 mt-2">
                            <div class="form-group">
                                <label for="">Durum</label>
                                <select class="form-control select2 w-100" id="status">
                                    <option value="0">Seçiniz..</option>
                                    @foreach(config('services.order_status') as $key => $status)
                                        <option
                                            value="{{$key}}">{{$status}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                       <div class="row">
                        <div class="row mt-2 d-none" id="form">
                            <div class="mb-3 col col-lg-2">
                                <label for="name" class="form-label">Stok</label>
                                <select class="select2 form-control stock_select stock_id" name="stock_id[]" required>
                                    <option value="0">Seçiniz..</option>
                                    @foreach($stocks as $stock)
                                    <option
                                        value="{{$stock->CODE}}">{{$stock->NAME}} | {{$stock->STGRPCODE}}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col col-lg-1">
                                <label for="" class="form-label">adet</label>
                                <input type="text" class="form-control quantity" >
                            </div>
                            @if (auth()->user()->can('order_price'))
                                <div class="mb-3 col col-lg-1">
                                    <label for="" class="form-label">Birim Fiyat</label>
                                    <input type="text" class="form-control per_price money">
                                </div>
                                <div class="mb-3 col">
                                    <label for="" class="form-label text-nowrap">Vergi Oranı</label>
                                    <input type="number" class="form-control tax_percent">
                                </div>
                                <div class="mb-3 col">
                                    <label for="" class="form-label text-nowrap">Vergi Dahil Toplam</label>
                                    <input type="text" class="form-control total_price money">
                                </div>
                            @else
                            
                            <div class="mb-3 col col-lg-2">
                                <label for="" class="form-label">Birim Fiyat</label>
                                <input type="text" class="form-control per_price money" readonly>
                            </div>
                            <div class="mb-3 col">
                                <label for="" class="form-label text-nowrap">Vergi Oranı</label>
                                <input type="number" class="form-control tax_percent" readonly>
                            </div>
                            <div class="mb-3 col">
                                <label for="" class="form-label text-nowrap">Vergi Dahil Toplam</label>
                                <input type="text" class="form-control total_price money" readonly>
                            </div>
                            @endif
                            <div class="mb-3 col-1 d-flex align-items-center mt-4">
                                <button onclick="removeItem(this)" type="button" class="btn btn-sm btn-outline-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                       </div>
                        <div class="row ">
                            <div class="col-12 col-lg-3 mt-2">
                                <button class="btn btn-outline-success" id="repeater_button">
                                    <i class="fa-solid fa-cart-flatbed"></i>
                                    Stok Ekle</button>
                            </div>
                        </div>
                       
                        <div class="d-flex justify-content-end mt-2">
                            <button type="button" class="btn btn-primary" id="submit_button" onclick="submitHandler()">
                                Kaydet
                            </button>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="/pages/orderCreate.js"></script>

    <script>
        $('.select2').select2();

        
        $('#saveButton').on('click', function () {
            var code = $('#code').val();
            var order_date = $('#order_date').val();
            var current_type_id = $('#current_id').val();
            var stock_id = $('#stock_id').val();
            var quantity = $('#quantity').val();
            var price = $('#price').val();
            var total_price = $('#total_price').val();
            var status = $('#status').val();


            $.ajax({
                url: '{{route('order.store')}}',
                type: 'POST',
                data: {
                    code: code,
                    order_date: order_date,
                    current_id: current_type_id,
                    stock_id: stock_id,
                    quantity: quantity,
                    price: price,
                    total_price: total_price,
                    status: status,
                    _token: '{{csrf_token()}}'
                },
                success: function (response) {
                        window.location.href = '{{route('order.list')}}';
                }
            });
        });


    </script>

@endsection
