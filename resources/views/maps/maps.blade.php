@extends('layouts.head')

{{-- @section('container') --}}
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-lg-4">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-2 d-flex flex-row align-items-center justify-content-between">

                    <a class="font-weight-bold  nav-link" href="/dashboard" style="color: black;">
                        <i class="fas fa-fw fa-home"></i>
                        <span>Dashboard</span></a>

                    <h6 class="m-0 font-weight-bold" style="color: black; text-decoration: underline;">Angka Pada Marker
                        Merupakan Urutan Prioritas Pengangkutan Sampah</h6>

                    <h6 class="m-0 font-weight-bold " style="color: black;">Peta Tempat Sampah</h6>
                </div>

                <!-- Card Body -->
                <div class="card-body">

                    <head>
                        <title>PETAPA (Pemantauan Tempat Sampah)</title>
                        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
                        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
                        <script>
                            // Fungsi untuk melakukan refresh halaman setiap 5 menit (300,000 milidetik)
                            function autoRefresh() {
                                location.reload();
                            }

                            // Atur interval refresh
                            setTimeout(autoRefresh, 10000); // 300,000 ms = 5 menit
                        </script>



                        <style>
                            html,
                            body {
                                height: 100%;
                                margin: 0;
                            }

                            .leaflet-container {
                                height: 400px;
                                width: 600px;
                                max-width: 100%;
                                max-height: 100%;
                            }
                        </style>
                    </head>

                    <body>
                        {{-- <div id="map" style="width: 100%; height: 500px;"></div> --}}
                        <div id="map" style="width: 100%; height: 90vh;"></div>


                        <script>
                            var map = L.map('map', {
                                fullscreenControl: {
                                    pseudoFullscreen: false
                                }
                            }).setView([-0.056986, 109.349103], 16);

                            L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                                maxZoom: 20,
                                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                            }).addTo(map);


                            // Tambahkan marker di peta
                            var locations = [{
                                    "lat": -0.060109,
                                    "lng": 109.345409,
                                    "name": 'I',
                                    "volumeorganik": {{ $untan->volumeorganik }},
                                    "volumenonorganik": {{ $untan->volumenonorganik }},
                                    "volumeB3": {{ $untan->volumeB3 }},
                                    "volumetotaledge": {{ $untan->volumetotaledge }},
                                    "ranking": {{ $rankUntan['ranking'] }},
                                },

                                {
                                    "lat": -0.062003,
                                    "lng": 109.348687,
                                    "name": 'III',
                                    "volumeorganik": {{ $rusunawa->volumeorganik }},
                                    "volumenonorganik": {{ $rusunawa->volumenonorganik }},
                                    "volumeB3": {{ $rusunawa->volumeB3 }},
                                    "volumetotaledge": {{ $rusunawa->volumetotaledge }},
                                    "ranking": {{ $rankRusunawa['ranking'] }},
                                },
                                {
                                    "lat": -0.053803,
                                    "lng": 109.347326,
                                    "name": 'II',
                                    "volumeorganik": {{ $polnep->volumeorganik }},
                                    "volumenonorganik": {{ $polnep->volumenonorganik }},
                                    "volumeB3": {{ $polnep->volumeB3 }},
                                    "volumetotaledge": {{ $polnep->volumetotaledge }},
                                    "ranking": {{ $rankPolnep['ranking'] }},
                                },

                            ];

                            // console.log(locations);

                            for (i in locations) {
                                var volumetotaledge = locations[i].volumetotaledge;
                                var ranking = locations[i].ranking;

                                // Hitung persentase volumetotaledge terhadap 100%
                                var volumetotaledgePercentage = (volumetotaledge / 100) * 100;

                                var iconUrl = '';

                                // Menentukan jenis ikon marker berdasarkan ranking dan persentase volumetotaledge
                                if (ranking === 1) {
                                    if (volumetotaledgePercentage <= 33) {
                                        iconUrl = '{{ asset('assets/img/tpshijau1.png') }}'; // Ikon hijau untuk ranking 1 dan volume rendah
                                    } else if (volumetotaledgePercentage <= 66) {
                                        iconUrl = '{{ asset('assets/img/tpskuning1.png') }}'; // Ikon kuning untuk ranking 1 dan volume sedang
                                    } else {
                                        iconUrl = '{{ asset('assets/img/tpsmerah1.png') }}'; // Ikon merah untuk ranking 1 dan volume tinggi
                                    }
                                } else if (ranking === 2) {
                                    if (volumetotaledgePercentage <= 33) {
                                        iconUrl = '{{ asset('assets/img/tpshijau2.png') }}'; // Ikon hijau untuk ranking 2 dan volume rendah
                                    } else if (volumetotaledgePercentage <= 66) {
                                        iconUrl = '{{ asset('assets/img/tpskuning2.png') }}'; // Ikon kuning untuk ranking 2 dan volume sedang
                                    } else {
                                        iconUrl = '{{ asset('assets/img/tpsmerah2.png') }}'; // Ikon merah untuk ranking 2 dan volume tinggi
                                    }
                                } else if (ranking === 3) {
                                    if (volumetotaledgePercentage <= 33) {
                                        iconUrl = '{{ asset('assets/img/tpshijau3.png') }}'; // Ikon hijau untuk ranking 3 dan volume rendah
                                    } else if (volumetotaledgePercentage <= 66) {
                                        iconUrl = '{{ asset('assets/img/tpskuning3.png') }}'; // Ikon kuning untuk ranking 3 dan volume sedang
                                    } else {
                                        iconUrl = '{{ asset('assets/img/tpsmerah3.png') }}'; // Ikon merah untuk ranking 3 dan volume tinggi
                                    }
                                } else if (ranking === 4) {
                                    if (volumetotaledgePercentage <= 33) {
                                        iconUrl = '{{ asset('assets/img/tpshijau4.png') }}'; // Ikon hijau untuk ranking 4 dan volume rendah
                                    } else if (volumetotaledgePercentage <= 66) {
                                        iconUrl = '{{ asset('assets/img/tpskuning4.png') }}'; // Ikon kuning untuk ranking 4 dan volume sedang
                                    } else {
                                        iconUrl = '{{ asset('assets/img/tpsmerah4.png') }}'; // Ikon merah untuk ranking 4 dan volume tinggi
                                    }
                                }

                                var warnaIcon = L.icon({
                                    iconUrl: iconUrl,
                                    iconSize: [50, 90],
                                    shadowSize: [50, 64],
                                    iconAnchor: [22, 94],
                                    popupAnchor: [-3, -76]
                                });

                                var marker = L.marker([locations[i].lat, locations[i].lng], {
                                    icon: warnaIcon
                                }).addTo(map);


                                var popupContent = `
                                    <b>Prioritas pengambilan ke: </b><strong>${locations[i].ranking}</strong> <br>
                                    <b>Nama Lokasi: </b> <strong>${locations[i].name}</strong><br>
                                    <div class="progress-container">
                                        <div class="volume-label">Tempat Sampah 1: ${locations[i].volumeorganik}%</div>
                                        <div class="progress">
                                            <div class="progress-bar ${getColorCategory(locations[i].volumeorganik)}" style="width: ${locations[i].volumeorganik}%;"></div>
                                        </div>
                                    </div>
                                    <div class="progress-container">
                                        <div class="volume-label">Tempat Sampah 2: ${locations[i].volumenonorganik}%</div>
                                        <div class="progress">
                                            <div class="progress-bar ${getColorCategory(locations[i].volumenonorganik)}" style="width: ${locations[i].volumenonorganik}%;"></div>
                                        </div>
                                    </div>
                                    <div class="progress-container">
                                        <div class="volume-label">Tempat Sampah 3: ${locations[i].volumeB3}%</div>
                                        <div class="progress">
                                            <div class="progress-bar ${getColorCategory(locations[i].volumeB3)}" style="width: ${locations[i].volumeB3}%;"></div>
                                        </div>
                                    </div>
                                    <div class="progress-container">
                                        <div class="volume-label">Volume Rata - Rata: ${locations[i].volumetotaledge}%</div>
                                        <div class="progress">
                                            <div class="progress-bar ${getColorCategory(locations[i].volumetotaledge)}" style="width: ${locations[i].volumetotaledge}%;"></div>
                                        </div>
                                    </div>`;

                                function getColorCategory(volume) {
                                    if (volume < 33.33) {
                                        return "bg-success"; // Warna hijau untuk kategori rendah
                                    } else if (volume < 66.67) {
                                        return "bg-warning"; // Warna kuning untuk kategori sedang
                                    } else {
                                        return "bg-danger"; // Warna merah untuk kategori tinggi
                                    }
                                }

                                marker.bindPopup(popupContent);


                            }
                            var siskom = [{
                                "lat": -0.0571164,
                                "lng": 109.3452931,
                                "name": 'IV',
                                "volumeorganik": {{ $siskom_tps1->kapasitas }},
                                "volumenonorganik": {{ $siskom_tps2->kapasitas }},
                                "volumetotaledge": {{ $total_siskom }},
                                "ranking": {{ $rankSiskom['ranking'] }},
                            }, ];



                            var popupSiskom = `
                                    <b>Prioritas pengambilan ke: </b><strong>${siskom[0].ranking}</strong> <br>
                                    <b>Nama Lokasi:</b> <strong>${siskom[0].name}</strong> <br>
                                    <div class="progress-container">
                                        <div class="volume-label">Tempat Sampah 1: ${siskom[0].volumeorganik}%</div>
                                        <div class="progress">
                                            <div class="progress-bar ${getColorCategory(siskom[0].volumeorganik)}" style="width: ${siskom[0].volumeorganik}%;"></div>
                                        </div>
                                    </div>
                                    <div class="progress-container">
                                        <div class="volume-label">Tempat Sampah 2: ${siskom[0].volumenonorganik}%</div>
                                        <div class="progress">
                                            <div class="progress-bar ${getColorCategory(siskom[0].volumenonorganik)}" style="width: ${siskom[0].volumenonorganik}%;"></div>
                                        </div>
                                    </div>
                                    <div class="progress-container">
                                        <div class="volume-label">Volume Rata - Rata: ${siskom[0].volumetotaledge}%</div>
                                        <div class="progress">
                                            <div class="progress-bar ${getColorCategory(siskom[0].volumetotaledge)}" style="width: ${siskom[0].volumetotaledge}%;"></div>
                                        </div>
                                    </div>`;

                            function getColorCategory(volume) {
                                if (volume < 33.33) {
                                    return "bg-success"; // Warna hijau untuk kategori rendah
                                } else if (volume < 66.67) {
                                    return "bg-warning"; // Warna kuning untuk kategori sedang
                                } else {
                                    return "bg-danger"; // Warna merah untuk kategori tinggi
                                }
                            }
                            var volumetotaledge = siskom[0].volumetotaledge;
                            var ranking = siskom[0].ranking;

                            // Hitung persentase volumetotaledge terhadap 100%
                            var volumetotaledgePercentage = (volumetotaledge / 100) * 100;

                            var iconUrl = '';

                            // Menentukan jenis ikon marker berdasarkan ranking dan persentase volumetotaledge
                            if (ranking === 1) {
                                if (volumetotaledgePercentage <= 33) {
                                    iconUrl = '{{ asset('assets/img/tpshijau1.png') }}'; // Ikon hijau untuk ranking 1 dan volume rendah
                                } else if (volumetotaledgePercentage <= 66) {
                                    iconUrl = '{{ asset('assets/img/tpskuning1.png') }}'; // Ikon kuning untuk ranking 1 dan volume sedang
                                } else {
                                    iconUrl = '{{ asset('assets/img/tpsmerah1.png') }}'; // Ikon merah untuk ranking 1 dan volume tinggi
                                }
                            } else if (ranking === 2) {
                                if (volumetotaledgePercentage <= 33) {
                                    iconUrl = '{{ asset('assets/img/tpshijau2.png') }}'; // Ikon hijau untuk ranking 2 dan volume rendah
                                } else if (volumetotaledgePercentage <= 66) {
                                    iconUrl = '{{ asset('assets/img/tpskuning2.png') }}'; // Ikon kuning untuk ranking 2 dan volume sedang
                                } else {
                                    iconUrl = '{{ asset('assets/img/tpsmerah2.png') }}'; // Ikon merah untuk ranking 2 dan volume tinggi
                                }
                            } else if (ranking === 3) {
                                if (volumetotaledgePercentage <= 33) {
                                    iconUrl = '{{ asset('assets/img/tpshijau3.png') }}'; // Ikon hijau untuk ranking 3 dan volume rendah
                                } else if (volumetotaledgePercentage <= 66) {
                                    iconUrl = '{{ asset('assets/img/tpskuning3.png') }}'; // Ikon kuning untuk ranking 3 dan volume sedang
                                } else {
                                    iconUrl = '{{ asset('assets/img/tpsmerah3.png') }}'; // Ikon merah untuk ranking 3 dan volume tinggi
                                }
                            } else if (ranking === 4) {
                                if (volumetotaledgePercentage <= 33) {
                                    iconUrl = '{{ asset('assets/img/tpshijau4.png') }}'; // Ikon hijau untuk ranking 4 dan volume rendah
                                } else if (volumetotaledgePercentage <= 66) {
                                    iconUrl = '{{ asset('assets/img/tpskuning4.png') }}'; // Ikon kuning untuk ranking 4 dan volume sedang
                                } else {
                                    iconUrl = '{{ asset('assets/img/tpsmerah4.png') }}'; // Ikon merah untuk ranking 4 dan volume tinggi
                                }
                            }

                            var warnaIcon2 = L.icon({
                                iconUrl: iconUrl,
                                iconSize: [50, 90],
                                shadowSize: [50, 64],
                                iconAnchor: [22, 94],
                                popupAnchor: [-3, -76]
                            });

                            var customIconUrl = iconUrl = '{{ asset('assets/img/tps.png') }}';

                            // Buat objek ikon dengan gambar kustom
                            var customIcon = L.icon({
                                iconUrl: customIconUrl,
                                iconSize: [20, 30], // Sesuaikan ukuran ikon sesuai kebutuhan
                                iconAnchor: [25, 50], // Posisi pusat bawah ikon, sesuaikan sesuai kebutuhan
                                popupAnchor: [0, -50] // Posisi popup di atas ikon, sesuaikan sesuai kebutuhan
                            });

                            var mainMarker = L.marker([siskom[0].lat, siskom[0].lng], {
                                icon: warnaIcon2
                            }).addTo(map);

                            var additionalMarkersGroup = L.layerGroup(); // Layer group to manage additional markers

                            mainMarker.on('click', function(e) {
                                var clickedLatLng = e.latlng;

                                var additionalMarkerPositions = [{
                                        lat: -0.056945,
                                        lng: 109.344877,
                                        name: 'tps 1'
                                    },
                                    {
                                        lat: -0.05727264036144048,
                                        lng: 109.3452504530016,
                                        name: 'tps 2'
                                    }
                                    // Add more positions as needed
                                ];

                                // Add additional markers to the layer group
                                additionalMarkerPositions.forEach(function(position) {
                                    var newMarker = L.marker([position.lat, position.lng], {
                                        icon: customIcon
                                    });
                                    newMarker.bindPopup(`<b>${position.name}</b><br>${popupSiskom}`);

                                    additionalMarkersGroup.addLayer(newMarker);

                                    // newMarker.on('click', function() {
                                    //     newMarker.openPopup();
                                    // });
                                });

                                // Add the layer group to the map
                                map.addLayer(additionalMarkersGroup);
                            });
                            additionalMarkersGroup.on('click', function(event) {
                                event.layer.openPopup();
                            });

                            // Close the additional markers when clicking elsewhere on the map
                            map.on('click', function(e) {
                                // Remove the layer group from the map
                                map.removeLayer(additionalMarkersGroup);
                            });

                            // Close the additional markers when closing the main marker popup
                            mainMarker.bindPopup(popupSiskom).on('popupclose', function() {
                                map.removeLayer(additionalMarkersGroup);
                            });
                            // .bindPopup(popupSiskom)
                            // .openPopup();
                        </script>



                    </body>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- @endsection --}}
