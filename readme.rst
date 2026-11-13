# Sistem Pelaporan dan Monitoring Tenaga Kerja Asing (TKA)

Aplikasi web untuk pelaporan keberadaan Tenaga Kerja Asing (TKA) oleh perusahaan dan monitoring terpusat oleh Dinas Tenaga Kerja (Disnaker) Kota Bekasi. Dikembangkan sebagai proyek skripsi S1 Sistem Informasi dan meraih penghargaan dari Disnaker Kota Bekasi (Juni 2026).

## Latar Belakang Masalah

Berdasarkan wawancara langsung dengan pihak Disnaker Kota Bekasi, pelaporan keberadaan TKA masih dilakukan dengan datang langsung ke dinas. Proses ini menyulitkan perusahaan dan membuat pemantauan data TKA tidak terpusat.

## Solusi

Sistem ini memungkinkan perusahaan melapor secara online, sementara Disnaker memantau dan memproses data TKA dalam satu sistem terpusat, lengkap dengan alur persetujuan berjenjang.

## Peran Pengguna

| Peran | Keterangan |
|---|---|
| Perusahaan | Registrasi, mengajukan pelaporan TKA, memantau status pengajuan |
| Admin Operator | Mengelola data operasional dan mengirim notifikasi |
| Approval (Kasi, Kabid, Sekdis, Kadis) | Meninjau dan menyetujui pengajuan secara berjenjang |
| Admin Sistem | Mengelola sistem dan pengguna secara keseluruhan |

## Fitur

- Registrasi dan login pengguna
- Pengajuan pelaporan TKA oleh perusahaan
- Melihat daftar dan status pengajuan
- Pengelolaan data TKA
- Persetujuan (approval) TKA secara berjenjang
- Profil pengguna
- Chat dengan admin
- Notifikasi, termasuk pengiriman notifikasi oleh admin atau admin operator
- Pilihan bahasa (multi-bahasa)

## Teknologi

- PHP
- CodeIgniter 3
- MySQL
- Metode pengembangan: Waterfall (analisis kebutuhan, perancangan, pengembangan, pengujian, serah terima)


<!-- ![Login](docs/login.png) -->
<!-- ![Pengajuan](docs/pengajuan.png) -->

## Cara Menjalankan (Lokal)

1. Clone repository ini:
   ```
   git clone https://github.com/Asyaifullah/TKA.git
   ```
2. Letakkan folder proyek di direktori web server lokal (misalnya `htdocs` pada XAMPP).
3. Buat database MySQL, lalu import file `Experiment_tka.sql` (sesuaikan dengan nama file database di proyek).
4. Atur koneksi database di `application/config/database.php`.
5. Atur `base_url` di `application/config/config.php` sesuai alamat lokal.
6. Jalankan Apache dan MySQL, lalu buka proyek di browser.

## Catatan

- Data pada repository ini adalah data contoh (dummy), bukan data asli.
- Repository ini dibuat untuk keperluan portofolio dan pembelajaran.

## Pengembang

Asyaifullah. S1 Sistem Informasi, Universitas Bina Sarana Informatika.