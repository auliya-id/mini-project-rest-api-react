## Deskripsi Project

Ini adalah mini project sederhana untuk memenuhi test lamar kerja, dengan membuat sebuah aplikasi Rest Api Laravel dan Web Frontend interaktif menggunakan React JS.

Project ini saya buat menggunakan bahasa pemrograman PHP versi 8.2 dengan framework Laravel versi 12, untuk database saya menggunakan postgreSql namun jika ingin menggunakan database lainnya juga bisa karena pada project ini struktur table dan column saya masukkan dalam migration sehingga bisa langsung untuk di generate menggunakan `php artisan migrate`.

## Langkah untuk Installasi

**1. FOLDER mini-project-rest-api:**
- rename file `.env.example` menjadi `.env` dan sesuaikan koneksi databasenya (pastikan database sudah dibuat)
- buka CLI/terminal/command-line dan Change Directory (CD) ke projectnya
- lakukan `composer install`
- lakukan `php artisan key:generate`
- lakukan `php artisan migrate` (pastikan nama database sudah dibuat)
- terakhir untuk menjalankannya lakukan `php artisan serve`
- buka pada browser dengan link `http://127.0.0.1:8000`

**2. FOLDER mini-project-react:**
- lakukan `npm install`
- lakukan `npm start`
- buka pada browser dengan link `http://127.0.0.1:3000`

## Pengembang

- **Nama** : Muhammad Noval Nur Auliya
- **Web Profil CV** : [http://auliya.id](http://auliya.id)
- **Instagram** : [https://www.instagram.com/noval_auliya](https://www.instagram.com/noval_auliya)
- **Facebook** : [https://www.facebook.com/MuhammadNovalNurAuliya](https://www.facebook.com/MuhammadNovalNurAuliya)
- **X (Twitter)** : [https://x.com/noval_auliya](https://x.com/noval_auliya)
- **Youtube** : [https://www.youtube.com/@novalauliya](https://www.youtube.com/@novalauliya)
- **LinkedIn** : [https://www.linkedin.com/in/noval-auliya](https://www.linkedin.com/in/noval-auliya)

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
