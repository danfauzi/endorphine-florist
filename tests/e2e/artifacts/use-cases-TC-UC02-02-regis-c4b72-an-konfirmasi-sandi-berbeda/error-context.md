# Instructions

- Following Playwright test failed.
- Explain why, be concise, respect Playwright best practices.
- Provide a snippet of code with the fix, if possible.

# Test info

- Name: use-cases.spec.js >> TC-UC02-02: registrasi menolak email duplikat dan konfirmasi sandi berbeda
- Location: tests\e2e\use-cases.spec.js:60:1

# Error details

```
Error: expect(locator).toBeVisible() failed

Locator: locator('.text-rose-500').first()
Expected: visible
Timeout: 5000ms
Error: element(s) not found

Call log:
  - Expect "toBeVisible" locator('.text-rose-500').first() with timeout 5000ms
  - waiting for locator('.text-rose-500').first()

```

```yaml
- link "🌸 EndorphineFlorist":
  - /url: http://127.0.0.1:8010
- heading "Buat Akun Baru" [level=2]
- paragraph: Daftar untuk menikmati pemesanan buket yang lebih mudah
- paragraph: ⚠️ The email has already been taken.
- paragraph: ⚠️ The password field confirmation does not match.
- text: Nama Lengkap
- textbox "Nama Lengkap":
  - /placeholder: "Contoh: Budi Santoso"
  - text: Pendaftaran Invalid
- text: Alamat Email
- textbox "Alamat Email":
  - /placeholder: nama@email.com
  - text: pelanggan@gmail.com
- text: Nomor HP / WhatsApp
- textbox "Nomor HP / WhatsApp":
  - /placeholder: "081234567890"
  - text: "081234567899"
- text: Kata Sandi
- textbox "Kata Sandi":
  - /placeholder: ••••••••
- button "Tampilkan kata sandi"
- text: Konfirmasi Kata Sandi
- textbox "Konfirmasi Kata Sandi":
  - /placeholder: ••••••••
- button "Tampilkan konfirmasi kata sandi"
- button "Daftar Sekarang"
- paragraph:
  - text: Sudah punya akun?
  - link "Masuk di sini":
    - /url: http://127.0.0.1:8010/login
- link "Kembali ke Katalog Utama":
  - /url: http://127.0.0.1:8010
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
> 70  |     await expect(page.locator('.text-rose-500').first()).toBeVisible();
      |                                                          ^ Error: expect(locator).toBeVisible() failed
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
  158 |     await expect(page).toHaveURL(/\/login$/);
  159 | });
  160 | 
  161 | test('TC-UC07-01: admin membuat voucher dan rekening pembayaran', async ({ page }) => {
  162 |     await loginAs(page, adminEmail);
  163 |     await page.goto('/admin/vouchers');
  164 |     const voucherForm = page.locator('form[action="/admin/vouchers"]');
  165 |     await voucherForm.locator('input[name="code"]').fill('E2EHEMAT');
  166 |     await voucherForm.locator('select[name="type"]').selectOption('percent');
  167 |     await voucherForm.locator('input[name="discount_value"]').fill('10');
  168 |     await voucherForm.locator('input[name="min_order_price"]').fill('50000');
  169 |     await voucherForm.locator('input[name="quota"]').fill('5');
  170 |     await voucherForm.locator('input[name="expired_date"]').fill(
```