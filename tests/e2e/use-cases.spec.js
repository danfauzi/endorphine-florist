import { expect, test } from '@playwright/test';

const customerEmail = 'pelanggan@gmail.com';
const cashierEmail = 'kasir@endorphine.com';
const adminEmail = 'admin@endorphine.com';
const ownerEmail = 'owner@endorphine.com';
const demoPassword = 'password';

async function loginAs(page, email) {
    await page.goto('/login');
    await page.locator('#email').fill(email);
    await page.locator('#password').fill(demoPassword);
    await page.getByRole('button', { name: 'Masuk Sekarang' }).click();
    await expect(page).not.toHaveURL(/\/login$/);
}

async function addSeedProductToCart(page) {
    await page.goto('/');
    await page.locator('a[href^="/products/"]').filter({ hasText: 'Buket Mawar Soft Pink' }).first().click();
    await page.getByRole('button', { name: /Tambahkan ke Keranjang/ }).click();
    await page.goto('/cart');
    await expect(page.getByText('Buket Mawar Soft Pink')).toBeVisible();
}

test.afterEach(async ({ page }, testInfo) => {
    const screenshotPath = testInfo.outputPath('execution.png');
    await page.screenshot({ path: screenshotPath, fullPage: true });
    await testInfo.attach('execution-screenshot', {
        path: screenshotPath,
        contentType: 'image/png',
    });
});

test('TC-UC01-01: pengunjung mencari, memfilter, dan membuka katalog produk', async ({ page }) => {
    await page.goto('/');
    await expect(page.locator('a[href^="/products/"]')).toHaveCount(6);
    await page.locator('input[name="search"]').fill('Buket Mawar Soft Pink');
    await page.locator('input[name="search"]').press('Enter');
    await expect(page.getByText('Buket Mawar Soft Pink')).toBeVisible();
    await expect(page.getByText('Buket Snack Chocolate Deluxe')).toHaveCount(0);

    await page.goto('/?search=not-a-real-bouquet');
    await expect(page.locator('a[href^="/products/"]')).toHaveCount(0);
});

test('TC-UC02-01: pengunjung mendaftar dan langsung menggunakan akun pelanggan', async ({ page }) => {
    const email = `e2e-${Date.now()}@example.test`;
    await page.goto('/register');
    await page.locator('#name').fill('Pelanggan E2E');
    await page.locator('#email').fill(email);
    await page.locator('#phone').fill('081234567899');
    await page.locator('#password').fill('ValidPass123!');
    await page.locator('#password_confirmation').fill('ValidPass123!');
    await page.getByRole('button', { name: 'Daftar Sekarang' }).click();

    await expect(page).toHaveURL('/');
    await expect(page.getByText('Pelanggan E2E')).toBeVisible();
});

test('TC-UC02-02: registrasi menolak email duplikat dan konfirmasi sandi berbeda', async ({ page }) => {
    await page.goto('/register');
    await page.locator('#name').fill('Pendaftaran Invalid');
    await page.locator('#email').fill(customerEmail);
    await page.locator('#phone').fill('081234567899');
    await page.locator('#password').fill('ValidPass123!');
    await page.locator('#password_confirmation').fill('DifferentPass123!');
    await page.getByRole('button', { name: 'Daftar Sekarang' }).click();

    await expect(page).toHaveURL(/\/register$/);
    await expect(page.locator('.text-rose-500').first()).toBeVisible();
});

test('TC-UC03-01: pelanggan menambah, mengubah, dan menghapus item keranjang', async ({ page }) => {
    await loginAs(page, customerEmail);
    await addSeedProductToCart(page);

    await page.getByRole('button', { name: 'Tambah jumlah' }).click();
    await expect(page.getByText('2x', { exact: false }).first()).toBeVisible();

    const noteInput = page.locator('input[name="note"]');
    await noteInput.fill('Pita warna pink');
    await noteInput.press('Tab');
    await expect(noteInput).toHaveValue('Pita warna pink');

    page.once('dialog', dialog => dialog.accept());
    await page.locator('form[action^="/cart/"]').last().getByRole('button').click();
    await expect(page.getByText('Keranjang belanja masih kosong.')).toBeVisible();
});

test('TC-UC03-02: akses keranjang tanpa login diarahkan ke autentikasi', async ({ page }) => {
    await page.goto('/cart');
    await expect(page).toHaveURL(/\/login$/);
});

