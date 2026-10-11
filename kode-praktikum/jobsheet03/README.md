# SIMPUS-Mini: Jobsheet 3 (Responsive Design)


## Deskripsi Praktikum
Jobsheet ketiga ini berfokus pada implementasi *Responsive Web Design* (RWD) murni menggunakan HTML dan CSS tanpa tambahan JavaScript. Pembaruan pada proyek SIMPUS-Mini ini memastikan tata letak dan fungsionalitas antarmuka tetap optimal ketika diakses melalui berbagai ukuran layar (desktop, tablet, maupun *smartphone*).

## Fitur Responsif yang Diimplementasikan
* **Viewport Meta Tag:** Menambahkan `<meta name="viewport" content="width=device-width, initial-scale=1">` di seluruh file HTML agar skala tampilan dikendalikan secara otomatis oleh perangkat seluler.
* **Hamburger Menu (CSS-Only):** Membangun sistem navigasi *dropdown* khusus layar sempit menggunakan teknik *checkbox hack*, memanfaatkan kombinasi state `:checked` dan *General Sibling Combinator* (`~`).
* **Tabel Responsif:** Menerapkan properti `overflow-x: auto` melalui kelas `.table-responsive` sebagai pembungkus tabel data buku dan anggota. Fitur ini mencegah tabel merusak lebar halaman (terpotong) dan mengizinkan pengguna melakukan *scroll* horizontal pada layar HP.
* **CSS Media Queries:** Menetapkan titik adaptasi (*breakpoint*) pada `900px` (menyesuaikan grid menjadi 2 kolom dan sidebar menjadi bilah atas) dan `480px` (mengubah grid menjadi 1 kolom penuh serta memicu transisi menu navigasi menjadi tombol hamburger).

## Observasi & Analisis (Ide Latihan Tambahan)

**1. Breakpoint Layar Super Lebar (1400px)**
Penambahan `@media (min-width: 1400px)` yang mengubah properti batas `<main>` menjadi `max-width: 1200px` berhasil membuat area konten memuai lebih proporsional pada monitor beresolusi tinggi, sehingga *website* tidak terlihat terlalu kecil dan terhimpit di tengah layar.

**2. Modifikasi Breakpoint Tablet (900px)**
Saat *breakpoint* `768px` diubah menjadi `900px`, susunan kartu statistik pada beranda terpaksa berubah dari 4 kolom menjadi 2 kolom jauh lebih cepat saat jendela browser ditarik menyempit. Ini mengonfirmasi bahwa penentuan *breakpoint* sepenuhnya dapat dimanipulasi oleh pengembang untuk mengakomodasi titik patah desain, tanpa harus kaku mengikuti resolusi standar perangkat.

**3. Adaptasi Pola `.table-responsive`**
Mekanisme membungkus elemen panjang agar dapat di-*scroll* secara independen ini sangat aplikatif untuk komponen lain. Sudah diterapkan pada blok `<pre class="scroll-responsive">` ("Struktur Proyek") di `index.html`: baris panjangnya bisa digeser sendiri di layar HP tanpa membuat halaman ikut melebar. Teknik yang sama bisa dipakai untuk kumpulan gambar memanjang.

**4. Posisi Navigasi Hamburger Menu**
`.nav-toggle-label` sudah dipindahkan ke posisi paling akhir di `<header>` (setelah `<nav>`) dan menu **tetap berfungsi**. Alasannya: aturan `.nav-toggle:checked ~ nav` hanya melibatkan *checkbox* sebagai elemen sumber dan `nav` sebagai target, sedangkan `<label>` hanya perantara yang mengklik checkbox lewat atribut `for`, sehingga letaknya bebas. Yang **gagal** adalah memindahkan *checkbox*-nya ke setelah `<nav>`, karena *General Sibling Combinator* (`~`) hanya memilih saudara yang berada **setelah** elemen sumber di HTML. Agar tombol hamburger tetap tampil di baris pertama bersama judul saat label berada setelah `nav`, `nav` diberi `order: 3` pada breakpoint mobile.

**5. Desktop-First vs Mobile-First**
*   **Desktop-First (Pola Praktikum):** Kode CSS standar ditulis untuk tampilan monitor lebar. Media queries (`max-width`) kemudian digunakan untuk "menekan" dan menyederhanakan kolom-kolom tersebut ketika layar menyempit menjadi seukuran HP.
*   **Mobile-First:** Alur logika ini dibalik. Gaya dasar CSS diketik murni untuk mengakomodasi tampilan seluler (1 kolom). Media queries (`min-width`) baru akan digunakan untuk melebarkan dan membagi tata letak menjadi beberapa kolom begitu layar mendeteksi ruang yang lebih luas (tablet/laptop).

Versi mobile-first sudah ditulis ulang di `assets/css/style-mobile-first.css`. Cara mencobanya: ganti `href="...style.css"` menjadi `href="...style-mobile-first.css"` di file HTML. Gaya dasarnya untuk layar HP, lalu `@media (min-width: 481px)`, `(min-width: 901px)`, dan `(min-width: 1400px)` menambah aturan untuk layar yang lebih lebar. Tampilannya sama persis dengan `style.css` (sudah dibandingkan piksel demi piksel di 12 lebar layar), hanya cara berpikirnya yang dibalik.
