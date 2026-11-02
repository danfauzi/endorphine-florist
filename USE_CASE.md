# Dokumen Use Case — Endorphine Florist

## 1. Tujuan dan cakupan

Dokumen ini merangkum perilaku aplikasi web Endorphine Florist berdasarkan route, middleware, controller, model, migrasi database, halaman Blade, dan tes fitur yang tersedia. Isinya menggambarkan implementasi saat ini, bukan rancangan fitur yang belum tersedia.

Sistem merupakan aplikasi web Laravel untuk katalog dan pemesanan produk, pengelolaan operasional toko, kasir/POS, serta laporan pemilik. Katalog dan ulasan dapat dibaca tanpa login; transaksi, profil, dan fitur operasional memerlukan login.

### Komponen yang dianalisis

| Komponen | Tanggung jawab yang tampak di aplikasi |
|---|---|
| Route web dan auth | URL katalog, keranjang, checkout, pesanan, dashboard per role, dan autentikasi |
| Middleware role | Membatasi fitur berdasarkan `pelanggan`, `admin`, `kasir`, dan `owner` |
| Controller | Menjalankan alur katalog, pembelian, pesanan, administrasi, kasir, laporan, dan akun |
| Model dan database | Menyimpan pengguna, produk/stok, keranjang, pesanan, voucher, rekening/QRIS, slide, dan rekap shift |
| Blade dan aset frontend | Formulir dan tampilan katalog, keranjang, checkout, dashboard, laporan, serta autentikasi |
| Tes fitur | Menguji alur catatan produk di keranjang, voucher, ulasan, pembatasan akses, dan detail pesanan |

### Batasan implementasi penting

- Pembayaran online tidak terhubung ke payment gateway. Pelanggan memilih metode yang tersedia, melakukan pembayaran di luar aplikasi, lalu mengunggah gambar bukti pembayaran. Kasir memperbarui status pembayaran.
- Pembayaran cash/tunai ditolak pada checkout web; pembayaran tersebut disediakan pada transaksi walk-in kasir.
- Ketersediaan metode transfer/QRIS untuk checkout bergantung pada rekening yang aktif. Informasi rekening/QRIS yang aktif ditampilkan pada halaman checkout/sukses.
- Admin dan owner dapat melihat daftar/detail pesanan. Pengelolaan status pesanan serta verifikasi pembayaran berada pada route kasir.
- Owner berfokus pada pemantauan dan laporan. Fitur pengelolaan produk, staf, rekening, slide, dan voucher berada di route admin. Tes akses mengonfirmasi owner tidak dapat membuka halaman pengelolaan tersebut.
- Pendaftaran mandiri membuat akun pelanggan. Pembuatan akun staf dilakukan oleh admin; role yang dapat dibuat/dipilih admin adalah `admin` atau `kasir`, bukan `owner`.
- Route operasional dilindungi login dan role. Sejumlah route umum transaksi hanya mensyaratkan login; alur bisnisnya ditujukan untuk pelanggan. Keranjang secara eksplisit menolak role admin.

## 2. Aktor utama

| Aktor | Deskripsi dan hak akses yang ditemukan |
|---|---|
| Pengunjung | Pengguna belum login; dapat melihat katalog, detail produk, dan ulasan. Harus login untuk menggunakan keranjang dan transaksi. |
| Pelanggan | Pengguna terdaftar ber-role `pelanggan`; dapat mengelola keranjang, memasang voucher, checkout, mengunggah bukti bayar, melihat pesanan sendiri, memberi ulasan, dan mengelola profil. |
| Admin | Mengelola produk, akun staf, rekening/QRIS, slide beranda, dan voucher; dapat memantau daftar serta detail semua pesanan. Tidak dapat melakukan pembelian melalui keranjang. |
| Kasir | Mengelola antrean pesanan, status pesanan dan pembayaran, transaksi walk-in/POS, serta rekap kas/penutupan shift. |
| Owner | Melihat dashboard, laporan dan grafik penjualan, mengekspor PDF/Excel, serta memantau daftar/detail pesanan. Bukan aktor pengelola data operasional admin. |
| Layanan email | Aktor pendukung untuk pengiriman tautan reset kata sandi dan notifikasi/verifikasi email, mengikuti konfigurasi Laravel aplikasi. |
| Penyimpanan aplikasi | Aktor pendukung untuk menyimpan gambar produk, avatar, gambar slide, QRIS, dan bukti pembayaran. |

## 3. Daftar fitur

