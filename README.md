<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Tentang SISENPAI

SISENPAI adalah Sistem Informasi Absensi Pegawai yang dibuat oleh Dinas Kominfo Bone Bolango dalam rangka penerapan absensi digital di lingkungan Pemerintah Kabupaten Bone Bolango. Fitur utama yang ada di dalam SISENPAI yaitu:

- Absen selfie dengan menggunakan radius lokasi.
- Absen penugasan.
- Pengajuan izin, cuti, dan sakit.

## Panduan Instalasi SISENPAI

- `git clone https://github.com/danikaharu/sisenpai.git`
- `composer install`
- `cp .env.example .env`
- sesuaikan pengaturan database 
- `php artisan key:generate`
- `php artisan migrate`
- `php artisan db:seed`
- `php artisan storage:link`
