# Dokumen Pengujian Sistem Endorphine Florist

## 1. Tujuan Pengujian

Pengujian ini bertujuan memeriksa apakah fungsi utama aplikasi Endorphine Florist berjalan sesuai use case pada diagram yang diberikan. Penomoran dan nama use case pada dokumen ini mengikuti diagram tersebut, yaitu UC-01 sampai UC-12.

Dokumen ini berisi rencana skenario pengujian. Kolom hasil eksekusi belum diisi sebagai PASS/FAIL karena skenario di bawah belum dijalankan melalui aplikasi.

## 2. Lingkup dan Aktor

Pengujian mencakup katalog, akun, keranjang, pemesanan dan pembayaran, ulasan, administrasi data, operasional kasir, serta laporan penjualan.

| Aktor | Fungsi yang diuji |
|---|---|
| Pengunjung | Melihat dan mencari katalog; registrasi dan login |
| Pelanggan | Keranjang, pemesanan, pembayaran, dan ulasan |
| Admin | Mengelola produk, banner, voucher, rekening, dan akun staf |
| Kasir | Mengelola status pesanan, transaksi POS/walk-in, serta rekap kasir dan shift |
| Owner | Melihat dan mengekspor laporan penjualan |

## 3. Ringkasan Skenario

| Use Case | Nama Use Case | Skenario utama | Hasil yang diharapkan |
|---|---|---|---|
| UC-01 | Melihat dan Mencari Katalog Produk | Pengunjung membuka katalog, mencari produk, memilih kategori, dan membuka detail produk. | Sistem menampilkan produk yang sesuai dengan pencarian/kategori dan detail produk yang dipilih. |
| UC-02 | Registrasi dan Login Akun | Pengunjung mendaftar dengan data valid, lalu masuk menggunakan akun yang dibuat. | Akun pelanggan tersimpan dan pengguna dapat login dengan kredensial yang valid. |
| UC-03 | Mengelola Keranjang Belanja | Pelanggan menambahkan produk, mengubah jumlah, menghapus item, dan menerapkan voucher. | Isi keranjang serta total belanja diperbarui sesuai tindakan dan voucher yang valid. |
| UC-04 | Melakukan Pemesanan dan Pembayaran | Pelanggan dengan akun aktif dan keranjang berisi produk mengisi checkout, membuat pesanan, lalu mengunggah bukti pembayaran. | Pesanan tersimpan dan bukti pembayaran diterima dengan status menunggu verifikasi. |
| UC-05 | Memberi Ulasan Pesanan | Pelanggan memberi rating dan ulasan pada pesanan yang telah selesai dan dibayar. | Ulasan tersimpan dan dapat ditampilkan pada bagian ulasan. |
| UC-06 | Mengelola Data Produk dan Banner | Admin menambah, mengubah, dan menghapus produk serta memperbarui banner. | Perubahan data tersimpan dan ditampilkan sesuai statusnya pada aplikasi. |
| UC-07 | Mengelola Voucher dan Rekening | Admin membuat/mengubah voucher serta menambah/mengubah rekening pembayaran. | Data voucher dan rekening tersimpan dan tersedia sesuai status aktifnya. |
| UC-08 | Mengelola Akun Staf | Admin membuat akun staf, mengubah data/role, dan mengaktifkan atau menonaktifkan akun. | Data staf tersimpan; akun nonaktif tidak dapat login. |
| UC-09 | Mengelola Status Pesanan | Kasir meninjau pesanan, memverifikasi pembayaran, dan memperbarui status pesanan. | Status pesanan/pembayaran diperbarui dan stok tidak berkurang lebih dari satu kali. |
| UC-10 | Transaksi POS / Walk-In | Kasir memilih produk dan kuantitas, menentukan metode pembayaran, lalu menyimpan transaksi. | Transaksi walk-in tercatat sebagai selesai dan dibayar serta stok diperbarui. |
| UC-11 | Mengelola Rekap Kasir dan Shift | Kasir melihat ringkasan transaksi, memasukkan modal awal dan uang fisik, lalu menyimpan rekap shift. | Rekap tersimpan dengan total transaksi, kas yang diharapkan, dan selisih yang benar. |
| UC-12 | Melihat dan Mengekspor Laporan Penjualan | Owner membuka laporan untuk periode tertentu dan mengunduh PDF atau Excel. | Ringkasan sesuai periode ditampilkan dan file laporan berhasil diunduh. |