test('TC-UC04-01: pelanggan checkout, menerima total, lalu mengunggah bukti pembayaran', async ({ page }) => {
    await loginAs(page, customerEmail);
    await addSeedProductToCart(page);
    await page.goto('/checkout');

    await page.locator('#shipping_address').fill('Jl. Mawar E2E No. 5');
    await page.locator('#recipient_phone').fill('081234567899');
    await page.locator('#radio-qris').check();
    await page.locator('form[action="/checkout"] button[type="submit"]').click();

    await expect(page).toHaveURL(/\/orders\/success\/\d+$/);
    await expect(page.getByText('Upload Bukti Pembayaran')).toBeVisible();

    const png = Buffer.from(
        'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAADUlEQVR4nGP4z8AAAAMBAQDJ/pLvAAAAAElFTkSuQmCC',
        'base64',
    );
    await page.locator('input[name="payment_proof"]').setInputFiles({
        name: 'payment-proof.png',
        mimeType: 'image/png',
        buffer: png,
    });
    await page.getByRole('button', { name: 'Kirim Bukti Pembayaran' }).click();
    await expect(page.getByText(/Menunggu Verifikasi Kasir/)).toBeVisible();
});

test('TC-UC04-02: checkout dengan keranjang kosong kembali ke keranjang', async ({ page }) => {
    await loginAs(page, customerEmail);
    await page.goto('/checkout');
    await expect(page).toHaveURL(/\/cart$/);
});

test('TC-UC05-01: pelanggan memberi ulasan pada pesanan selesai dan lunas', async ({ page }) => {
    await loginAs(page, customerEmail);
    await page.goto('/my-orders?status=review');
    await expect(page.getByText('Beri bintang').first()).toBeVisible();
    await page.locator('input[name="rating"][value="5"]').first().check({ force: true });
    await page.locator('textarea[name="review"]').first().fill('Pengalaman E2E sangat baik.');
    await page.getByRole('button', { name: 'Kirim Penilaian' }).first().click();
    await expect(page).toHaveURL(/\/my-orders\?status=review/);
});

test('TC-UC06-01: admin menambah produk dan memperbarui banner', async ({ page }) => {
    await loginAs(page, adminEmail);
    await page.goto('/admin/products');
    const productForm = page.locator('form[action="/products"]');
    await productForm.locator('input[name="name"]').fill('Buket Admin E2E');
    await productForm.locator('select[name="category"]').selectOption('bunga');
    await productForm.locator('input[name="price"]').fill('125000');
    await productForm.locator('input[name="stock"]').fill('4');
    await productForm.locator('textarea[name="description"]').fill('Produk hasil pengujian browser.');
    await productForm.getByRole('button', { name: 'Tambah ke Katalog' }).click();
    await expect(page.getByText('Buket Admin E2E')).toBeVisible();

    await page.goto('/admin/hero-slides');
    const slideForm = page.locator('form[action^="/admin/hero-slides/"]').first();
    await slideForm.locator('input[name="title"]').fill('Banner Uji E2E');
    await slideForm.getByRole('button', { name: /Simpan Slide/ }).click();
    await expect(page.getByText('Banner Uji E2E')).toBeVisible();
});

test('TC-UC06-02: pengunjung tanpa login tidak dapat membuka administrasi produk', async ({ page }) => {
    await page.goto('/admin/products');
    await expect(page).toHaveURL(/\/login$/);
});

test('TC-UC07-01: admin membuat voucher dan rekening pembayaran', async ({ page }) => {
    await loginAs(page, adminEmail);
    await page.goto('/admin/vouchers');
    const voucherForm = page.locator('form[action="/admin/vouchers"]');
    await voucherForm.locator('input[name="code"]').fill('E2EHEMAT');
    await voucherForm.locator('select[name="type"]').selectOption('percent');
    await voucherForm.locator('input[name="discount_value"]').fill('10');
    await voucherForm.locator('input[name="min_order_price"]').fill('50000');
    await voucherForm.locator('input[name="quota"]').fill('5');
    await voucherForm.locator('input[name="expired_date"]').fill(
        new Date(Date.now() + 7 * 86400000).toISOString().slice(0, 10),
    );
    await voucherForm.getByRole('button', { name: 'Simpan Voucher' }).click();
    await expect(page.getByText('E2EHEMAT')).toBeVisible();

    await page.goto('/admin/bank-accounts');
    const accountForm = page.locator('form[action="/admin/bank-accounts"]');
    await accountForm.locator('input[name="bank_name"]').fill('Mandiri E2E');
    await accountForm.locator('input[name="account_number"]').fill('9988776655');
    await accountForm.locator('input[name="account_holder"]').fill('Endorphine Florist');
    await accountForm.getByRole('button', { name: 'Simpan Rekening' }).click();
    await expect(page.getByText('Mandiri E2E')).toBeVisible();
});

test('TC-UC07-02: owner tidak berhak mengelola voucher atau rekening', async ({ page }) => {
    await loginAs(page, ownerEmail);
    const voucherResponse = await page.goto('/admin/vouchers');
    expect(voucherResponse.status()).toBe(403);
    const bankResponse = await page.goto('/admin/bank-accounts');
    expect(bankResponse.status()).toBe(403);
});