| Area | Fitur / use case | Aktor |
|---|---|---|
| Katalog | Melihat, mencari, dan memfilter produk; melihat detail produk dan ulasan | Pengunjung, pelanggan |
| Akun | Registrasi, login, logout, reset/perbarui kata sandi, verifikasi email, ubah/hapus profil | Pengunjung, pengguna login |
| Belanja | Tambah/ubah/hapus item, catatan produk, kosongkan keranjang, terapkan/hapus voucher | Pelanggan |
| Pemesanan | Checkout, melihat status/riwayat, melihat detail sukses, mengunggah bukti pembayaran, memberi ulasan | Pelanggan |
| Administrasi | CRUD produk; pengelolaan akun admin/kasir; rekening/QRIS; slide beranda; voucher | Admin |
| Monitoring | Melihat daftar dan detail pesanan | Admin, owner |
| Operasional kasir | Cari/filter pesanan; memperbarui status pesanan/pembayaran; transaksi walk-in/POS | Kasir |
| Keuangan kasir | Melihat ringkasan, mengatur modal awal, menghitung selisih fisik, menyimpan rekap shift | Kasir |
| Laporan | Dashboard/ringkasan omzet, filter rentang tanggal, grafik, ekspor PDF/Excel | Owner |

## 4. Spesifikasi use case

### UC-01 — Melihat dan mencari katalog

- **Aktor:** Pengunjung, pelanggan.
- **Pre-condition:** Aplikasi dapat diakses; katalog produk tersedia.
- **Post-condition:** Daftar produk, filter/pencarian yang diminta, konten slide aktif dan ulasan ditampilkan. Tidak ada data yang diubah.
- **Main flow:**
  1. Aktor membuka beranda.
  2. Sistem menampilkan produk terbaru, slide aktif, serta ringkasan ulasan pelanggan yang memenuhi syarat.
  3. Aktor dapat memasukkan kata kunci nama produk atau memilih kategori.
  4. Sistem menampilkan hasil yang sesuai.
  5. Aktor memilih produk untuk membuka halaman detail, atau membuka daftar seluruh ulasan.
- **Exception / alternative flow:**
  - Kata kunci/kategori tidak cocok dengan produk mana pun: daftar hasil kosong.
  - Produk tidak ditemukan saat halaman detail diminta: sistem merespons tidak ditemukan.
  - Tidak ada ulasan yang memenuhi syarat: bagian ulasan tidak memiliki data untuk ditampilkan.

### UC-02 — Registrasi pelanggan

- **Aktor:** Pengunjung.
- **Pre-condition:** Aktor belum login; alamat email belum terdaftar.
- **Post-condition:** Akun role pelanggan tersimpan, sesi login dibuat, dan aktor diarahkan ke beranda.
- **Main flow:**
  1. Aktor membuka halaman registrasi.
  2. Aktor mengisi nama, email, nomor telepon, kata sandi, dan konfirmasi kata sandi.
  3. Sistem memvalidasi data, termasuk email unik dan kata sandi sesuai aturan aplikasi.
  4. Sistem membuat akun pelanggan dan memicu event registrasi.
  5. Sistem langsung login sebagai pelanggan dan mengarahkan aktor ke beranda.
- **Exception / alternative flow:**
  - Data wajib kosong/tidak valid, kata sandi tidak cocok, atau email telah digunakan: pendaftaran ditolak dan kesalahan validasi ditampilkan.
  - Pengunjung yang sudah login mengakses halaman guest: akses mengikuti redirect middleware guest.

### UC-03 — Login, mengingat email, dan logout

- **Aktor:** Pengunjung, pengguna terdaftar.
- **Pre-condition:** Untuk login, akun terdaftar dan aktif. Untuk logout, aktor sudah login.
- **Post-condition:** Login membuat sesi terautentikasi yang diregenerasi; logout mengakhiri sesi dan kembali ke beranda.
- **Main flow:**
  1. Aktor membuka halaman login dan mengisi email serta kata sandi.
  2. Secara opsional aktor memilih opsi “ingat saya”.
  3. Sistem memeriksa status akun dan memvalidasi kredensial.
  4. Sistem mengarahkan aktor ke tujuan sebelumnya atau dashboard universal.
  5. Dashboard universal mengarahkan role admin, kasir, owner, atau pelanggan ke halaman yang sesuai.
  6. Untuk logout, aktor memilih logout; sistem mengakhiri sesi, memperbarui token keamanan, lalu mengarahkan ke beranda.
- **Exception / alternative flow:**
  - Kredensial salah: login ditolak dengan kesalahan autentikasi.
  - Akun nonaktif: login ditolak dengan pesan bahwa akun harus ditangani owner.
  - Opsi “ingat saya” dipilih: email disimpan dalam cookie selama 30 hari; jika tidak dipilih, cookie tersebut dihapus.
  - Role tidak dikenali oleh dashboard universal: sistem mengarahkan kembali ke beranda.

