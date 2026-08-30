## Deskripsi Praktikum

Jobsheet pertama ini berfokus pada penguasaan struktur dasar web menggunakan HTML5.
Proyek utama yang dibangun adalah kerangka awal Sistem Informasi Perpustakaan Mini (SIMPUS-Mini).


**6.5 Latihan Reflektif**

1.Kenapa field "Alamat" dan "No. HP" tidak diberi required, sedangkan "Nama" dan "No. Anggota" diberi?

Jawaban: Karena field "Alamat" dan "No.HP" merupakan data opsional(boleh di isi dan boleh tidak isi).

2.Apa yang akan terjadi (di browser) kalau kamu klik tombol "Simpan" tanpa mengisi field "Nama"? Coba buka filenya di browser dan praktikkan.

Jawaban: Browser akan menolak submit form(dan menampilkan pesan peringatan) kalau field ini dikosongkan karena field "Nama" memiliki atribut "required". 

3.Form ini juga belum punya action pada tag "form" nya, apa dampaknya saat tombol "Simpan" ditekan?

Jawaban: Jika tombol "Simpan" ditekan, maka form ini belum mengirim data ke manapun karena masih belum memiliki atribut action(browser hanya akan reload halaman yang sama).