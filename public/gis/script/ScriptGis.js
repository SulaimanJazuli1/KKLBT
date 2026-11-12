
const mapboxToken = MAPBOX_ACCESS_TOKEN;
mapboxgl.accessToken = mapboxToken;
const INITIAL_VIEW = {
    center: [115.48225622511961, -2.628696515468055],
    zoom: 13,
    pitch: 0,
    bearing: 0,
};

const CONTROL_POS = "top-right";
const CATALOG_URL = window.GIS_CATALOG_URL;
const DEFAULT_COLOR = "#64748b";

// Urutan tumpukan: poligon (bawah) < garis < titik (atas)
const RANK = {
    polygon: 1,
    polygonLereng: 3,
    lineSungai: 5,
    lineJalan: 10,
    point: 20
};

const OPACITY_PROPS = {
    circle: ["circle-opacity", "circle-stroke-opacity"],
    symbol: ["text-opacity"],
    line: ["line-opacity"],
    fill: ["fill-opacity"],
};

/* =====================================================
   2. KATALOG & DATA
   ===================================================== */
let CATALOG = { categories: {}, layers: {} };
const dataCache = {}; // id -> GeoJSON yang sudah diunduh
const dataPromise = {}; // id -> Promise (mencegah fetch ganda)

function loadData(id) {
    if (!dataPromise[id]) {
        dataPromise[id] = fetch(CATALOG.layers[id].url, {
            headers: { Accept: "application/geo+json, application/json" },
        })
            .then((r) => {
                if (!r.ok) throw new Error("HTTP " + r.status);
                return r.json();
            })
            .then((json) => (dataCache[id] = json))
            .catch((err) => {
                delete dataPromise[id];
                throw err;
            });
    }
    return dataPromise[id];
}

/* =====================================================
   3. STATE
   ===================================================== */
const state = {
    basemap: "mapbox://styles/mapbox/streets-v12",
    visible: {}, // id -> boolean
    opacity: {}, // id -> 0..1
    activated: new Set(), // layer yang pernah diaktifkan (sudah/akan digambar)
};
let styleReady = false; // true setelah style peta selesai dimuat

/* =====================================================
   4. INISIALISASI PETA & PEMBUAT LAYER
   ===================================================== */
if (mapboxToken.startsWith("GANTI"))
    document.getElementById("tokenWarn").classList.remove("d-none");

const map = new mapboxgl.Map({
    container: "map",
    style: state.basemap,
    ...INITIAL_VIEW,
});

map.dragRotate.enable();
map.touchZoomRotate.enableRotation();

map.addControl(
    new mapboxgl.NavigationControl({ visualizePitch: true }),
    CONTROL_POS,
);
map.addControl(new mapboxgl.ScaleControl({ unit: "metric" }), "bottom-right");

/** Menerjemahkan 1 entri katalog menjadi 1-2 layer Mapbox. */
function buildLayerSpecs(id, def) {
    const s = def.style || {};
    const color = s.color || DEFAULT_COLOR;
    const layerRank = def.rank ? RANK[def.rank] : RANK[def.geometry];
    const common = {
        source: "src-" + id,
        metadata: { gisRank: layerRank },
    };
    if (def.minzoom != null) common.minzoom = def.minzoom;
    if (def.maxzoom != null) common.maxzoom = def.maxzoom;

    if (def.geometry === "polygon") {

        const fillColor = (s.color === "from_geojson")
            ? ["to-color", ["get", "warna"], ["get", "color"], ["get", "fill"], DEFAULT_COLOR]
                : color;

        return [
            {
                ...common,
                id: id + "-fill",
                type: "fill",
                paint: {
                    "fill-color": fillColor,
                    "fill-opacity": s.fill_opacity ?? 0.4,
                },
            },
        ];
    }
    if (def.geometry === "line") {
        const w = s.width ?? 2;
        return [
            {
                ...common,
                id: id + "-line",
                type: "line",
                layout: { "line-cap": "round", "line-join": "round" },
                paint: {
                    "line-color": color,
                    "line-opacity": 1,
                    "line-width": [
                        "interpolate",
                        ["linear"],
                        ["zoom"],
                        10,
                        w,
                        16,
                        w * 3,
                    ],
                    ...(s.dash ? { "line-dasharray": s.dash } : {}),
                },
            },
        ];
    }
// point
const r = s.radius ?? 5;
const specs = [
    {
        ...common,
        id: id + "-circle",
        type: "circle",
        paint: {
            "circle-color": color,
            "circle-radius": [
                "interpolate", ["linear"], ["zoom"],
                8, r * 0.6,
                14, r * 1.6,
            ],
            "circle-stroke-color": "#ffffff",
            "circle-stroke-width": 1.5,
            "circle-opacity": 1,
            "circle-stroke-opacity": 1,
        },
    },
];

    if (def.label_field) {
        specs.push({
            ...common,
            id: id + "-label",
            type: "symbol",
            minzoom: Math.max(def.minzoom ?? 0, 12),
            layout: {
                "text-field": ["get", def.label_field],
                "text-size": 11,
                "text-offset": [0, 1.3],
                "text-anchor": "top",
            },
            paint: {
                "text-color": "#1f2933",
                "text-halo-color": "#ffffff",
                "text-halo-width": 1.4,
                "text-opacity": 1,
            },
        });
    }
    return specs;
}