### UC-04 — Reset dan perubahan kata sandi

- **Aktor:** Pengunjung yang lupa kata sandi; pengguna login yang ingin mengganti kata sandi; layanan email.
- **Pre-condition:** Reset membutuhkan email akun yang terdaftar; perubahan kata sandi membutuhkan sesi login dan kata sandi saat ini.
- **Post-condition:** Jika berhasil, kata sandi baru tersimpan. Reset yang berhasil mengarahkan pengguna ke login.
- **Main flow:**
  1. Untuk reset, aktor meminta tautan reset dengan mengisi email.
  2. Sistem mengirim tautan reset melalui mekanisme Laravel; pada lingkungan local sistem dapat menyediakan tautan reset pada sesi respons.
  3. Aktor membuka tautan, lalu mengirim token, email, kata sandi baru, dan konfirmasi.
  4. Sistem memvalidasi token dan data, menyimpan kata sandi baru, memperbarui remember token, dan memicu event reset.
  5. Untuk perubahan dari akun aktif, aktor mengisi kata sandi saat ini serta kata sandi baru dan konfirmasinya; sistem menyimpan kata sandi baru.
- **Exception / alternative flow:**
  - Email tidak valid/tidak dapat diproses, token tidak valid/kedaluwarsa, atau konfirmasi kata sandi salah: sistem menampilkan kesalahan dan kata sandi tidak berubah.
  - Kata sandi saat ini salah: perubahan dari profil ditolak.
  - Pengiriman email gagal: pengguna tidak dapat melanjutkan sampai tautan reset tersedia; penyedia email bergantung pada konfigurasi aplikasi.

### UC-05 — Verifikasi email

- **Aktor:** Pengguna login, layanan email.
- **Pre-condition:** Akun sudah login dan belum diverifikasi; tautan verifikasi bertanda tangan masih berlaku.
- **Post-condition:** Email akun ditandai terverifikasi dan pengguna diarahkan ke dashboard yang dimaksud.
- **Main flow:**
  1. Sistem menampilkan permintaan verifikasi kepada pengguna.
  2. Pengguna meminta pengiriman ulang email verifikasi bila diperlukan.
  3. Pengguna membuka tautan verifikasi.
  4. Sistem memeriksa tanda tangan dan batas request, menandai email terverifikasi, lalu mengarahkan pengguna ke dashboard.
- **Exception / alternative flow:**
  - Tautan tidak valid/tidak bertanda tangan atau request melewati pembatasan: verifikasi ditolak.
  - Email sudah terverifikasi: sistem tetap mengarahkan pengguna ke dashboard dengan penanda bahwa verifikasi sudah dilakukan.

### UC-06 — Mengelola keranjang dan voucher

- **Aktor:** Pengguna login (alur utama pelanggan).
- **Pre-condition:** Aktor login; produk tersedia untuk penambahan item.
- **Post-condition:** Isi keranjang/catatan/voucher sesi diperbarui, atau tidak berubah jika validasi gagal.
- **Main flow:**
  1. Aktor membuka keranjang atau memilih produk untuk ditambahkan.
  2. Sistem menambahkan kuantitas yang diminta ke item produk aktor, dengan minimum kuantitas satu.
  3. Aktor dapat menaikkan/menurunkan kuantitas, menyimpan catatan produk, menghapus satu item, atau mengosongkan keranjang.
  4. Sistem menghitung subtotal dari harga produk saat ini dan kuantitas di keranjang.
  5. Untuk memakai voucher, aktor memasukkan kode; sistem memeriksa status aktif, tanggal kedaluwarsa, kuota dan minimum pembelian.
  6. Sistem menghitung diskon nominal atau persentase dan menyimpan voucher/diskon di sesi.
  7. Aktor dapat menghapus voucher dari sesi sebelum checkout.
- **Exception / alternative flow:**
  - Admin membuka atau mengubah keranjang melalui alur tambah: sistem menolak transaksi pembelian admin.
  - Produk tidak ditemukan atau stok nol: penambahan ditolak.
  - Kuantitas tambahan melebihi stok: penambahan ditolak dan sisa stok diinformasikan.
  - Catatan lebih dari 1.000 karakter atau tidak valid: perubahan keranjang ditolak.
  - Kode voucher tidak ditemukan, nonaktif, habis kuota, kedaluwarsa, atau subtotal kurang dari minimum: voucher tidak diterapkan dan pesan kesalahan ditampilkan.
  - Keranjang kosong: subtotal nol; checkout mengarahkan kembali ke keranjang.

### UC-07 — Checkout dan membuat pesanan online

