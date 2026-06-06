# Mini E-Wallet

Mini E-Wallet adalah aplikasi web sederhana berbasis Laravel yang memungkinkan pengguna untuk login, melihat saldo, melakukan transfer dana ke pengguna lain, dan melihat riwayat transaksi.

Aplikasi ini dibuat sebagai bagian dari take-home test Fullstack Developer dengan fokus pada implementasi backend, database, frontend, autentikasi, validasi, error handling, dan konsistensi data.

## Fitur Utama

- Login menggunakan email dan password
- Dashboard pengguna
- Menampilkan nama pengguna yang sedang login
- Menampilkan saldo pengguna saat ini
- Transfer dana ke pengguna lain
- Validasi transfer
- Riwayat transaksi milik pengguna
- Pagination riwayat transaksi
- Sorting transaksi berdasarkan tanggal
- Loading state saat form diproses
- Error handling dengan pesan yang informatif
- Identifier unik untuk setiap transaksi transfer
- Data awal minimal 3 pengguna

## Teknologi yang Digunakan

- Laravel
- Laravel Breeze
- Blade Template
- Bootstrap 5
- MySQL / MariaDB
- Laravel Herd untuk local development

## Requirement Sistem

Pastikan perangkat sudah memiliki:

- PHP sesuai versi Laravel yang digunakan
- Composer
- Node.js dan npm
- MySQL atau MariaDB
- Laravel Herd atau local server lain
- Git

## Cara Instalasi

Clone repository:

```bash
git clone <url-repository>
cd mini-e-wallet
```

Install dependency PHP:

```bash
composer install
```

Install dependency frontend:

```bash
npm install
```

Copy file environment:

```bash
cp .env.example .env
```

Untuk Windows PowerShell, bisa gunakan:

```bash
copy .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

## Konfigurasi Database

Buat database baru di MySQL atau MariaDB, misalnya:

```sql
CREATE DATABASE mini_e_wallet;
```

Lalu ubah konfigurasi database di file `.env`:

```env
APP_NAME="Mini Wallet"
APP_URL=http://mini-e-wallet.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mini_e_wallet
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan `DB_USERNAME` dan `DB_PASSWORD` dengan konfigurasi database lokal masing-masing.

## Menjalankan Migration dan Seeder

Jalankan migration dan seeder:

```bash
php artisan migrate:fresh --seed
```

Perintah tersebut akan:

- Menghapus tabel lama
- Membuat ulang struktur tabel
- Mengisi data awal pengguna

## Menjalankan Aplikasi

Jika menggunakan Laravel Herd, buka aplikasi melalui domain lokal:

```text
http://mini-e-wallet.test
```

Jika menggunakan artisan server:

```bash
php artisan serve
```

Lalu buka:

```text
http://127.0.0.1:8000
```

Untuk menjalankan asset frontend saat development:

```bash
npm run dev
```

Atau build untuk production:

```bash
npm run build
```

## Akun Demo

Aplikasi menyediakan 3 akun demo melalui seeder.

| Nama   | Email                                   | Password | Saldo Awal |
| ------ | --------------------------------------- | -------- | ---------- |
| User A | [usera@mail.com](mailto:usera@mail.com) | password | Rp100.000  |
| User B | [userb@mail.com](mailto:userb@mail.com) | password | Rp100.000  |
| User C | [userc@mail.com](mailto:userc@mail.com) | password | Rp100.000  |

## Alur Penggunaan Aplikasi

1. Pengguna membuka aplikasi.
2. Pengguna diarahkan ke halaman login.
3. Pengguna login menggunakan email dan password.
4. Setelah login berhasil, pengguna masuk ke dashboard.
5. Dashboard menampilkan nama pengguna dan saldo saat ini.
6. Pengguna dapat melakukan transfer dana ke pengguna lain.
7. Setelah transfer berhasil, saldo diperbarui.
8. Transaksi yang berhasil akan masuk ke riwayat transaksi.
9. Pengguna dapat melihat daftar transaksi, mengurutkan berdasarkan tanggal, dan berpindah halaman dengan pagination.

## Struktur Database

### Tabel `users`

Tabel `users` digunakan untuk menyimpan data pengguna dan saldo.

Kolom utama:

| Kolom      | Keterangan                  |
| ---------- | --------------------------- |
| id         | Primary key                 |
| name       | Nama pengguna               |
| email      | Email pengguna              |
| password   | Password yang sudah di-hash |
| balance    | Saldo pengguna              |
| created_at | Waktu data dibuat           |
| updated_at | Waktu data diperbarui       |

### Tabel `transactions`

Tabel `transactions` digunakan untuk menyimpan data transaksi transfer.

Kolom utama:

| Kolom            | Keterangan                 |
| ---------------- | -------------------------- |
| id               | Primary key                |
| transaction_code | Identifier unik transaksi  |
| sender_id        | ID pengguna pengirim       |
| receiver_id      | ID pengguna penerima       |
| amount           | Nominal transfer           |
| type             | Jenis transaksi            |
| description      | Keterangan transaksi       |
| created_at       | Waktu transaksi dibuat     |
| updated_at       | Waktu transaksi diperbarui |

### Autentikasi

Aplikasi menggunakan Laravel Breeze untuk menangani autentikasi dasar seperti login, register, logout, dan validasi login.

User melakukan login menggunakan email dan password. Setelah login berhasil, user diarahkan ke dashboard.

### Dashboard

Dashboard menampilkan:

- Nama user yang sedang login
- Saldo user saat ini
- Beberapa transaksi terbaru

