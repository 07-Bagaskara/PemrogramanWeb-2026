# Checklist Keamanan & Transaksi — Jobsheet 12

Keamanan Jobsheet 11 tetap berlaku di modul baru (`sewa/`).

| Item | Penerapan di modul sewa |
|---|---|
| Login wajib | `auth_guard.php` di semua halaman `sewa/` |
| CSRF | `csrf_field()` di form, `csrf_verify()` di `proses_tambah.php` & `proses_kembali.php` |
| XSS | semua output dibungkus `e()` |
| SQL Injection | seluruh query prepared statement |
| Validasi | `filter_var(..., FILTER_VALIDATE_INT, min_range 1)` untuk id & jumlah |
| Pesan error | `DomainException` = pesan bisnis; `PDOException` = `error_log` + pesan generik |
| Transaksi | `beginTransaction` / `commit` / `rollBack` (cek `inTransaction()`) |
| Race condition | `SELECT ... FOR UPDATE` pada alat (sewa) dan pada baris sewa (kembali) |
| Integritas data | FK `sewa -> alat_kemah/penyewa`, `CHECK (jumlah > 0)`, `CHECK status` |

## Cara menguji
1. Sewa alat stok 2 sebanyak 3 -> ditolak "Stok tidak mencukupi", stok tidak berubah.
2. Sewa 1 -> stok berkurang 1; Pengembalian -> stok kembali.
3. Klik "Kembalikan" dua kali pada transaksi yang sama -> kedua kalinya ditolak, stok tidak bertambah dua kali.
4. Hapus alat/penyewa yang punya riwayat sewa -> ditolak dengan pesan jelas.
5. Kirim POST tanpa token -> 403.

## Catatan yang masih terbuka
- Password database masih tertulis di `includes/koneksi.php` — reset di Supabase dan pindah ke environment variable Vercel.
- Session di Vercel serverless bisa hilang antar instance (login/CSRF sesekali gagal).