## 4. Detail Test Case

### 4.1 UC-01 — Melihat dan Mencari Katalog Produk

| ID Test Case | Aktor | Langkah Uji | Hasil yang Diharapkan | Hasil Eksekusi |
|---|---|---|---|---|
| TC-UC01-01 | Pengunjung | Buka halaman katalog, masukkan nama produk yang tersedia pada kolom pencarian, lalu jalankan pencarian. | Daftar menampilkan produk yang sesuai dengan kata kunci. | Belum diuji |
| TC-UC01-02 | Pengunjung | Pilih kategori, buka salah satu produk pada hasil, lalu ulangi pencarian dengan kata kunci yang tidak cocok. | Produk detail yang dipilih tampil; pencarian tanpa hasil menampilkan daftar kosong atau pesan yang sesuai. | Belum diuji |

### 4.2 UC-02 — Registrasi dan Login Akun

| ID Test Case | Aktor | Langkah Uji | Hasil yang Diharapkan | Hasil Eksekusi |
|---|---|---|---|---|
| TC-UC02-01 | Pengunjung | Buka registrasi, isi nama, email baru, nomor telepon, kata sandi dan konfirmasi yang sama, lalu kirim formulir. | Akun pelanggan dibuat dan pengguna dapat melanjutkan sebagai akun yang telah login. | Belum diuji |
| TC-UC02-02 | Pengunjung | Coba registrasi menggunakan email yang sudah terdaftar atau konfirmasi kata sandi yang berbeda; kemudian coba login dengan kata sandi yang salah. | Sistem menolak data tidak valid dan menampilkan pesan validasi/autentikasi tanpa membuat sesi login yang tidak sah. | Belum diuji |

### 4.3 UC-03 — Mengelola Keranjang Belanja

| ID Test Case | Aktor | Langkah Uji | Hasil yang Diharapkan | Hasil Eksekusi |
|---|---|---|---|---|
| TC-UC03-01 | Pelanggan | Tambahkan produk yang stoknya tersedia ke keranjang, ubah jumlahnya, lalu periksa subtotal. | Produk tampil di keranjang dan jumlah serta subtotal berubah sesuai input. | Belum diuji |
| TC-UC03-02 | Pelanggan | Hapus item dari keranjang. Coba tambahkan jumlah melebihi stok atau terapkan kode voucher yang tidak valid. | Item yang dihapus tidak lagi tampil; jumlah melebihi stok dan voucher tidak valid ditolak dengan pesan yang sesuai. | Belum diuji |

### 4.4 UC-04 — Melakukan Pemesanan dan Pembayaran

| ID Test Case | Aktor | Langkah Uji | Hasil yang Diharapkan | Hasil Eksekusi |
|---|---|---|---|---|
| TC-UC04-01 | Pelanggan | Pastikan sudah login dan keranjang berisi produk; buka checkout, isi alamat, nomor telepon, dan metode pembayaran non-tunai yang tersedia, lalu konfirmasi pesanan. | Pesanan dan item tersimpan; status awal pesanan pending dan pembayaran unpaid; halaman konfirmasi menampilkan detail pesanan. | Belum diuji |
| TC-UC04-02 | Pelanggan | Buka pesanan milik sendiri, unggah bukti pembayaran berupa gambar yang memenuhi batas ukuran, lalu coba kirim berkas non-gambar atau gambar di atas batas ukuran. | Bukti yang valid diterima dan pembayaran menjadi menunggu verifikasi; berkas tidak valid ditolak dengan pesan yang sesuai. | Belum diuji |
| TC-UC04-03 | Pelanggan | Coba checkout saat keranjang kosong dan coba memilih pembayaran tunai pada checkout web. | Checkout kosong dikembalikan ke keranjang; pembayaran tunai ditolak pada checkout web. | Belum diuji |

### 4.5 UC-05 — Memberi Ulasan Pesanan

