<?php

return [
    'groups' => [
        'fasilitas' => [
            'label' => 'Fasilitas Umum',
            'icon' => 'bi-building-fill',
        ],
        'utilitas' => [
            'label' => 'Prasarana Utilitas',
            'icon'  => 'bi-lightning-charge-fill',
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
        'listrik' => ['label' => 'Jaringan Listrik', 'group' => 'utilitas'],


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

                'Trafo' => [
            'label'    => 'Trafo Listrik',
            'category' => 'listrik',
            'geometry' => 'point',
            'rank'     => 'point',
            'file'     => 'trafo.geojson',
            'visible'  => true,
            'minzoom'  => null,
            'label_field' => 'NAMOBJ',
            'style'    => [
                'type'     => 'bootstrap-icon',
                'icon'     => 'bi-lightning-charge-fill',
                'color'    => '#f59e0b',
                'size'     => '24px',
                'bg_color' => '#ffffff',
            ],
            'popup'    => [
                'title'  => 'Trafo',             // atribut untuk judul popup
                'fields' => [                   // atribut => label tampilan
                    'NAMOBJ' => 'Nama Fasilitas',
                ],
                'image'  => [                   // opsional
                    'field' => 'foto',          // atribut berisi NAMA FILE gambar
                    'dir'   => 'img/WebGIS/Fasum',    // folder di /public
                ],
            ],
        ],

        'Pamsimas' => [
            'label'    => 'Pamsimas',
            'category' => 'air_bersih',
            'geometry' => 'point',
            'rank'     => 'point',
            'file'     => 'pamsimas.geojson',
            'visible'  => true,
            'minzoom'  => null,
            'label_field' => 'NAMOBJ',
            'style'    => [
                'type'     => 'bootstrap-icon',
                'icon'     => 'bi-droplet-fill',
                'color'    => '#0284c7',
                'size'     => '24px',
                'bg_color' => '#ffffff',
            ],
            'popup'    => [
                'title'  => 'Pamsimas',             // atribut untuk judul popup
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
                    'REMARK'=> 'Jenis Fasilitas',
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
            'style'    => ['color' => '#38bdf8', 'width' => 2.5],   // opsional: 'dash' => [2, 2]
            'popup'    => [
                'title'  => 'Aliran Sungai',
                'fields' => [
                    // 'Panjang' => 'Panjang Sungai',
                ],
            ],
        ],

                'Jaringan' => [
            'label'    => 'Sistem Jaringan',
            'category' => 'listrik',
            'geometry' => 'line',
            'rank'     => 'lineSungai',
            'file'     => 'Sistem Jaringan.geojson',
            'visible'  => false,
            'style'    => ['color' => '#F59E0B', 'width' => 0.5],   // opsional: 'dash' => [2, 2]
            'popup'    => [
                'title'  => 'Aliran Sungai',
                'fields' => [
                    'LN_ENERGI' => 'Jenis Kelistrikan',
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
            'style'    => ['color' => '#030303', 'width' => 1],   // opsional: 'dash' => [2, 2]
            'popup'    => [
                'title'  => 'Jalan',
                'fields' => [
                    'REMARK' => 'Jalan Lokal',
                    'Panjang' => 'Panjang Jalan',
                ],
            ],
        ],

        'Admin' => [
            'label'    => 'Batas Desa',
            'category' => 'administrasi',
            'geometry' => 'polygon',
            'rank'     => 'polygon',
            'file'     => 'RT.geojson',
            'visible'  => true,
            'style'      => [
                'color'        => 'from_geojson',
                'fill_opacity' => 0.6,
                'width'        => 1
            ],
            'popup'    => [
                'title'  => 'RT',
                'fields' => [
                    'BatasRT' => 'RT',
                    'luas' => 'Luas Area',
                ],
            ],
        ],

                                            // Sistem Informasi Geografis

        'NDVI20' => [
            'label'    => 'NDVI (Normalized Difference Vegetation Index) 2020',
            'category' => 'sig',
            'geometry' => 'polygon',
            'rank'     => 'polygon',
            'file'     => 'NDVI20.geojson',
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

        'NDVI25' => [
            'label'    => 'NDVI (Normalized Difference Vegetation Index) 2025',
            'category' => 'sig',
            'geometry' => 'polygon',
            'rank'     => 'polygon',
            'file'     => 'NDVI25.geojson',
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

        'NDBI20' => [
            'label'    => 'NDBI (Normalized Difference Built-up Index) 2020',
            'category' => 'sig',
            'geometry' => 'polygon',
            'rank'     => 'polygon',
            'file'     => 'NDBI20.geojson',
            'visible'  => false,
            'style'      => [
                'color'        => 'from_geojson',
                'fill_opacity' => 0.6,
                'width'        => 1
            ],
            'popup'    => [
                'title'  => 'Index Vegetasi',
                'fields' => [
                    'Nilai' => 'Nilai NBVI',
                    'Kelas' => 'Kelas',
                    'Keterangan' => 'Keterangan',
                    'luas' => 'Luas Area',
                ],
            ],
        ],

        'NDBI25' => [
            'label'    => 'NDBI (Normalized Difference Built-up Index) 2025',
            'category' => 'sig',
            'geometry' => 'polygon',
            'rank'     => 'polygon',
            'file'     => 'NDBI25.geojson',
            'visible'  => false,
            'style'      => [
                'color'        => 'from_geojson',
                'fill_opacity' => 0.6,
                'width'        => 1
            ],
            'popup'    => [
                'title'  => 'Index Vegetasi',
                'fields' => [
                    'Nilai' => 'Nilai NDBI',
                    'Kelas' => 'Kelas',
                    'Keterangan' => 'Keterangan',
                    'luas' => 'Luas Area',
                ],
            ],
        ],

        // 'Lereng' => [
        //     'label'    => 'Kemiringan Lereng',
        //     'category' => 'sig',
        //     'geometry' => 'polygon',
        //     'rank'     => 'polygon',
        //     'file'     => 'Lereng.geojson',
        //     'visible'  => false,
        //     'style'      => [
        //         'color'        => 'from_geojson',
        //         'fill_opacity' => 0.7,
        //         'width'        => 1
        //     ],
        //     'popup'    => [
        //         'title'  => 'Kemiringan Lereng',
        //         'fields' => [
        //             'klasifikasi' =>'Klasifikasi Lereng',
        //             'Luas' => 'Luas Keseluruhan',
        //         ],
        //     ],
        // ],

        //         'Ketinggian' => [
        //     'label'    => 'Ketinggian',
        //     'category' => 'sig',
        //     'geometry' => 'polygon',
        //     'rank'     => 'polygon',
        //     'file'     => 'Ketinggian.geojson',
        //     'visible'  => false,
        //     'style'      => [
        //         'color'        => 'from_geojson',
        //         'fill_opacity' => 0.7,
        //         'width'        => 1
        //     ],
        //     'popup'    => [
        //         'title'  => 'Ketinggian',
        //         'fields' => [
        //             'klasifikasi' =>'Klasifikasi',
        //             'Luas' => 'Luas Keseluruhan',
        //         ],
        //     ],
        // ],

        //          'PL' => [
        //     'label'    => 'Penggunaan Lahan',
        //     'category' => 'sig',
        //     'geometry' => 'polygon',
        //     'rank'     => 'polygon',
        //     'file'     => 'RF.geojson',
        //     'visible'  => false,
        //     'style'      => [
        //         'color'        => 'from_geojson',
        //         'fill_opacity' => 0.6,
        //         'width'        => 1
        //     ],
        //     'popup'    => [
        //         'title'  => 'Penggunaan Lahan',
        //         'fields' => [
        //             'Keterangan' => 'Keterangan',
        //             'Luas' => 'Luas Area',
        //         ],
        //     ],
        // ],

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

            'PolaRuang' => [
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
