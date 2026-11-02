# Instructions

- Following Playwright test failed.
- Explain why, be concise, respect Playwright best practices.
- Provide a snippet of code with the fix, if possible.

# Test info

- Name: use-cases.spec.js >> TC-UC01-01: pengunjung mencari, memfilter, dan membuka katalog produk
- Location: tests\e2e\use-cases.spec.js:34:1

# Error details

```
Error: expect(locator).toHaveCount(expected) failed

Locator:  locator('a[href^="/products/"]')
Expected: 6
Received: 0
Timeout:  5000ms

Call log:
  - Expect "toHaveCount" locator('a[href^="/products/"]') with timeout 5000ms
  - waiting for locator('a[href^="/products/"]')
    14 × locator resolved to 0 elements
       - unexpected value "0"

```

# Page snapshot

```yaml
- generic [active] [ref=e1]:
  - navigation [ref=e2]:
    - generic [ref=e3]:
      - link "🌸 EndorphineFlorist" [ref=e4] [cursor=pointer]:
        - /url: http://127.0.0.1:8010
        - generic [ref=e5]: 🌸
        - generic [ref=e6]: EndorphineFlorist
      - textbox "Cari buket mawar, snack, dll..." [ref=e9]
      - generic [ref=e10]:
        - link "Masuk" [ref=e11] [cursor=pointer]:
          - /url: http://127.0.0.1:8010/login
        - link "Daftar" [ref=e13] [cursor=pointer]:
          - /url: http://127.0.0.1:8010/register
  - generic [ref=e16]:
    - generic [ref=e17]:
      - group "1 / 5" [ref=e18]:
        - img "Kirim Kebahagiaan Lewat Rangkaian Buket Estetik" [ref=e20]
        - generic [ref=e23]:
          - generic [ref=e24]: ✨ Handcrafted Bouquet with Love
          - heading "Kirim Kebahagiaan Lewat Rangkaian Buket Estetik" [level=1] [ref=e25]
          - paragraph [ref=e26]: Pilihan buket bunga murni, snack favorit, hingga buket uang eksklusif yang dirangkai khusus untuk momen terindah orang tersayangmu.
      - group "2 / 5" [ref=e27]:
        - img "Koleksi Buket Mawar Soft & Premium" [ref=e29]
        - generic [ref=e32]:
          - generic [ref=e33]: 💐 Bunga Segar Setiap Hari
          - heading "Koleksi Buket Mawar Soft & Premium" [level=1] [ref=e34]
          - paragraph [ref=e35]: Dipetik segar langsung dari kebun dan dirangkai oleh florist profesional untuk kesan yang tak terlupakan.
      - group "3 / 5" [ref=e36]:
        - img "Buket Snack & Uang untuk Momen Wisuda" [ref=e38]
        - generic [ref=e41]:
          - generic [ref=e42]: 🎉 Special Gift & Graduation
          - heading "Buket Snack & Uang untuk Momen Wisuda" [level=1] [ref=e43]
          - paragraph [ref=e44]: Custom jumlah lembaran uang dan jajanan favorit dengan gratis kartu ucapan unik.
      - group "4 / 5" [ref=e45]:
        - img "Kado Manis untuk Orang Tersayang" [ref=e47]
        - generic [ref=e50]:
          - generic [ref=e51]: 🎁 Hadiah untuk Momen Spesial
          - heading "Kado Manis untuk Orang Tersayang" [level=1] [ref=e52]
          - paragraph [ref=e53]: Pilih hadiah yang dirangkai dengan penuh perhatian untuk setiap perayaan.
      - group "5 / 5" [ref=e54]:
        - img "Buket Wisuda yang Berkesan" [ref=e56]
        - generic [ref=e59]:
          - generic [ref=e60]: 🎓 Rayakan Pencapaianmu
          - heading "Buket Wisuda yang Berkesan" [level=1] [ref=e61]
          - paragraph [ref=e62]: Rayakan hari kelulusan dengan rangkaian buket yang dibuat khusus untuk momen bangga.
    - button "Next slide" [ref=e63] [cursor=pointer]: next
    - button "Previous slide" [ref=e64] [cursor=pointer]: prev
    - generic [ref=e65]:
      - button "Go to slide 1" [ref=e66] [cursor=pointer]
      - button "Go to slide 2" [ref=e67] [cursor=pointer]
      - button "Go to slide 3" [ref=e68] [cursor=pointer]
      - button "Go to slide 4" [ref=e69] [cursor=pointer]
      - button "Go to slide 5" [ref=e70] [cursor=pointer]
  - generic [ref=e72]:
    - generic [ref=e73]:
      - generic [ref=e74]: 🌸
      - generic [ref=e75]:
        - heading "Bunga Segar Berkualitas" [level=4] [ref=e76]
        - paragraph [ref=e77]: Rangkaian terbaik dengan bahan premium
    - generic [ref=e78]:
      - generic [ref=e79]: 💌
      - generic [ref=e80]:
        - heading "Gratis Kartu Ucapan" [level=4] [ref=e81]
        - paragraph [ref=e82]: Custom pesan manis sesuai permintaanmu
    - generic [ref=e83]:
      - generic [ref=e84]: 💳
      - generic [ref=e85]:
        - heading "Pembayaran Aman" [level=4] [ref=e86]
        - paragraph [ref=e87]: Cash, Transfer, dan QRIS tersedia
  - main [ref=e88]:
    - generic [ref=e89]:
      - generic [ref=e90]:
        - text: Katalog Buket
        - heading "Temukan Pilihan Favoritmu" [level=2] [ref=e91]
      - generic [ref=e92]:
        - button "Geser kategori ke kiri" [ref=e93] [cursor=pointer]: ←
        - generic [ref=e94]:
          - link "✨ Semua" [ref=e95] [cursor=pointer]:
            - /url: http://127.0.0.1:8010
            - text: ✨
            - generic [ref=e96]: Semua
          - link "💐 Bunga" [ref=e97] [cursor=pointer]:
            - /url: http://127.0.0.1:8010?category=Bunga
            - text: 💐
            - generic [ref=e98]: Bunga
          - link "🍫 Snack" [ref=e99] [cursor=pointer]:
            - /url: http://127.0.0.1:8010?category=Snack
            - text: 🍫
            - generic [ref=e100]: Snack
          - link "💸 Uang" [ref=e101] [cursor=pointer]:
            - /url: http://127.0.0.1:8010?category=Uang
            - text: 💸
            - generic [ref=e102]: Uang
          - link "🎁 Kado" [ref=e103] [cursor=pointer]:
            - /url: http://127.0.0.1:8010?category=Kado
            - text: 🎁
            - generic [ref=e104]: Kado
          - link "🎓 Wisuda" [ref=e105] [cursor=pointer]:
            - /url: http://127.0.0.1:8010?category=Wisuda
            - text: 🎓
            - generic [ref=e106]: Wisuda
        - button "Geser kategori ke kanan" [ref=e107] [cursor=pointer]: →
    - generic [ref=e108]:
      - generic [ref=e109]:
        - generic [ref=e110]:
          - link "Lihat detail produk Buket Mawar Red Classic" [ref=e111] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/5
            - generic [ref=e112]: No Photo Available
            - generic [ref=e114]: Bunga
            - generic [ref=e115]: Ready
            - generic [ref=e116]: Baru
          - heading "Buket Mawar Red Classic" [level=3] [ref=e118]
        - generic [ref=e119]:
          - generic [ref=e120]:
            - paragraph [ref=e121]: Harga
            - paragraph [ref=e122]: Rp 150.000
          - link "🔎 Detail Produk" [ref=e123] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/5
            - text: 🔎
            - generic [ref=e124]: Detail Produk
      - generic [ref=e125]:
        - generic [ref=e126]:
          - link "Lihat detail produk Buket Snack Choco Lovers" [ref=e127] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/6
            - generic [ref=e128]: No Photo Available
            - generic [ref=e130]: Snack
            - generic [ref=e131]: Ready
            - generic [ref=e132]: Baru
          - heading "Buket Snack Choco Lovers" [level=3] [ref=e134]
        - generic [ref=e135]:
          - generic [ref=e136]:
            - paragraph [ref=e137]: Harga
            - paragraph [ref=e138]: Rp 85.000
          - link "🔎 Detail Produk" [ref=e139] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/6
            - text: 🔎
            - generic [ref=e140]: Detail Produk
      - generic [ref=e141]:
        - generic [ref=e142]:
          - link "Lihat detail produk Buket Mawar Soft Pink" [ref=e143] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/1
            - img "Buket Mawar Soft Pink" [ref=e144]
            - generic [ref=e146]: Bunga
            - generic [ref=e147]: Ready
            - generic [ref=e148]: Baru
          - heading "Buket Mawar Soft Pink" [level=3] [ref=e150]
        - generic [ref=e151]:
          - generic [ref=e152]:
            - paragraph [ref=e153]: Harga
            - paragraph [ref=e154]: Rp 150.000
          - link "🔎 Detail Produk" [ref=e155] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/1
            - text: 🔎
            - generic [ref=e156]: Detail Produk
      - generic [ref=e157]:
        - generic [ref=e158]:
          - link "Lihat detail produk Buket Snack Chocolate Deluxe" [ref=e159] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/2
            - img "Buket Snack Chocolate Deluxe" [ref=e160]
            - generic [ref=e162]: Snack
            - generic [ref=e163]: Ready
            - generic [ref=e164]: Baru
          - heading "Buket Snack Chocolate Deluxe" [level=3] [ref=e166]
        - generic [ref=e167]:
          - generic [ref=e168]:
            - paragraph [ref=e169]: Harga
            - paragraph [ref=e170]: Rp 85.000
          - link "🔎 Detail Produk" [ref=e171] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/2
            - text: 🔎
            - generic [ref=e172]: Detail Produk
      - generic [ref=e173]:
        - generic [ref=e174]:
          - link "Lihat detail produk Buket Uang Pecahan 50rb" [ref=e175] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/3
            - img "Buket Uang Pecahan 50rb" [ref=e176]
            - generic [ref=e178]: Uang
            - generic [ref=e179]: Ready
            - generic [ref=e180]: Baru
          - heading "Buket Uang Pecahan 50rb" [level=3] [ref=e182]
        - generic [ref=e183]:
          - generic [ref=e184]:
            - paragraph [ref=e185]: Harga
            - paragraph [ref=e186]: Rp 250.000
          - link "🔎 Detail Produk" [ref=e187] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/3
            - text: 🔎
            - generic [ref=e188]: Detail Produk
      - generic [ref=e189]:
        - generic [ref=e190]:
          - link "Lihat detail produk Buket Tulip Gradasi Lavender" [ref=e191] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/4
            - img "Buket Tulip Gradasi Lavender" [ref=e192]
            - generic [ref=e194]: Bunga
            - generic [ref=e195]: Ready
            - generic [ref=e196]: Baru
          - heading "Buket Tulip Gradasi Lavender" [level=3] [ref=e198]
        - generic [ref=e199]:
          - generic [ref=e200]:
            - paragraph [ref=e201]: Harga
            - paragraph [ref=e202]: Rp 175.000
          - link "🔎 Detail Produk" [ref=e203] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/4
            - text: 🔎
            - generic [ref=e204]: Detail Produk
  - contentinfo [ref=e205]:
    - generic [ref=e206]:
      - generic [ref=e207]:
        - generic [ref=e208]:
          - link "🌸 EndorphineFlorist" [ref=e209] [cursor=pointer]:
            - /url: http://127.0.0.1:8010
            - generic [ref=e210]: 🌸
            - generic [ref=e211]: EndorphineFlorist
          - paragraph [ref=e212]: Toko buket bunga, snack, dan uang terpercaya. Dirangkai estetik dengan penuh kasih sayang untuk merayakan setiap momen berharga bersama orang tersayang.
          - generic [ref=e213]:
            - paragraph [ref=e214]: Lokasi Toko
            - paragraph [ref=e215]: Jl. Cimanggir
        - generic [ref=e216]:
          - heading "Ulasan Pelanggan" [level=4] [ref=e217]
          - paragraph [ref=e220]: Belum ada ulasan pelanggan.
        - generic [ref=e221]:
          - heading "Toko Online / E-Commerce" [level=4] [ref=e222]
          - generic [ref=e224]:
            - link "🛍️ Shopee Official" [ref=e225] [cursor=pointer]:
              - /url: https://shopee.co.id
              - generic [ref=e226]: 🛍️
              - generic [ref=e227]: Shopee Official
            - link "🟢 Tokopedia Official" [ref=e228] [cursor=pointer]:
              - /url: https://tokopedia.com
              - generic [ref=e229]: 🟢
              - generic [ref=e230]: Tokopedia Official
        - generic [ref=e231]:
          - heading "Hubungi & Ikuti Kami" [level=4] [ref=e232]
          - paragraph [ref=e234]: Punya pertanyaan atau mau custom order khusus?
          - link "💬 WhatsApp CS (0812-3456-7890)" [ref=e235] [cursor=pointer]:
            - /url: https://wa.me/6281234567890
            - generic [ref=e236]: 💬
            - text: WhatsApp CS (0812-3456-7890)
          - generic [ref=e237]:
            - link "Instagram" [ref=e238] [cursor=pointer]:
              - /url: https://instagram.com
            - link "TikTok" [ref=e241] [cursor=pointer]:
              - /url: https://tiktok.com
            - link "Facebook" [ref=e244] [cursor=pointer]:
              - /url: https://facebook.com
      - generic [ref=e247]:
        - paragraph [ref=e248]: © 2026 Endorphine Florist. All rights reserved.
        - paragraph [ref=e249]: Designed with 💖 for special moments.
```