- **Aktor:** Pelanggan.
- **Pre-condition:** Aktor login; keranjang berisi item; metode pembayaran tersedia untuk dipilih.
- **Post-condition:** Pesanan beserta item tersimpan dengan status awal pembayaran `unpaid` dan pesanan `pending`; keranjang serta voucher sesi dikosongkan; pelanggan melihat halaman sukses.
- **Main flow:**
  1. Pelanggan membuka checkout.
  2. Sistem memastikan keranjang tidak kosong, menghitung subtotal/diskon/total, dan menampilkan rekening/QRIS aktif.
  3. Pelanggan mengisi alamat, nomor penerima, metode pembayaran, serta secara opsional pesan kartu ucapan.
  4. Sistem memvalidasi data dan memastikan metode pembayaran bukan cash/tunai untuk checkout web.
  5. Jika voucher tersimpan di sesi, sistem memeriksa kembali ketersediaan voucher dan mengurangi kuotanya.
  6. Sistem membuat pesanan dan item pesanan; catatan item dari keranjang ikut disalin.
  7. Sistem menghapus keranjang dan voucher dari sesi, lalu menampilkan halaman sukses pesanan.
- **Exception / alternative flow:**
  - Keranjang kosong saat membuka atau mengirim checkout: pelanggan diarahkan ke keranjang.
  - Alamat, telepon, atau metode pembayaran tidak diisi: validasi menolak checkout.
  - Metode pembayaran cash/tunai: checkout web ditolak dengan pesan bahwa cash hanya tersedia untuk pembelian offline.
  - Voucher tidak lagi tersedia pada saat checkout: sesi voucher dihapus, pelanggan dikembalikan ke keranjang untuk memeriksa ulang.
  - Error penyimpanan: pesanan tidak dapat dianggap berhasil sampai proses pembuatan selesai.

### UC-08 — Mengunggah bukti pembayaran

- **Aktor:** Pelanggan.
- **Pre-condition:** Pelanggan login dan merupakan pemilik pesanan.
- **Post-condition:** Gambar bukti disimpan; status pembayaran berubah menjadi `Menunggu Verifikasi`; pelanggan kembali ke halaman sukses.
- **Main flow:**
  1. Pelanggan membuka pesanan miliknya dan memilih unggah bukti.
  2. Pelanggan memilih gambar bukti pembayaran.
  3. Sistem memvalidasi berkas gambar dengan ukuran maksimum 2 MB.
  4. Sistem menyimpan gambar pada penyimpanan publik dan memperbarui pesanan ke status menunggu verifikasi.
- **Exception / alternative flow:**
  - Pesanan bukan milik pelanggan: akses ditolak.
  - Tidak memilih gambar, berkas bukan gambar, atau ukuran melebihi batas: unggahan ditolak.
  - Upload terputus, konfigurasi server menolak berkas, atau penyimpanan gagal: pesan kesalahan yang sesuai ditampilkan dan status pesanan tidak dinyatakan berhasil diperbarui.

### UC-09 — Melihat riwayat dan detail pesanan

- **Aktor:** Pelanggan.
- **Pre-condition:** Pelanggan login.
- **Post-condition:** Sistem menampilkan pesanan milik pelanggan; tidak ada perubahan data.
- **Main flow:**
  1. Pelanggan membuka riwayat pesanan.
  2. Sistem memuat pesanan beserta item dan produk, diurutkan dari yang terbaru.
  3. Pelanggan dapat memfilter pesanan belum dibayar, status dikemas/dikirim, atau pesanan selesai yang masih menunggu ulasan.
  4. Pelanggan membuka halaman sukses untuk melihat detail pesanan miliknya, informasi pembayaran dan rekening yang tersedia.
- **Exception / alternative flow:**
  - Tidak ada pesanan yang cocok dengan filter: daftar kosong.
  - ID pesanan tidak ditemukan: halaman tidak ditemukan.
  - ID pesanan milik pengguna lain: akses ke halaman sukses ditolak.

### UC-10 — Memberi ulasan pesanan

- **Aktor:** Pelanggan.
- **Pre-condition:** Pelanggan login dan memiliki pesanan dengan status `completed`, pembayaran `paid`, serta belum pernah diulas.
- **Post-condition:** Rating 1–5, ulasan, dan waktu ulasan tersimpan; ulasan yang memenuhi syarat dapat tampil pada katalog dan daftar ulasan.
- **Main flow:**
  1. Pelanggan membuka filter pesanan yang menunggu ulasan.
  2. Pelanggan memilih pesanan yang telah selesai dan mengirim rating serta ulasan.
  3. Sistem memeriksa kepemilikan, kelayakan status, dan validasi input (ulasan wajib, maksimum 1.000 karakter).
  4. Sistem menyimpan ulasan dan mengarahkan pelanggan kembali ke daftar ulasan yang menunggu.
