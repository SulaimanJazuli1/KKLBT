<?php

return [
    'groups' => [
        'fasilitas' => [
            'label' => 'Fasilitas Umum',
            'icon' => 'bi-building-fill',
        ],
        'transportasi' => [
            'label' => 'Prasarana Transportasi',
            'icon' => 'bi-signpost-split-fill',
        ],
        'perairan' => [
            'label' => 'Wilayah Perairan',
            'icon' => 'bi-water',
        ],
         'administrasi' => [
            'label' => 'Wilayah Administrasi',
            'icon' => 'bi-map-fill',
        ],
        'analisis' => [
            'label' => 'Analisis KKL',
            'icon' => 'bi-globe-asia-australia',
        ],
    ],

    'categories' => [
        'pemerintahan' => ['label' => 'Fasilitas Pemerintahan', 'group' => 'fasilitas'],
        'sosial' => ['label' => 'Fasilitas Sosial', 'group' => 'fasilitas'],
        'poskesdes' => ['label' => 'Fasilitas Kesehatan', 'group' => 'fasilitas'],
        'pendidikan' => ['label' => 'Fasilitas Pendidikan', 'group' => 'fasilitas'],
        'keagamaan' => ['label' => 'Fasilitas Keagamaan', 'group' => 'fasilitas'],
        'ekonomi' => ['label' => 'Fasilitas Ekonomi', 'group' => 'fasilitas'],
        'transportasi' => ['label' => 'Prasarana Transportasi', 'group' => 'transportasi'],
        'administrasi' => ['label' => 'Wilayah Administrasi', 'group' => 'administrasi'],
        'sungai' => ['label' => 'Sungai', 'group' => 'perairan'],
        'sig' => ['label' => 'Sistem Informasi Geografis', 'group' => 'analisis'],
        'lmb' => ['label' => 'Lingkungan Mitigasi Bencana', 'group' => 'analisis'],
        'ppw' => ['label' => 'Perencanaan Pembangunan Wilayah', 'group' => 'analisis'],

    ],

    'layers' => [
        'Kantor' => [
            'label'    => 'Kantor Desa',
            'category' => 'pemerintahan',
            'geometry' => 'point',
            'rank'     => 'point',
            'file'     => 'Kantor.geojson',
            'visible'  => true,                 // aktif saat halaman dibuka
            'minzoom'  => null,                 // null = selalu tampil
            'label_field' => 'nama',            // atribut untuk label teks di peta (opsional)
            'style'       => [
                'type'      => 'bootstrap-icon',
                'icon'      => 'bi-moon-stars-fill', // Ganti dengan class icon Bootstrap yang diinginkan (misal: bi-building-fill atau icon khusus)
                'color'     => '#f5b83d',            // Warna icon
                'size'      => '24px',               // Ukuran icon
                'bg_color'  => '#ffffff',            // Warna latar belakang pin (opsional, agar kontras)
            ],
            'popup'    => [
                'title'  => 'Kantor Desa',             // atribut untuk judul popup
                'fields' => [                   // atribut => label tampilan
                    'NAMOBJ' => 'Nama Fasilitas',
                ],
                'image'  => [                   // opsional
                    'field' => 'foto',          // atribut berisi NAMA FILE gambar
                    'dir'   => 'img/WebGIS/Fasum',    // folder di /public
                ],
            ],
        ],

        'Makam' => [
            'label'    => 'Pemakaman Umum',
            'category' => 'sosial',
            'geometry' => 'point',
            'rank'     => 'point',
            'file'     => 'Pemakaman.geojson',
            'visible'  => true,                 // aktif saat halaman dibuka
            'minzoom'  => null,                 // null = selalu tampil
            'label_field' => 'nama',            // atribut untuk label teks di peta (opsional)
            'style'       => [
                'type'      => 'bootstrap-icon',
                'icon'      => 'bi-moon-stars-fill', // Ganti dengan class icon Bootstrap yang diinginkan (misal: bi-building-fill atau icon khusus)
                'color'     => '#4b5563',            // Warna icon
                'size'      => '24px',               // Ukuran icon
                'bg_color'  => '#ffffff',            // Warna latar belakang pin (opsional, agar kontras)
            ],
            'popup'    => [
                'title'  => 'Makam',             // atribut untuk judul popup
                'fields' => [                   // atribut => label tampilan
                    'NAMOBJ' => 'Nama Fasilitas',
                ],
                'image'  => [                   // opsional
                    'field' => 'foto',          // atribut berisi NAMA FILE gambar
                    'dir'   => 'img/WebGIS/Fasum',    // folder di /public
                ],
            ],
        ],

        'Poskesdes' => [
            'label'    => 'Poskesdes',
            'category' => 'poskesdes',
            'geometry' => 'point',
            'rank'     => 'point',
            'file'     => 'Poskesdes.geojson',
            'visible'  => true,                 // aktif saat halaman dibuka
            'minzoom'  => null,                 // null = selalu tampil
            'label_field' => 'nama',            // atribut untuk label teks di peta (opsional)
            'style'       => [
                'type'      => 'bootstrap-icon',
                'icon'      => 'bi-moon-stars-fill', // Ganti dengan class icon Bootstrap yang diinginkan (misal: bi-building-fill atau icon khusus)
                'color'     => '#e63946',            // Warna icon
                'size'      => '24px',               // Ukuran icon
                'bg_color'  => '#ffffff',            // Warna latar belakang pin (opsional, agar kontras)
            ],
            'popup'    => [
                'title'  => 'Poskesdes',             // atribut untuk judul popup
                'fields' => [                   // atribut => label tampilan
                    'NAMOBJ' => 'Nama Fasilitas',
                ],
                'image'  => [                   // opsional
                    'field' => 'foto',          // atribut berisi NAMA FILE gambar
                    'dir'   => 'img/WebGIS/Fasum',    // folder di /public
                ],
            ],
        ],

        'Keagamaan' => [
            'label'    => 'Masjid',
            'category' => 'keagamaan',
            'geometry' => 'point',
            'rank'     => 'point',
            'file'     => 'Masjid.geojson',
            'visible'  => true,                 // aktif saat halaman dibuka
            'minzoom'  => null,                 // null = selalu tampil
            'label_field' => 'nama',            // atribut untuk label teks di peta (opsional)
            'style'       => [
                'type'      => 'bootstrap-icon',
                'icon'      => 'bi-moon-stars-fill', // Ganti dengan class icon Bootstrap yang diinginkan (misal: bi-building-fill atau icon khusus)
                'color'     => '#0f766e',            // Warna icon
                'size'      => '24px',               // Ukuran icon
                'bg_color'  => '#ffffff',            // Warna latar belakang pin (opsional, agar kontras)
            ],
            'popup'    => [
                'title'  => 'Masjid',             // atribut untuk judul popup
                'fields' => [                   // atribut => label tampilan
                    'NAMOBJ' => 'Nama Fasilitas',
                ],
                'image'  => [                   // opsional
                    'field' => 'foto',          // atribut berisi NAMA FILE gambar
                    'dir'   => 'img/WebGIS/Fasum',    // folder di /public
                ],
            ],
        ],

        'Sekolah' => [
            'label'    => 'Sekolah Dasar',
            'category' => 'pendidikan',
            'geometry' => 'point',
            'rank'     => 'point',
            'file'     => 'Sekolah.geojson',
            'visible'  => true,                 // aktif saat halaman dibuka
            'minzoom'  => null,                 // null = selalu tampil
            'label_field' => 'nama',            // atribut untuk label teks di peta (opsional)
            'style'       => [
                'type'      => 'bootstrap-icon',
                'icon'      => 'bi-moon-stars-fill', // Ganti dengan class icon Bootstrap yang diinginkan (misal: bi-building-fill atau icon khusus)
                'color'     => '#7c3aed',            // Warna icon
                'size'      => '24px',               // Ukuran icon
                'bg_color'  => '#ffffff',            // Warna latar belakang pin (opsional, agar kontras)
            ],
            'popup'    => [
                'title'  => 'Sekolah',             // atribut untuk judul popup
                'fields' => [                   // atribut => label tampilan
                    'NAMOBJ' => 'Nama Fasilitas',
                ],
                'image'  => [                   // opsional
                    'field' => 'foto',          // atribut berisi NAMA FILE gambar
                    'dir'   => 'img/WebGIS/Fasum',    // folder di /public
                ],
            ],
        ],

        'Jembatan' => [
            'label'    => 'Jembatan',
            'category' => 'transportasi',
            'geometry' => 'point',
            'rank'     => 'point',
            'file'     => 'Jembatan.geojson',
            'visible'  => true,                 // aktif saat halaman dibuka
            'minzoom'  => null,                 // null = selalu tampil
            'label_field' => 'nama',            // atribut untuk label teks di peta (opsional)
            'style'       => [
                'type'      => 'bootstrap-icon',
                'icon'      => 'bi-moon-stars-fill', // Ganti dengan class icon Bootstrap yang diinginkan (misal: bi-building-fill atau icon khusus)
                'color'     => '#8b5a2b',            // Warna icon
                'size'      => '24px',               // Ukuran icon
                'bg_color'  => '#ffffff',            // Warna latar belakang pin (opsional, agar kontras)
            ],
            'popup'    => [
                'title'  => 'Jembatan',             // atribut untuk judul popup
                'fields' => [                   // atribut => label tampilan
                    'NAMOBJ' => 'Nama Fasilitas',
                ],
                'image'  => [                   // opsional
                    'field' => 'foto',          // atribut berisi NAMA FILE gambar
                    'dir'   => 'img/WebGIS/Fasum',    // folder di /public
                ],
            ],
        ],

        'Sungai' => [
            'label'    => 'Sungai',
            'category' => 'sungai',
            'geometry' => 'line',
            'rank'     => 'lineSungai',
            'file'     => 'Sungai.geojson',
            'visible'  => true,
            'style'    => ['color' => '#38bdf8', 'width' => 4],   // opsional: 'dash' => [2, 2]
            'popup'    => [
                'title'  => 'Aliran Sungai',
                'fields' => [
                    'NAMOBJ' => 'Nama Sungai',
                    'REMARK' => 'Jenis Alur',
                    'Panjang' => 'Panjang Sungai',
                ],
            ],
        ],

        'Jalan' => [
            'label'    => 'Jalan Desa',
            'category' => 'transportasi',
            'geometry' => 'line',
            'rank'     => 'lineJalan',
            'file'     => 'Jalan.geojson',
            'visible'  => true,
            'style'    => ['color' => '#030303', 'width' => 2],   // opsional: 'dash' => [2, 2]
            'popup'    => [
                'title'  => 'Jalan',
                'fields' => [
                    'REMARK' => 'Jalan Lokal',
                    'Panjang' => 'Panjang Jalan',
                ],
            ],
        ],

        'Admin' => [
            'label'    => 'Desa Alat',
            'category' => 'administrasi',
            'geometry' => 'polygon',
            'rank'     => 'polygon',
            'file'     => 'Batas Desa.geojson',
            'visible'  => true,
            'style'    => ['color' => '#3ca22a', 'fill_opacity' => 0.4, 'width' => 2],
            'popup'    => [
                'title'  => 'Batas',
                'fields' => [
                    'WADMPR' => 'Kalimantan Selatan',
                    'WADMKK' => 'Hulu Sungai Tengah',
                    'WADMKC' => 'Hantakan',
                    'WADMKD' => 'Alat',
                ],
            ],
        ],

                                            // Sistem Informasi Geografis

        'NDVI' => [
            'label'    => 'NDVI (INDEX VEGETASI)',
            'category' => 'sig',
            'geometry' => 'polygon',
            'rank'     => 'polygon',
            'file'     => 'NDVI.geojson',
            'visible'  => false,
            'style'      => [
                'color'        => 'from_geojson',
                'fill_opacity' => 0.6,
                'width'        => 1
            ],
            'popup'    => [
                'title'  => 'Index Vegetasi',
                'fields' => [
                    'Nilai' => 'Nilai NDVI',
                    'Kelas' => 'Kelas Vegetasi',
                    'Keterangan' => 'Keterangan',
                    'luas' => 'Luas Area',
                ],
            ],
        ],

        'Lereng' => [
            'label'    => 'Kemiringan Lereng',
            'category' => 'sig',
            'geometry' => 'polygon',
            'rank'     => 'polygon',
            'file'     => 'Lereng.geojson',
            'visible'  => false,
            'style'      => [
                'color'        => 'from_geojson',
                'fill_opacity' => 0.7,
                'width'        => 1
            ],
            'popup'    => [
                'title'  => 'Kemiringan Lereng',
                'fields' => [
                    'klasifikasi' =>'Klasifikasi Lereng',
                    'Luas' => 'Luas Keseluruhan',
                ],
            ],
        ],

        'TutupanLahan' => [
            'label'    => 'Tutupan Lahan (supervised classification) 2025',
            'category' => 'sig',
            'geometry' => 'polygon',
            'rank'     => 'polygon',
            'file'     => 'Tuplah25.geojson',
            'visible'  => false,
            'style'      => [
                'color'        => 'from_geojson',
                'fill_opacity' => 0.6,
                'width'        => 1
            ],
            'popup'    => [
                'title'  => 'Tutupan Lahan',
                'fields' => [
                    'Keterangan' => 'Keterangan',
                    'Luas' => 'Luas Area',
                ],
            ],
        ],

                 'RF' => [
            'label'    => 'Random Forest',
            'category' => 'sig',
            'geometry' => 'polygon',
            'rank'     => 'polygon',
            'file'     => 'RF.geojson',
            'visible'  => false,
            'style'      => [
                'color'        => 'from_geojson',
                'fill_opacity' => 0.6,
                'width'        => 1
            ],
            'popup'    => [
                'title'  => 'Tutupan Lahan',
                'fields' => [
                    'Keterangan' => 'Keterangan',
                    'Luas' => 'Luas Area',
                ],
            ],
        ],

                                             // Lingkungan Mitigasi Bencana //
                'Tanah' => [
            'label'    => 'Jenis Tanah',
            'category' => 'lmb',
            'geometry' => 'polygon',
            'rank'     => 'polygon',
            'file'     => 'Jenis Tanah.geojson',
            'visible'  => false,
            'style'      => [
                'color'        => 'from_geojson',
                'fill_opacity' => 0.6,
                'width'        => 1
            ],
            'popup'    => [
                'title'  => 'Jenis Tanah',
                'fields' => [
                    'Tanah' => 'Tanah',
                    'Luas' => 'Luas Area',
                ],
            ],
        ],


                                            // Perencanaan Pembangunan Wilayah //

            'PR' => [
            'label'    => 'Pola Ruang',
            'category' => 'ppw',
            'geometry' => 'polygon',
            'rank'     => 'polygon',
            'file'     => 'Pola Ruang.geojson',
            'visible'  => false,
            'style'      => [
                'color'        => 'from_geojson',
                'fill_opacity' => 0.6,
                'width'        => 1
            ],
            'popup'    => [
                'title'  => 'Pola Ruang',
                'fields' => [
                    'NAMOBJ' => 'Kawasan',
                    'Luas' => 'Luas Area',
                ],
            ],
        ],
    ],
];
