# Instructions

- Following Playwright test failed.
- Explain why, be concise, respect Playwright best practices.
- Provide a snippet of code with the fix, if possible.

# Test info

- Name: use-cases.spec.js >> TC-UC03-01: pelanggan menambah, mengubah, dan menghapus item keranjang
- Location: tests\e2e\use-cases.spec.js:73:1

# Error details

```
Test timeout of 30000ms exceeded.
```

```
Error: locator.click: Test timeout of 30000ms exceeded.
Call log:
  - waiting for locator('a[href^="/products/"]').filter({ hasText: 'Buket Mawar Soft Pink' }).first()

```

# Page snapshot

```yaml
- generic [active] [ref=f2e1]:
  - navigation [ref=f2e2]:
    - generic [ref=f2e3]:
      - link "🌸 EndorphineFlorist" [ref=f2e4] [cursor=pointer]:
        - /url: http://127.0.0.1:8010
        - generic [ref=f2e5]: 🌸
        - generic [ref=f2e6]: EndorphineFlorist
      - textbox "Cari buket mawar, snack, dll..." [ref=f2e9]
      - generic [ref=f2e10]:
        - link "🛒" [ref=f2e11] [cursor=pointer]:
          - /url: http://127.0.0.1:8010/cart
        - button "P Pelanggan Demo" [ref=f2e14] [cursor=pointer]:
          - generic [ref=f2e15]: P
          - generic [ref=f2e16]: Pelanggan Demo
  - generic [ref=f2e19]:
    - generic [ref=f2e20]:
      - group "3 / 5" [ref=f2e21]:
        - img "Buket Snack & Uang untuk Momen Wisuda" [ref=f2e23]
        - generic [ref=f2e26]:
          - generic [ref=f2e27]: 🎉 Special Gift & Graduation
          - heading "Buket Snack & Uang untuk Momen Wisuda" [level=1] [ref=f2e28]
          - paragraph [ref=f2e29]: Custom jumlah lembaran uang dan jajanan favorit dengan gratis kartu ucapan unik.
      - group "4 / 5" [ref=f2e30]:
        - img "Kado Manis untuk Orang Tersayang" [ref=f2e32]
        - generic [ref=f2e35]:
          - generic [ref=f2e36]: 🎁 Hadiah untuk Momen Spesial
          - heading "Kado Manis untuk Orang Tersayang" [level=1] [ref=f2e37]
          - paragraph [ref=f2e38]: Pilih hadiah yang dirangkai dengan penuh perhatian untuk setiap perayaan.
      - group "5 / 5" [ref=f2e39]:
        - img "Buket Wisuda yang Berkesan" [ref=f2e41]
        - generic [ref=f2e44]:
          - generic [ref=f2e45]: 🎓 Rayakan Pencapaianmu
          - heading "Buket Wisuda yang Berkesan" [level=1] [ref=f2e46]
          - paragraph [ref=f2e47]: Rayakan hari kelulusan dengan rangkaian buket yang dibuat khusus untuk momen bangga.
      - group "1 / 5" [ref=f2e48]:
        - img "Kirim Kebahagiaan Lewat Rangkaian Buket Estetik" [ref=f2e50]
        - generic [ref=f2e53]:
          - generic [ref=f2e54]: ✨ Handcrafted Bouquet with Love
          - heading "Kirim Kebahagiaan Lewat Rangkaian Buket Estetik" [level=1] [ref=f2e55]
          - paragraph [ref=f2e56]: Pilihan buket bunga murni, snack favorit, hingga buket uang eksklusif yang dirangkai khusus untuk momen terindah orang tersayangmu.
      - group "2 / 5" [ref=f2e57]:
        - img "Koleksi Buket Mawar Soft & Premium" [ref=f2e59]
        - generic [ref=f2e62]:
          - generic [ref=f2e63]: 💐 Bunga Segar Setiap Hari
          - heading "Koleksi Buket Mawar Soft & Premium" [level=1] [ref=f2e64]
          - paragraph [ref=f2e65]: Dipetik segar langsung dari kebun dan dirangkai oleh florist profesional untuk kesan yang tak terlupakan.
    - button "Next slide" [ref=f2e66] [cursor=pointer]: next
    - button "Previous slide" [ref=f2e67] [cursor=pointer]: prev
    - generic [ref=f2e68]:
      - button "Go to slide 1" [ref=f2e69] [cursor=pointer]
      - button "Go to slide 2" [ref=f2e70] [cursor=pointer]
      - button "Go to slide 3" [ref=f2e71] [cursor=pointer]
      - button "Go to slide 4" [ref=f2e72] [cursor=pointer]
      - button "Go to slide 5" [ref=f2e73] [cursor=pointer]
  - generic [ref=f2e75]:
    - generic [ref=f2e76]:
      - generic [ref=f2e77]: 🌸
      - generic [ref=f2e78]:
        - heading "Bunga Segar Berkualitas" [level=4] [ref=f2e79]
        - paragraph [ref=f2e80]: Rangkaian terbaik dengan bahan premium
    - generic [ref=f2e81]:
      - generic [ref=f2e82]: 💌
      - generic [ref=f2e83]:
        - heading "Gratis Kartu Ucapan" [level=4] [ref=f2e84]
        - paragraph [ref=f2e85]: Custom pesan manis sesuai permintaanmu
    - generic [ref=f2e86]:
      - generic [ref=f2e87]: 💳
      - generic [ref=f2e88]:
        - heading "Pembayaran Aman" [level=4] [ref=f2e89]
        - paragraph [ref=f2e90]: Cash, Transfer, dan QRIS tersedia
  - main [ref=f2e91]:
    - generic [ref=f2e92]:
      - generic [ref=f2e93]:
        - text: Katalog Buket
        - heading "Temukan Pilihan Favoritmu" [level=2] [ref=f2e94]
      - generic [ref=f2e95]:
        - button "Geser kategori ke kiri" [ref=f2e96] [cursor=pointer]: ←
        - generic [ref=f2e97]:
          - link "✨ Semua" [ref=f2e98] [cursor=pointer]:
            - /url: http://127.0.0.1:8010
            - text: ✨
            - generic [ref=f2e99]: Semua
          - link "💐 Bunga" [ref=f2e100] [cursor=pointer]:
            - /url: http://127.0.0.1:8010?category=Bunga
            - text: 💐
            - generic [ref=f2e101]: Bunga
          - link "🍫 Snack" [ref=f2e102] [cursor=pointer]:
            - /url: http://127.0.0.1:8010?category=Snack
            - text: 🍫
            - generic [ref=f2e103]: Snack
          - link "💸 Uang" [ref=f2e104] [cursor=pointer]:
            - /url: http://127.0.0.1:8010?category=Uang
            - text: 💸
            - generic [ref=f2e105]: Uang
          - link "🎁 Kado" [ref=f2e106] [cursor=pointer]:
            - /url: http://127.0.0.1:8010?category=Kado
            - text: 🎁
            - generic [ref=f2e107]: Kado
          - link "🎓 Wisuda" [ref=f2e108] [cursor=pointer]:
            - /url: http://127.0.0.1:8010?category=Wisuda
            - text: 🎓
            - generic [ref=f2e109]: Wisuda
        - button "Geser kategori ke kanan" [ref=f2e110] [cursor=pointer]: →
    - generic [ref=f2e111]:
      - generic [ref=f2e112]:
        - generic [ref=f2e113]:
          - link "Lihat detail produk Buket Mawar Red Classic" [ref=f2e114] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/5
            - generic [ref=f2e115]: No Photo Available
            - generic [ref=f2e117]: Bunga
            - generic [ref=f2e118]: Ready
            - generic [ref=f2e119]: Baru
          - heading "Buket Mawar Red Classic" [level=3] [ref=f2e121]
        - generic [ref=f2e122]:
          - generic [ref=f2e123]:
            - paragraph [ref=f2e124]: Harga
            - paragraph [ref=f2e125]: Rp 150.000
          - link "🔎 Detail Produk" [ref=f2e126] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/5
            - text: 🔎
            - generic [ref=f2e127]: Detail Produk
      - generic [ref=f2e128]:
        - generic [ref=f2e129]:
          - link "Lihat detail produk Buket Snack Choco Lovers" [ref=f2e130] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/6
            - generic [ref=f2e131]: No Photo Available
            - generic [ref=f2e133]: Snack
            - generic [ref=f2e134]: Ready
            - generic [ref=f2e135]: Baru
          - heading "Buket Snack Choco Lovers" [level=3] [ref=f2e137]
        - generic [ref=f2e138]:
          - generic [ref=f2e139]:
            - paragraph [ref=f2e140]: Harga
            - paragraph [ref=f2e141]: Rp 85.000
          - link "🔎 Detail Produk" [ref=f2e142] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/6
            - text: 🔎
            - generic [ref=f2e143]: Detail Produk
      - generic [ref=f2e144]:
        - generic [ref=f2e145]:
          - link "Lihat detail produk Buket Mawar Soft Pink" [ref=f2e146] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/1
            - img "Buket Mawar Soft Pink" [ref=f2e147]
            - generic [ref=f2e149]: Bunga
            - generic [ref=f2e150]: Ready
            - generic [ref=f2e151]: Baru
          - heading "Buket Mawar Soft Pink" [level=3] [ref=f2e153]
        - generic [ref=f2e154]:
          - generic [ref=f2e155]:
            - paragraph [ref=f2e156]: Harga
            - paragraph [ref=f2e157]: Rp 150.000
          - link "🔎 Detail Produk" [ref=f2e158] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/1
            - text: 🔎
            - generic [ref=f2e159]: Detail Produk
      - generic [ref=f2e160]:
        - generic [ref=f2e161]:
          - link "Lihat detail produk Buket Snack Chocolate Deluxe" [ref=f2e162] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/2
            - img "Buket Snack Chocolate Deluxe" [ref=f2e163]
            - generic [ref=f2e165]: Snack
            - generic [ref=f2e166]: Ready
            - generic [ref=f2e167]: Baru
          - heading "Buket Snack Chocolate Deluxe" [level=3] [ref=f2e169]
        - generic [ref=f2e170]:
          - generic [ref=f2e171]:
            - paragraph [ref=f2e172]: Harga
            - paragraph [ref=f2e173]: Rp 85.000
          - link "🔎 Detail Produk" [ref=f2e174] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/2
            - text: 🔎
            - generic [ref=f2e175]: Detail Produk
      - generic [ref=f2e176]:
        - generic [ref=f2e177]:
          - link "Lihat detail produk Buket Uang Pecahan 50rb" [ref=f2e178] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/3
            - img "Buket Uang Pecahan 50rb" [ref=f2e179]
            - generic [ref=f2e181]: Uang
            - generic [ref=f2e182]: Ready
            - generic [ref=f2e183]: Baru
          - heading "Buket Uang Pecahan 50rb" [level=3] [ref=f2e185]
        - generic [ref=f2e186]:
          - generic [ref=f2e187]:
            - paragraph [ref=f2e188]: Harga
            - paragraph [ref=f2e189]: Rp 250.000
          - link "🔎 Detail Produk" [ref=f2e190] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/3
            - text: 🔎
            - generic [ref=f2e191]: Detail Produk
      - generic [ref=f2e192]:
        - generic [ref=f2e193]:
          - link "Lihat detail produk Buket Tulip Gradasi Lavender" [ref=f2e194] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/4
            - img "Buket Tulip Gradasi Lavender" [ref=f2e195]
            - generic [ref=f2e197]: Bunga
            - generic [ref=f2e198]: Ready
            - generic [ref=f2e199]: Baru
          - heading "Buket Tulip Gradasi Lavender" [level=3] [ref=f2e201]
        - generic [ref=f2e202]:
          - generic [ref=f2e203]:
            - paragraph [ref=f2e204]: Harga
            - paragraph [ref=f2e205]: Rp 175.000
          - link "🔎 Detail Produk" [ref=f2e206] [cursor=pointer]:
            - /url: http://127.0.0.1:8010/products/4
            - text: 🔎
            - generic [ref=f2e207]: Detail Produk
  - contentinfo [ref=f2e208]:
    - generic [ref=f2e209]:
      - generic [ref=f2e210]:
        - generic [ref=f2e211]:
          - link "🌸 EndorphineFlorist" [ref=f2e212] [cursor=pointer]:
            - /url: http://127.0.0.1:8010
            - generic [ref=f2e213]: 🌸
            - generic [ref=f2e214]: EndorphineFlorist
          - paragraph [ref=f2e215]: Toko buket bunga, snack, dan uang terpercaya. Dirangkai estetik dengan penuh kasih sayang untuk merayakan setiap momen berharga bersama orang tersayang.
          - generic [ref=f2e216]:
            - paragraph [ref=f2e217]: Lokasi Toko
            - paragraph [ref=f2e218]: Jl. Cimanggir
        - generic [ref=f2e219]:
          - heading "Ulasan Pelanggan" [level=4] [ref=f2e220]
          - paragraph [ref=f2e223]: Belum ada ulasan pelanggan.
        - generic [ref=f2e224]:
          - heading "Toko Online / E-Commerce" [level=4] [ref=f2e225]
          - generic [ref=f2e227]:
            - link "🛍️ Shopee Official" [ref=f2e228] [cursor=pointer]:
              - /url: https://shopee.co.id
              - generic [ref=f2e229]: 🛍️
              - generic [ref=f2e230]: Shopee Official
            - link "🟢 Tokopedia Official" [ref=f2e231] [cursor=pointer]:
              - /url: https://tokopedia.com
              - generic [ref=f2e232]: 🟢
              - generic [ref=f2e233]: Tokopedia Official
        - generic [ref=f2e234]:
          - heading "Hubungi & Ikuti Kami" [level=4] [ref=f2e235]
          - paragraph [ref=f2e237]: Punya pertanyaan atau mau custom order khusus?
          - link "💬 WhatsApp CS (0812-3456-7890)" [ref=f2e238] [cursor=pointer]:
            - /url: https://wa.me/6281234567890
            - generic [ref=f2e239]: 💬
            - text: WhatsApp CS (0812-3456-7890)
          - generic [ref=f2e240]:
            - link "Instagram" [ref=f2e241] [cursor=pointer]:
              - /url: https://instagram.com
            - link "TikTok" [ref=f2e244] [cursor=pointer]:
              - /url: https://tiktok.com
            - link "Facebook" [ref=f2e247] [cursor=pointer]:
              - /url: https://facebook.com
      - generic [ref=f2e250]:
        - paragraph [ref=f2e251]: © 2026 Endorphine Florist. All rights reserved.
        - paragraph [ref=f2e252]: Designed with 💖 for special moments.
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
> 19  |     await page.locator('a[href^="/products/"]').filter({ hasText: 'Buket Mawar Soft Pink' }).first().click();
      |                                                                                                      ^ Error: locator.click: Test timeout of 30000ms exceeded.
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
```