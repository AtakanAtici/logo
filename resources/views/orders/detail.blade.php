@extends('layouts.main')

@section('title', 'Sipariş Detayı')

@section('content')
<div class="row invoice-preview">
    <!-- Invoice -->
    <div class="col-xl-12 col-md-12 col-12 mb-md-0 mb-4">
      <div class="card invoice-preview-card">
        <div class="card-body">
          <div
            class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column p-sm-3 p-0"
          >
            <div class="mb-xl-0 mb-4">
              <div class="d-flex svg-illustration mb-3 gap-2">
                <span class="app-brand-logo demo">
                 {{-- logo --}}
                </span>
                {{-- <span class="app-brand-text demo text-body fw-bolder">Sneat</span> --}}
              </div>
              <h3 class="mb-1">{{$order->current->DEFINITION_}}</h3>
              {{-- <p class="mb-1">San Diego County, CA 91905, USA</p>
              <p class="mb-0">+1 (123) 456 7891, +44 (876) 543 2198</p> --}}
            </div>
            <div>
              <h4>Sipariş #{{$order->code}}</h4>
              <div class="mb-2">
                <span class="me-1">Sipariş Tarihi:</span>
                <span class="fw-semibold">{{\Carbon\Carbon::parse($order->order_date)->format('d.m.Y')}}</span>
              </div>
            </div>
          </div>
        </div>
        <hr class="my-0" />
      
        <div class="table-responsive">
          <table class="table border-top m-0">
            <thead>
              <tr>
                <th>Stok</th>
                <th>Adet</th>
                <th>Birim Fiyat</th>
                <th>Vergi Oranı</th>
                <th>Toplam Fiyat</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item )
                <tr>
                    <td class="text-nowrap">{{$item->stock->NAME}}</td>
                    <td class="text-nowrap">{{$item->quantity}}</td>
                    <td>{{number_format($item->per_price, '2', ',', '.')}}₺</td>
                    <td>%{{$item->tax_percent}}</td>
                    <td>{{number_format($item->total_price, '2', ',', '.')}}₺</td>
                  </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="align-top px-4 py-5">
                      {{-- <p class="mb-2">
                        <span class="me-1 fw-semibold">Siparişi Oluşturan:</span>
                        <span>Atakan Atıcı</span>
                      </p> --}}
                    </td>
                    <td class="text-end px-4 py-5">
                      <p class="mb-2">Toplam:</p>
                      <p class="mb-2">Vergi:</p>
                      <p class="mb-0">Vergi Dahil Toplam:</p>
                    </td>
                    <td class="px-4 py-5">
                      <p class="fw-semibold mb-2">{{number_format($order->items->sum('price_withput_tax'), '2', ',', '.')}}₺</p>
                      <p class="fw-semibold mb-2">{{number_format($order->items->sum('tax_amount'), '2', ',', '.')}}₺</p>
                      <p class="fw-semibold mb-0">{{number_format($order->items->sum('total_price'), '2', ',', '.')}}₺</p>
                    </td>
                  </tr>
            </tbody>
          </table>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <span class="fw-semibold">Not:</span>
              <span
                >Sadece bilgilendirme amaçlıdır fatura yerine geçmez!</span
              >
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /Invoice -->

    <!-- yan taraf -->
    {{-- <div class="col-xl-3 col-md-4 col-12 invoice-actions">
      <div class="card">
        <div class="card-body">
          <button
            class="btn btn-primary d-grid w-100 mb-3"
            data-bs-toggle="offcanvas"
            data-bs-target="#sendInvoiceOffcanvas"
          >
            <span class="d-flex align-items-center justify-content-center text-nowrap"
              ><i class="bx bx-paper-plane bx-xs me-3"></i>Send Invoice</span
            >
          </button>
          <button class="btn btn-label-secondary d-grid w-100 mb-3">Download</button>
          <a
            class="btn btn-label-secondary d-grid w-100 mb-3"
            target="_blank"
            href="./app-invoice-print.html"
          >
            Print
          </a>
          <a href="./app-invoice-edit.html" class="btn btn-label-secondary d-grid w-100 mb-3">
            Edit Invoice
          </a>
          <button
            class="btn btn-primary d-grid w-100"
            data-bs-toggle="offcanvas"
            data-bs-target="#addPaymentOffcanvas"
          >
            <span class="d-flex align-items-center justify-content-center text-nowrap"
              ><i class="bx bx-dollar bx-xs me-3"></i>Add Payment</span
            >
          </button>
        </div>
      </div>
    </div> --}}
    <!-- /Invoice Actions -->
  </div>

  <!-- Offcanvas -->
  <!-- Send Invoice Sidebar -->
  <div class="offcanvas offcanvas-end" id="sendInvoiceOffcanvas" aria-hidden="true">
    <div class="offcanvas-header mb-3">
      <h5 class="offcanvas-title">Send Invoice</h5>
      <button
        type="button"
        class="btn-close text-reset"
        data-bs-dismiss="offcanvas"
        aria-label="Close"
      ></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
      <form>
        <div class="mb-3">
          <label for="invoice-from" class="form-label">From</label>
          <input
            type="text"
            class="form-control"
            id="invoice-from"
            value="shelbyComapny@email.com"
            placeholder="company@email.com"
          />
        </div>
        <div class="mb-3">
          <label for="invoice-to" class="form-label">To</label>
          <input
            type="text"
            class="form-control"
            id="invoice-to"
            value="qConsolidated@email.com"
            placeholder="company@email.com"
          />
        </div>
        <div class="mb-3">
          <label for="invoice-subject" class="form-label">Subject</label>
          <input
            type="text"
            class="form-control"
            id="invoice-subject"
            value="Invoice of purchased Admin Templates"
            placeholder="Invoice regarding goods"
          />
        </div>
        <div class="mb-3">
          <label for="invoice-message" class="form-label">Message</label>
          <textarea class="form-control" name="invoice-message" id="invoice-message" cols="3" rows="8">
Dear Queen Consolidated,
Thank you for your business, always a pleasure to work with you!
We have generated a new invoice in the amount of $95.59
We would appreciate payment of this invoice by 05/11/2021</textarea
          >
        </div>
        <div class="mb-4">
          <span class="badge bg-label-primary">
            <i class="bx bx-link bx-xs"></i>
            <span class="align-middle">Invoice Attached</span>
          </span>
        </div>
        <div class="mb-3 d-flex flex-wrap">
          <button type="button" class="btn btn-primary me-3" data-bs-dismiss="offcanvas">Send</button>
          <button type="button" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
        </div>
      </form>
    </div>
  </div>
@endsection