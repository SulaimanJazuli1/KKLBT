<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>WebGIS Desa Alat</title>
    <link rel="icon" href="{{ asset('img/Logo/HST.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@600;700&family=Instrument+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 + Bootstrap Icons: dibutuhkan ScriptGis.js (kelas d-flex, form-check-input, bi-*, dll.) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    {{-- Mapbox GL JS (versi dipatok). Jangan hapus logo & atribusi Mapbox (syarat layanan). --}}
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.8.0/mapbox-gl.css" rel="stylesheet">

    <style>
        :root {
            --gis-ink: #12302f;
            --gis-muted: #587370;
            --gis-rail: #123D32;
            --gis-rail-ink: #d6e7e4;
            --gis-pane: #f4f7f6;
            --gis-line: #d3dedb;
            --gis-accent: #0e7c86;
            --gis-amber: #e0a526;
            --gis-rail-w: 56px;
            --gis-pane-w: 340px;
            --bs-primary: #0e7c86;
            --bs-primary-rgb: 14, 124, 134;
        }

        html, body { height: 100%; margin: 0; }
        body {
            font-family: "Instrument Sans", system-ui, sans-serif;
            color: var(--gis-ink);
            overflow: hidden;
        }

        /* ---------- Kerangka ---------- */
        .gis-app { position: fixed; inset: 0; display: flex; }
        .gis-stage { position: relative; flex: 1; min-width: 0; height: 100%; }
        #map { position: absolute; inset: 0; }

        /* ---------- Sidebar: rail ikon + panel ---------- */
        .gis-side {
            display: flex;
            flex: none;
            height: 100%;
            z-index: 5;
            background: var(--gis-pane);
            box-shadow: 2px 0 14px rgba(15, 61, 62, .18);
        }
        .gis-rail {
            width: var(--gis-rail-w);
            flex: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            padding: calc(12px + env(safe-area-inset-top, 0px)) 0 calc(12px + env(safe-area-inset-bottom, 0px));
            background: var(--gis-rail);
        }
        .gis-rail-spacer { flex: 1; }
        .gis-rail-btn {
            position: relative;
            width: 40px;
            height: 40px;
            border: 0;
            border-radius: 10px;
            background: transparent;
            color: var(--gis-rail-ink);
            font-size: 1.15rem;
            line-height: 1;
        }
        .gis-rail-btn:hover { background: rgba(255, 255, 255, .1); }
        .gis-rail-btn.active { background: rgba(255, 255, 255, .14); color: #fff; }
        .gis-rail-btn.active::before {
            content: "";
            position: absolute;
            left: -8px; top: 10px; bottom: 10px;
            width: 3px;
            border-radius: 2px;
            background: var(--gis-amber);
        }
        .gis-rail-btn i { display: inline-block; transition: transform .25s ease; }
        .gis-side.is-collapsed [data-action="collapse"] i { transform: rotate(180deg); }

        .gis-panes {
            width: var(--gis-pane-w);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: width .25s ease;
        }
        .gis-side.is-collapsed .gis-panes { width: 0; }

        .gis-pane {
            display: none;
            flex: 1;
            flex-direction: column;
            min-height: 0;
            width: var(--gis-pane-w);
        }
        .gis-pane.active { display: flex; }

        .gis-pane-head {
            padding: calc(16px + env(safe-area-inset-top, 0px)) 16px 12px;
            border-bottom: 1px solid var(--gis-line);
        }
        .gis-pane-head h1,
        .gis-pane-head h2 {
            margin: 0;
            font-family: "Bricolage Grotesque", system-ui, sans-serif;
            font-weight: 700;
            font-size: 1.2rem;
            letter-spacing: -.01em;
        }
        .gis-pane-head p { margin: 2px 0 0; font-size: .8rem; color: var(--gis-muted); }
        .gis-pane-actions { display: flex; gap: 8px; margin-top: 12px; }
        .gis-pane-body {
            flex: 1;
            overflow-y: auto;
            padding: 12px 16px calc(20px + env(safe-area-inset-bottom, 0px));
        }
        .gis-hint { margin: 14px 2px 0; font-size: .78rem; color: var(--gis-muted); }

        /* ---------- Pohon layer (dibangun ScriptGis.js) ---------- */
        .gis-group {
            border: 1px solid var(--gis-line);
            border-radius: 10px;
            background: #fff;
            overflow: hidden;
        }
        .gis-group > summary { padding: 10px 12px; font-weight: 600; font-size: .92rem; }
        .gis-group > div { margin-right: 10px; padding-bottom: 8px; }
        .gis-cat > summary { padding: 4px 0; }
        .gis-group > summary,
        .gis-cat > summary { cursor: pointer; list-style: none; }
        .gis-group > summary::-webkit-details-marker,
        .gis-cat > summary::-webkit-details-marker { display: none; }
        .gis-group > summary::after,
        .gis-cat > summary::after {
            content: "";
            flex: none;
            width: 7px; height: 7px;
            margin-left: auto;
            border-right: 2px solid currentColor;
            border-bottom: 2px solid currentColor;
            color: var(--gis-muted);
            transform: rotate(45deg);
            transition: transform .2s ease;
        }
        .gis-group[open] > summary::after,
        .gis-cat[open] > summary::after { transform: rotate(225deg); }
        .gis-layer + .gis-layer { border-top: 1px dashed var(--gis-line); }
        .gis-layer .form-range { height: 1rem; margin-top: 2px; }
        .gis-layer.text-danger .small { text-decoration: line-through; }

        .form-range::-webkit-slider-thumb { background: var(--gis-accent); }
        .form-range::-moz-range-thumb { background: var(--gis-accent); }

        /* ---------- Basemap ---------- */
        .gis-basemap {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 10px;
            margin-bottom: 6px;
            border: 1px solid var(--gis-line);
            border-radius: 10px;
            background: #fff;
            cursor: pointer;
        }
        .gis-basemap:has(input:checked) { border-color: var(--gis-accent); box-shadow: 0 0 0 1px var(--gis-accent); }
        .gis-bm-swatch { flex: none; width: 44px; height: 32px; border-radius: 6px; border: 1px solid rgba(0, 0, 0, .12); }
        .gis-basemap strong { display: block; font-size: .9rem; }
        .gis-basemap small { color: var(--gis-muted); }

        /* ---------- Tombol ---------- */
        .btn-primary {
            --bs-btn-bg: #0e7c86; --bs-btn-border-color: #0e7c86;
            --bs-btn-hover-bg: #0b6770; --bs-btn-hover-border-color: #0b6770;
            --bs-btn-active-bg: #0a5c64; --bs-btn-active-border-color: #0a5c64;
        }
        .btn-outline-primary {
            --bs-btn-color: #0e7c86; --bs-btn-border-color: #0e7c86;
            --bs-btn-hover-bg: #0e7c86; --bs-btn-hover-border-color: #0e7c86;
            --bs-btn-active-bg: #0e7c86; --bs-btn-active-border-color: #0e7c86;
        }
        .gis-tool { display: flex; align-items: center; gap: 10px; width: 100%; text-align: left; margin-bottom: 8px; }

        /* ---------- Overlay di atas peta ---------- */
        #coord {
            position: absolute;
            top: calc(12px + env(safe-area-inset-top, 0px));
            left: 12px;
            z-index: 3;
            padding: 4px 10px;
            border-radius: 8px;
            background: rgba(255, 255, 255, .92);
            font-size: .78rem;
            font-variant-numeric: tabular-nums;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .15);
        }
        #tokenWarn {
            position: absolute;
            top: calc(52px + env(safe-area-inset-top, 0px));
            left: 50%;
            z-index: 4;
            max-width: min(92%, 460px);
            transform: translateX(-50%);
            margin: 0;
            font-size: .85rem;
        }

        /* ---------- Popup (diisi buildPopup di ScriptGis.js) ---------- */
        .mapboxgl-popup-content {
            padding: 12px;
            border-radius: 10px;
            font-family: "Instrument Sans", system-ui, sans-serif;
            color: var(--gis-ink);
        }
        .gis-popup-title {
            padding-bottom: 6px;
            border-bottom: 1px solid var(--gis-line);
            font-family: "Bricolage Grotesque", system-ui, sans-serif;
            font-size: .95rem;
        }

        :focus-visible { outline: 2px solid var(--gis-amber); outline-offset: 2px; }

        /* ---------- Layar kecil: panel menumpuk di atas peta ---------- */
        @media (max-width: 575.98px) {
            .gis-side { position: absolute; left: 0; top: 0; bottom: 0; }
            .gis-stage { margin-left: var(--gis-rail-w); }
            .gis-panes,
            .gis-pane { width: min(88vw, var(--gis-pane-w)); }
            .gis-side.is-collapsed .gis-panes { width: 0; }
        }

        @media (prefers-reduced-motion: reduce) {
            .gis-panes,
            .gis-rail-btn i,
            .gis-group > summary::after,
            .gis-cat > summary::after { transition: none; }
        }
    </style>
