$(document).ready(function() {
    
    // Initialize Plugins
    $('.select2').select2({
        allowClear: true
    });

    // Global Leaflet map instances and language
    var compareMapInstance = null;
    var compareCurrentTileLayer = null;
    var monthlyMapInstance = null;
    var monthlyCurrentTileLayer = null;
    var monthlyMarkersLayer = null;
    var monthlyPolylinesLayer = null;
    var monthlyScansData = [];

    // Map Tile Providers (English by default, with Arabic & Satellite options)
    var MAP_TILES = {
        en: {
            name: "English (Street Map)",
            url: "https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}",
            options: {
                maxZoom: 19,
                attribution: 'Tiles &copy; Esri &mdash; English Map'
            }
        },
        ar: {
            name: "Arabic / Native (OSM)",
            url: "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
            options: {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors &mdash; Arabic Map'
            }
        },
        sat: {
            name: "Satellite Imagery",
            url: "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",
            options: {
                maxZoom: 19,
                attribution: 'Tiles &copy; Esri &mdash; Satellite Imagery'
            }
        }
    };

    var preferredMapLang = localStorage.getItem('thc_preferred_map_lang') || 'en';

    function createBaseMapLayers() {
        return {
            "English (Street)": L.tileLayer(MAP_TILES.en.url, MAP_TILES.en.options),
            "عربي (Arabic OSM)": L.tileLayer(MAP_TILES.ar.url, MAP_TILES.ar.options),
            "Satellite Imagery": L.tileLayer(MAP_TILES.sat.url, MAP_TILES.sat.options)
        };
    }

    function syncLanguageButtons(lang) {
        $('.btn-map-lang, .btn-compare-lang').removeClass('btn-primary active').addClass('btn-light');
        $('.btn-map-lang[data-lang="' + lang + '"], .btn-compare-lang[data-lang="' + lang + '"]').removeClass('btn-light').addClass('btn-primary active');
    }
    syncLanguageButtons(preferredMapLang);

    // Helper: Create Red Asset Pin Icon
    function getRedAssetIcon() {
        return L.divIcon({
            className: 'custom-pin-red',
            html: '<div style="background-color: #e53935; width: 32px; height: 32px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); border: 2px solid #ffffff; box-shadow: 0 2px 6px rgba(0,0,0,0.4); display: flex; align-items: center; justify-content: center;"><i class="icon-location4" style="color: white; transform: rotate(45deg); font-size: 15px;"></i></div>',
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -30]
        });
    }

    // Helper: Create Blue Janitor Scan Pin Icon
    function getBlueScanIcon() {
        return L.divIcon({
            className: 'custom-pin-blue',
            html: '<div style="background-color: #1e88e5; width: 32px; height: 32px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); border: 2px solid #ffffff; box-shadow: 0 2px 6px rgba(0,0,0,0.4); display: flex; align-items: center; justify-content: center;"><i class="icon-mobile" style="color: white; transform: rotate(45deg); font-size: 15px;"></i></div>',
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -30]
        });
    }

    // Setup Export Buttons defaults
    $.extend($.fn.dataTable.defaults, {
        autoWidth: false,
        dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            searchPlaceholder: 'Type to filter...',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 
                'first': 'First', 
                'last': 'Last', 
                'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 
                'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' 
            }
        }
    });

    // =========================================================================
    // 1. DATA TABLE: QR SCAN & LOCATION TRACKING REPORT
    // =========================================================================
    var tblScanTracking = $('#tblScanTracking').DataTable({
        "ajax": {
            "url": "../controller/janitor/execution_report_controller.php",
            "type": "POST",
            "data": function(d) {
                d.action = "list_scan_tracking";
                d.employee_id = $('#filter_janitor').val();
                d.asset_id = $('#filter_asset').val();
                d.scan_status = $('#filter_scan_status').val();
                d.from_date = $('#filter_from_date').val();
                d.to_date = $('#filter_to_date').val();
            }
        },
        "buttons": [
            {
                extend: 'excelHtml5',
                className: 'btn btn-light',
                text: '<i class="icon-file-excel text-success mr-1"></i> Excel Export',
                title: 'Janitor QR Scan Tracking Report',
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
            },
            {
                extend: 'pdfHtml5',
                className: 'btn btn-light',
                text: '<i class="icon-file-pdf text-danger mr-1"></i> PDF Export',
                title: 'Janitor QR Scan Tracking Report',
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
            }
        ],
        "columns": [
            { 
                "data": "attendance_date",
                "render": function(data, type, row) {
                    if (!data) return '';
                    var timeStr = row.attendance_time ? '<br><span class="badge badge-light font-weight-normal text-muted"><i class="icon-alarm mr-1"></i>' + row.attendance_time + '</span>' : '';
                    var dt = new Date(data);
                    var formatted = isNaN(dt.getTime()) ? data : dt.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
                    return '<span class="font-weight-semibold">' + formatted + '</span>' + timeStr;
                }
            },
            { 
                "data": "employee_name",
                "render": function(data, type, row) {
                    return '<span class="font-weight-semibold">' + (data || 'Janitor') + '</span>' + 
                           (row.employee_code ? '<br><small class="text-muted"><i class="icon-user mr-1"></i>' + row.employee_code + '</small>' : '');
                }
            },
            { 
                "data": "asset_code",
                "render": function(data, type, row) {
                    return '<span class="badge badge-light text-primary font-weight-bold">' + (data || '') + '</span>' + 
                           (row.asset_description ? '<br><small class="text-muted">' + row.asset_description + '</small>' : '');
                }
            },
            { 
                "data": "building_name",
                "render": function(data) {
                    return data ? '<span class="text-dark">' + data + '</span>' : '<span class="text-muted">-</span>';
                }
            },
            { 
                "data": "effective_asset_lat",
                "render": function(data, type, row) {
                    var lat = row.effective_asset_lat;
                    var lng = row.effective_asset_lng;
                    if (lat && lng && lat != '0' && lng != '0') {
                        var mapUrl = 'https://www.google.com/maps?q=' + lat + ',' + lng;
                        return '<a href="' + mapUrl + '" target="_blank" class="badge badge-light border border-danger text-danger font-size-sm p-1 px-2" title="View Asset GPS in Google Maps">' +
                               '<span class="map-dot-red mr-1"></span>' + parseFloat(lat).toFixed(4) + ', ' + parseFloat(lng).toFixed(4) + '</a>';
                    }
                    return '<span class="text-muted font-size-sm">Not Geocoded</span>';
                }
            },
            { 
                "data": "scan_lat",
                "render": function(data, type, row) {
                    var lat = row.scan_lat;
                    var lng = row.scan_lng;
                    if (lat && lng && lat != '0' && lng != '0') {
                        var mapUrl = 'https://www.google.com/maps?q=' + lat + ',' + lng;
                        return '<a href="' + mapUrl + '" target="_blank" class="badge badge-light border border-primary text-primary font-size-sm p-1 px-2" title="View Janitor Scan GPS in Google Maps">' +
                               '<span class="map-dot-blue mr-1"></span>' + parseFloat(lat).toFixed(4) + ', ' + parseFloat(lng).toFixed(4) + '</a>';
                    }
                    return '<span class="text-muted font-size-sm">No GPS</span>';
                }
            },
            { 
                "data": "distance_meters",
                "render": function(data) {
                    if (data === null || data === undefined) return '<span class="text-muted">-</span>';
                    var dist = parseFloat(data);
                    var badgeClass = 'badge-success';
                    var distText = dist < 1000 ? dist.toFixed(1) + ' m' : (dist / 1000).toFixed(2) + ' km';
                    
                    if (dist > 200) {
                        badgeClass = 'badge-danger';
                    } else if (dist > 50) {
                        badgeClass = 'badge-warning';
                    }

                    return '<span class="badge ' + badgeClass + ' font-size-sm px-2 py-1">' + distText + '</span>';
                }
            },
            { 
                "data": "scan_status",
                "render": function(data) {
                    if (data === 'Verified') {
                        return '<span class="badge badge-success"><i class="icon-checkmark3 mr-1"></i>Verified</span>';
                    } else if (data === 'Bypassed') {
                        return '<span class="badge badge-info"><i class="icon-shield-check mr-1"></i>Bypassed</span>';
                    } else if (data === 'Rejected' || data === 'Mismatch') {
                        return '<span class="badge badge-danger"><i class="icon-cross2 mr-1"></i>Mismatch</span>';
                    }
                    return '<span class="badge badge-secondary">' + (data || 'Recorded') + '</span>';
                }
            },
            { 
                "data": null,
                "orderable": false,
                "className": "text-center",
                "render": function(data, type, row) {
                    var empId = row.employee_id || '';
                    var attDate = row.attendance_date || '';
                    return '<div class="btn-group btn-group-sm">' +
                           '<button type="button" class="btn btn-outline-primary btn-compare-locations" ' +
                           'data-asset-code="' + (row.asset_code || '') + '" ' +
                           'data-asset-name="' + (row.asset_description || '') + '" ' +
                           'data-bldg-name="' + (row.building_name || '') + '" ' +
                           'data-janitor="' + (row.employee_name || '') + ' (' + (row.employee_code || '') + ')" ' +
                           'data-scan-lat="' + (row.scan_lat || '') + '" ' +
                           'data-scan-lng="' + (row.scan_lng || '') + '" ' +
                           'data-asset-lat="' + (row.effective_asset_lat || '') + '" ' +
                           'data-asset-lng="' + (row.effective_asset_lng || '') + '" ' +
                           'data-dist="' + (row.distance_meters || 0) + '" ' +
                           'data-status="' + (row.scan_status || '') + '" ' +
                           'data-time="' + (row.attendance_date || '') + ' ' + (row.attendance_time || '') + '">' +
                           '<i class="icon-map5 mr-1"></i> Compare</button>' +
                           '<button type="button" class="btn btn-outline-secondary btn-quick-month-history" ' +
                           'data-employee-id="' + empId + '" ' +
                           'data-date="' + attDate + '" ' +
                           'title="Inspect this Janitor\'s 1-Month Pin History on Map">' +
                           '<i class="icon-calendar52 mr-1"></i> Month Pins</button>' +
                           '</div>';
                }
            }
        ],
        "order": [[0, "desc"]]
    });

    // =========================================================================
    // 2. DATA TABLE: WORK ORDER EXECUTION LOGS
    // =========================================================================
    var tblExecutionReport = $('#tblExecutionReport').DataTable({
        "ajax": {
            "url": "../controller/janitor/execution_report_controller.php",
            "type": "POST",
            "data": function(d) {
                d.action = "list_executions";
                d.customer_id = $('#filter_customer').val();
                d.asset_id = $('#filter_asset').val();
                d.amc_ref_no = $('#filter_amc').val();
                d.employee_id = $('#filter_janitor').val();
                d.from_date = $('#filter_from_date').val();
                d.to_date = $('#filter_to_date').val();
            }
        },
        "buttons": [
            {
                extend: 'excelHtml5',
                className: 'btn btn-light',
                text: '<i class="icon-file-excel text-success mr-1"></i> Excel Export',
                title: 'Janitor Execution Logs',
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
            },
            {
                extend: 'pdfHtml5',
                className: 'btn btn-light',
                text: '<i class="icon-file-pdf text-danger mr-1"></i> PDF Export',
                title: 'Janitor Execution Logs',
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] }
            }
        ],
        "columns": [
            { "data": "assignment_ref_no" },
            { 
                "data": "executed_date",
                "render": function(data) {
                    if (!data) return '';
                    var dt = new Date(data);
                    return isNaN(dt.getTime()) ? data : dt.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
                }
            },
            { 
                "data": "executed_slot",
                "render": function(data) {
                    return '<span class="badge badge-light badge-striped badge-striped-left border-left-info">' + data + '</span>';
                }
            },
            { 
                "data": "employee_name",
                "render": function(data, type, row) {
                    return (data || 'Janitor') + (row.employee_code ? ' <br><small class="text-muted">(' + row.employee_code + ')</small>' : '');
                }
            },
            { 
                "data": "asset_ref_no",
                "render": function(data, type, row) {
                    return '<span class="font-weight-semibold">' + data + '</span>' + (row.asset_description ? ' <br><small class="text-muted">' + row.asset_description + '</small>' : '');
                }
            },
            { "data": "checklist_name" },
            {
                "data": "scan_lat",
                "render": function(data, type, row) {
                    if (row.scan_lat && row.scan_lng) {
                        var dist = row.distance_meters !== null ? parseFloat(row.distance_meters).toFixed(1) + 'm' : 'Recorded';
                        var badgeClass = (row.distance_meters && parseFloat(row.distance_meters) > 200) ? 'badge-danger' : 'badge-success';
                        return '<span class="badge ' + badgeClass + '"><i class="icon-location4 mr-1"></i>' + dist + '</span>';
                    }
                    return '<span class="badge badge-light text-muted">No GPS</span>';
                }
            },
            { 
                "data": "status",
                "render": function(data) {
                    var badgeClass = data === 'Completed' ? 'badge-success' : 'badge-warning';
                    return '<span class="badge ' + badgeClass + '">' + (data || 'Submitted') + '</span>';
                }
            },
            { 
                "data": null,
                "orderable": false,
                "className": "text-center",
                "render": function(data, type, row) {
                    return '<button type="button" class="btn btn-outline-info btn-sm btn-view-execution" data-id="'+row.execution_id+'"><i class="icon-eye font-size-sm mr-1"></i> View Data</button>';
                }
            }
        ],
        "order": [[1, "desc"], [0, "desc"]]
    });

    // Filter Buttons
    $('#btn_search').on('click', function() {
        tblScanTracking.ajax.reload();
        tblExecutionReport.ajax.reload();
    });

    $('#btn_reset_filters').on('click', function() {
        $('#filter_customer').val('').trigger('change');
        $('#filter_asset').val('').trigger('change');
        $('#filter_amc').val('').trigger('change');
        $('#filter_janitor').val('').trigger('change');
        $('#filter_scan_status').val('').trigger('change');
        
        var today = new Date().toISOString().split('T')[0];
        $('#filter_from_date').val(today);
        $('#filter_to_date').val(today);

        tblScanTracking.ajax.reload();
        tblExecutionReport.ajax.reload();
    });

    // Handle tab switching (Leaflet and DataTables resize)
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        if (e.target.id === 'nav_tab_monthly_history' && monthlyMapInstance) {
            setTimeout(function() {
                monthlyMapInstance.invalidateSize();
            }, 200);
        }
    });

    // =========================================================================
    // 3. MODAL: COMPARE MAP LOCATIONS WITH DUAL-COLORED PINS (RED vs BLUE)
    // =========================================================================
    var compareAssetMarker = null;
    var compareScanMarker = null;
    var comparePolyline = null;
    var compareBounds = [];

    $(document).on('click', '.btn-compare-locations', function(e) {
        e.preventDefault();
        var $btn = $(this);
        
        var assetCode = $btn.data('asset-code');
        var assetName = $btn.data('asset-name');
        var bldgName = $btn.data('bldg-name');
        var janitor = $btn.data('janitor');
        var scanLat = parseFloat($btn.data('scan-lat'));
        var scanLng = parseFloat($btn.data('scan-lng'));
        var assetLat = parseFloat($btn.data('asset-lat'));
        var assetLng = parseFloat($btn.data('asset-lng'));
        var dist = parseFloat($btn.data('dist')) || 0;
        var status = $btn.data('status');
        var time = $btn.data('time');

        var distStr = dist < 1000 ? dist.toFixed(1) + ' meters' : (dist / 1000).toFixed(2) + ' km';
        var statusBadge = (status === 'Verified') 
            ? '<span class="badge badge-success font-size-sm px-2 py-1"><i class="icon-checkmark3 mr-1"></i>Verified (Within Radius)</span>' 
            : '<span class="badge badge-danger font-size-sm px-2 py-1"><i class="icon-cross2 mr-1"></i>Location Mismatch</span>';

        var hasScanCoords = (!isNaN(scanLat) && !isNaN(scanLng) && scanLat !== 0 && scanLng !== 0);
        var hasAssetCoords = (!isNaN(assetLat) && !isNaN(assetLng) && assetLat !== 0 && assetLng !== 0);

        var html = '' +
            '<div class="d-flex flex-wrap justify-content-between align-items-center mb-2 px-1">' +
                '<div class="btn-group btn-group-sm mb-1" id="compare_pin_toggles">' +
                    '<button type="button" class="btn btn-primary active btn-compare-toggle" data-mode="both"><i class="icon-eye mr-1"></i> Both Pins (Red &amp; Blue)</button>' +
                    '<button type="button" class="btn btn-light btn-compare-toggle" data-mode="asset" ' + (!hasAssetCoords ? 'disabled' : '') + '><span class="map-dot-red"></span> Asset Pin (Red)</button>' +
                    '<button type="button" class="btn btn-light btn-compare-toggle" data-mode="scan" ' + (!hasScanCoords ? 'disabled' : '') + '><span class="map-dot-blue"></span> Scanned Pin (Blue)</button>' +
                '</div>' +
                '<div class="d-flex align-items-center mb-1">' +
                    '<div class="btn-group btn-group-sm mr-2" id="compare_lang_toggles">' +
                        '<button type="button" class="btn ' + (preferredMapLang === 'en' ? 'btn-primary active' : 'btn-light') + ' btn-compare-lang" data-lang="en" title="English Map Labels"><i class="icon-sphere mr-1"></i> English</button>' +
                        '<button type="button" class="btn ' + (preferredMapLang === 'ar' ? 'btn-primary active' : 'btn-light') + ' btn-compare-lang" data-lang="ar" title="Arabic Map Labels (عربي)"><i class="icon-sphere mr-1"></i> عربي</button>' +
                    '</div>' +
                    '<span class="badge badge-dark px-2 py-1 mr-1">Distance: ' + distStr + '</span> ' + statusBadge +
                '</div>' +
            '</div>' +
            
            '<div id="compare_map_box" style="height: 380px; width: 100%; border-radius: 6px; border: 1px solid #ddd; margin-bottom: 12px; position: relative;">' +
                (!hasScanCoords && !hasAssetCoords ? '<div class="text-center p-5 text-muted"><i class="icon-location4 icon-2x"></i><br>Coordinates missing for this scan</div>' : '') +
            '</div>' +

            '<div class="row">' +
                '<div class="col-md-6">' +
                    '<div class="card card-body bg-light border-left-3 border-left-danger p-2 mb-2">' +
                        '<div class="font-weight-bold text-danger"><span class="map-dot-red"></span> Asset Location (Registered)</div>' +
                        '<div class="font-size-sm text-dark mt-1"><strong>' + assetCode + '</strong> - ' + assetName + '</div>' +
                        '<div class="font-size-xs text-muted"><i class="icon-office mr-1"></i>' + bldgName + '</div>' +
                        '<div class="font-size-xs text-muted mt-1">GPS: ' + (hasAssetCoords ? assetLat.toFixed(6) + ', ' + assetLng.toFixed(6) : 'Not Geocoded') + '</div>' +
                    '</div>' +
                '</div>' +
                '<div class="col-md-6">' +
                    '<div class="card card-body bg-light border-left-3 border-left-primary p-2 mb-2">' +
                        '<div class="font-weight-bold text-primary"><span class="map-dot-blue"></span> Janitor Device Location (Scanned)</div>' +
                        '<div class="font-size-sm text-dark mt-1"><i class="icon-user mr-1"></i>' + janitor + '</div>' +
                        '<div class="font-size-xs text-muted"><i class="icon-alarm mr-1"></i>' + time + '</div>' +
                        '<div class="font-size-xs text-muted mt-1">GPS: ' + (hasScanCoords ? scanLat.toFixed(6) + ', ' + scanLng.toFixed(6) : 'No Device GPS') + '</div>' +
                    '</div>' +
                '</div>' +
            '</div>';

        $('#modal_map_compare_body').html(html);
        $('#modal_map_compare').modal('show');

        // Initialize Leaflet Map inside Modal
        $('#modal_map_compare').off('shown.bs.modal').on('shown.bs.modal', function() {
            if (!hasScanCoords && !hasAssetCoords) return;

            if (compareMapInstance) {
                compareMapInstance.remove();
                compareMapInstance = null;
                compareCurrentTileLayer = null;
            }

            var centerLat = hasAssetCoords ? assetLat : scanLat;
            var centerLng = hasAssetCoords ? assetLng : scanLng;

            compareMapInstance = L.map('compare_map_box', {
                center: [centerLat, centerLng],
                zoom: 17
            });

            // English by default (or user's preferred language)
            var initialTileCfg = MAP_TILES[preferredMapLang] || MAP_TILES.en;
            compareCurrentTileLayer = L.tileLayer(initialTileCfg.url, initialTileCfg.options).addTo(compareMapInstance);
            L.control.layers(createBaseMapLayers(), null, { position: 'topright' }).addTo(compareMapInstance);

            compareBounds = [];
            compareAssetMarker = null;
            compareScanMarker = null;
            comparePolyline = null;

            // 1. RED Pin: Asset Location
            if (hasAssetCoords) {
                compareAssetMarker = L.marker([assetLat, assetLng], { icon: getRedAssetIcon() }).addTo(compareMapInstance);
                compareAssetMarker.bindPopup('<b>🔴 Asset Location</b><br><b>' + assetCode + '</b><br>' + assetName + '<br>Building: ' + bldgName);
                compareBounds.push([assetLat, assetLng]);
            }

            // 2. BLUE Pin: Janitor Device Scanned Location
            if (hasScanCoords) {
                compareScanMarker = L.marker([scanLat, scanLng], { icon: getBlueScanIcon() }).addTo(compareMapInstance);
                compareScanMarker.bindPopup('<b>🔵 Janitor Scanned Here</b><br>' + janitor + '<br>Time: ' + time + '<br><b>Distance: ' + distStr + '</b>');
                compareBounds.push([scanLat, scanLng]);
            }

            // 3. Connect pins with dashed red line
            if (hasAssetCoords && hasScanCoords) {
                comparePolyline = L.polyline([[assetLat, assetLng], [scanLat, scanLng]], {
                    color: '#e53935',
                    weight: 3,
                    opacity: 0.85,
                    dashArray: '6, 8'
                }).addTo(compareMapInstance);

                compareMapInstance.fitBounds(compareBounds, { padding: [50, 50], maxZoom: 18 });
            } else if (compareBounds.length === 1) {
                compareMapInstance.setView(compareBounds[0], 17);
            }

            compareMapInstance.invalidateSize();
        });

        // Toggle View in Modal: Both Pins, Asset Only, Scan Only
        $(document).off('click', '.btn-compare-toggle').on('click', '.btn-compare-toggle', function(evt) {
            evt.preventDefault();
            $('.btn-compare-toggle').removeClass('btn-primary active').addClass('btn-light');
            $(this).removeClass('btn-light').addClass('btn-primary active');

            var mode = $(this).data('mode');
            if (!compareMapInstance) return;

            if (mode === 'both') {
                if (compareAssetMarker && !compareMapInstance.hasLayer(compareAssetMarker)) compareAssetMarker.addTo(compareMapInstance);
                if (compareScanMarker && !compareMapInstance.hasLayer(compareScanMarker)) compareScanMarker.addTo(compareMapInstance);
                if (comparePolyline && !compareMapInstance.hasLayer(comparePolyline)) comparePolyline.addTo(compareMapInstance);
                if (compareBounds.length > 1) {
                    compareMapInstance.fitBounds(compareBounds, { padding: [50, 50], maxZoom: 18 });
                } else if (compareBounds.length === 1) {
                    compareMapInstance.setView(compareBounds[0], 17);
                }
            } else if (mode === 'asset') {
                if (compareAssetMarker && !compareMapInstance.hasLayer(compareAssetMarker)) compareAssetMarker.addTo(compareMapInstance);
                if (compareScanMarker && compareMapInstance.hasLayer(compareScanMarker)) compareMapInstance.removeLayer(compareScanMarker);
                if (comparePolyline && compareMapInstance.hasLayer(comparePolyline)) compareMapInstance.removeLayer(comparePolyline);
                if (hasAssetCoords) {
                    compareMapInstance.setView([assetLat, assetLng], 18);
                    compareAssetMarker.openPopup();
                }
            } else if (mode === 'scan') {
                if (compareScanMarker && !compareMapInstance.hasLayer(compareScanMarker)) compareScanMarker.addTo(compareMapInstance);
                if (compareAssetMarker && compareMapInstance.hasLayer(compareAssetMarker)) compareMapInstance.removeLayer(compareAssetMarker);
                if (comparePolyline && compareMapInstance.hasLayer(comparePolyline)) compareMapInstance.removeLayer(comparePolyline);
                if (hasScanCoords) {
                    compareMapInstance.setView([scanLat, scanLng], 18);
                    compareScanMarker.openPopup();
                }
            }
        });

        // Switch Map Language in Compare Modal: English vs Arabic
        $(document).off('click', '.btn-compare-lang').on('click', '.btn-compare-lang', function(evt) {
            evt.preventDefault();
            var lang = $(this).data('lang');
            preferredMapLang = lang;
            localStorage.setItem('thc_preferred_map_lang', lang);
            syncLanguageButtons(lang);

            if (compareMapInstance) {
                if (compareCurrentTileLayer && compareMapInstance.hasLayer(compareCurrentTileLayer)) {
                    compareMapInstance.removeLayer(compareCurrentTileLayer);
                }
                var tileCfg = MAP_TILES[lang] || MAP_TILES.en;
                compareCurrentTileLayer = L.tileLayer(tileCfg.url, tileCfg.options).addTo(compareMapInstance);
                compareCurrentTileLayer.bringToBack();
            }
        });
    });

    // Quick Jump from Table Row to Month Pin History
    $(document).on('click', '.btn-quick-month-history', function(e) {
        e.preventDefault();
        var empId = $(this).data('employee-id');
        var attDate = $(this).data('date');
        var monthStr = attDate ? attDate.substring(0, 7) : new Date().toISOString().substring(0, 7);

        // Switch to Tab 2
        $('#nav_tab_monthly_history').tab('show');

        // Populate fields
        if (empId) {
            $('#history_janitor').val(empId).trigger('change');
        }
        if (monthStr) {
            $('#history_month').val(monthStr);
        }

        // Trigger loading
        setTimeout(function() {
            $('#btn_load_month_history').trigger('click');
        }, 200);
    });

    // =========================================================================
    // 4. TAB 2: SELECT JANITOR AND VIEW ONE MONTH PIN HISTORY ON MAP
    // =========================================================================
    var monthlyScanMarkers = [];
    var currentMonthlyFilter = 'all';

    $('#btn_load_month_history').on('click', function(e) {
        e.preventDefault();

        var janitorId = $('#history_janitor').val();
        var selectedMonth = $('#history_month').val();

        if (!janitorId) {
            swal("Please Select Janitor", "Choose a janitor from the dropdown to view their monthly scan pin history.", "warning");
            return;
        }

        if (!selectedMonth) {
            swal("Please Select Month", "Choose a valid year and month to display pins.", "warning");
            return;
        }

        var $btn = $(this);
        var originalText = $btn.html();
        $btn.prop('disabled', true).html('<i class="icon-spinner2 spinner mr-1"></i> Loading History Pins...');

        $.ajax({
            url: '../controller/janitor/execution_report_controller.php',
            type: 'POST',
            data: {
                action: 'get_janitor_month_history',
                employee_id: janitorId,
                month: selectedMonth
            },
            dataType: 'json',
            success: function(res) {
                $btn.prop('disabled', false).html(originalText);

                if (res && res.status === 'success') {
                    monthlyScansData = res.data || [];
                    
                    // Update Summary Counters
                    var s = res.summary || {};
                    $('#metric_total_scans').text(s.total_scans || 0);
                    $('#metric_verified_scans').text(s.verified_scans || 0);
                    $('#metric_mismatch_scans').text(s.mismatch_scans || 0);
                    $('#metric_avg_distance').text((s.avg_distance || 0) + ' m');
                    $('#history_metrics_row').slideDown(200);

                    // Reset filter button to 'all'
                    $('.btn-filter-pins').removeClass('btn-primary active').addClass('btn-light');
                    $('.btn-filter-pins[data-filter="all"]').removeClass('btn-light').addClass('btn-primary active');
                    currentMonthlyFilter = 'all';

                    // Render Map Pins & Timeline
                    renderMonthlyMapAndTimeline(monthlyScansData, res.month, currentMonthlyFilter);
                } else {
                    swal("Notice", res.message || "No scan history records found for this janitor in the selected month.", "info");
                }
            },
            error: function() {
                $btn.prop('disabled', false).html(originalText);
                swal("Request Failed", "Failed to retrieve monthly scan history from server.", "error");
            }
        });
    });

    // Pin Filter Buttons on Monthly Map
    $(document).on('click', '.btn-filter-pins', function(e) {
        e.preventDefault();
        $('.btn-filter-pins').removeClass('btn-primary active').addClass('btn-light');
        $(this).removeClass('btn-light').addClass('btn-primary active');

        currentMonthlyFilter = $(this).data('filter') || 'all';
        renderMonthlyMapAndTimeline(monthlyScansData, $('#history_month').val(), currentMonthlyFilter);
    });

    // Map Language Buttons on Tab 2 (English vs Arabic)
    $(document).on('click', '.btn-map-lang', function(e) {
        e.preventDefault();
        var lang = $(this).data('lang');
        preferredMapLang = lang;
        localStorage.setItem('thc_preferred_map_lang', lang);
        syncLanguageButtons(lang);

        if (monthlyMapInstance) {
            if (monthlyCurrentTileLayer && monthlyMapInstance.hasLayer(monthlyCurrentTileLayer)) {
                monthlyMapInstance.removeLayer(monthlyCurrentTileLayer);
            }
            var tileCfg = MAP_TILES[lang] || MAP_TILES.en;
            monthlyCurrentTileLayer = L.tileLayer(tileCfg.url, tileCfg.options).addTo(monthlyMapInstance);
            monthlyCurrentTileLayer.bringToBack();
        }
    });

    function renderMonthlyMapAndTimeline(scans, monthStr, filter) {
        // 1. Initialize Leaflet Map if not already created
        if (!monthlyMapInstance) {
            monthlyMapInstance = L.map('monthly_history_map', {
                center: [26.1868, 50.5236], // Default Bahrain center
                zoom: 14
            });

            // English by default (or user's preferred language)
            var initialTileCfg = MAP_TILES[preferredMapLang] || MAP_TILES.en;
            monthlyCurrentTileLayer = L.tileLayer(initialTileCfg.url, initialTileCfg.options).addTo(monthlyMapInstance);
            L.control.layers(createBaseMapLayers(), null, { position: 'topright' }).addTo(monthlyMapInstance);

            monthlyMarkersLayer = L.featureGroup().addTo(monthlyMapInstance);
            monthlyPolylinesLayer = L.featureGroup().addTo(monthlyMapInstance);
        } else {
            monthlyMarkersLayer.clearLayers();
            monthlyPolylinesLayer.clearLayers();
        }

        monthlyScanMarkers = [];
        var bounds = [];
        var timelineHtml = '';
        var displayedCount = 0;

        if (!scans || scans.length === 0) {
            timelineHtml = '<div class="alert alert-warning text-center p-3">No scans recorded for this janitor in ' + monthStr + '.</div>';
            $('#monthly_scans_timeline').html(timelineHtml);
            $('#timeline_count_badge').text('0 Scans');
            monthlyMapInstance.setView([26.1868, 50.5236], 13);
            return;
        }

        scans.forEach(function(item, idx) {
            var status = item.scan_status || item.attendance_status;
            var isVerified = (status === 'Verified' || status === 'Present');
            var isMismatch = !isVerified && status !== 'Bypassed';

            // Filter check
            if (filter === 'verified' && !isVerified) return;
            if (filter === 'mismatch' && isVerified) return;

            displayedCount++;

            var scanLat = parseFloat(item.scan_lat);
            var scanLng = parseFloat(item.scan_lng);
            var assetLat = parseFloat(item.effective_asset_lat);
            var assetLng = parseFloat(item.effective_asset_lng);
            var dist = parseFloat(item.distance_meters) || 0;
            var distStr = dist < 1000 ? dist.toFixed(1) + ' m' : (dist / 1000).toFixed(2) + ' km';
            var statusBadge = isVerified ? '<span class="badge badge-success">Verified</span>' : '<span class="badge badge-danger">Mismatch</span>';

            var hasScan = (!isNaN(scanLat) && !isNaN(scanLng) && scanLat !== 0 && scanLng !== 0);
            var hasAsset = (!isNaN(assetLat) && !isNaN(assetLng) && assetLat !== 0 && assetLng !== 0);

            // Add Markers to Map
            var scanMarker = null;
            if (hasScan) {
                scanMarker = L.marker([scanLat, scanLng], { icon: getBlueScanIcon() }).addTo(monthlyMarkersLayer);
                scanMarker.bindPopup(
                    '<div class="font-size-sm">' +
                    '<span class="font-weight-bold text-primary"><span class="map-dot-blue"></span> Janitor Scan Pin</span><br>' +
                    '<b>' + item.asset_code + '</b> (' + (item.asset_description || '') + ')<br>' +
                    '<i class="icon-alarm mr-1"></i>' + item.attendance_date + ' ' + item.attendance_time + '<br>' +
                    'Distance: <b>' + distStr + '</b> (' + status + ')' +
                    '</div>'
                );
                bounds.push([scanLat, scanLng]);
                monthlyScanMarkers[idx] = scanMarker;
            }

            var assetMarker = null;
            if (hasAsset) {
                assetMarker = L.marker([assetLat, assetLng], { icon: getRedAssetIcon() }).addTo(monthlyMarkersLayer);
                assetMarker.bindPopup(
                    '<div class="font-size-sm">' +
                    '<span class="font-weight-bold text-danger"><span class="map-dot-red"></span> Asset Location Pin</span><br>' +
                    '<b>' + item.asset_code + '</b><br>' + (item.asset_description || '') + '<br>' +
                    '<i class="icon-office mr-1"></i>' + (item.building_name || '') +
                    '</div>'
                );
                bounds.push([assetLat, assetLng]);
            }

            // Connect scan to asset
            if (hasScan && hasAsset) {
                L.polyline([[assetLat, assetLng], [scanLat, scanLng]], {
                    color: isVerified ? '#1e88e5' : '#e53935',
                    weight: 2,
                    opacity: 0.75,
                    dashArray: '4, 6'
                }).addTo(monthlyPolylinesLayer);
            }

            // Append to timeline card list
            timelineHtml += '' +
                '<div class="history-timeline-item p-2 mb-2 bg-light rounded" id="timeline_item_' + idx + '">' +
                    '<div class="d-flex justify-content-between align-items-center">' +
                        '<span class="font-weight-semibold font-size-sm text-dark">' + item.attendance_date + ' ' + item.attendance_time + '</span>' +
                        statusBadge +
                    '</div>' +
                    '<div class="font-size-xs text-primary font-weight-bold mt-1">#' + item.asset_code + '</div>' +
                    '<div class="font-size-xs text-muted">' + (item.asset_description || 'Asset') + ' • ' + (item.building_name || '') + '</div>' +
                    '<div class="d-flex justify-content-between align-items-center mt-2">' +
                        '<span class="badge badge-light border font-size-xs">Dist: ' + distStr + '</span>' +
                        (hasScan ? '<button type="button" class="btn btn-outline-info btn-xs btn-focus-scan-pin" data-index="' + idx + '" data-lat="' + scanLat + '" data-lng="' + scanLng + '"><i class="icon-target mr-1"></i>Focus Pin</button>' : '') +
                    '</div>' +
                '</div>';
        });

        $('#timeline_count_badge').text(displayedCount + ' Scans');

        if (displayedCount === 0) {
            timelineHtml = '<div class="alert alert-info text-center p-3">No scans match the selected filter.</div>';
        }

        $('#monthly_scans_timeline').html(timelineHtml);

        if (bounds.length > 0) {
            monthlyMapInstance.fitBounds(bounds, { padding: [40, 40], maxZoom: 17 });
        }
        monthlyMapInstance.invalidateSize();
    }

    // Focus Pin on Map from Timeline List
    $(document).on('click', '.btn-focus-scan-pin', function(e) {
        e.preventDefault();
        var idx = $(this).data('index');
        var lat = parseFloat($(this).data('lat'));
        var lng = parseFloat($(this).data('lng'));

        if (monthlyMapInstance && !isNaN(lat) && !isNaN(lng)) {
            monthlyMapInstance.setView([lat, lng], 18, { animate: true });
            if (monthlyScanMarkers[idx]) {
                monthlyScanMarkers[idx].openPopup();
            }
        }
    });

    // =========================================================================
    // 5. MODAL: VIEW EXECUTION DETAILS (CHECKLIST & GPS AUDIT)
    // =========================================================================
    $(document).on('click', '.btn-view-execution', function(e) {
        e.preventDefault();
        var exec_id = $(this).data('id');
        if (!exec_id) return;
        
        $('#div_execution_details_body').html('<div class="text-center p-3"><i class="icon-spinner2 spinner mr-2"></i> Loading checklist and scan details...</div>');
        $('#modal_view_execution').modal('show');

        $.ajax({
            url: '../controller/janitor/execution_report_controller.php',
            type: 'POST',
            data: {
                action: 'get_execution_points',
                execution_id: exec_id
            },
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success' && res.categories) {
                    var html = '';

                    // GPS Location Verification Card if available
                    if (res.geo_info) {
                        var g = res.geo_info;
                        var sLat = g.scan_lat;
                        var sLng = g.scan_lng;
                        var aLat = g.effective_asset_lat;
                        var aLng = g.effective_asset_lng;
                        var d = g.distance_meters !== null ? parseFloat(g.distance_meters) : null;
                        var dText = d !== null ? (d < 1000 ? d.toFixed(1) + ' m' : (d / 1000).toFixed(2) + ' km') : 'Recorded';

                        html += '<div class="card card-body bg-light border-left-3 border-left-info p-3 mb-3">' +
                                    '<div class="d-flex justify-content-between align-items-center mb-2">' +
                                        '<h6 class="font-weight-bold mb-0 text-info"><i class="icon-location4 mr-1"></i>QR Scan Location Verification</h6>' +
                                        '<span class="badge badge-primary px-2 py-1">Distance: ' + dText + '</span>' +
                                    '</div>' +
                                    '<div class="row font-size-sm">' +
                                        '<div class="col-md-6 mb-1">' +
                                            '<strong><span class="map-dot-blue"></span> Janitor Scan GPS:</strong> ' + 
                                            (sLat ? '<a href="https://www.google.com/maps?q=' + sLat + ',' + sLng + '" target="_blank" class="ml-1 text-primary font-weight-semibold">' + parseFloat(sLat).toFixed(5) + ', ' + parseFloat(sLng).toFixed(5) + '</a>' : '<span class="text-muted ml-1">No GPS Recorded</span>') +
                                        '</div>' +
                                        '<div class="col-md-6 mb-1">' +
                                            '<strong><span class="map-dot-red"></span> Asset Location GPS:</strong> ' + 
                                            (aLat ? '<a href="https://www.google.com/maps?q=' + aLat + ',' + aLng + '" target="_blank" class="ml-1 text-danger font-weight-semibold">' + parseFloat(aLat).toFixed(5) + ', ' + parseFloat(aLng).toFixed(5) + '</a>' : '<span class="text-muted ml-1">Not Set</span>') +
                                        '</div>' +
                                    '</div>' +
                                '</div>';
                    }

                    // Iterate categories
                    var catKeys = Object.keys(res.categories);
                    if (catKeys.length === 0) {
                        html += '<div class="alert alert-warning">No checklist items recorded for this execution.</div>';
                    } else {
                        catKeys.forEach(function(catName) {
                            html += '<div class="card mb-3 border">' +
                                        '<div class="card-header bg-light font-weight-bold py-2">' +
                                            '<i class="icon-folder mr-2 text-primary"></i>' + catName +
                                        '</div>' +
                                        '<div class="table-responsive">' +
                                            '<table class="table table-sm">' +
                                                '<thead>' +
                                                    '<tr>' +
                                                        '<th style="width: 45%;">Checklist Point</th>' +
                                                        '<th style="width: 15%;">Completed</th>' +
                                                        '<th style="width: 25%;">Remarks</th>' +
                                                        '<th style="width: 15%;" class="text-center">Photo</th>' +
                                                    '</tr>' +
                                                '</thead>' +
                                                '<tbody>';
                            
                            res.categories[catName].forEach(function(point) {
                                var isCompBadge = point.is_completed === 'Yes' ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-danger">No</span>';
                                var photoBtn = point.photo_url ? '<a href="'+point.photo_url+'" target="_blank" class="btn btn-sm btn-outline-info"><i class="icon-image2"></i> View</a>' : '<span class="text-muted">-</span>';
                                var rem = point.remarks ? point.remarks : '<span class="text-muted">-</span>';

                                html += '<tr>' +
                                            '<td>' + point.item_description + '</td>' +
                                            '<td>' + isCompBadge + '</td>' +
                                            '<td>' + rem + '</td>' +
                                            '<td class="text-center">' + photoBtn + '</td>' +
                                        '</tr>';
                            });

                            html +=             '</tbody>' +
                                            '</table>' +
                                        '</div>' +
                                    '</div>';
                        });
                    }

                    $('#div_execution_details_body').html(html);
                } else {
                    $('#div_execution_details_body').html('<div class="alert alert-danger">Failed to load checklist details.</div>');
                }
            },
            error: function() {
                $('#div_execution_details_body').html('<div class="alert alert-danger">Error fetching execution details from server.</div>');
            }
        });
    });

});