- **Exception / alternative flow:**
  - Pesanan bukan milik pelanggan, belum selesai/belum dibayar, atau sudah diulas: pengiriman ditolak.
  - Rating di luar 1–5, ulasan kosong, atau terlalu panjang: validasi ditolak.

### UC-11 — Mengelola produk

- **Aktor:** Admin.
- **Pre-condition:** Admin login; route pengelolaan hanya dapat diakses role admin.
- **Post-condition:** Daftar produk tersimpan sesuai tambah, ubah, atau hapus; status stok produk dihitung sebagai `Ready` atau `Habis`.
- **Main flow:**
  1. Admin membuka daftar produk dan dapat mencari berdasarkan nama.
  2. Admin mengirim data produk baru atau mengubah nama, kategori, harga, stok, deskripsi, dan gambar.
  3. Sistem memvalidasi kategori, tipe data, batas deskripsi, dan berkas gambar (JPEG/PNG/JPG/WEBP, maksimum 2 MB).
  4. Sistem menyimpan produk dan menetapkan status berdasarkan stok.
  5. Untuk menghapus, admin memilih produk; sistem menghapus data produk dan gambar terkait bila ada.
- **Exception / alternative flow:**
  - Pengguna tanpa role admin membuka route pengelolaan: akses ditolak.
  - Data produk atau gambar tidak valid: perubahan ditolak.
  - Produk/gambar tidak ditemukan: operasi terkait gagal/tidak tersedia.

### UC-12 — Mengelola akun staf

- **Aktor:** Admin.
- **Pre-condition:** Admin login.
- **Post-condition:** Akun admin/kasir dibuat atau diperbarui; akun staf dapat diaktif/nonaktifkan.
- **Main flow:**
  1. Admin membuka daftar akun staf.
  2. Admin dapat membuat akun dengan nama, email, role `admin`/`kasir`, dan kata sandi terkonfirmasi.
  3. Admin dapat mengubah nama, email, atau role dari akun admin/kasir.
  4. Admin dapat mengaktifkan/nonaktifkan akun lain.
  5. Sistem menyimpan perubahan dan menampilkan hasilnya.
- **Exception / alternative flow:**
  - Pengguna bukan admin: akses ditolak.
  - Email duplikat, data tidak valid, role bukan admin/kasir, atau konfirmasi kata sandi gagal: penyimpanan ditolak.
  - Akun owner tidak dapat diubah melalui fitur ini.
  - Admin tidak dapat mengubah status akunnya sendiri melalui fitur toggle.
  - ID akun tidak ditemukan: operasi ditolak.

### UC-13 — Mengelola rekening dan QRIS

- **Aktor:** Admin.
- **Pre-condition:** Admin login.
- **Post-condition:** Data rekening/QRIS disimpan, dihapus, atau status aktifnya diubah; daftar aktif menjadi sumber informasi pembayaran checkout.
- **Main flow:**
  1. Admin membuka halaman rekening.
  2. Admin menambah rekening dengan nama bank, nomor rekening, nama pemilik, atau menambahkan gambar QRIS.
  3. Sistem memvalidasi data dan gambar QRIS (JPEG/JPG/PNG/WEBP, maksimum 2 MB), lalu menyimpan rekening.
  4. Admin dapat mengaktif/nonaktifkan rekening, atau menghapusnya.
- **Exception / alternative flow:**
  - Pengguna bukan admin: akses ditolak.
  - Data rekening wajib kosong atau gambar tidak memenuhi validasi: penyimpanan ditolak.
  - Rekening tidak ditemukan saat toggle/hapus: operasi gagal.
  - Jika tidak ada rekening aktif, checkout tidak memiliki informasi rekening aktif untuk ditampilkan.

### UC-14 — Mengelola slide beranda

- **Aktor:** Admin.
- **Pre-condition:** Admin login; slide yang akan diubah tersedia.
- **Post-condition:** Teks, gambar, dan status aktif slide tersimpan; hanya slide aktif ditampilkan pada beranda.
- **Main flow:**
  1. Admin membuka daftar slide beranda.
  2. Admin memilih slide dan mengubah judul, eyebrow, deskripsi, status aktif, dan/atau gambar.
  3. Sistem memvalidasi judul, panjang teks, serta gambar (JPEG/JPG/PNG/WEBP, maksimum 4 MB).
  4. Sistem menyimpan perubahan dan mengganti gambar lama bila gambar baru diberikan.