</head>
<body>

<div class="gis-app">

  {{-- ===== Sidebar: tab (data-tab) <-> panel (data-pane), is-collapsed diatur ScriptGis.js ===== --}}
  <aside class="gis-side" id="side" aria-label="Panel kontrol peta">

    <nav class="gis-rail" aria-label="Menu panel">
      <button type="button" class="gis-rail-btn" data-action="collapse" title="Ciutkan atau buka panel" aria-label="Ciutkan atau buka panel">
        <i class="bi bi-chevron-double-right"></i>
      </button>

      <button type="button" class="gis-rail-btn active" data-tab="layer" title="Layer" aria-label="Layer">
        <i class="bi bi-layers-fill"></i>
      </button>
      <button type="button" class="gis-rail-btn" data-tab="basemap" title="Peta dasar" aria-label="Peta dasar">
        <i class="bi bi-map"></i>
      </button>
      <button type="button" class="gis-rail-btn" data-tab="tampilan" title="Tampilan" aria-label="Tampilan">
        <i class="bi bi-sliders"></i>
      </button>

      <span class="gis-rail-spacer"></span>

        <button type="button"
                onclick="window.location.href='{{ route('beranda') }}'"
                class="gis-rail-btn flex items-center justify-center my-auto"
                title="Kembali ke Beranda"
                aria-label="Kembali ke Beranda">
            <i class="bi bi-house-door-fill"></i>
        </button>
    </nav>

    <div class="gis-panes">

      {{-- Panel 1: Layer. #layerTree diisi otomatis dari /gis/catalog (groups > categories > layers) --}}
      <section class="gis-pane active" data-pane="layer" aria-label="Layer peta">
        <header class="gis-pane-head">
          <div class="d-flex align-items-center gap-2 mb-3">
        {{-- Logo Desa di samping judul utama WebGIS --}}
        <img src="{{ asset('img/Logo/HST.png') }}" alt="Logo Desa Alat" style="width: 36px; height: 36px; object-fit: contain;">
        <h1 class="h4 mb-0 fw-bold text-dark">WebGIS Desa Alat</h1>
        </div>
          <div class="gis-pane-actions">
            <button type="button" class="btn btn-sm btn-outline-primary" data-action="show-all">Tampilkan semua</button>
            <button type="button" class="btn btn-sm btn-outline-secondary" data-action="hide-all">Sembunyikan semua</button>
          </div>
        </header>
        <div class="gis-pane-body">
          <div id="layerTree" aria-live="polite">
            <p class="small text-secondary m-0">Memuat katalog layer…</p>
          </div>
        </div>
      </section>

      {{-- Panel 2: Basemap. value = URL style Mapbox yang dibaca script --}}
      <section class="gis-pane" data-pane="basemap" aria-label="Peta dasar">
        <header class="gis-pane-head">
          <h2>Peta dasar</h2>
        </header>
        <div class="gis-pane-body">
          <label class="gis-basemap">
            <input class="form-check-input m-0" type="radio" name="basemap" value="mapbox://styles/mapbox/streets-v12" checked>
            <span class="gis-bm-swatch" style="background:linear-gradient(135deg,#e8e4d8 0 45%,#a8d4e6 45% 70%,#f6cf65 70%)"></span>
            <span><strong>Jalan</strong></span>
          </label>
            <label class="gis-basemap">
                <input class="form-check-input m-0" type="radio" name="basemap" value="mapbox://styles/mapbox/satellite-v9">
                <span class="gis-bm-swatch" style="background:linear-gradient(135deg,#2f4a2b,#5b6d3c 55%,#1f3b4d)"></span>
                <span><strong>Satelit</strong></span>
            </label>
          <label class="gis-basemap">
            <input class="form-check-input m-0" type="radio" name="basemap" value="mapbox://styles/mapbox/outdoors-v12">
            <span class="gis-bm-swatch" style="background:linear-gradient(135deg,#d8e8c4 0 50%,#b9d8a0 50% 75%,#9cc4dc 75%)"></span>
            <span><strong>Medan</strong></span>
          </label>
          <label class="gis-basemap">
            <input class="form-check-input m-0" type="radio" name="basemap" value="mapbox://styles/mapbox/light-v11">
            <span class="gis-bm-swatch" style="background:linear-gradient(135deg,#f5f5f5,#dcdcdc)"></span>
            <span><strong>Terang</strong></span>
          </label>
          <label class="gis-basemap">
            <input class="form-check-input m-0" type="radio" name="basemap" value="mapbox://styles/mapbox/dark-v11">
            <span class="gis-bm-swatch" style="background:linear-gradient(135deg,#2b2f36,#13161a)"></span>
            <span><strong>Gelap</strong></span>
          </label>
        </div>
      </section>


{{-- Panel 3: Tampilan Peta --}}
      <section class="gis-pane" data-pane="tampilan" aria-label="Tampilan peta">
        <header class="gis-pane-head">
          <h2>Tampilan</h2>
        </header>
        <div class="gis-pane-body">

          {{-- 1. Kembali ke Desa Alat --}}
          <button type="button" class="btn btn-outline-primary gis-tool mb-3" data-action="reset-view">
            <i class="bi bi-bullseye"></i><span>Kembali ke Desa Alat</span>
          </button>

            {{-- 2. Kotak Tampilan Miring (3D) - Ditambahkan pointer-events: none pada teks/ikon --}}
          <div class="btn btn-outline-primary gis-tool px-3 py-2 mb-3 text-start d-block h-auto" style="cursor: pointer;" id="btnTogglePitch">
            <div class="d-flex align-items-center gap-2 fw-medium text-dark" style="pointer-events: none;">
              <i class="bi bi-box fs-5 text-primary"></i><span>Tampilan miring (3D)</span>
            </div>

            <div class="range mt-2 pt-2 border-top border-secondary-subtle" id="pitchControlBox" style="display: none;" onclick="event.stopPropagation();">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="small text-muted">Kemiringan Peta</span>
                <span id="pitchVal" class="small fw-bold text-dark" style="font-size: 0.95rem;">0°</span>
              </div>
              <input type="range" id="pitchRange" class="form-range" min="0" max="85" value="0" step="1">
            </div>
          </div>

            {{-- 3. Kotak Elevasi Gunung (Terrain) - Ditambahkan pointer-events: none di pembungkus teks agar seluruh area bisa diklik --}}
          <div class="btn btn-outline-primary gis-tool px-3 py-2 mb-3 text-start d-block h-auto" style="cursor: pointer;" id="terrainCardBox">
            <div class="d-flex align-items-center gap-2 fw-medium text-dark" style="pointer-events: none;">
              <i class="bi bi-layers fs-5 text-primary"></i><span>Elevasi Gunung (Terrain)</span>
            </div>

            <div class="range mt-2 pt-2 border-top border-secondary-subtle" id="terrainExagBox" style="display: none;" onclick="event.stopPropagation();">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="small text-muted">Skala Ketinggian</span>
                <span id="terrainExagVal" class="small fw-bold text-dark" style="font-size: 0.95rem;">100%</span>
              </div>
              <input type="range" id="terrainExagRange" class="form-range" min="0" max="175" value="100" step="10">
            </div>
          </div>

        </div>
      </section>

    </div>
  </aside>

  {{-- ===== Peta ===== --}}
  <main class="gis-stage">
    <div id="map" role="application" aria-label="Peta Kalimantan Selatan"></div>
    <div id="coord" aria-live="off">Arahkan kursor ke peta</div>
    <div id="tokenWarn" class="alert alert-warning d-none" role="alert">
      Token Mapbox belum diatur.
    </div>
  </main>

</div>

<script>
  const MAPBOX_ACCESS_TOKEN = "{{ env('MAPBOX_ACCESS_TOKEN') }}";
  window.GIS_CATALOG_URL = @json(route('gis.catalog'));
</script>
<script src="https://api.mapbox.com/mapbox-gl-js/v3.8.0/mapbox-gl.js"></script>
<script src="{{ asset('gis/script/ScriptGis.js') }}"></script>

</body>
</html>