/** Cari layer pertama yang berpangkat lebih tinggi, agar layer baru disisipkan di bawahnya. */
function beforeIdFor(rank) {
    const found = map
        .getStyle()
        .layers.find((l) => l.metadata && l.metadata.gisRank > rank);
    return found ? found.id : undefined;
}

function drawLayer(id, data) {
    const def = CATALOG.layers[id];
    const src = "src-" + id;
    if (!map.getSource(src)) map.addSource(src, { type: "geojson", data });
    buildLayerSpecs(id, def).forEach((spec) => {
        if (!map.getLayer(spec.id))
            map.addLayer(spec, beforeIdFor(spec.metadata.gisRank));
    });
    applyLayerState(id);
}

function applyLayerState(id) {
    const on = state.visible[id];
    buildLayerSpecs(id, CATALOG.layers[id]).forEach((spec) => {
        if (!map.getLayer(spec.id)) return;
        map.setLayoutProperty(spec.id, "visibility", on ? "visible" : "none");
        const base = spec.type === "fill" ? spec.paint["fill-opacity"] : 1;
        OPACITY_PROPS[spec.type].forEach((p) =>
            map.setPaintProperty(spec.id, p, base * state.opacity[id]),
        );
    });
}

/** Lazy loading: data baru diunduh saat layer pertama kali diaktifkan. */
async function ensureLayer(id) {
    state.activated.add(id);
    const data = await loadData(id);
    if (styleReady) drawLayer(id, data);
}

/** Setelah ganti basemap, semua source/layer hilang: gambar ulang dari cache. */
function restore() {
    state.activated.forEach((id) => {
        if (dataCache[id]) drawLayer(id, dataCache[id]);
    });
}

map.on("style.load", () => {
    styleReady = true;
    restore();
});

function setVisible(id, on) {
    state.visible[id] = on;
    const cb = document.querySelector(`[data-toggle="${id}"]`);
    if (cb) cb.checked = on;
    if (!on) {
        applyLayerState(id);
        return;
    }
    ensureLayer(id)
        .then(() => applyLayerState(id))
        .catch((err) => {
            console.error("Gagal memuat layer " + id, err);
            state.visible[id] = false;
            if (cb) {
                cb.checked = false;
                const row = cb.closest(".gis-layer");
                if (row) {
                    row.classList.add("text-danger");
                    row.title = "Gagal memuat data";
                }
            }
            syncCategories();
        });
}

/* =====================================================
   5. INTERAKSI PETA (popup, kursor, koordinat)
   ===================================================== */
const coordEl = document.getElementById("coord");

function hit(point) {
    const ids = Object.values(CATALOG.layers)
        .map((d) => d._main)
        .filter((lid) => lid && map.getLayer(lid));
    if (!ids.length) return undefined;
    const box = [
        [point.x - 4, point.y - 4],
        [point.x + 4, point.y + 4],
    ]; // toleransi klik untuk garis/titik
    return map.queryRenderedFeatures(box, { layers: ids })[0];
}

function el(tag, className, text) {
    const n = document.createElement(tag);
    if (className) n.className = className;
    if (text != null) n.textContent = text; // textContent: aman dari injeksi HTML
    return n;
}

