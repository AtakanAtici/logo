@extends('layouts.main')

@section('title', 'Sipariş Oluştur')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Ayarlar
                    </h2>
                </div>
            </div>
        </div>
        <div class="page-body">
            <form action="{{route('setting.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
        <div class="container-xl card p-4">
                <div class="row row-cards">
                        <div class="row">
                            <div class="col-12 col-lg-6 mt-2" >
                                <div class="form-group">
                                    <label for="">Firma Adı</label>
                                    <input type="text" name="company_name" class="form-control" value="{{$setting->company_name}}" required>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 mt-2" >
                                <div class="form-group">
                                    <label for="">Firma Logo</label>
                                    <input type="file" name="logo_path" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 mt-2" >
                                <div class="form-group">
                                    <label for="">Veri Tabanı Adı</label>
                                    <input type="text" name="logo_db_name" class="form-control" value="{{$setting->logo_db_name}}" required>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 mt-2" >
                                <div class="form-group">
                                    <label for="">Dönem No.</label>
                                    <input type="text" name="logo_donem_no" class="form-control" value="{{$setting->logo_donem_no}}" required>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 mt-2" >
                                <div class="form-group">
                                    <label for="">Firma No.</label>
                                    <input type="text" name="logo_firma_no" class="form-control" value="{{$setting->logo_firma_no}}" required>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 mt-2" >
                                <div class="form-group">
                                    <label for="logo_db_ip">Veitabanı Ip</label>
                                    <input type="text" name="logo_db_ip" id="logo_db_ip" class="form-control" value="{{$logo_db_ip}}" required>
                                </div>
                            </div>
                      
                        <div class="d-flex justify-content-end mt-2">
                            <button type="submit" class="btn btn-primary">
                                Kaydet
                            </button>
                        </div>
                </div>
            </div>
        </form>
        </div>
    </div>
@endsection

