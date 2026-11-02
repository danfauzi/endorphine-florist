# Instructions

- Following Playwright test failed.
- Explain why, be concise, respect Playwright best practices.
- Provide a snippet of code with the fix, if possible.

# Test info

- Name: use-cases.spec.js >> TC-UC02-01: pengunjung mendaftar dan langsung menggunakan akun pelanggan
- Location: tests\e2e\use-cases.spec.js:46:1

# Error details

```
Error: expect(locator).toBeVisible() failed

Locator: getByText('Pelanggan E2E')
Expected: visible
Error: strict mode violation: getByText('Pelanggan E2E') resolved to 2 elements:
    1) <span class="text-xs sm:text-sm font-bold text-slate-700">↵                                    Pelanggan E2…</span> aka getByRole('button', { name: 'P Pelanggan E2E' })
    2) <p class="mt-1 truncate text-sm font-extrabold text-slate-800">Pelanggan E2E</p> aka locator('p').filter({ hasText: 'Pelanggan E2E' })

Call log:
  - Expect "toBeVisible" getByText('Pelanggan E2E') with timeout 5000ms
  - waiting for getByText('Pelanggan E2E')

```

# Page snapshot

```yaml
- generic [active] [ref=f1e1]:
  - navigation [ref=f1e2]:
    - generic [ref=f1e3]:
      - link "🌸 EndorphineFlorist" [ref=f1e4] [cursor=pointer]:
        - /url: http://127.0.0.1:8010
        - generic [ref=f1e5]: 🌸
        - generic [ref=f1e6]: EndorphineFlorist
      - textbox "Cari buket mawar, snack, dll..." [ref=f1e9]
      - generic [ref=f1e10]:
        - link "🛒" [ref=f1e11] [cursor=pointer]:
          - /url: http://127.0.0.1:8010/cart
        - button "P Pelanggan E2E" [ref=f1e14] [cursor=pointer]:
          - generic [ref=f1e15]: P
          - generic [ref=f1e16]: Pelanggan E2E
  - generic [ref=f1e19]:
    - generic [ref=f1e20]:
      - group "1 / 5" [ref=f1e21]:
        - img "Kirim Kebahagiaan Lewat Rangkaian Buket Estetik" [ref=f1e23]
        - generic [ref=f1e26]:
          - generic [ref=f1e27]: ✨ Handcrafted Bouquet with Love
          - heading "Kirim Kebahagiaan Lewat Rangkaian Buket Estetik" [level=1] [ref=f1e28]
          - paragraph [ref=f1e29]: Pilihan buket bunga murni, snack favorit, hingga buket uang eksklusif yang dirangkai khusus untuk momen terindah orang tersayangmu.
      - group "2 / 5" [ref=f1e30]:
        - img "Koleksi Buket Mawar Soft & Premium" [ref=f1e32]
        - generic [ref=f1e35]:
          - generic [ref=f1e36]: 💐 Bunga Segar Setiap Hari
          - heading "Koleksi Buket Mawar Soft & Premium" [level=1] [ref=f1e37]
          - paragraph [ref=f1e38]: Dipetik segar langsung dari kebun dan dirangkai oleh florist profesional untuk kesan yang tak terlupakan.
      - group "3 / 5" [ref=f1e39]:
        - img "Buket Snack & Uang untuk Momen Wisuda" [ref=f1e41]
        - generic [ref=f1e44]:
          - generic [ref=f1e45]: 🎉 Special Gift & Graduation
          - heading "Buket Snack & Uang untuk Momen Wisuda" [level=1] [ref=f1e46]
          - paragraph [ref=f1e47]: Custom jumlah lembaran uang dan jajanan favorit dengan gratis kartu ucapan unik.
      - group "4 / 5" [ref=f1e48]:
        - img "Kado Manis untuk Orang Tersayang" [ref=f1e50]
        - generic [ref=f1e53]:
          - generic [ref=f1e54]: 🎁 Hadiah untuk Momen Spesial
          - heading "Kado Manis untuk Orang Tersayang" [level=1] [ref=f1e55]
          - paragraph [ref=f1e56]: Pilih hadiah yang dirangkai dengan penuh perhatian untuk setiap perayaan.
      - group "5 / 5" [ref=f1e57]:
        - img "Buket Wisuda yang Berkesan" [ref=f1e59]
        - generic [ref=f1e62]:
          - generic [ref=f1e63]: 🎓 Rayakan Pencapaianmu
          - heading "Buket Wisuda yang Berkesan" [level=1] [ref=f1e64]
          - paragraph [ref=f1e65]: Rayakan hari kelulusan dengan rangkaian buket yang dibuat khusus untuk momen bangga.
    - button "Next slide" [ref=f1e66] [cursor=pointer]: next
    - button "Previous slide" [ref=f1e67] [cursor=pointer]: prev
    - generic [ref=f1e68]:
      - button "Go to slide 1" [ref=f1e69] [cursor=pointer]
      - button "Go to slide 2" [ref=f1e70] [cursor=pointer]
      - button "Go to slide 3" [ref=f1e71] [cursor=pointer]
      - button "Go to slide 4" [ref=f1e72] [cursor=pointer]
      - button "Go to slide 5" [ref=f1e73] [cursor=pointer]
  - generic [ref=f1e75]:
    - generic [ref=f1e76]:
      - generic [ref=f1e77]: 🌸
      - generic [ref=f1e78]:
        - heading "Bunga Segar Berkualitas" [level=4] [ref=f1e79]
        - paragraph [ref=f1e80]: Rangkaian terbaik dengan bahan premium
    - generic [ref=f1e81]:
      - generic [ref=f1e82]: 💌
      - generic [ref=f1e83]:
        - heading "Gratis Kartu Ucapan" [level=4] [ref=f1e84]
        - paragraph [ref=f1e85]: Custom pesan manis sesuai permintaanmu
    - generic [ref=f1e86]:
      - generic [ref=f1e87]: 💳
      - generic [ref=f1e88]:
        - heading "Pembayaran Aman" [level=4] [ref=f1e89]
        - paragraph [ref=f1e90]: Cash, Transfer, dan QRIS tersedia
  - main [ref=f1e91]:
    - generic [ref=f1e92]:
      - generic [ref=f1e93]:
        - text: Katalog Buket
        - heading "Temukan Pilihan Favoritmu" [level=2] [ref=f1e94]
      - generic [ref=f1e95]:
        - button "Geser kategori ke kiri" [ref=f1e96] [cursor=pointer]: ←
        - generic [ref=f1e97]:
          - link "✨ Semua" [ref=f1e98] [cursor=pointer]:
            - /url: http://127.0.0.1:8010
            - text: ✨
            - generic [ref=f1e99]: Semua
          - link "💐 Bunga" [ref=f1e100] [cursor=pointer]:
            - /url: http://127.0.0.1:8010?category=Bunga
            - text: 💐
            - generic [ref=f1e101]: Bunga
          - link "🍫 Snack" [ref=f1e102] [cursor=pointer]:
            - /url: http://127.0.0.1:8010?category=Snack
            - text: 🍫
            - generic [ref=f1e103]: Snack
          - link "💸 Uang" [ref=f1e104] [cursor=pointer]:
            - /url: http://127.0.0.1:8010?category=Uang
            - text: 💸
            - generic [ref=f1e105]: Uang
          - link "🎁 Kado" [ref=f1e106] [cursor=pointer]:
            - /url: http://127.0.0.1:8010?category=Kado
            - text: 🎁
            - generic [ref=f1e107]: Kado
          - link "🎓 Wisuda" [ref=f1e108] [cursor=pointer]:
            - /url: http://127.0.0.1:8010?category=Wisuda
            - text: 🎓
            - generic [ref=f1e109]: Wisuda
        - button "Geser kategori ke kanan" [ref=f1e110] [cursor=pointer]: →
    - generic [ref=f1e111]:
      - generic [ref=f1e112]:
        - generic [ref=f1e113]:
          - link "Lihat detail produk Buket Mawar Red Classic" [ref=f1e114] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/5
            - generic [ref=f1e115]: No Photo Available
            - generic [ref=f1e117]: Bunga
            - generic [ref=f1e118]: Ready
            - generic [ref=f1e119]: Baru
          - heading "Buket Mawar Red Classic" [level=3] [ref=f1e121]
        - generic [ref=f1e122]:
          - generic [ref=f1e123]:
            - paragraph [ref=f1e124]: Harga
            - paragraph [ref=f1e125]: Rp 150.000
          - link "🔎 Detail Produk" [ref=f1e126] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/5
            - text: 🔎
            - generic [ref=f1e127]: Detail Produk
      - generic [ref=f1e128]:
        - generic [ref=f1e129]:
          - link "Lihat detail produk Buket Snack Choco Lovers" [ref=f1e130] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/6
            - generic [ref=f1e131]: No Photo Available
            - generic [ref=f1e133]: Snack
            - generic [ref=f1e134]: Ready
            - generic [ref=f1e135]: Baru
          - heading "Buket Snack Choco Lovers" [level=3] [ref=f1e137]
        - generic [ref=f1e138]:
          - generic [ref=f1e139]:
            - paragraph [ref=f1e140]: Harga
            - paragraph [ref=f1e141]: Rp 85.000
          - link "🔎 Detail Produk" [ref=f1e142] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/6
            - text: 🔎
            - generic [ref=f1e143]: Detail Produk
      - generic [ref=f1e144]:
        - generic [ref=f1e145]:
          - link "Lihat detail produk Buket Mawar Soft Pink" [ref=f1e146] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/1
            - img "Buket Mawar Soft Pink" [ref=f1e147]
            - generic [ref=f1e149]: Bunga
            - generic [ref=f1e150]: Ready
            - generic [ref=f1e151]: Baru
          - heading "Buket Mawar Soft Pink" [level=3] [ref=f1e153]
        - generic [ref=f1e154]:
          - generic [ref=f1e155]:
            - paragraph [ref=f1e156]: Harga
            - paragraph [ref=f1e157]: Rp 150.000
          - link "🔎 Detail Produk" [ref=f1e158] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/1
            - text: 🔎
            - generic [ref=f1e159]: Detail Produk
      - generic [ref=f1e160]:
        - generic [ref=f1e161]:
          - link "Lihat detail produk Buket Snack Chocolate Deluxe" [ref=f1e162] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/2
            - img "Buket Snack Chocolate Deluxe" [ref=f1e163]
            - generic [ref=f1e165]: Snack
            - generic [ref=f1e166]: Ready
            - generic [ref=f1e167]: Baru
          - heading "Buket Snack Chocolate Deluxe" [level=3] [ref=f1e169]
        - generic [ref=f1e170]:
          - generic [ref=f1e171]:
            - paragraph [ref=f1e172]: Harga
            - paragraph [ref=f1e173]: Rp 85.000
          - link "🔎 Detail Produk" [ref=f1e174] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/2
            - text: 🔎
            - generic [ref=f1e175]: Detail Produk
      - generic [ref=f1e176]:
        - generic [ref=f1e177]:
          - link "Lihat detail produk Buket Uang Pecahan 50rb" [ref=f1e178] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/3
            - img "Buket Uang Pecahan 50rb" [ref=f1e179]
            - generic [ref=f1e181]: Uang
            - generic [ref=f1e182]: Ready
            - generic [ref=f1e183]: Baru
          - heading "Buket Uang Pecahan 50rb" [level=3] [ref=f1e185]
        - generic [ref=f1e186]:
          - generic [ref=f1e187]:
            - paragraph [ref=f1e188]: Harga
            - paragraph [ref=f1e189]: Rp 250.000
          - link "🔎 Detail Produk" [ref=f1e190] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/3
            - text: 🔎
            - generic [ref=f1e191]: Detail Produk
      - generic [ref=f1e192]:
        - generic [ref=f1e193]:
          - link "Lihat detail produk Buket Tulip Gradasi Lavender" [ref=f1e194] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/4
            - img "Buket Tulip Gradasi Lavender" [ref=f1e195]
            - generic [ref=f1e197]: Bunga
            - generic [ref=f1e198]: Ready
            - generic [ref=f1e199]: Baru
          - heading "Buket Tulip Gradasi Lavender" [level=3] [ref=f1e201]
        - generic [ref=f1e202]:
          - generic [ref=f1e203]:
            - paragraph [ref=f1e204]: Harga
            - paragraph [ref=f1e205]: Rp 175.000
          - link "🔎 Detail Produk" [ref=f1e206] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/4
            - text: 🔎
            - generic [ref=f1e207]: Detail Produk
  - contentinfo [ref=f1e208]:
    - generic [ref=f1e209]:
      - generic [ref=f1e210]:
        - generic [ref=f1e211]:
          - link "🌸 EndorphineFlorist" [ref=f1e212] [cursor=pointer]:
            - /url: http://127.0.0.1:8010
            - generic [ref=f1e213]: 🌸
            - generic [ref=f1e214]: EndorphineFlorist
          - paragraph [ref=f1e215]: Toko buket bunga, snack, dan uang terpercaya. Dirangkai estetik dengan penuh kasih sayang untuk merayakan setiap momen berharga bersama orang tersayang.
          - generic [ref=f1e216]:
            - paragraph [ref=f1e217]: Lokasi Toko
            - paragraph [ref=f1e218]: Jl. Cimanggir
        - generic [ref=f1e219]:
          - heading "Ulasan Pelanggan" [level=4] [ref=f1e220]
          - paragraph [ref=f1e223]: Belum ada ulasan pelanggan.
        - generic [ref=f1e224]:
          - heading "Toko Online / E-Commerce" [level=4] [ref=f1e225]
          - generic [ref=f1e227]:
            - link "🛍️ Shopee Official" [ref=f1e228] [cursor=pointer]:
              - /url: https://shopee.co.id
              - generic [ref=f1e229]: 🛍️
              - generic [ref=f1e230]: Shopee Official
            - link "🟢 Tokopedia Official" [ref=f1e231] [cursor=pointer]:
              - /url: https://tokopedia.com
              - generic [ref=f1e232]: 🟢
              - generic [ref=f1e233]: Tokopedia Official
        - generic [ref=f1e234]:
          - heading "Hubungi & Ikuti Kami" [level=4] [ref=f1e235]
          - paragraph [ref=f1e237]: Punya pertanyaan atau mau custom order khusus?
          - link "💬 WhatsApp CS (0812-3456-7890)" [ref=f1e238] [cursor=pointer]:
            - /url: https://wa.me/6281234567890
            - generic [ref=f1e239]: 💬
            - text: WhatsApp CS (0812-3456-7890)
          - generic [ref=f1e240]:
            - link "Instagram" [ref=f1e241] [cursor=pointer]:
              - /url: https://instagram.com
            - link "TikTok" [ref=f1e244] [cursor=pointer]:
              - /url: https://tiktok.com
            - link "Facebook" [ref=f1e247] [cursor=pointer]:
              - /url: https://facebook.com
      - generic [ref=f1e250]:
        - paragraph [ref=f1e251]: © 2026 Endorphine Florist. All rights reserved.
        - paragraph [ref=f1e252]: Designed with 💖 for special moments.
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
  36  |     await expect(page.locator('a[href^="/products/"]')).toHaveCount(6);
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
> 57  |     await expect(page.getByText('Pelanggan E2E')).toBeVisible();
      |                                                   ^ Error: expect(locator).toBeVisible() failed
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
  137 | test('TC-UC06-01: admin menambah produk dan memperbarui banner', async ({ page }) => {
  138 |     await loginAs(page, adminEmail);
  139 |     await page.goto('/admin/products');
  140 |     const productForm = page.locator('form[action="/products"]');
  141 |     await productForm.locator('input[name="name"]').fill('Buket Admin E2E');
  142 |     await productForm.locator('select[name="category"]').selectOption('bunga');
  143 |     await productForm.locator('input[name="price"]').fill('125000');
  144 |     await productForm.locator('input[name="stock"]').fill('4');
  145 |     await productForm.locator('textarea[name="description"]').fill('Produk hasil pengujian browser.');
  146 |     await productForm.getByRole('button', { name: 'Tambah ke Katalog' }).click();
  147 |     await expect(page.getByText('Buket Admin E2E')).toBeVisible();
  148 | 
  149 |     await page.goto('/admin/hero-slides');
  150 |     const slideForm = page.locator('form[action^="/admin/hero-slides/"]').first();
  151 |     await slideForm.locator('input[name="title"]').fill('Banner Uji E2E');
  152 |     await slideForm.getByRole('button', { name: /Simpan Slide/ }).click();
  153 |     await expect(page.getByText('Banner Uji E2E')).toBeVisible();
  154 | });
  155 | 
  156 | test('TC-UC06-02: pengunjung tanpa login tidak dapat membuka administrasi produk', async ({ page }) => {
  157 |     await page.goto('/admin/products');
```