- **Exception / alternative flow:**
  - Pengguna bukan admin: akses ditolak.
  - Judul kosong, teks melampaui batas, atau gambar tidak valid: perubahan ditolak.
  - Slide tidak ditemukan: perubahan gagal.

### UC-15 — Mengelola voucher

- **Aktor:** Admin; pelanggan menggunakan voucher melalui UC-06/UC-07.
- **Pre-condition:** Admin login untuk mengelola voucher; voucher tersedia dan aktif untuk digunakan pelanggan.
- **Post-condition:** Voucher tersimpan/dihapus/statusnya berubah; pemakaian checkout mengurangi kuota voucher.
- **Main flow:**
  1. Admin membuka daftar voucher; sistem memperbarui status berdasarkan masa berlaku dan kuota.
  2. Admin membuat voucher berisi kode, tipe diskon (`fixed`/`percent`), nilai diskon, minimum belanja, kuota, dan tanggal kedaluwarsa.
  3. Sistem menyimpan kode dalam huruf besar dan mengaktifkan voucher.
  4. Admin dapat mengganti status aktif atau menghapus voucher.
  5. Pelanggan menerapkan voucher di keranjang; sistem memeriksa minimum belanja dan menghitung diskon.
  6. Saat pelanggan checkout, sistem memeriksa kembali voucher dan mengurangi kuota.
- **Exception / alternative flow:**
  - Kode duplikat, kuota kurang dari satu, nilai/minimum negatif, tipe tidak didukung, atau tanggal kedaluwarsa sebelum hari ini: pembuatan ditolak.
  - Voucher tidak aktif/kedaluwarsa/kuotanya habis: tidak dapat diterapkan.
  - Kuota habis atau voucher kedaluwarsa setelah dipasang di keranjang: voucher sesi dibuang dan checkout dikembalikan ke keranjang.

### UC-16 — Memantau pesanan sebagai admin/owner

- **Aktor:** Admin, owner.
- **Pre-condition:** Aktor login; role admin atau owner.
- **Post-condition:** Daftar/detail pesanan ditampilkan tanpa mengubah status pesanan.
- **Main flow:**
  1. Aktor membuka daftar pesanan.
  2. Sistem menampilkan pesanan terbaru, pembeli dan item.
  3. Aktor membuka salah satu detail untuk meninjau alamat, permintaan/catatan pembeli, dan informasi pesanan.
- **Exception / alternative flow:**
  - Role lain membuka route monitoring: akses ditolak.
  - ID pesanan tidak ditemukan: halaman tidak ditemukan.
  - Route admin hanya untuk baca/pemantauan; perubahan status dilakukan oleh kasir.

### UC-17 — Mengelola antrean dan status pesanan

- **Aktor:** Kasir.
- **Pre-condition:** Kasir login; pesanan tersedia.
- **Post-condition:** Daftar pesanan difilter/ditampilkan atau status pesanan/pembayaran diperbarui. Pengurangan stok dilakukan maksimal sekali per pesanan melalui penanda `stock_deducted`.
- **Main flow:**
  1. Kasir membuka daftar pesanan; secara opsional memfilter tanggal atau mencari nomor pesanan/nama pembeli.
  2. Sistem menampilkan pesanan dan jumlah yang menunggu verifikasi.
  3. Kasir membuka detail, lalu memperbarui status pesanan atau status pembayaran.
  4. Jika status pesanan menjadi `completed`/`selesai` atau status pembayaran menjadi `paid`, sistem memeriksa stok dan menguranginya satu kali.
  5. Sistem menyimpan perubahan dan menampilkan konfirmasi.
- **Exception / alternative flow:**
  - Role selain kasir membuka route operasional: akses ditolak.
  - Stok item tidak cukup saat pengurangan: transaksi stok dibatalkan dan kasir menerima pesan validasi.
  - Order tidak ditemukan: perubahan ditolak.
  - Perubahan status pesanan ke `pending`, `cancelled`, atau `dibatalkan` menetapkan pembayaran `unpaid`, kecuali order bertipe `Walk-in`.
  - Implementasi route memvalidasi status sebagai string wajib; nilai status tidak dibatasi enum pada controller.

### UC-18 — Membuat transaksi walk-in/POS

- **Aktor:** Kasir.
- **Pre-condition:** Kasir login; produk tersedia; keranjang POS berisi produk dan kuantitas.
- **Post-condition:** Pesanan walk-in tersimpan sebagai `completed` dan `paid`; item tersimpan; stok dikurangi; kasir kembali ke daftar pesanan.
- **Main flow:**
  1. Kasir membuka POS atau halaman walk-in.
  2. Kasir memilih produk, memasukkan nama pelanggan, item dan kuantitas, serta metode pembayaran.
  3. Sistem memvalidasi nama, isi keranjang dan metode pembayaran.
  4. Sistem memeriksa semua produk dan ketersediaan stok.
  5. Sistem menghitung total dari data item POS, membuat pesanan walk-in dan itemnya.
  6. Jika metode cash/tunai dipilih, sistem menyimpan metode `Cash`; selain itu sistem menyimpan `QRIS`.
  7. Sistem mengurangi stok dan memperbarui status ketersediaan produk.