/** Mendapatkan warna spesifik objek (mendukung layer statis maupun 'from_geojson') */
function getFeatureColor(def, props) {
    const s = def.style || {};
    if (s.color === "from_geojson") {
        // Mengambil warna dari properti GeoJSON (warna, color, atau fill)
        return props.warna || props.color || props.fill || DEFAULT_COLOR;
    }
    return s.color || DEFAULT_COLOR;
}

function buildPopup(id, props) {
    const def = CATALOG.layers[id];
    const cfg = def.popup || {};
    const box = el("div", "gis-popup");

    // 1. Gambar Dinamis
    const img = cfg.image;
    if (img && props[img.field]) {
        const rawName = String(props[img.field]).trim();
        const fileName = rawName + (img.ext || ".png");
        const url = img.base_url + "/" + encodeURI(fileName);

        const a = el("a", "gis-popup-img");
        a.href = url;
        a.target = "_blank";
        a.rel = "noopener";

        const im = document.createElement("img");
        im.loading = "lazy";
        im.alt = rawName;
        im.src = url;
        im.style.cssText = "display:block;width:100%;max-height:140px;object-fit:cover;border-radius:6px;margin-bottom:8px";
        im.onerror = () => a.remove();

        a.appendChild(im);
        box.appendChild(a);
    }

    // 2. Judul Popup Dilengkapi Kotak Indikator Warna (Legenda)
    const titleContainer = el("div", "gis-popup-title mb-2 d-flex align-items-center gap-2 pb-2 border-bottom");
    const color = getFeatureColor(def, props);

    // Membuat bentuk kotak warna sesuai geometri layer (titik, garis, atau poligon)
    const swatch = document.createElement("span");
    const shape = def.geometry === "point"
        ? "width:12px;height:12px;border-radius:50%"
        : def.geometry === "line"
          ? "width:16px;height:3px"
          : "width:14px;height:12px;opacity:.85;border:1px solid rgba(0,0,0,0.2)";
    swatch.style.cssText = `flex:none;display:inline-block;background:${color};${shape}`;

    const titleText = el("strong", "flex-grow-1 m-0", def.label);
    titleContainer.append(swatch, titleText);
    box.appendChild(titleContainer);

    function titleCase(str) {
        if (!str) return "";
        return String(str).toLowerCase().replace(/(^|\s)\S/g, (L) => L.toUpperCase());
    }

    // 3. Render Daftar Informasi Menggunakan Tabel HTML (Titik Dua Sejajar)
    const table = document.createElement("table");
    table.style.cssText = "width:100%; border-collapse:collapse; font-size:0.85rem; margin-top:4px;";

    Object.entries(cfg.fields || {}).forEach(([key, labelText]) => {
        const v = props[key];
        if (v == null || v === "") return;

        const cleanLabel = String(labelText).replace(":", "").trim();

        const tr = document.createElement("tr");

        const tdLabel = document.createElement("td");
        tdLabel.style.cssText = "color:var(--muted); padding:2px 0; white-space:nowrap; vertical-align:top;";
        tdLabel.textContent = cleanLabel;

        const tdColon = document.createElement("td");
        tdColon.style.cssText = "color:var(--muted); padding:2px 6px; vertical-align:top; text-align:center;";
        tdColon.textContent = ":";

        const tdVal = document.createElement("td");
        tdVal.style.cssText = "color:var(--ink); padding:2px 0; vertical-align:top; word-break:break-word;";
        tdVal.textContent = titleCase(v);

        tr.append(tdLabel, tdColon, tdVal);
        table.appendChild(tr);
    });

    box.appendChild(table);
    return box;
}

map.on("click", (e) => {
    const f = hit(e.point);
    if (!f) return;
    const id = String(f.source).replace(/^src-/, "");
    if (!CATALOG.layers[id]) return;
    const at = f.geometry.type === "Point" ? f.geometry.coordinates : e.lngLat;
    new mapboxgl.Popup({ offset: 12, closeButton: false, maxWidth: "260px" })
        .setLngLat(at)
        .setDOMContent(buildPopup(id, f.properties))
        .addTo(map);
});
map.on("mousemove", (e) => {
    map.getCanvas().style.cursor = hit(e.point) ? "pointer" : "";
    if (coordEl)
        coordEl.textContent = `${e.lngLat.lat.toFixed(5)}, ${e.lngLat.lng.toFixed(5)}`;
});

/* =====================================================
   6. PANEL LAYER (dibangun otomatis dari katalog)
   ===================================================== */