| ID Test Case | Aktor | Langkah Uji | Hasil yang Diharapkan | Hasil Eksekusi |
|---|---|---|---|---|
| TC-UC05-01 | Pelanggan | Buka pesanan milik sendiri dengan status selesai dan dibayar, isi rating 1–5 dan ulasan, lalu kirim. | Ulasan tersimpan dan dapat ditampilkan pada katalog/daftar ulasan. | Belum diuji |
| TC-UC05-02 | Pelanggan | Coba mengirim ulasan kosong, rating di luar rentang 1–5, atau mengulas pesanan yang belum selesai/sudah diulas. | Sistem menolak ulasan yang tidak memenuhi validasi atau syarat kelayakan pesanan. | Belum diuji |

### 4.6 UC-06 — Mengelola Data Produk dan Banner

| ID Test Case | Aktor | Langkah Uji | Hasil yang Diharapkan | Hasil Eksekusi |
|---|---|---|---|---|
| TC-UC06-01 | Admin | Buka pengelolaan produk, tambahkan produk dengan data valid, lalu ubah data dan stok produk tersebut. | Produk tersimpan dan perubahan tampil pada daftar/detail; status ketersediaan mengikuti stok. | Belum diuji |
| TC-UC06-02 | Admin | Hapus produk uji, lalu ubah teks atau status aktif banner pada halaman pengelolaan banner. | Produk yang dihapus tidak lagi tersedia; perubahan banner tersimpan dan hanya banner aktif yang tampil pada beranda. | Belum diuji |
| TC-UC06-03 | Pengunjung | Coba membuka halaman pengelolaan produk atau banner tanpa login sebagai admin. | Akses ditolak atau diarahkan sesuai mekanisme autentikasi dan otorisasi aplikasi. | Belum diuji |

### 4.7 UC-07 — Mengelola Voucher dan Rekening

| ID Test Case | Aktor | Langkah Uji | Hasil yang Diharapkan | Hasil Eksekusi |
|---|---|---|---|---|
| TC-UC07-01 | Admin | Buat voucher dengan kode, jenis/nilai diskon, minimum belanja, kuota, dan masa berlaku yang valid; kemudian buat rekening pembayaran dengan data valid. | Voucher dan rekening tersimpan dan tampil pada daftar pengelolaan. | Belum diuji |
| TC-UC07-02 | Admin | Nonaktifkan voucher atau rekening, lalu coba simpan voucher dengan kode duplikat/kuota tidak valid dan rekening dengan data wajib kosong. | Status berubah sesuai tindakan; data tidak valid ditolak; voucher/rekening nonaktif tidak ditawarkan untuk transaksi baru. | Belum diuji |
| TC-UC07-03 | Pengunjung | Coba membuka halaman pengelolaan voucher dan rekening tanpa hak akses admin. | Akses ditolak atau diarahkan sesuai mekanisme autentikasi dan otorisasi aplikasi. | Belum diuji |

### 4.8 UC-08 — Mengelola Akun Staf

| ID Test Case | Aktor | Langkah Uji | Hasil yang Diharapkan | Hasil Eksekusi |
|---|---|---|---|---|
| TC-UC08-01 | Admin | Buat akun staf baru dengan email unik, role admin atau kasir, dan kata sandi terkonfirmasi; lalu ubah data staf. | Akun staf tersimpan dan perubahan data tampil pada daftar staf. | Belum diuji |
| TC-UC08-02 | Admin | Nonaktifkan akun staf, lalu coba login dengan akun tersebut; coba juga membuat staf dengan email duplikat atau role yang tidak diizinkan. | Akun nonaktif tidak dapat login; input tidak valid ditolak dengan pesan validasi. | Belum diuji |
| TC-UC08-03 | Pengunjung | Coba membuka halaman pengelolaan staf tanpa login sebagai admin. | Akses ditolak atau diarahkan sesuai mekanisme autentikasi dan otorisasi aplikasi. | Belum diuji |

### 4.9 UC-09 — Mengelola Status Pesanan