- **Exception / alternative flow:**
  - Nama pelanggan, keranjang, atau metode pembayaran tidak diberikan: validasi gagal.
  - Data keranjang kosong/tidak dapat dibaca, produk tidak ditemukan, atau stok tidak cukup: transaksi ditolak.
  - Stok berubah/tidak mencukupi saat proses pengurangan: pengurangan stok dibatalkan. Karena pesanan dan item dibuat sebelum pengurangan stok, record pesanan mungkin sudah tersimpan ketika kondisi balapan ini terjadi.

### UC-19 — Melihat rekap dan menutup shift kasir

- **Aktor:** Kasir.
- **Pre-condition:** Kasir login; transaksi harian tercatat.
- **Post-condition:** Modal awal dapat tersimpan pada sesi, atau rekap shift tersimpan dengan total tunai/QRIS, kas yang diharapkan, uang fisik dan selisih.
- **Main flow:**
  1. Kasir membuka halaman rekap untuk melihat jumlah dan total transaksi tunai/QRIS serta hingga 10 rekap terbaru; riwayat dapat difilter berdasarkan tanggal.
  2. Sistem menghitung transaksi hari ini dengan status pembayaran paid atau status pesanan completed.
  3. Kasir dapat menyimpan modal awal; nilai tersebut disimpan di sesi dan digunakan untuk hitung kas.
  4. Pada penutupan, kasir memasukkan modal awal, uang fisik, dan catatan opsional.
  5. Sistem menghitung kas yang diharapkan (`modal awal + total tunai`) dan selisih (`uang fisik - kas yang diharapkan`), lalu menyimpan rekap.
- **Exception / alternative flow:**
  - Data angka wajib kosong/tidak valid: rekap tidak disimpan.
  - Belum ada transaksi: nilai total pemasukan menjadi nol, tetapi kas yang diharapkan tetap memperhitungkan modal awal.
  - Modal awal sesi belum pernah diatur: halaman menggunakan nilai default 300.000.

### UC-20 — Melihat dashboard dan laporan owner

- **Aktor:** Owner.
- **Pre-condition:** Owner login; data pesanan tersedia.
- **Post-condition:** Sistem menampilkan agregasi transaksi dan grafik sesuai periode; tidak ada perubahan data pesanan.
- **Main flow:**
  1. Owner membuka dashboard, laporan, atau grafik.
  2. Owner memilih rentang tanggal bila diperlukan.
  3. Sistem menghitung omzet/transaksi, pemisahan tunai dan QRIS atau omzet toko/web, grafik harian, produk terlaris, dan pesanan terbaru sesuai halaman.
  4. Owner meninjau hasil dan dapat memilih ekspor PDF/Excel melalui use case UC-21.
- **Exception / alternative flow:**
  - Pengguna bukan owner membuka route laporan owner: akses ditolak.
  - Belum ada transaksi pada rentang tanggal: ringkasan/grafik menampilkan hasil kosong atau bernilai nol.
  - Parameter tanggal tidak dapat diproses: permintaan laporan gagal diproses.
  - Definisi perhitungan berbeda antarhalaman: dashboard utama menggunakan status pesanan `completed`, sementara laporan dan grafik terpisah menggunakan status pembayaran `paid`; hasil antarhalaman karena itu dapat berbeda.

### UC-21 — Mengekspor laporan penjualan

- **Aktor:** Owner.
- **Pre-condition:** Owner login; rentang laporan dapat diproses.
- **Post-condition:** Browser menerima unduhan laporan PDF atau XLSX yang berisi pesanan selesai pada rentang yang dipilih.
- **Main flow:**
  1. Owner memilih ekspor PDF atau Excel dari area laporan.
  2. Sistem menentukan tanggal awal/akhir; jika tidak diberikan, default adalah awal bulan sampai waktu saat ini.
  3. Sistem mengambil pesanan berstatus completed, menghitung omzet dan breakdown metode pembayaran.
  4. Sistem membentuk file dengan ringkasan dan daftar transaksi.
  5. Browser mengunduh file dengan nama sesuai rentang tanggal.
- **Exception / alternative flow:**
  - Pengguna bukan owner: akses ditolak.
  - Tidak ada pesanan selesai: sistem tetap menghasilkan laporan tanpa baris transaksi atau dengan total nol.
  - Kegagalan generator PDF/Excel atau output unduhan: laporan tidak dapat diunduh.