function swatchEl(def) {
    const c = (def.style && def.style.color) || DEFAULT_COLOR;
    const s = document.createElement("span");
    const shape =
        def.geometry === "point"
            ? "width:12px;height:12px;border-radius:50%"
            : def.geometry === "line"
              ? "width:16px;height:3px"
              : `width:14px;height:12px;opacity:.7;border:1px solid ${c}`;
    s.style.cssText = `flex:none;display:inline-block;background:${c};${shape}`;
    return s;
}

function layerRow(id, def) {
    const row = el("div", "gis-layer py-1");
    const top = el("div", "d-flex align-items-center gap-2");

    const cb = document.createElement("input");
    cb.type = "checkbox";
    cb.className = "form-check-input m-0";
    cb.dataset.toggle = id;
    cb.addEventListener("change", () => {
        setVisible(id, cb.checked);
        syncCategories();
    });

    const name = el("span", "flex-grow-1 small", def.label);
    if (def.minzoom != null) name.title = "Tampil pada zoom ≥ " + def.minzoom;

    const zoomBtn = el(
        "button",
        "btn btn-sm btn-outline-secondary py-0 px-1",
        "⌖",
    );
    zoomBtn.type = "button";
    zoomBtn.title = "Zoom ke layer";
    zoomBtn.addEventListener("click", () => zoomToLayer(id));

    top.append(cb, swatchEl(def), name, zoomBtn);

    const range = document.createElement("input");
    range.type = "range";
    range.min = 0;
    range.max = 100;
    range.value = 100;
    range.className = "form-range";
    range.dataset.opacity = id;
    range.addEventListener("input", () => {
        state.opacity[id] = range.value / 100;
        applyLayerState(id);
    });

    row.append(top, range);
    return row;
}

function buildPanel() {
    const root = document.getElementById("layerTree");
    root.textContent = "";

    const groups = CATALOG.groups || { default: 'Layer Peta' };
    const categories = CATALOG.categories || {};

    // Petakan layer berdasarkan kategori
    const byCat = {};
    Object.entries(CATALOG.layers).forEach(([id, def]) =>
        (byCat[def.category] ||= []).push(id),
    );

    // Petakan kategori berdasarkan group
    const byGroup = {};
    Object.entries(categories).forEach(([catId, cat]) => {
        const groupId = cat.group || 'default';
        (byGroup[groupId] ||= []).push(catId);
    });

    // Render Group (Dropdown Induk, misal: "Fasilitas Umum")
    Object.entries(groups).forEach(([groupId, groupDef]) => {
        const catIds = byGroup[groupId];
        if (!catIds || !catIds.length) return;

        // Mendukung format baru (berisi objek label & icon)
        const groupLabel = typeof groupDef === 'object' ? groupDef.label : groupDef;
        const groupIcon  = typeof groupDef === 'object' && groupDef.icon ? groupDef.icon : 'bi-folder';

        const groupDetails = el("details", "gis-group mb-2");

        // Aturan Accordion (Grup lain otomatis tertutup)
        groupDetails.addEventListener("toggle", () => {
            if (groupDetails.open) {
                document.querySelectorAll(".gis-group").forEach((otherGroup) => {
                    if (otherGroup !== groupDetails) {
                        otherGroup.open = false;
                    }
                });
            }
        });

        const groupSummary = el("summary", "d-flex align-items-center gap-2");

        // Membuat elemen ikon kecil secara dinamis
        const iconEl = document.createElement("i");
        iconEl.className = `bi ${groupIcon} fs-6 text-warning`;

        groupSummary.append(iconEl, el("span", null, groupLabel));
        groupDetails.appendChild(groupSummary);

        const groupBody = el("div", "ps-3 mt-2 border-start ms-2");

        // Render Sub-Kategori di dalam Group Induk
        catIds.forEach((catId) => {
            const cat = categories[catId];
            const ids = byCat[catId];
            if (!ids) return;

            const catDetails = el("details", "gis-cat mb-2");
            const catSummary = el("summary", "d-flex align-items-center gap-2 fw-semibold small");

            const catCb = document.createElement("input");
            catCb.type = "checkbox";
            catCb.className = "form-check-input m-0";
            catCb.dataset.cat = catId;
            catCb.addEventListener("change", () => {
                ids.forEach((id) => setVisible(id, catCb.checked));
                syncCategories();
            });

            catSummary.append(catCb, el("span", null, cat.label));
            catDetails.appendChild(catSummary);

            const catBody = el("div", "ps-4 mt-1");
            ids.forEach((id) => catBody.appendChild(layerRow(id, CATALOG.layers[id])));
            catDetails.appendChild(catBody);

            groupBody.appendChild(catDetails);
        });

        groupDetails.appendChild(groupBody);
        root.appendChild(groupDetails);
    });
}
function syncCategories() {
    document.querySelectorAll("[data-cat]").forEach((cb) => {
        const ids = Object.keys(CATALOG.layers).filter(
            (id) => CATALOG.layers[id].category === cb.dataset.cat,
        );
        const n = ids.filter((id) => state.visible[id]).length;
        cb.checked = ids.length > 0 && n === ids.length;
        cb.indeterminate = n > 0 && n < ids.length;
    });
}