| ID Test Case | Aktor | Langkah Uji | Hasil yang Diharapkan | Hasil Eksekusi |
|---|---|---|---|---|
| TC-UC09-01 | Kasir | Login sebagai kasir, buka antrean pesanan, pilih pesanan yang menunggu verifikasi, verifikasi pembayaran, lalu perbarui status pesanan. | Perubahan status tersimpan dan ditampilkan pada detail/daftar pesanan. | Belum diuji |
| TC-UC09-02 | Kasir | Perbarui status pesanan hingga stok perlu dikurangi, lalu ulangi perubahan status pada pesanan yang sama. | Stok berkurang sesuai jumlah item hanya satu kali untuk pesanan tersebut. | Belum diuji |
| TC-UC09-03 | Pengunjung | Coba mengakses halaman atau aksi pengelolaan status pesanan tanpa role kasir. | Akses atau aksi ditolak sesuai hak akses. | Belum diuji |

### 4.10 UC-10 — Transaksi POS / Walk-In

| ID Test Case | Aktor | Langkah Uji | Hasil yang Diharapkan | Hasil Eksekusi |
|---|---|---|---|---|
| TC-UC10-01 | Kasir | Buka POS, pilih produk dengan stok cukup, masukkan nama pelanggan dan kuantitas, pilih pembayaran tunai, lalu simpan transaksi. | Transaksi walk-in tersimpan sebagai selesai dan dibayar, tercatat dengan metode tunai, dan stok diperbarui. | Belum diuji |
| TC-UC10-02 | Kasir | Buat transaksi walk-in dengan metode QRIS; kemudian coba menyimpan transaksi dengan keranjang kosong atau kuantitas melebihi stok. | Transaksi valid tersimpan dengan metode QRIS; data kosong atau stok tidak mencukupi ditolak dan transaksi tidak dinyatakan berhasil. | Belum diuji |

### 4.11 UC-11 — Mengelola Rekap Kasir dan Shift

| ID Test Case | Aktor | Langkah Uji | Hasil yang Diharapkan | Hasil Eksekusi |
|---|---|---|---|---|
| TC-UC11-01 | Kasir | Buka halaman rekap, periksa ringkasan transaksi tunai/QRIS, masukkan modal awal dan uang fisik, lalu simpan penutupan shift. | Rekap tersimpan; kas yang diharapkan dihitung dari modal awal ditambah total tunai dan selisih dari uang fisik. | Belum diuji |
| TC-UC11-02 | Kasir | Coba menyimpan rekap dengan nilai angka wajib kosong atau tidak valid; lihat ringkasan pada hari tanpa transaksi. | Data tidak valid ditolak; total transaksi tanpa penjualan bernilai nol dan perhitungan kas tetap memperhitungkan modal awal. | Belum diuji |
| TC-UC11-03 | Pengunjung | Coba membuka halaman rekap kasir tanpa role kasir. | Akses ditolak atau diarahkan sesuai mekanisme autentikasi dan otorisasi aplikasi. | Belum diuji |

### 4.12 UC-12 — Melihat dan Mengekspor Laporan Penjualan

| ID Test Case | Aktor | Langkah Uji | Hasil yang Diharapkan | Hasil Eksekusi |
|---|---|---|---|---|
| TC-UC12-01 | Owner | Login sebagai owner, buka laporan, pilih rentang tanggal yang memiliki transaksi, lalu periksa ringkasan dan grafik. | Laporan menampilkan agregasi penjualan untuk rentang tanggal yang dipilih. | Belum diuji |
| TC-UC12-02 | Owner | Ekspor laporan untuk rentang tanggal yang sama dalam format PDF dan Excel; ulangi pada rentang tanpa transaksi. | File dengan format yang dipilih berhasil diunduh; rentang tanpa transaksi tetap menghasilkan laporan dengan total nol/tanpa baris transaksi. | Belum diuji |
| TC-UC12-03 | Pengunjung | Coba membuka dashboard atau endpoint laporan owner tanpa role owner. | Akses ditolak atau diarahkan sesuai mekanisme autentikasi dan otorisasi aplikasi. | Belum diuji |

## 5. Rekap Hasil Eksekusi

| Status | Jumlah |
|---|---:|
| PASS | 0 |
| FAIL | 0 |
| Belum diuji | 31 |
| Total test case | 31 |

Isi kolom **Hasil Eksekusi** dan tabel rekap setelah setiap test case dijalankan. Gunakan status PASS jika hasil aktual sesuai dengan hasil yang diharapkan; gunakan FAIL jika berbeda, lalu catat hasil aktual dan bukti/keterangan pada catatan pengujian.
