# Sistem Pelaporan dan Monitoring Tenaga Kerja Asing (TKA)

SITLAKEB TKA (Sistem Informasi Tenaga Kerja Asing) adalah aplikasi web untuk pelaporan keberadaan Tenaga Kerja Asing (TKA) oleh perusahaan dan monitoring terpusat oleh Dinas Tenaga Kerja (Disnaker) Kota Bekasi. Dikembangkan sebagai proyek skripsi S1 Sistem Informasi dan meraih penghargaan dari Disnaker Kota Bekasi (Juni 2026).

**Demo:** [tester-tka.vercel.app](https://tester-tka.vercel.app)

![PHP](https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white)
![CodeIgniter](https://img.shields.io/badge/CodeIgniter_3-EF4223?logo=codeigniter&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?logo=mysql&logoColor=white)

## Daftar Isi

- [Latar Belakang](#latar-belakang)
- [Solusi](#solusi)
- [Peran Pengguna](#peran-pengguna)
- [Fitur](#fitur)
- [Alur Pengajuan](#alur-pengajuan)
- [Teknologi](#teknologi)
- [Tampilan Aplikasi](#tampilan-aplikasi)
- [Struktur Proyek](#struktur-proyek)
- [Cara Menjalankan (Lokal)](#cara-menjalankan-lokal)
- [Catatan](#catatan)
- [Lisensi](#lisensi)
- [Pengembang](#pengembang)

## Latar Belakang

Berdasarkan wawancara langsung dengan pihak Disnaker Kota Bekasi, pelaporan keberadaan TKA masih dilakukan dengan datang langsung ke dinas. Proses ini menyulitkan perusahaan dan membuat pemantauan data TKA tidak terpusat.

## Solusi

Sistem ini memungkinkan perusahaan melapor secara online, sementara Disnaker memantau dan memproses data TKA dalam satu sistem terpusat, lengkap dengan alur persetujuan berjenjang.

## Peran Pengguna

| Peran | Keterangan |
| --- | --- |
| Perusahaan | Registrasi, mengajukan pelaporan TKA, memantau status pengajuan |
| Admin Operator | Mengelola data operasional dan mengirim notifikasi |
| Approval (Kasi, Kabid, Sekdis, Kadis) | Meninjau dan menyetujui pengajuan secara berjenjang |
| Admin Sistem | Mengelola sistem dan pengguna secara keseluruhan |

## Fitur

- Registrasi dan login pengguna
- Pengajuan pelaporan TKA oleh perusahaan
- Daftar dan status pengajuan
- Pengelolaan data TKA
- Unggah dokumen (PDF dan gambar, maksimal 2 MB) dengan panduan pengisian
- Persetujuan (approval) TKA secara berjenjang
- Unduh surat keterangan digital setelah pengajuan selesai
- Dashboard perusahaan: ringkasan pengajuan (total, diproses, selesai, ditolak)
- Dashboard admin: tahapan approval, rata-rata waktu proses, dan tren pengajuan
- Profil pengguna
- Chat dengan admin
- Notifikasi, termasuk pengiriman oleh admin atau admin operator
- Pilihan bahasa (multi-bahasa)

## Alur Pengajuan

1. Perusahaan melakukan registrasi dan login.
2. Perusahaan mengajukan pelaporan TKA.
3. Pengajuan ditinjau dan disetujui secara berjenjang oleh pejabat approval (Kasi, Kabid, Sekdis, Kadis).
4. Perusahaan memantau status pengajuan dan menerima notifikasi.
5. Disnaker memantau seluruh data TKA secara terpusat.

## Teknologi

| Komponen | Teknologi |
| --- | --- |
| Bahasa | PHP |
| Framework | CodeIgniter 3 (arsitektur MVC) |
| Database | MySQL |
| Metode pengembangan | Waterfall (analisis kebutuhan, perancangan, pengembangan, pengujian, serah terima) |
| Demo | Vercel |

## Tampilan Aplikasi

### Halaman Login

Perusahaan masuk atau mendaftar akun, dengan pilihan bahasa Indonesia dan English.

![Halaman Login](docs/login.png)

### Dashboard Perusahaan

Perusahaan memantau jumlah pengajuan (total, diproses, selesai, ditolak), membaca panduan sebelum unggah data, dan mengelola daftar pengajuan TKA.

![Dashboard Perusahaan](docs/dashboard-perusahaan.png)

### Dashboard Admin

Admin memantau tahapan approval (Kasi, Kabid, Sekdis, Kadis), rata-rata waktu proses, tren pengajuan, dan pengajuan terbaru.

![Dashboard Admin](docs/dashboard-admin.png)

> Seluruh data pada tampilan di atas adalah data contoh (dummy).

## Struktur Proyek

```
TKA/
├── application/   # Controller, model, view, dan konfigurasi (CodeIgniter 3)
├── assets/        # CSS, JavaScript, dan gambar
├── system/        # Inti framework CodeIgniter
├── uploads/       # Berkas unggahan pengguna
├── [nama_file_sql_final].sql   # Struktur dan data contoh database
└── index.php      # Titik masuk aplikasi
```

## Cara Menjalankan (Lokal)

Prasyarat: PHP, MySQL, dan web server lokal (misalnya XAMPP).

1. Clone repository ini:

   ```
   git clone https://github.com/Asyaifullah/TKA.git
   ```

2. Letakkan folder proyek di direktori web server lokal (misalnya `htdocs` pada XAMPP).
3. Buat database MySQL, lalu import file `[nama_file_sql_final].sql`.
4. Atur koneksi database di `application/config/database.php`.
5. Atur `base_url` di `application/config/config.php` sesuai alamat lokal.
6. Jalankan Apache dan MySQL, lalu buka `http://localhost/TKA` di browser.

## Catatan

- Data pada repository ini adalah data contoh (dummy), bukan data asli.
- Repository ini dibuat untuk keperluan portofolio dan pembelajaran.

## Lisensi

Dirilis di bawah lisensi MIT. Lihat berkas `LICENSE` untuk detailnya.

## Pengembang

**Agun Syaifullah**
S1 Sistem Informasi, Universitas Bina Sarana Informatika
GitHub: [@Asyaifullah](https://github.com/Asyaifullah)