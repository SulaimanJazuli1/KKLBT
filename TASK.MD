# KKLBT
Website Desa Alat KKL2

To Do List (Saturday 07 Nov 2026)

"Kerjakan Bagian Frontend & Webgis (syahrul syauqi, bagi aja ke yang lain), Khusus Deployment aku aja yang ngerjakan

-> Frontend {
    Beranda Page {
        - Logo & Icon = Gunakan logo barabai | DONE
        - Beranda -> Sambutan Kepala Desa (Confirm text sambutan apakah memang dari kades atau bikinan AI -_-) = pAKAI SAMBUTAN YANG ADA
        - Footer (Nama Desa, Alamat Resmi, & Kontak Desa) =
        - Beranda -> Wrap Stats Reveal (Sesuaikan Data Desa)
        - Beranda -> Potensi Desa (Sesuaikan Foto & Deskripsi setiap Foto)
        - Beranda -> Peta Interaktif (Data Geojson webGIS)
        - Beranda -> KKL Geografi (Sesuaikan Foto & isi Deskripsi singkat sesuai konsentrasi)
        - Beranda -> Foto Unggulan (Isi Foto unggulan sesuai dengan foto-foto Desa)
        - Beranda -> Destinasi Wisata (Isi Foto Wisata sesuai dengan foto terbaru & Isi Deskripsinya)
    }

    Pemdes Page {
        - Confirm seluruh Text (Visi Misi, Nama-nama pokja, Kepala Dusun, maupun aparat desa apakah sudah sesuai dengan data desa)
        - Pemdes -> LandingPage (Sesuaikan Gambar pada tampilan awal halaman dengan gambar aparat yang sebenarnya)
        - Pemdes -> Visi Misi (di bagian bawah atau sumber di isi sesuai dengan data yang benar atau dihapus agar tidak salah)
        - Pemdes ->
    }

    Mitra Desa {
        - Atur seluruh gambar agar sesuai dengan gambar yang diperlukan
            - SIG {
                - SIG -> Alur Kerja Spasial (Atur tampilan jika memang diperlukan)
                - SIG -> Peta Tematik Desa (Ganti Sesuai Peta hasil olah data & Isi Deskripsi yang sesuai)
                - SIG -> Dokumentasi Pengambilan Data Lapangan (Ganti Sesuai kegiatan survey & Isi Deskripsi yang sesuai)
                - SIG -> Pengembangan WebGIS (Kalo gak dipake, hapus aja)
            }
            - LMB {
                - LMB -> Ringkasan Kajian Lingkungan (Atur tampilan jika memang diperlukan - Gambar & Deskripsi)
                - LMB -> Metodologi tahapan Kajian (Atur tampilan jika memang diperlukan - hapus jika tidak diperlukan)
                - LMB -> Dokumentasi (Sesuaikan gambar dengan dokumentasi lapangan tim konsentrasi)
                - LMB -> Hasil dan Rekomendasi (Atur tampilan jika memang diperlukan - hapus jika tidak diperlukan)
            }
            - PPW {
                - PPW -> Empat Aspek Wilayah (Atur tampilan jika memang diperlukan - Hapus jika tidak diperlukan)
                - PPW -> Metode Survey (sesuaikan isi tampilan dengan data dan gambar asli)
                - PPW -> Dokumentasi & Peta Tematik (sesuaikan isi tampilan dengan data dan gambar asli)
                - PPW -> Arah Pengembangan (Atur tampilan jika diperlukan, hapus jika tidak diperlukan)
            }
    }

     Informasi Desa {
	- Informasi desa -> Landing Page "Data & Cerita Desa Alat" apakah sudah sesuai dengan konsep halaman.
	- Informasi desa -> Ringkasan (Apakah memang ada berita di website, hapus jika tidak digunakan)
	- Informasi desa -> Berita & Pengumuman (Apakah emang mau dipake, kalo mau dipake, bikin halaman & routenya, kalo gak, hapus)

	- Demografi -> Landing Page (Atur tampilan agar sesuai dengan gambar kependudukan)
	- Demografi -> Confirm jumlah penduduk & kepala keluarga apakah sudah dari data desa & Apakah tampilan diagram gak jadi?.
	- Demografi -> Jenis Kelamin & Kelompok Umur atur ke bentuk Persentase, bukan jumlah angka (Pake Rumus Persentase buat nyari angkanya).
	- Demografi -> Tren Penduduk (Atur Data jika memang dipake-Data Temporal)

	- Wisata -> Atur gambar Destinasi, Deskripsi Singkat, serta sesuaikan dengan jumlah wisata yang ada di desa
	- Wisata -> Detail Destinasi (Atur jika memang datanya ada + Tombol Detail nanti akan mengarah kemana?)
    }

}

-> WebGIS {
    - NDVI Belum Muncul | DONE
    - Layer webgis "Jembatan" terlihat tidak sesuai pada titik tampilan di dalam webgis, sesuaikan titik koordinat agar benar benar tepat pada koordinat jembatan di desa. | DONE
    - Geojson-Layer Jalan&Sungai gunakan satuan Meter, Bukan Ha2 (Hectare)
    - Geojson-Layer Sungai masih sama dengan geojson Jalan, perbaiki geojson sungai
}

-> Deployment
    - Checking all pages (Responsivity & Syntax)
    - Clearing Styling System
    - Checking bugs & false Syntax
    - Requirement Data
    - Panel Control (Kerangka Per Kategori Data)

	- Login Page {
		- Frontend (View Blade, Form, Js, Route Login
		- Backend (Controller, Login Logic, Role User
		- Database (Table User)
	}

	- Dashboard System {
		- Update Page (Beranda), (Pemdes), (Mitra), (Informasi)
		- Delete Page (Beranda), (Pemdes), (Mitra), (Informasi)
		- Create Page (Beranda), (Pemdes), (Mitra), (Informasi)
	}

