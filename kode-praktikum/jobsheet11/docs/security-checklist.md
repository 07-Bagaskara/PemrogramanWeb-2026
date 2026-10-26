# Checklist Keamanan — Jobsheet 11 (NatureRent)

Audit keamanan terhadap kode Jobsheet 7–10 yang dibawa ke Jobsheet 11.
Kolom **Sebelum** diambil dari hasil membaca kode Jobsheet 10; kolom **Sesudah** adalah perbaikan di folder ini.

| # | Kerentanan | Ditemukan di | Sebelum | Sesudah (perbaikan) |
|---|---|---|---|---|
| 1 | SQL Injection | Semua query di `alat/`, `penyewa/`, `auth/`, `index.php` | Sejak Jobsheet 8 semua query yang memakai input pengguna sudah *prepared statement* PDO (`:parameter`). | **Diaudit ulang, sudah aman** — tidak ada `$_POST`/`$_GET` yang disisipkan langsung ke string SQL; query tanpa parameter (`COUNT(*)`, `ORDER BY id DESC`) tidak memakai input. Uji login dengan username `' OR '1'='1` → tetap ditolak. |
| 2 | XSS (Cross-Site Scripting) | `alat/list.php`, `alat/edit.php`, `penyewa/list.php`, `penyewa/edit.php`, `includes/header.php`, pesan flash di semua halaman | Data tabel dan form sudah dibungkus `htmlspecialchars()`, tetapi **pesan flash** (`$_SESSION['flash']['pesan']`), judul halaman, dan beberapa `id` masih dicetak mentah. | Semua output dibungkus `e()` (`includes/helpers.php`, `htmlspecialchars` + `ENT_QUOTES`). `id` dicetak lewat `(int)`. Uji nama alat `<script>alert(1)</script>` → tampil sebagai teks, tidak dieksekusi. |
| 3 | CSRF (Cross-Site Request Forgery) | Semua form POST: Login, Registrasi, Tambah/Edit/Hapus Alat & Penyewa | Form POST tidak punya token verifikasi — bisa dipicu dari situs lain selama korban sedang login. | `includes/csrf.php` (`csrf_field()` + `csrf_verify()`). Token acak (`random_bytes`) per-sesi, dibandingkan dengan `hash_equals()`. Setiap `proses_*.php` memanggil `csrf_verify()` sebelum menyentuh database; token palsu/kosong → HTTP 403. |
| 4 | Endpoint proses tanpa guard login | `alat/proses_*.php`, `penyewa/proses_*.php` | Hanya memanggil `session_start()`, **tidak** memeriksa login — siapa pun bisa `POST` langsung untuk menambah/mengubah/menghapus data tanpa masuk. | Semua `proses_*.php` memuat `includes/auth_guard.php` paling awal. Uji `POST` ke `proses_hapus.php` tanpa login → di-redirect ke Login, data tidak terhapus. |
| 5 | Validasi & sanitasi input | `alat/proses_edit.php`, `penyewa/proses_edit.php` | Validasi hanya ada di jalur *tambah*; jalur *edit* menerima apa saja, sehingga aturan (mis. kode barang hanya angka/strip, No. HP angka) bisa dilewati lewat form edit. | Aturan validasi dipusatkan di `includes/validasi.php` & `includes/validasi_penyewa.php`, dipakai bersama oleh tambah dan edit. Tahun dibatasi 1900–tahun ini, stok bilangan bulat ≥ 0, kategori harus salah satu nilai yang diizinkan, `id` divalidasi `FILTER_VALIDATE_INT`. |
| 6 | Session Fixation | `auth/proses_login.php` | ID sesi tidak diganti setelah login. | `session_regenerate_id(true)` dipanggil tepat setelah `password_verify()` berhasil. Uji: `PHPSESSID` sebelum dan sesudah login **berbeda**. |
| 7 | Kebocoran pesan error database | Semua blok `catch (PDOException $e)` | Pesan asli `$e->getMessage()` ditampilkan ke pengguna (bisa membocorkan nama tabel/kolom dan struktur database). | Pengguna hanya melihat pesan umum; detail error ditulis ke log server lewat `error_log()`. Kasus duplikat (kode `23505`) tetap diberi pesan yang jelas. |
| 8 | Halaman debug publik | `debug_session.php` | Mencetak seluruh isi `$_SESSION` tanpa login, dan ikut ter-deploy ke Vercel. | Dihapus dari folder Jobsheet 11. |

## Catatan Implementasi
- Urutan di setiap halaman proses: **`auth_guard.php` (login) → `csrf_verify()` → validasi → query**. Pengguna yang belum login langsung diarahkan ke Login tanpa pengecekan CSRF.
- Form pencarian memakai `method="GET"` dan hanya membaca data, jadi sengaja tidak diberi token CSRF (CSRF menyerang aksi yang *mengubah* data).
- `logout.php` masih berupa link `GET` (sama seperti contoh jobsheet). Risikonya kecil (hanya memaksa keluar), tetapi untuk produksi sebaiknya dijadikan form `POST` + token.

## Cara Menguji
1. **CSRF:** setelah login, `curl -X POST <url>/alat/proses_tambah.php -d "nama_alat=x"` (dengan cookie sesi, tanpa `csrf_token`) → HTTP 403.
2. **XSS:** tambah alat bernama `<script>alert(1)</script>` → di Inventaris Alat tampil sebagai teks.
3. **Guard:** `POST` ke `alat/proses_hapus.php` tanpa login → diarahkan ke Login.
4. **SQL Injection:** login dengan username `' OR '1'='1` → "Username atau password salah."
5. **Session fixation:** bandingkan nilai cookie `PHPSESSID` (DevTools → Application → Cookies) sebelum dan sesudah login.