# Test source

```ts
  1   | import { expect, test } from '@playwright/test';
  2   | 
  3   | const customerEmail = 'pelanggan@gmail.com';
  4   | const cashierEmail = 'kasir@endorphine.com';
  5   | const adminEmail = 'admin@endorphine.com';
  6   | const ownerEmail = 'owner@endorphine.com';
  7   | const demoPassword = 'password';
  8   | 
  9   | async function loginAs(page, email) {
  10  |     await page.goto('/login');
  11  |     await page.locator('#email').fill(email);
  12  |     await page.locator('#password').fill(demoPassword);
  13  |     await page.getByRole('button', { name: 'Masuk Sekarang' }).click();
  14  |     await expect(page).not.toHaveURL(/\/login$/);
  15  | }
  16  | 
  17  | async function addSeedProductToCart(page) {
  18  |     await page.goto('/');
  19  |     await page.locator('a[href^="/products/"]').filter({ hasText: 'Buket Mawar Soft Pink' }).first().click();
  20  |     await page.getByRole('button', { name: /Tambahkan ke Keranjang/ }).click();
  21  |     await page.goto('/cart');
  22  |     await expect(page.getByText('Buket Mawar Soft Pink')).toBeVisible();
  23  | }
  24  | 
  25  | test.afterEach(async ({ page }, testInfo) => {
  26  |     const screenshotPath = testInfo.outputPath('execution.png');
  27  |     await page.screenshot({ path: screenshotPath, fullPage: true });
  28  |     await testInfo.attach('execution-screenshot', {
  29  |         path: screenshotPath,
  30  |         contentType: 'image/png',
  31  |     });
  32  | });
  33  | 
  34  | test('TC-UC01-01: pengunjung mencari, memfilter, dan membuka katalog produk', async ({ page }) => {
  35  |     await page.goto('/');
> 36  |     await expect(page.locator('a[href^="/products/"]')).toHaveCount(6);
      |                                                         ^ Error: expect(locator).toHaveCount(expected) failed
  37  |     await page.locator('input[name="search"]').fill('Buket Mawar Soft Pink');
  38  |     await page.locator('input[name="search"]').press('Enter');
  39  |     await expect(page.getByText('Buket Mawar Soft Pink')).toBeVisible();
  40  |     await expect(page.getByText('Buket Snack Chocolate Deluxe')).toHaveCount(0);
  41  | 
  42  |     await page.goto('/?search=not-a-real-bouquet');
  43  |     await expect(page.locator('a[href^="/products/"]')).toHaveCount(0);
  44  | });
  45  | 
  46  | test('TC-UC02-01: pengunjung mendaftar dan langsung menggunakan akun pelanggan', async ({ page }) => {
  47  |     const email = `e2e-${Date.now()}@example.test`;
  48  |     await page.goto('/register');
  49  |     await page.locator('#name').fill('Pelanggan E2E');
  50  |     await page.locator('#email').fill(email);
  51  |     await page.locator('#phone').fill('081234567899');
  52  |     await page.locator('#password').fill('ValidPass123!');
  53  |     await page.locator('#password_confirmation').fill('ValidPass123!');
  54  |     await page.getByRole('button', { name: 'Daftar Sekarang' }).click();
  55  | 
  56  |     await expect(page).toHaveURL('/');
  57  |     await expect(page.getByText('Pelanggan E2E')).toBeVisible();
  58  | });
  59  | 
  60  | test('TC-UC02-02: registrasi menolak email duplikat dan konfirmasi sandi berbeda', async ({ page }) => {
  61  |     await page.goto('/register');
  62  |     await page.locator('#name').fill('Pendaftaran Invalid');
  63  |     await page.locator('#email').fill(customerEmail);
  64  |     await page.locator('#phone').fill('081234567899');
  65  |     await page.locator('#password').fill('ValidPass123!');
  66  |     await page.locator('#password_confirmation').fill('DifferentPass123!');
  67  |     await page.getByRole('button', { name: 'Daftar Sekarang' }).click();
  68  | 
  69  |     await expect(page).toHaveURL(/\/register$/);
  70  |     await expect(page.locator('.text-rose-500').first()).toBeVisible();
  71  | });
  72  | 
  73  | test('TC-UC03-01: pelanggan menambah, mengubah, dan menghapus item keranjang', async ({ page }) => {
  74  |     await loginAs(page, customerEmail);
  75  |     await addSeedProductToCart(page);
  76  | 
  77  |     await page.getByRole('button', { name: 'Tambah jumlah' }).click();
  78  |     await expect(page.getByText('2x', { exact: false }).first()).toBeVisible();
  79  | 
  80  |     const noteInput = page.locator('input[name="note"]');
  81  |     await noteInput.fill('Pita warna pink');
  82  |     await noteInput.press('Tab');
  83  |     await expect(noteInput).toHaveValue('Pita warna pink');
  84  | 
  85  |     page.once('dialog', dialog => dialog.accept());
  86  |     await page.locator('form[action^="/cart/"]').last().getByRole('button').click();
  87  |     await expect(page.getByText('Keranjang belanja masih kosong.')).toBeVisible();
  88  | });
  89  | 
  90  | test('TC-UC03-02: akses keranjang tanpa login diarahkan ke autentikasi', async ({ page }) => {
  91  |     await page.goto('/cart');
  92  |     await expect(page).toHaveURL(/\/login$/);
  93  | });
  94  | 
  95  | test('TC-UC04-01: pelanggan checkout, menerima total, lalu mengunggah bukti pembayaran', async ({ page }) => {
  96  |     await loginAs(page, customerEmail);
  97  |     await addSeedProductToCart(page);
  98  |     await page.goto('/checkout');
  99  | 
  100 |     await page.locator('#shipping_address').fill('Jl. Mawar E2E No. 5');
  101 |     await page.locator('#recipient_phone').fill('081234567899');
  102 |     await page.locator('#radio-qris').check();
  103 |     await page.locator('form[action="/checkout"] button[type="submit"]').click();
  104 | 
  105 |     await expect(page).toHaveURL(/\/orders\/success\/\d+$/);
  106 |     await expect(page.getByText('Upload Bukti Pembayaran')).toBeVisible();
  107 | 
  108 |     const png = Buffer.from(
  109 |         'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAADUlEQVR4nGP4z8AAAAMBAQDJ/pLvAAAAAElFTkSuQmCC',
  110 |         'base64',
  111 |     );
  112 |     await page.locator('input[name="payment_proof"]').setInputFiles({
  113 |         name: 'payment-proof.png',
  114 |         mimeType: 'image/png',
  115 |         buffer: png,
  116 |     });
  117 |     await page.getByRole('button', { name: 'Kirim Bukti Pembayaran' }).click();
  118 |     await expect(page.getByText(/Menunggu Verifikasi Kasir/)).toBeVisible();
  119 | });
  120 | 
  121 | test('TC-UC04-02: checkout dengan keranjang kosong kembali ke keranjang', async ({ page }) => {
  122 |     await loginAs(page, customerEmail);
  123 |     await page.goto('/checkout');
  124 |     await expect(page).toHaveURL(/\/cart$/);
  125 | });
  126 | 
  127 | test('TC-UC05-01: pelanggan memberi ulasan pada pesanan selesai dan lunas', async ({ page }) => {
  128 |     await loginAs(page, customerEmail);
  129 |     await page.goto('/my-orders?status=review');
  130 |     await expect(page.getByText('Beri bintang').first()).toBeVisible();
  131 |     await page.locator('input[name="rating"][value="5"]').first().check({ force: true });
  132 |     await page.locator('textarea[name="review"]').first().fill('Pengalaman E2E sangat baik.');
  133 |     await page.getByRole('button', { name: 'Kirim Penilaian' }).first().click();
  134 |     await expect(page).toHaveURL(/\/my-orders\?status=review/);
  135 | });
  136 | 
```