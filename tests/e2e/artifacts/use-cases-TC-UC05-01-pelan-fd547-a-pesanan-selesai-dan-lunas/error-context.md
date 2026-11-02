# Instructions

- Following Playwright test failed.
- Explain why, be concise, respect Playwright best practices.
- Provide a snippet of code with the fix, if possible.

# Test info

- Name: use-cases.spec.js >> TC-UC05-01: pelanggan memberi ulasan pada pesanan selesai dan lunas
- Location: tests\e2e\use-cases.spec.js:127:1

# Error details

```
Error: locator.check: Clicking the checkbox did not change its state
Call log:
  - waiting for locator('input[name="rating"][value="5"]').first()
    - locator resolved to <input value="5" required="" type="radio" name="rating" id="rating-2-5" class="rating-input sr-only"/>
  - attempting click action
    - scrolling into view if needed
    - done scrolling
    - forcing action
    - performing click action
    - click action done
    - waiting for scheduled navigations to finish
    - navigations have finished

```

# Page snapshot

```yaml
- generic [active] [ref=f2e1]:
  - navigation [ref=f2e2]:
    - generic [ref=f2e3]:
      - link "🌸 Endorphine Florist" [ref=f2e4] [cursor=pointer]:
        - /url: http://127.0.0.1:8010
        - generic [ref=f2e5]: 🌸
        - text: Endorphine
        - generic [ref=f2e6]: Florist
      - link "Kembali ke Beranda" [ref=f2e7] [cursor=pointer]:
        - /url: http://127.0.0.1:8010
  - main [ref=f2e11]:
    - generic [ref=f2e12]:
      - text: PENILAIAN PESANAN
      - heading "Penilaian" [level=1] [ref=f2e13]
      - paragraph [ref=f2e14]: Berikan penilaian untuk pesanan yang sudah selesai.
    - article [ref=f2e15]:
      - generic [ref=f2e16]:
        - generic [ref=f2e17]:
          - generic [ref=f2e18]:
            - generic [ref=f2e19]:
              - paragraph [ref=f2e20]: "#E2E-REVIEW-Z2OEYKVL"
              - paragraph [ref=f2e21]: 02 Nov 2026 - 13:30 WIB
            - generic [ref=f2e22]: paid
          - generic [ref=f2e24]:
            - img "Buket Mawar Soft Pink" [ref=f2e25]
            - paragraph [ref=f2e26]: 1x Buket Mawar Soft Pink
          - generic [ref=f2e28]:
            - paragraph [ref=f2e29]: Metode QRIS
            - paragraph [ref=f2e30]: Rp 150.000
        - generic [ref=f2e31]:
          - generic [ref=f2e32]:
            - generic [ref=f2e33]: Beri bintang
            - generic "Pilih rating 1 sampai 5" [ref=f2e34]:
              - radio "★" [ref=f2e35]
              - generic [ref=f2e36] [cursor=pointer]: ★
              - radio "★" [ref=f2e37]
              - generic [ref=f2e38] [cursor=pointer]: ★
              - radio "★" [ref=f2e39]
              - generic [ref=f2e40] [cursor=pointer]: ★
              - radio "★" [ref=f2e41]
              - generic [ref=f2e42] [cursor=pointer]: ★
              - radio "★" [ref=f2e43]
              - generic [ref=f2e44] [cursor=pointer]: ★
          - textbox "Tulis deskripsi pengalamanmu..." [ref=f2e45]
          - button "Kirim Penilaian" [ref=f2e46] [cursor=pointer]
```

# Test source

```ts
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
> 131 |     await page.locator('input[name="rating"][value="5"]').first().check({ force: true });
      |                                                                   ^ Error: locator.check: Clicking the checkbox did not change its state
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
  171 |         new Date(Date.now() + 7 * 86400000).toISOString().slice(0, 10),
  172 |     );
  173 |     await voucherForm.getByRole('button', { name: 'Simpan Voucher' }).click();
  174 |     await expect(page.getByText('E2EHEMAT')).toBeVisible();
  175 | 
  176 |     await page.goto('/admin/bank-accounts');
  177 |     const accountForm = page.locator('form[action="/admin/bank-accounts"]');
  178 |     await accountForm.locator('input[name="bank_name"]').fill('Mandiri E2E');
  179 |     await accountForm.locator('input[name="account_number"]').fill('9988776655');
  180 |     await accountForm.locator('input[name="account_holder"]').fill('Endorphine Florist');
  181 |     await accountForm.getByRole('button', { name: 'Simpan Rekening' }).click();
  182 |     await expect(page.getByText('Mandiri E2E')).toBeVisible();
  183 | });
  184 | 
  185 | test('TC-UC07-02: owner tidak berhak mengelola voucher atau rekening', async ({ page }) => {
  186 |     await loginAs(page, ownerEmail);
  187 |     const voucherResponse = await page.goto('/admin/vouchers');
  188 |     expect(voucherResponse.status()).toBe(403);
  189 |     const bankResponse = await page.goto('/admin/bank-accounts');
  190 |     expect(bankResponse.status()).toBe(403);
  191 | });
  192 | 
  193 | test('TC-UC08-01: admin membuat akun kasir dan email yang sama ditolak', async ({ page }) => {
  194 |     await loginAs(page, adminEmail);
  195 |     const email = `staff-${Date.now()}@example.test`;
  196 |     await page.goto('/admin/users/create');
  197 |     const staffForm = page.locator('form[action="/admin/users"]');
  198 | 
  199 |     await staffForm.locator('input[name="name"]').fill('Kasir E2E');
  200 |     await staffForm.locator('input[name="email"]').fill(email);
  201 |     await staffForm.locator('select[name="role"]').selectOption('kasir');
  202 |     await staffForm.locator('input[name="password"]').fill('ValidPass123!');
  203 |     await staffForm.locator('input[name="password_confirmation"]').fill('ValidPass123!');
  204 |     await staffForm.getByRole('button', { name: 'Simpan Staf Baru' }).click();
  205 |     await expect(page.getByText(email)).toBeVisible();
  206 | 
  207 |     await page.goto('/admin/users/create');
  208 |     await page.locator('input[name="name"]').fill('Duplikat');
  209 |     await page.locator('input[name="email"]').fill(email);
  210 |     await page.locator('select[name="role"]').selectOption('admin');
  211 |     await page.locator('input[name="password"]').fill('ValidPass123!');
  212 |     await page.locator('input[name="password_confirmation"]').fill('ValidPass123!');
  213 |     await page.getByRole('button', { name: 'Simpan Staf Baru' }).click();
  214 |     await expect(page).toHaveURL(/\/admin\/users\/create$/);
  215 |     await expect(page.locator('.text-rose-500').first()).toBeVisible();
  216 | });
  217 | 
  218 | test('TC-UC09-01: kasir menyelesaikan pesanan dari antrean dan akses role lain ditolak', async ({ page }) => {
  219 |     await loginAs(page, cashierEmail);
  220 |     await page.goto('/kasir/orders');
  221 |     const statusSelect = page.locator('form[action$="/status"] select[name="status"]').first();
  222 |     await statusSelect.selectOption('completed');
  223 |     await expect(page.locator('select[name="status"]').first()).toHaveValue('completed');
  224 | 
  225 |     const adminOrdersResponse = await page.goto('/admin/orders');
  226 |     expect(adminOrdersResponse.status()).toBe(403);
  227 | });
  228 | 
  229 | test('TC-UC10-01: kasir menyimpan transaksi POS sebagai tunai', async ({ page }) => {
  230 |     await loginAs(page, cashierEmail);
  231 |     await page.goto('/kasir/pos');
```