Data user diambil dari session autentikasi Laravel menggunakan user yang sedang login.

### Transfer Dana

Fitur transfer dana memungkinkan user mengirim saldo ke user lain.

Field yang digunakan:

- Penerima
- Nominal transfer

Validasi transfer:

- Penerima wajib dipilih
- Nominal wajib diisi
- Nominal harus berupa angka
- Nominal harus lebih besar dari 0
- User tidak boleh transfer ke akun sendiri
- Saldo pengirim harus mencukupi

Jika validasi gagal, aplikasi menampilkan pesan error yang jelas.

Contoh:

```text
Saldo tidak mencukupi.
```

### Konsistensi Data

Proses transfer menggunakan database transaction.

Tujuannya agar proses berikut berjalan sebagai satu kesatuan:

1. Mengurangi saldo pengirim
2. Menambah saldo penerima
3. Menyimpan data transaksi

Jika salah satu proses gagal, maka semua perubahan akan dibatalkan.

Hal ini penting agar saldo pengguna tetap konsisten.

### Pencegahan Race Condition

Pada proses transfer, data saldo pengguna dapat dikunci sementara menggunakan `lockForUpdate()`.

Tujuannya untuk mengurangi risiko masalah saat ada banyak request transfer yang terjadi secara bersamaan.

### Identifier Unik Transaksi

Setiap transaksi memiliki `transaction_code` yang unik.

Contoh:

```text
TRX-20260605130724-DHSFGD
```

Identifier ini dapat digunakan untuk membedakan satu transaksi dengan transaksi lainnya dan memudahkan proses tracking transaksi.

### Riwayat Transaksi

Halaman riwayat transaksi hanya menampilkan transaksi milik user yang sedang login.

Transaksi ditampilkan jika user tersebut berperan sebagai:

- Pengirim
- Penerima

Data yang ditampilkan:

- Tanggal transaksi
- Kode transaksi
- Jenis transaksi
- Nominal
- Keterangan transaksi

Fitur tambahan:

- Pagination
- Sorting berdasarkan tanggal terbaru atau terlama

## Validasi dan Error Handling

Aplikasi menangani validasi dari sisi backend menggunakan Laravel validation.

Contoh validasi:

```php
$request->validate([
    'receiver_id' => ['required', 'exists:users,id'],
    'amount' => ['required', 'numeric', 'min:1'],
]);
```

Jika terjadi error, aplikasi akan menampilkan pesan yang informatif kepada user.

Contoh:

```text
Nominal wajib diisi.
Nominal harus lebih besar dari nol.
Saldo tidak mencukupi.
Tidak boleh transfer ke akun sendiri.
```

## Loading State

Saat user mengirim form, tombol submit akan berubah menjadi:

```text
Memproses...
```

Tujuannya agar user mengetahui bahwa request sedang diproses dan mencegah submit berulang.

## Asumsi Pengembangan

Beberapa asumsi yang digunakan dalam aplikasi ini:

- Aplikasi hanya memiliki satu role, yaitu user.
- Admin tidak dibuat karena tidak disebutkan secara eksplisit di requirement.
- Saldo disimpan langsung di tabel `users` agar aplikasi tetap sederhana.
- Riwayat transaksi disimpan di tabel `transactions`.
- Setiap user awal memiliki saldo Rp100.000.
- Transfer hanya dapat dilakukan antar user yang sudah terdaftar.
- User hanya dapat melihat transaksi miliknya sendiri.

## Pertimbangan Desain

Aplikasi dibuat sederhana agar mudah dipahami dan mudah dijelaskan.

Pertimbangan teknis:

- Laravel Breeze digunakan untuk mempercepat implementasi autentikasi.
- Blade digunakan agar frontend tetap sederhana tanpa React atau Next.js.
- Bootstrap digunakan untuk tampilan yang cepat, rapi, dan responsif.
- Database transaction digunakan agar perubahan saldo dan pencatatan transaksi tetap konsisten.
- Migration dan seeder digunakan agar struktur database dan data awal mudah direplikasi.

## Perintah Penting

Menjalankan migration:

```bash
php artisan migrate
```

Menjalankan migration ulang beserta seeder:

```bash
php artisan migrate:fresh --seed
```

Menjalankan server lokal:

```bash
php artisan serve
```

Menjalankan frontend development:

```bash
npm run dev
```

Build asset frontend:

```bash
npm run build
```

Membersihkan cache:

```bash
php artisan optimize:clear
```

## Troubleshooting

### Halaman tidak berubah setelah edit Blade

Jalankan:

```bash
php artisan view:clear
php artisan optimize:clear
```

### Database tidak terhubung

Pastikan konfigurasi `.env` sudah benar:

```env
DB_DATABASE=mini_e_wallet
DB_USERNAME=root
DB_PASSWORD=
```

Lalu jalankan:

```bash
php artisan migrate
```

### Domain Herd tidak bisa dibuka

Pastikan project berada di folder yang dipantau Laravel Herd.

Jika masih bermasalah, gunakan:

```bash
php artisan serve
```

Lalu buka:

```text
http://127.0.0.1:8000
```

### Asset CSS atau JavaScript tidak muncul

Jalankan:

```bash
npm install
npm run dev
```

Atau:

```bash
npm run build
```

## Status Project

Project ini sudah mencakup fitur utama Mini E-Wallet:

- Login
- Dashboard saldo
- Transfer dana
- Riwayat transaksi
- Pagination
- Sorting tanggal
- Validasi form
- Loading state
- Error handling
- Identifier unik transaksi
- Data awal 3 user