function boundsOf(collection) {
    const b = new mapboxgl.LngLatBounds();
    (function walk(c) {
        typeof c[0] === "number" ? b.extend(c) : c.forEach(walk);
    })(collection.features.map((f) => f.geometry.coordinates));
    return b;
}

async function zoomToLayer(id) {
    try {
        const data = await loadData(id);
        if (!data.features.length) return;
        if (!state.visible[id]) {
            setVisible(id, true);
            syncCategories();
        }
        map.fitBounds(boundsOf(data), {
            padding: 80,
            maxZoom: 16,
            duration: 900,
        });
    } catch (err) {
        console.error("Gagal zoom ke layer " + id, err);
    }
}

function setAll(visible) {
    Object.keys(CATALOG.layers).forEach((id) => setVisible(id, visible));
    syncCategories();
}

/* =====================================================
   7. KONTROL LAIN (basemap, sidebar, aksi)
   ===================================================== */
document.querySelectorAll('input[name="basemap"]').forEach((el) =>
    el.addEventListener("change", () => {
        state.basemap = el.value;
        styleReady = false; // layer akan digambar ulang di style.load
        map.setStyle(el.value, { diff: false }); // diff:false = ganti style total, style.load pasti terpanggil
    }),
);

const side = document.getElementById("side");

if (window.innerWidth < 576) {
    side.classList.add("is-collapsed");
    setTimeout(() => map.resize(), 100);
}

const toggleSide = (collapse) => {
    side.classList.toggle("is-collapsed", collapse);
    setTimeout(() => map.resize(), 150);
    setTimeout(() => map.resize(), 320);
};

document.querySelectorAll("[data-tab]").forEach((btn) =>
    btn.addEventListener("click", () => {
        document
            .querySelectorAll("[data-tab]")
            .forEach((b) => b.classList.toggle("active", b === btn));
        document
            .querySelectorAll("[data-pane]")
            .forEach((p) =>
                p.classList.toggle(
                    "active",
                    p.dataset.pane === btn.dataset.tab,
                ),
            );
        if (side.classList.contains("is-collapsed")) toggleSide(false);
    }),
);

document.querySelectorAll("[data-action]").forEach((btn) =>
    btn.addEventListener("click", () => {
        switch (btn.dataset.action) {
            case "show-all":
                setAll(true);
                break;
            case "hide-all":
                setAll(false);
                break;
            case "reset-view":
                map.flyTo({ ...INITIAL_VIEW, duration: 1200 });
                btn.blur();
                break;
            case "toggle-pitch": {
                const isFlat = map.getPitch() < 10;

                if (isFlat) {
                    // Mengubah kemiringan ke 50 derajat agar mode 3D aktif dan bisa diputar
                    map.easeTo({ pitch: 50, bearing: 30, duration: 800 });
                    btn.classList.add("active");
                } else {
                    // Mengembalikan ke posisi datar jika diklik kembali
                    map.easeTo({ pitch: 0, bearing: 0, duration: 800 });
                    btn.classList.remove("active");
                }
                break;
            }
            case "collapse":
                toggleSide(!side.classList.contains("is-collapsed"));
                break;
        }
    }),
);

/* =====================================================
   8. START: ambil katalog -> bangun panel -> aktifkan layer default
   ===================================================== */
