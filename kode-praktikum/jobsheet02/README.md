## Deskripsi Praktikum

Jobsheet kedua ini merupakan tahap penyempurnaan antarmuka proyek NatureRent.
Fokus utama terletak pada penambahan CSS pada website NatureRent.

## 10.4 Latihan Tambahan

4.Uji responsivitas sederhana — perkecil lebar jendela browser secara bertahap sampai sangat sempit (seperti lebar HP), amati kapan "flex-wrap: wrap" pada navbar mulai memindahkan menu ke baris baru.

Jawaban: Pada desain sidebar, menu disusun vertikal (`flex-direction: column`), jadi menu tidak pernah pindah baris karena `flex-wrap`. Yang terjadi pada jobsheet 2 (belum ada media query) adalah halaman mulai melebar ke samping (muncul scroll horizontal) saat lebar jendela di bawah sekitar 750px (beranda) dan 760px (daftar alat), karena sidebar tetap 240px dan konten tidak menyesuaikan. Efek `flex-wrap: wrap` pada menu baru terlihat di jobsheet 3: pada lebar 481-900px menu berjajar horizontal, dan mulai pindah ke baris kedua saat lebar jendela sekitar 690px atau kurang. Di bawah 480px menu berubah menjadi tombol hamburger.