### UC-22 — Mengelola profil dan menghapus akun

- **Aktor:** Pengguna login.
- **Pre-condition:** Aktor login dan membuka profil miliknya.
- **Post-condition:** Profil tersimpan; bila akun dihapus, sesi diakhiri dan aktor diarahkan ke beranda.
- **Main flow:**
  1. Aktor membuka halaman profil.
  2. Aktor mengubah informasi profil dan secara opsional mengunggah avatar.
  3. Sistem memvalidasi data, menyimpan avatar, mengganti avatar lama, lalu menyimpan perubahan.
  4. Jika email berubah, sistem menghapus penanda verifikasi email agar perlu diverifikasi kembali.
  5. Untuk menghapus akun, aktor mengonfirmasi dengan kata sandi saat ini.
  6. Sistem logout, menghapus avatar yang tersimpan, menghapus akun, menginvalidasi sesi, dan kembali ke beranda.
- **Exception / alternative flow:**
  - Profil atau avatar tidak valid: perubahan ditolak.
  - Kata sandi saat ini salah atau tidak diberikan saat penghapusan: akun tidak dihapus.
  - Penghapusan akun akan berdampak pada relasi pesanan yang mengikuti kebijakan foreign key database.

## 5. Ringkasan kontrol akses

| Fitur | Pengunjung | Pelanggan | Admin | Kasir | Owner |
|---|---:|---:|---:|---:|---:|
| Katalog/detail/ulasan | Ya | Ya | Ya | Ya | Ya |
| Registrasi/login | Ya | Tidak (sudah login) | Tidak (sudah login) | Tidak (sudah login) | Tidak (sudah login) |
| Keranjang dan checkout | Tidak | Ya* | Ditolak untuk keranjang | Route umum mensyaratkan login* | Route umum mensyaratkan login* |
| Riwayat dan ulasan milik akun | Tidak | Ya | Route umum mensyaratkan login* | Route umum mensyaratkan login* | Route umum mensyaratkan login* |
| Pengelolaan produk/staf/rekening/slide/voucher | Tidak | Tidak | Ya | Tidak | Tidak |
| Monitoring daftar/detail pesanan | Tidak | Tidak | Ya | Melalui area kasir | Ya |
| Status pesanan/verifikasi pembayaran | Tidak | Tidak | Tidak | Ya | Tidak |
| POS dan rekap shift | Tidak | Tidak | Tidak | Ya | Tidak |
| Dashboard/laporan/ekspor owner | Tidak | Tidak | Tidak | Tidak | Ya |
| Profil | Tidak | Ya | Ya | Ya | Ya |

\* Route tertentu dalam kelompok transaksi umum hanya memakai middleware `auth`, bukan pembatas role khusus. Tabel ini membedakan alur bisnis yang ditujukan kepada pelanggan dari aturan akses teknis route saat ini.

## 6. Status dan aturan bisnis yang tercermin di alur

- **Pesanan online:** dibuat `pending` dan pembayaran `unpaid`. Bukti pembayaran mengubah pembayaran menjadi `Menunggu Verifikasi`.
- **Pesanan walk-in:** dibuat `completed` dan `paid`; metode pembayaran selain cash/tunai dipetakan menjadi `QRIS`.
- **Pengurangan stok:** dipicu saat pesanan diselesaikan atau pembayaran ditandai `paid`; penanda `stock_deducted` mencegah pengurangan ganda. Walk-in mengurangi stok pada saat dibuat.
- **Voucher:** status bergantung pada flag aktif, tanggal kedaluwarsa, dan kuota. Diskon disimpan di sesi; kuota dikurangi saat checkout.
- **Ulasan:** hanya pesanan milik pengguna yang completed, paid, dan belum pernah diulas yang dapat diberi rating dan ulasan.
- **Rekap kas:** omzet tunai/QRIS menggunakan transaksi hari ini yang paid atau completed; kas fisik yang diharapkan adalah modal awal ditambah omzet tunai.
- **Laporan:** cara penyaringan omzet berbeda antara dashboard owner utama dan halaman laporan/ekspor; perbedaan tersebut dicatat agar hasil angka tidak diasumsikan identik.

## 7. Hal di luar cakupan implementasi yang teramati

Dokumen ini tidak mengasumsikan adanya gateway pembayaran otomatis, pelacakan kurir, notifikasi status pesanan otomatis, pembatalan mandiri pelanggan, pengelolaan bahan baku, atau proses persetujuan owner. Fitur-fitur tersebut tidak ditemukan pada alur route/controller yang dianalisis.