test('TC-UC08-01: admin membuat akun kasir dan email yang sama ditolak', async ({ page }) => {
    await loginAs(page, adminEmail);
    const email = `staff-${Date.now()}@example.test`;
    await page.goto('/admin/users/create');
    const staffForm = page.locator('form[action="/admin/users"]');

    await staffForm.locator('input[name="name"]').fill('Kasir E2E');
    await staffForm.locator('input[name="email"]').fill(email);
    await staffForm.locator('select[name="role"]').selectOption('kasir');
    await staffForm.locator('input[name="password"]').fill('ValidPass123!');
    await staffForm.locator('input[name="password_confirmation"]').fill('ValidPass123!');
    await staffForm.getByRole('button', { name: 'Simpan Staf Baru' }).click();
    await expect(page.getByText(email)).toBeVisible();

    await page.goto('/admin/users/create');
    await page.locator('input[name="name"]').fill('Duplikat');
    await page.locator('input[name="email"]').fill(email);
    await page.locator('select[name="role"]').selectOption('admin');
    await page.locator('input[name="password"]').fill('ValidPass123!');
    await page.locator('input[name="password_confirmation"]').fill('ValidPass123!');
    await page.getByRole('button', { name: 'Simpan Staf Baru' }).click();
    await expect(page).toHaveURL(/\/admin\/users\/create$/);
    await expect(page.locator('.text-rose-500').first()).toBeVisible();
});

test('TC-UC09-01: kasir menyelesaikan pesanan dari antrean dan akses role lain ditolak', async ({ page }) => {
    await loginAs(page, cashierEmail);
    await page.goto('/kasir/orders');
    const statusSelect = page.locator('form[action$="/status"] select[name="status"]').first();
    await statusSelect.selectOption('completed');
    await expect(page.locator('select[name="status"]').first()).toHaveValue('completed');

    const adminOrdersResponse = await page.goto('/admin/orders');
    expect(adminOrdersResponse.status()).toBe(403);
});

test('TC-UC10-01: kasir menyimpan transaksi POS sebagai tunai', async ({ page }) => {
    await loginAs(page, cashierEmail);
    await page.goto('/kasir/pos');
    await page.getByPlaceholder('Cari nama buket / bunga...').fill('Buket Mawar Soft Pink');
    await page.getByRole('button', { name: '+ Tambah' }).click();
    await page.getByRole('button', { name: /Simpan Pembayaran & Cetak Struk/ }).click();
    await expect(page).toHaveURL(/\/kasir\/orders$/);
    await expect(page.getByText('Pelanggan Walk-in')).toBeVisible();
});

test('TC-UC10-02: POS kosong menolak pembayaran dan menampilkan peringatan', async ({ page }) => {
    await loginAs(page, cashierEmail);
    await page.goto('/kasir/pos');
    page.once('dialog', async dialog => {
        expect(dialog.message()).toContain('Keranjang pesanan masih kosong');
        await dialog.accept();
    });
    await page.getByRole('button', { name: /Simpan Pembayaran & Cetak Struk/ }).click();
    await expect(page).toHaveURL(/\/kasir\/pos$/);
});

test('TC-UC11-01: kasir menyimpan rekap shift dan perhitungan kas', async ({ page }) => {
    await loginAs(page, cashierEmail);
    await page.goto('/kasir/recap');
    await page.locator('form[action="/kasir/recap"] input[name="physical_cash"]').fill('300000');
    await page.locator('form[action="/kasir/recap"] button[type="submit"]').click();
    await expect(page.getByText('Penutupan shift kasir berhasil disimpan!')).toBeVisible();
});

test('TC-UC12-01: owner memfilter laporan dan mengunduh PDF serta Excel', async ({ page }) => {
    await loginAs(page, ownerEmail);
    await page.goto('/owner/reports');
    await page.locator('input[name="start_date"]').fill(new Date().toISOString().slice(0, 8) + '01');
    await page.locator('input[name="end_date"]').fill(new Date().toISOString().slice(0, 10));
    await page.getByRole('button', { name: 'Filter Laporan' }).click();
    await expect(page.getByText('Laporan Omset & Keuangan Toko')).toBeVisible();

    await page.goto('/owner/dashboard');
    const pdfForm = page.locator('form[action="/owner/export-pdf"]');
    const [pdfDownload] = await Promise.all([
        page.waitForEvent('download'),
        pdfForm.getByRole('button', { name: /Unduh Berkas/ }).click(),
    ]);
    expect(pdfDownload.suggestedFilename()).toMatch(/\.pdf$/);

    const excelForm = page.locator('form[action="/owner/export-excel"]');
    const [excelDownload] = await Promise.all([
        page.waitForEvent('download'),
        excelForm.getByRole('button', { name: /Unduh Spreadsheet/ }).click(),
    ]);
    expect(excelDownload.suggestedFilename()).toMatch(/\.xlsx$/);
});

test('TC-UC12-02: kasir tidak dapat membuka laporan owner', async ({ page }) => {
    await loginAs(page, cashierEmail);
    const response = await page.goto('/owner/reports');
    expect(response.status()).toBe(403);
});
