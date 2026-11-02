<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Endorphine Florist - Katalog Buket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">Endorphine Florist</a>
  </div>
</nav>

<div class="container my-5">
    <h2 class="text-center mb-4 font-weight-bold">Katalog Buket Flowers & Gifts</h2>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <span class="badge bg-secondary mb-2">{{ ucfirst($product->category) }}</span>
                        <h5 class="card-title fw-bold">{{ $product->name }}</h5>
                        <p class="card-text text-muted">{{ $product->description }}</p>
                        <h6 class="text-danger fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</h6>
                    </div>
                    <div class="card-footer bg-white border-top-0">
                        <button class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#orderModal{{ $product->id }}">
                            Pesan Sekarang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal Form Pemesanan -->
            <div class="modal fade" id="orderModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title fw-bold">Pesan: {{ $product->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                  <form action="{{ route('orders.store') }}" method="POST">
                      @csrf
                      <div class="modal-body">
                          <input type="hidden" name="total_price" value="{{ $product->price }}">
                          <input type="hidden" name="channel" value="online">
                          
                          <div class="mb-3">
                              <label class="form-label">Nama Lengkap</label>
                              <input type="text" name="customer_name" class="form-control" required>
                          </div>
                          <div class="mb-3">
                              <label class="form-label">Nomor WhatsApp</label>
                              <input type="text" name="customer_phone" class="form-control" placeholder="08xxxxxxxxxx" required>
                          </div>
                          <div class="mb-3">
                              <label class="form-label">Metode Pembayaran</label>
                              <select name="payment_method" class="form-select" required>
                                  <option value="transfer">Transfer Bank</option>
                                  <option value="qris">QRIS</option>
                                  <option value="cash">Bayar di Tempat (COD/Cash)</option>
                              </select>
                          </div>
                          <div class="mb-3">
                              <label class="form-label">Tanggal & Jam Pengambilan</label>
                              <input type="datetime-local" name="pickup_date" class="form-control">
                          </div>
                          <div class="mb-3">
                              <label class="form-label">Teks Kartu Ucapan (Opsional)</label>
                              <textarea name="greeting_card_text" class="form-control" rows="2" placeholder="Tuliskan ucapan di sini..."></textarea>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-danger w-100">Konfirmasi Pemesanan</button>
                      </div>
                  </form>
                </div>
              </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">Belum ada produk yang tersedia.</p>
            </div>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>