async function init() {
    const resp = await fetch(CATALOG_URL, {
        headers: { Accept: "application/json" },
    });
    if (!resp.ok) throw new Error("HTTP " + resp.status);
    CATALOG = await resp.json();

    Object.entries(CATALOG.layers).forEach(([id, def]) => {
        def._main = buildLayerSpecs(id, def)[0].id; // layer yang menerima klik
        state.visible[id] = false;
        state.opacity[id] = 1;
    });

    buildPanel();
    Object.entries(CATALOG.layers).forEach(([id, def]) => {
        if (def.visible) setVisible(id, true);
    });
    syncCategories();
}

init().catch((err) => {
    console.error("Katalog layer gagal dimuat", err);
    const root = document.getElementById("layerTree");
    if (root)
        root.textContent =
            "Katalog layer gagal dimuat. Periksa route /gis/katalog.";
});

/* =====================================================
   KONTROL TAMPILAN MIRING (3D)
   ===================================================== */
const btnTogglePitch = document.getElementById("btnTogglePitch");
const pitchControlBox = document.getElementById("pitchControlBox");
const pitchRange = document.getElementById("pitchRange");
const pitchVal = document.getElementById("pitchVal");

if (btnTogglePitch) {
    btnTogglePitch.addEventListener("click", (e) => {
        if (e.target.tagName === "INPUT" || e.target.tagName === "SPAN" || e.target.closest(".range")) {
            return;
        }

        const isHidden = pitchControlBox.style.display === "none" || pitchControlBox.style.display === "";
        const targetOpen = isHidden;

        pitchControlBox.style.display = targetOpen ? "block" : "none";

        const targetPitch = targetOpen ? 50 : 0;
        map.easeTo({ pitch: targetPitch, duration: 800 });

        if (targetOpen && pitchRange && pitchRange.value == "0") {
            pitchRange.value = "50";
            if (pitchVal) pitchVal.textContent = "50°";
        } else if (!targetOpen) {
            if (pitchRange) pitchRange.value = "0";
            if (pitchVal) pitchVal.textContent = "0°";
        }
    });
}

if (pitchRange) {
    pitchRange.addEventListener("input", (e) => {
        const pitch = parseFloat(e.target.value);
        if (pitchVal) pitchVal.textContent = pitch + "°";
        map.setPitch(pitch);
    });

    map.on("pitch", () => {
        const currentPitch = Math.round(map.getPitch());
        if (pitchRange && document.activeElement !== pitchRange) {
            pitchRange.value = currentPitch;
        }
        if (pitchVal && document.activeElement !== pitchRange) {
            pitchVal.textContent = currentPitch + "°";
        }
    });
}


/* =====================================================
   KONTROL ELEVASI GUNUNG / TERRAIN 3D (PERSENTASE)
   ===================================================== */
const terrainCardBox = document.getElementById("terrainCardBox");
const terrainExagBox = document.getElementById("terrainExagBox");
const terrainExagRange = document.getElementById("terrainExagRange");
const terrainExagVal = document.getElementById("terrainExagVal");

let isTerrainActive = false;

if (terrainCardBox) {
    terrainCardBox.addEventListener("click", (e) => {
        if (e.target.tagName === "INPUT" || e.target.tagName === "SPAN" || e.target.closest(".range")) {
            return;
        }

        const isHidden = terrainExagBox.style.display === "none" || terrainExagBox.style.display === "";
        const targetOpen = isHidden;

        terrainExagBox.style.display = targetOpen ? "block" : "none";
        isTerrainActive = targetOpen;

        if (!map.getSource("mapbox-dem")) {
            map.addSource("mapbox-dem", {
                type: "raster-dem",
                url: "mapbox://mapbox.mapbox-terrain-dem-v1",
                tileSize: 512,
                maxzoom: 14,
            });
        }

        if (targetOpen) {
            const rawVal = parseFloat(terrainExagRange ? terrainExagRange.value : 100);
            map.setTerrain({ source: "mapbox-dem", exaggeration: rawVal / 100 });
        } else {
            map.setTerrain(null);
        }
    });
}

if (terrainExagRange) {
    terrainExagRange.addEventListener("input", (e) => {
        const percent = parseInt(e.target.value);
        if (terrainExagVal) terrainExagVal.textContent = percent + "%";

        const exag = percent / 100;
        if (isTerrainActive) {
            map.setTerrain({ source: "mapbox-dem", exaggeration: exag });
        }
    });
}
