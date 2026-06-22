@extends('TemplateLayout.AdminLayout')

@section('content')
    @push('title')
        <title>Dashboard Admin - QRUN Website</title>
    @endpush

    @push('css')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intro.js@7.2.0/minified/introjs.min.css">

        <style>
            #mapGuideModal .modal-dialog {
                margin-top: 40px;
                transition: .25s ease;
            }

            /* #mapGuideModal.fade .modal-dialog {
                                                                                                                                                                                                                                transform: translateY(-20px);
                                                                                                                                                                                                                            }

                                                                                                                                                                                                                            #mapGuideModal.show .modal-dialog {
                                                                                                                                                                                                                                transform: translateY(0);
                                                                                                                                                                                                                            } */

            .map-ui-wrapper {
                position: relative;
            }

            .bubble-label {
                pointer-events: none;
            }

            .bubble-label.clickable {
                pointer-events: auto;
            }

            .leaflet-interactive {
                cursor: pointer;
            }

            .map-side-panel {
                position: absolute;
                top: 18px;
                right: 18px;
                width: 340px;
                max-height: calc(100% - 36px);
                overflow-y: auto;
                z-index: 999;
                background: rgba(255, 255, 255, .96);
                backdrop-filter: blur(14px);
                border-radius: 22px;
                box-shadow: 0 12px 40px rgba(0, 0, 0, .12);
                border: 1px solid rgba(255, 255, 255, .5);
                padding: 18px;
                transition: .25s ease;
            }

            .map-side-panel.hidden {
                opacity: 0;
                visibility: hidden;
                transform: translateX(20px);
            }

            .map-side-title {
                font-size: 18px;
                font-weight: 800;
                color: #111827;
                margin-bottom: 4px;
            }

            .map-side-subtitle {
                color: #6b7280;
                font-size: 13px;
                margin-bottom: 16px;
            }

            .breakdown-group {
                margin-bottom: 16px;
            }

            .breakdown-header {
                font-size: 14px;
                font-weight: 700;
                color: #2563eb;
                margin-bottom: 10px;
                display: flex;
                justify-content: space-between;
            }

            .breakdown-item {
                background: #f8fafc;
                border-radius: 14px;
                padding: 10px 12px;
                margin-bottom: 8px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                transition: .2s ease;
            }

            .breakdown-item:hover {
                background: #eff6ff;
                transform: translateX(2px);
            }

            .breakdown-item-name {
                font-size: 13px;
                font-weight: 600;
                color: #374151;
            }

            .breakdown-item-total {
                min-width: 34px;
                height: 34px;
                border-radius: 999px;
                background: #2563eb;
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 700;
                font-size: 12px;
            }

            .breadcrumb-map {
                background: #f9fafb;
                border-radius: 14px;
                padding: 10px 14px;
                overflow-x: auto;
                white-space: nowrap;
            }

            .breadcrumb-item-map {
                transition: .2s ease;
                padding: 6px 10px;
                border-radius: 10px;
            }

            .breadcrumb-item-map:hover {
                background: #e0edff;
                color: #2563eb;
            }

            .breadcrumb-item-map.active {
                background: #2563eb;
                color: white !important;
            }

            .custom-popup .leaflet-popup-content-wrapper {
                border-radius: 18px;
                padding: 6px;
            }

            .custom-popup .leaflet-popup-content {
                margin: 10px 14px;
            }

            @media(max-width: 992px) {

                .map-side-panel {
                    position: relative;
                    top: unset;
                    right: unset;
                    width: 100%;
                    max-height: 300px;
                    margin-top: 16px;
                }

                .map-ui-wrapper {
                    display: flex;
                    flex-direction: column;
                }

                #analyticsMap {
                    height: 450px;
                }
            }

            .dashboard-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 15px;
                margin-bottom: 24px;
            }

            .dashboard-title h1 {
                font-weight: 700;
                color: #2c3e50;
                margin-bottom: 5px;
            }

            .dashboard-title p {
                color: #7f8c8d;
                margin: 0;
            }

            .date-range-wrapper {
                min-width: 280px;
            }

            #dashboardDateRange {
                background: #fff;
                cursor: pointer;
                padding: 12px 18px;
                border: 1px solid #e5e7eb;
                width: 100%;
                border-radius: 12px;
                font-weight: 600;
                box-shadow: 0 2px 10px rgba(0, 0, 0, .04);
            }

            .modern-stat-card {
                position: relative;
                overflow: hidden;
                border-radius: 22px;
                transition: .25s ease;
                border: 1px solid #f1f5f9;
            }

            .modern-stat-card::before {
                content: '';
                position: absolute;
                top: -40px;
                right: -40px;
                width: 120px;
                height: 120px;
                background: rgba(37, 99, 235, .05);
                border-radius: 999px;
            }

            .modern-stat-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 15px 35px rgba(0, 0, 0, .08);
            }

            .stats-title {
                font-size: 12px;
                letter-spacing: .6px;
                margin-bottom: 10px;
            }

            .stats-value {
                font-size: 34px;
                font-weight: 800;
                line-height: 1;
            }

            .stats-icon {
                width: 62px;
                height: 62px;
                border-radius: 18px;
                font-size: 24px;
                box-shadow: 0 10px 20px rgba(0, 0, 0, .08);
            }

            .stats-card {
                border: none;
                border-radius: 18px;
                overflow: hidden;
                transition: .25s ease;
                box-shadow: 0 4px 18px rgba(0, 0, 0, .05);
            }

            .stats-card:hover {
                transform: translateY(-3px);
            }

            .stats-card .card-body {
                padding: 22px;
            }

            .stats-icon {
                width: 56px;
                height: 56px;
                border-radius: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 22px;
            }

            .stats-title {
                font-size: 13px;
                font-weight: 700;
                text-transform: uppercase;
                color: #6b7280;
                margin-bottom: 6px;
            }

            .stats-value {
                font-size: 30px;
                font-weight: 800;
                color: #111827;
                line-height: 1;
            }

            .analytics-card {
                border: none;
                border-radius: 22px;
                overflow: hidden;
                box-shadow: 0 4px 20px rgba(0, 0, 0, .05);
                margin-bottom: 24px;
            }

            .analytics-card .card-header {
                background: white;
                border-bottom: 1px solid #f1f1f1;
                padding: 20px 24px;
            }

            .analytics-card .card-header h5 {
                margin: 0;
                font-weight: 700;
                color: #1f2937;
            }

            .analytics-card .card-body {
                padding: 15px;
            }

            #analyticsMap {
                height: 620px;
                border-radius: 18px;
                overflow: hidden;
            }

            .breadcrumb-map {
                display: flex;
                align-items: center;
                flex-wrap: wrap;
                gap: 10px;
                margin-bottom: 18px;
            }

            .breadcrumb-item-map {
                font-weight: 600;
                color: #4b5563;
                cursor: pointer;
            }

            .breadcrumb-item-map.active {
                color: #2563eb;
            }

            .bubble-label {
                background: transparent;
                border: none;
                box-shadow: none;
            }

            .bubble-content {
                background: rgba(37, 99, 235, .92);
                color: white;
                padding: 10px 16px;
                border-radius: 999px;
                text-align: center;
                font-weight: 700;
                min-width: 120px;
                backdrop-filter: blur(8px);
                box-shadow: 0 10px 25px rgba(37, 99, 235, .35);
            }

            .bubble-content small {
                display: block;
                font-size: 11px;
                opacity: .9;
                font-weight: 500;
            }

            .chart-container {
                min-height: 380px;
            }

            .loading-overlay {
                position: absolute;
                inset: 0;
                background: rgba(255, 255, 255, .7);
                z-index: 999;
                display: none;
                align-items: center;
                justify-content: center;
                border-radius: 18px;
            }

            .analytics-wrapper {
                position: relative;
            }

            .district-list-item {
                padding: 16px;
                border-radius: 14px;
                border: 1px solid #edf2f7;
                margin-bottom: 12px;
                transition: .2s ease;
                cursor: pointer;
            }

            .district-list-item:hover {
                border-color: #2563eb;
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(37, 99, 235, .1);
            }

            .district-total {
                font-size: 26px;
                font-weight: 800;
                color: #2563eb;
            }

            .daterangepicker {
                border-radius: 18px !important;
                border: none !important;
                box-shadow: 0 15px 45px rgba(0, 0, 0, .12) !important;
                overflow: hidden;
            }

            .daterangepicker td.active,
            .daterangepicker td.active:hover {
                background: #2563eb !important;
            }

            .daterangepicker .ranges li.active {
                background: #2563eb !important;
            }


            /* ==========================================================================
                                                                                                                                                                                                                                                                                                                                                        | DATERANGE PICKER MODERN UI
                                                                                                                                                                                                                                                                                                                                                        |========================================================================== */

            .daterangepicker {
                border: none !important;
                border-radius: 22px !important;
                overflow: hidden;
                padding: 14px !important;
                box-shadow: 0 20px 60px rgba(0, 0, 0, .14) !important;
                font-family: inherit;
            }

            .daterangepicker:before,
            .daterangepicker:after {
                display: none !important;
            }

            /*
                                                                                                                                                                                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                                                                                                        | CALENDAR
                                                                                                                                                                                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                                                                                                        */

            .daterangepicker .calendar-table {
                border: none !important;
                background: transparent !important;
            }

            .daterangepicker table {
                border-collapse: separate !important;
                border-spacing: 6px !important;
            }

            .daterangepicker td,
            .daterangepicker th {
                width: 40px !important;
                height: 40px !important;
                border-radius: 12px !important;
                border: none !important;
                transition: .18s ease;
                font-weight: 600;
            }

            /*
                                                                                                                                                                                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                                                                                                        | HOVER
                                                                                                                                                                                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                                                                                                        */

            .daterangepicker td.available:hover,
            .daterangepicker th.available:hover {
                background: #eff6ff !important;
                color: #2563eb !important;
            }

            /*
                                                                                                                                                                                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                                                                                                        | ACTIVE
                                                                                                                                                                                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                                                                                                        */

            .daterangepicker td.active,
            .daterangepicker td.active:hover {
                background: #2563eb !important;
                color: white !important;
            }

            /*
                                                                                                                                                                                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                                                                                                        | IN RANGE
                                                                                                                                                                                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                                                                                                        */

            .daterangepicker td.in-range {
                background: #dbeafe !important;
                color: #1d4ed8 !important;
            }

            /*
                                                                                                                                                                                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                                                                                                        | MONTH / YEAR DROPDOWN
                                                                                                                                                                                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                                                                                                        */

            .daterangepicker select.monthselect,
            .daterangepicker select.yearselect {
                border: 1px solid #e5e7eb !important;
                border-radius: 12px !important;
                padding: 8px 12px !important;
                font-size: 13px !important;
                font-weight: 700;
                color: #111827;
                background: white;
                cursor: pointer;
                outline: none !important;
                margin: 0 4px;
                transition: .2s ease;
            }

            .daterangepicker select.monthselect:hover,
            .daterangepicker select.yearselect:hover {
                border-color: #2563eb !important;
            }

            /*
                                                                                                                                                                                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                                                                                                        | HEADER
                                                                                                                                                                                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                                                                                                        */

            .daterangepicker .drp-calendar.left {
                padding-right: 10px !important;
            }

            .daterangepicker .drp-calendar.right {
                padding-left: 10px !important;
            }

            .daterangepicker .calendar-table .next span,
            .daterangepicker .calendar-table .prev span {
                border-color: #2563eb !important;
                padding: 4px !important;
            }

            /*
                                                                                                                                                                                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                                                                                                        | RANGE BUTTONS
                                                                                                                                                                                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                                                                                                        */

            .daterangepicker .ranges {
                border-right: 1px solid #f1f5f9;
                padding-right: 14px;
            }

            .daterangepicker .ranges ul {
                width: 180px;
            }

            .daterangepicker .ranges li {
                border-radius: 12px !important;
                padding: 12px 14px !important;
                margin-bottom: 6px;
                font-weight: 600;
                transition: .2s ease;
            }

            .daterangepicker .ranges li:hover {
                background: #eff6ff !important;
                color: #2563eb !important;
            }

            .daterangepicker .ranges li.active {
                background: #2563eb !important;
                color: white !important;
            }

            /*
                                                                                                                                                                                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                                                                                                        | APPLY / CANCEL
                                                                                                                                                                                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                                                                                                        */

            .daterangepicker .drp-buttons {
                border-top: 1px solid #f1f5f9 !important;
                padding-top: 14px !important;
            }

            .daterangepicker .btn {
                border-radius: 12px !important;
                padding: 10px 18px !important;
                font-weight: 700;
                border: none !important;
            }

            .daterangepicker .applyBtn {
                background: #2563eb !important;
            }

            .daterangepicker .cancelBtn {
                background: #e5e7eb !important;
                color: #374151 !important;
            }

            /*
                                                                                                                                                                                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                                                                                                        | MOBILE
                                                                                                                                                                                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                                                                                                        */

            @media(max-width:768px) {

                .daterangepicker {
                    width: 95vw !important;
                    left: 10px !important;
                }

                .daterangepicker .ranges {
                    width: 100%;
                    border-right: none;
                    border-bottom: 1px solid #f1f5f9;
                    margin-bottom: 12px;
                    padding-bottom: 12px;
                }

                .daterangepicker .ranges ul {
                    width: 100%;
                }
            }

            /* ==========================================================================
                                                                                                                                                                                                                                                                                | MOBILE STAT CARD COMPACT
                                                                                                                                                                                                                                                                                |========================================================================== */

            @media(max-width:768px) {

                #statsWrapper .col-xxl-3,
                #statsWrapper .col-xl-3,
                #statsWrapper .col-lg-4,
                #statsWrapper .col-md-6 {
                    width: 50%;
                    flex: 0 0 50%;
                    max-width: 50%;
                    padding-left: 6px;
                    padding-right: 6px;
                    margin-bottom: 12px;
                }

                .stats-card .card-body {
                    padding: 14px;
                }

                .stats-title {
                    font-size: 10px;
                    margin-bottom: 4px;
                }

                .stats-value {
                    font-size: 20px;
                }

                .stats-icon {
                    width: 42px;
                    height: 42px;
                    border-radius: 12px;
                    font-size: 16px;
                }

                .modern-stat-card::before {
                    width: 80px;
                    height: 80px;
                    top: -25px;
                    right: -25px;
                }
            }

            /* EXTRA SMALL DEVICE */
            @media(max-width:480px) {

                .stats-title {
                    font-size: 9px;
                }

                .stats-value {
                    font-size: 18px;
                }

                .stats-icon {
                    width: 38px;
                    height: 38px;
                    font-size: 14px;
                }

                .stats-card .card-body {
                    padding: 12px;
                }
            }

            /* ==========================================================================
                                                                                                                                                                                                                                | MAP GUIDE MODAL
                                                                                                                                                                                                                                |========================================================================== */

            #mapGuideModal .nav-pills .nav-link {
                border-radius: 12px;
                font-weight: 700;
                color: #6b7280;
                background: #f3f4f6;
                transition: .2s ease;
            }

            #mapGuideModal .nav-pills .nav-link.active {
                background: #2563eb;
                color: white;
            }

            .guide-step {
                display: flex;
                gap: 16px;
                padding: 18px;
                border-radius: 18px;
                background: #f8fafc;
                margin-bottom: 14px;
                transition: .2s ease;
            }

            .guide-step:hover {
                background: #eff6ff;
                transform: translateY(-2px);
            }

            .guide-number {
                min-width: 42px;
                height: 42px;
                border-radius: 14px;
                background: #2563eb;
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 800;
                font-size: 16px;
            }

            .guide-title {
                font-weight: 800;
                font-size: 15px;
                color: #111827;
                margin-bottom: 4px;
            }

            .guide-desc {
                color: #6b7280;
                font-size: 13px;
                line-height: 1.6;
            }

            @media(max-width:768px) {


                #mapGuideModal .modal-dialog {
                    margin: 12px auto;
                    max-width: calc(100vw - 24px);
                }

                /* #mapGuideModal .modal-dialog {
                                                                                                                                                                                                                                    margin: 12px;
                                                                                                                                                                                                                                } */

                .guide-step {
                    padding: 14px;
                    gap: 12px;
                }

                .guide-number {
                    min-width: 36px;
                    height: 36px;
                    font-size: 14px;
                }

                .guide-title {
                    font-size: 14px;
                }

                .guide-desc {
                    font-size: 12px;
                }
            }

            /* ==========================================================================
                                                                                                                                                                                                                                                                | MOBILE DATERANGE FIX
                                                                                                                                                                                                                                                                |========================================================================== */

            @media (max-width: 768px) {

                .daterangepicker {
                    width: calc(100vw - 20px) !important;
                    left: 10px !important;
                    right: 10px !important;
                    padding: 10px !important;
                    border-radius: 18px !important;
                }

                /*
                                                                                                                                                                                                                                                                    |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                    | HIDE SECOND CALENDAR
                                                                                                                                                                                                                                                                    |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                    */

                .daterangepicker .drp-calendar.right {
                    display: none !important;
                }

                .daterangepicker.single .drp-calendar.left {
                    display: block !important;
                }

                /*
                                                                                                                                                                                                                                                                    |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                    | FULL WIDTH CALENDAR
                                                                                                                                                                                                                                                                    |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                    */

                .daterangepicker .drp-calendar.left {
                    max-width: 100% !important;
                    width: 100% !important;
                    padding: 0 !important;
                }

                /*
                                                                                                                                                                                                                                                                    |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                    | RANGE BUTTONS HORIZONTAL
                                                                                                                                                                                                                                                                    |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                    */

                .daterangepicker .ranges {
                    width: 100% !important;
                    border: none !important;
                    padding: 0 0 10px 0 !important;
                    margin-bottom: 10px !important;
                    overflow-x: auto;
                }

                .daterangepicker .ranges ul {
                    display: flex !important;
                    width: max-content !important;
                    gap: 8px;
                    padding-bottom: 4px;
                }

                .daterangepicker .ranges li {
                    margin-bottom: 0 !important;
                    white-space: nowrap;
                    padding: 8px 12px !important;
                    font-size: 12px;
                    border-radius: 10px !important;
                }

                /*
                                                                                                                                                                                                                                                                    |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                    | DATE CELL
                                                                                                                                                                                                                                                                    |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                    */

                .daterangepicker td,
                .daterangepicker th {
                    width: 34px !important;
                    height: 34px !important;
                    font-size: 12px;
                }

                /*
                                                                                                                                                                                                                                                                    |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                    | DROPDOWN MONTH YEAR
                                                                                                                                                                                                                                                                    |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                    */

                .daterangepicker select.monthselect,
                .daterangepicker select.yearselect {
                    font-size: 12px !important;
                    padding: 6px 8px !important;
                }

                /*
                                                                                                                                                                                                                                                                    |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                    | BUTTONS
                                                                                                                                                                                                                                                                    |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                    */

                .daterangepicker .drp-buttons {
                    display: flex;
                    justify-content: space-between;
                    gap: 10px;
                    padding-top: 10px !important;
                }

                .daterangepicker .drp-buttons .btn {
                    flex: 1;
                    padding: 10px !important;
                    font-size: 13px;
                }

                /*
                                                                                                                                                                                                                                                                    |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                    | INPUT
                                                                                                                                                                                                                                                                    |--------------------------------------------------------------------------
                                                                                                                                                                                                                                                                    */

                #dashboardDateRange {
                    padding: 10px 14px;
                    font-size: 13px;
                }
            }

            .place-limit-card {
                display: flex;
                align-items: center;
                gap: 10px;

                background: linear-gradient(135deg, #2563eb, #1d4ed8);
                color: white;

                padding: 8px 14px;
                border-radius: 14px;

                box-shadow: 0 6px 18px rgba(37, 99, 235, .14);

                min-width: 165px;
                height: 48px;

                transition: .2s ease;
            }

            .place-limit-card:hover {
                transform: translateY(-1px);
                box-shadow: 0 10px 20px rgba(37, 99, 235, .18);
            }

            .place-limit-icon {
                width: 34px;
                height: 34px;

                border-radius: 10px;

                background: rgba(255, 255, 255, .14);

                display: flex;
                align-items: center;
                justify-content: center;

                font-size: 14px;

                flex-shrink: 0;
            }

            .place-limit-label {
                font-size: 9px;
                font-weight: 700;

                letter-spacing: .7px;
                text-transform: uppercase;

                opacity: .82;
                line-height: 1;
            }

            .place-limit-value {
                font-size: 15px;
                font-weight: 800;

                line-height: 1.1;
                margin-top: 2px;

                white-space: nowrap;
            }

            .dashboard-header .gap-3 {
                gap: 12px !important;
            }

            .place-limit-chip {
                margin-right: 8px;
                height: 50px;

                padding: 0 14px;

                border-radius: 12px;

                background: #eff6ff;
                border: 1px solid #dbeafe;

                display: flex;
                align-items: center;
                gap: 10px;

                color: #1d4ed8;

                font-size: 13px;
                font-weight: 600;

                white-space: nowrap;

                transition: .2s ease;
            }

            .place-limit-chip i {
                font-size: 13px;
                opacity: .85;
            }

            .place-limit-chip strong {
                font-size: 14px;
                font-weight: 800;
                color: #111827;
            }

            .place-limit-chip:hover {
                background: #dbeafe;
            }

            @media(max-width:768px) {

                .place-limit-chip {
                    width: 100%;
                    justify-content: center;
                }

                .date-range-wrapper {
                    width: 100%;
                    margin-top: 10px;
                }

                .place-limit-chip {
                    margin-right: 0;
                }
            }

            .dashboard-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 18px;
                flex-wrap: wrap;
                margin-bottom: 24px;
            }

            .dashboard-title h1 {
                font-size: 30px;
                font-weight: 800;
                margin-bottom: 4px;
                color: #111827;
            }

            .dashboard-title p {
                margin: 0;
                color: #6b7280;
                font-size: 14px;
            }

            .dashboard-toolbar {
                display: flex;
                align-items: center;
                flex-wrap: wrap;
                gap: 12px;
            }

            /*
                                                                                                                |--------------------------------------------------------------------------
                                                                                                                | PLACE LIMIT (legacy – kept for tutorial step ref)
                                                                                                                |--------------------------------------------------------------------------
                                                                                                                */

            /* ==========================================================================
               | COMBO CARDS (Place Limit + Request / Filter + DateRange)
               |========================================================================== */

            .dashboard-combo-card {
                background: #ffffff;
                border: 1px solid #e5e7eb;
                border-radius: 16px;
                padding: 14px 18px;
                box-shadow: 0 3px 10px rgba(0,0,0,.04);
                display: flex;
                flex-direction: column;
                gap: 10px;
                width: 400px;
                transition: .2s ease;
            }

            .dashboard-combo-card.combo-row {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                gap: 14px;
            }

            .combo-card-top {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .combo-card-divider {
                height: 1px;
                background: #f1f5f9;
            }

            .combo-card-btn {
                background: #eff6ff;
                border: 1px solid #dbeafe;
                color: #2563eb;
                border-radius: 999px;
                padding: 7px 16px;
                font-size: 12px;
                font-weight: 700;
                white-space: nowrap;
                flex-shrink: 0;
                cursor: pointer;
                transition: .2s ease;
                outline: none;
                display: inline-flex;
                align-items: center;
                gap: 5px;
            }

            .combo-card-btn:hover {
                background: #dbeafe;
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(37,99,235,.15);
            }

            /* Place limit icon */
            .place-limit-icon {
                width: 38px;
                height: 38px;
                border-radius: 12px;
                background: #eefbf3;
                color: #16a34a;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 15px;
                flex-shrink: 0;
            }

            .place-limit-content { line-height: 1.1; }

            .place-limit-label {
                display: block;
                color: #6b7280;
                font-size: 11px;
                font-weight: 700;
                margin-bottom: 4px;
            }

            .place-limit-value {
                font-size: 14px;
                font-weight: 800;
                color: #111827;
            }

            /* Filter icon */
            .filter-info-icon {
                width: 38px;
                height: 38px;
                border-radius: 12px;
                background: #eff6ff;
                color: #2563eb;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 15px;
                flex-shrink: 0;
            }

            .filter-info-content { line-height: 1.1; }

            .filter-info-label {
                display: block;
                color: #6b7280;
                font-size: 11px;
                font-weight: 700;
                margin-bottom: 2px;
            }

            .filter-info-value {
                font-size: 13px;
                font-weight: 700;
                color: #111827;
            }

            /* Date range inside combo card */
            #dashboardDateRange {
                background: #f8fafc;
                border: 1px solid #e5e7eb;
                border-radius: 10px;
                padding: 9px 14px;
                font-weight: 700;
                font-size: 13px;
                color: #111827;
                cursor: pointer;
                outline: none;
                min-width: 0;
            }

            #dashboardDateRange:focus {
                border-color: #2563eb;
                box-shadow: 0 0 0 3px rgba(37,99,235,.1);
            }

            @media(max-width:768px) {
                .dashboard-header { align-items: stretch; }

                .dashboard-toolbar {
                    width: 100%;
                    flex-direction: column;
                    align-items: stretch;
                }

                .dashboard-combo-card {
                    width: 100%;
                }

                .dashboard-combo-card.combo-row {
                    flex-direction: column;
                    align-items: stretch;
                }

                .dashboard-combo-card.combo-row .combo-card-btn {
                    width: 100%;
                    justify-content: center;
                    border-radius: 10px;
                }

                .dashboard-combo-card.combo-row #dashboardDateRange {
                    width: 100%;
                }
            }

            @media(max-width:768px) {

                #analyticsMap {
                    height: 500px;
                }

                .stats-value {
                    font-size: 24px;
                }
            }

            .analytics-map-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 16px;
                flex-wrap: wrap;
                padding: 18px 22px;
            }

            .analytics-map-header-left h5 {
                font-weight: 700;
                margin-bottom: 4px;
            }

            .analytics-map-header-right {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .btn-reset-map {
                border-radius: 12px;
                border: 1px solid #e5e7eb;
                background: #fff;
                color: #374151;
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: 8px;
                transition: all .2s ease;
                padding: 8px 14px;
            }

            .btn-reset-map:hover {
                transform: translateY(-1px);
                box-shadow: 0 6px 18px rgba(0, 0, 0, .08);
            }

            .account-alert-card {
                margin-top: 20px;
                padding: 22px;
                border-radius: 22px;
                background: #fff;
                border: 1px solid #ffe0b2;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            }

            .account-alert-header {
                display: flex;
                align-items: center;
                gap: 16px;
                margin-bottom: 20px;
            }

            .account-alert-icon {
                width: 58px;
                height: 58px;
                border-radius: 18px;
                background: rgba(255, 152, 0, 0.12);
                color: #f57c00;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 24px;
                flex-shrink: 0;
            }

            .account-alert-title {
                margin: 0;
                font-size: 20px;
                font-weight: 700;
                color: #2d3436;
            }

            .account-alert-subtitle {
                margin: 4px 0 0;
                color: #7f8c8d;
                font-size: 14px;
            }

            .account-alert-list {
                display: flex;
                flex-direction: column;
                gap: 14px;
            }

            .account-alert-item {
                display: flex;
                align-items: flex-start;
                gap: 14px;
                padding: 16px;
                border-radius: 16px;
            }

            .account-alert-item.danger {
                background: #fff5f5;
                border: 1px solid #ffcdd2;
            }

            .account-alert-item.warning {
                background: #fff8e1;
                border: 1px solid #ffe082;
            }

            .account-alert-item-icon {
                width: 46px;
                height: 46px;
                border-radius: 14px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 18px;
                flex-shrink: 0;
            }

            .account-alert-item.danger .account-alert-item-icon {
                background: rgba(244, 67, 54, 0.12);
                color: #d32f2f;
            }

            .account-alert-item.warning .account-alert-item-icon {
                background: rgba(255, 152, 0, 0.12);
                color: #f57c00;
            }

            .account-alert-item-content {
                display: flex;
                flex-direction: column;
            }

            .account-alert-item-content strong {
                font-size: 15px;
                color: #2d3436;
                margin-bottom: 4px;
            }

            .account-alert-item-content span {
                font-size: 13px;
                color: #636e72;
                line-height: 1.5;
            }

            @media(max-width:768px) {
                .analytics-map-header {
                    align-items: flex-start;
                }

                .analytics-map-header-right {
                    width: 100%;
                    justify-content: flex-end;
                }
            }

            /* ==========================================================================
               | TUTORIAL FAB
               |========================================================================== */

            .dashboard-tutorial-fab {
                position: fixed;
                bottom: 72px;
                right: 20px;
                z-index: 9999;
                width: 44px;
                height: 44px;
                border-radius: 50%;
                background: linear-gradient(135deg, #2563eb, #3b82f6);
                color: #fff;
                border: none;
                box-shadow: 0 6px 20px rgba(37, 99, 235, .35);
                font-size: 16px;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: .2s ease;
            }

            .dashboard-tutorial-fab:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 28px rgba(37, 99, 235, .45);
            }

            @media (max-width: 768px) {
                .dashboard-tutorial-fab {
                    width: 40px;
                    height: 40px;
                    bottom: 68px;
                    right: 14px;
                    font-size: 14px;
                    box-shadow: 0 4px 14px rgba(37, 99, 235, .3);
                }
            }
        </style>
    @endpush


    @push('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // Success Toast
                @if (session()->has('success'))
                    Swal.fire({
                        toast: true,
                        position: 'top-end',

                        icon: 'success',
                        title: @json(session()->get('success')),
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                @endif

                // Error Toast
                @if ($errors->any())
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: 'Error',
                        html: `{!! implode('<br>', $errors->all()) !!}`,
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true
                    });
                @endif

            });
        </script>
    @endpush
    <div class="container-fluid">

        <div class="dashboard-header" id="dashboardHeaderSection">

            <div class="dashboard-title">
                <h1>{{ __('messages.management.dashboard.title') }}</h1>
                <p>
                    {{ __('messages.management.dashboard.subtitle') }}
                </p>
            </div>

            <div class="dashboard-toolbar">

                {{-- CARD 1: PLACE LIMIT + REQUEST --}}
                <div class="dashboard-combo-card combo-row" id="placeLimitChip">
                    <div class="combo-card-top" style="flex:1;min-width:0;">
                        <div class="place-limit-icon">
                            <i class="fas fa-fw fa-map"></i>
                        </div>
                        <div class="place-limit-content">
                            <small class="place-limit-label">{{ __('messages.management.dashboard.place_limit') }}</small>
                            <div class="place-limit-value" id="placeLimitText">{{ $data['account_limit'] ?? '-' }}</div>
                        </div>
                    </div>

                    @if (!Auth::user()->hasRole('superadmin'))
                        <button type="button" class="combo-card-btn" id="btnRequestLimit" onclick="openRequestLimitModal()">
                            <i class="fas fa-arrow-up" style="font-size:10px;"></i>
                            Request More Limit
                        </button>
                    @endif
                </div>

                {{-- CARD 2: STATS FILTER + DATE RANGE --}}
                <div class="dashboard-combo-card combo-row" id="filterInfoChip">
                    <div class="combo-card-top" style="flex-shrink:0;">
                        <div class="filter-info-icon">
                            <i class="fas fa-filter"></i>
                        </div>
                        <div class="filter-info-content">
                            <small class="filter-info-label">{{ __('messages.management.dashboard.stats_filter') }}</small>
                            <div class="filter-info-value">{{ __('messages.management.dashboard.date_range') }}</div>
                        </div>
                    </div>
                    <input type="text" id="dashboardDateRange" style="flex:1;min-width:0;">
                </div>

            </div>

        </div>

        {{-- ACCOUNT STATUS ALERT --}}
        @php
            $isEmailVerified = !empty(auth()->user()?->email_verified_at);
            $isApproved = !empty(auth()->user()?->approved_at);
        @endphp

        @if (!$isEmailVerified || !$isApproved)
            <div class="account-alert-card mb-3">

                <div class="account-alert-header">

                    <div class="account-alert-icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>

                    <div>
                        <h5 class="account-alert-title">
                            {{ __('messages.management.dashboard.alert_title') }}
                        </h5>

                        <p class="account-alert-subtitle">
                            {{ __('messages.management.dashboard.alert_subtitle') }}
                        </p>
                    </div>

                </div>

                <div class="account-alert-list">

                    @if (!$isEmailVerified)
                        <div class="account-alert-item danger">
                            <div class="account-alert-item-icon">
                                <i class="fas fa-envelope"></i>
                            </div>

                            <div class="account-alert-item-content">
                                <strong>{{ __('messages.management.dashboard.email_not_verified') }}</strong>
                                <span>
                                    {{ __('messages.management.dashboard.email_verify_desc') }}
                                </span>
                            </div>
                        </div>
                    @endif

                    @if (!$isApproved)
                        <div class="account-alert-item warning">
                            <div class="account-alert-item-icon">
                                <i class="fas fa-user-clock"></i>
                            </div>

                            <div class="account-alert-item-content">
                                <strong>{{ __('messages.management.dashboard.pending_approval') }}</strong>
                                <span>
                                    {{ __('messages.management.dashboard.pending_approval_desc') }}
                                </span>
                            </div>
                        </div>
                    @endif

                </div>

            </div>
        @endif
        {{-- STAT CARD --}}
        <div class="row" id="statsWrapper">

            @if (Auth::user()->hasRole('superadmin'))
                @php
                    $stats = [
                        [
                            'title' => __('messages.management.dashboard.stat_total_users'),
                            'id' => 'stat-user-count',
                            'value' => '0',
                            'icon' => 'fas fa-users',
                            'bg' => 'primary',
                        ],
                        [
                            'title' => __('messages.management.dashboard.stat_pending'),
                            'id' => 'stat-user-pending',
                            'value' => '0',
                            'icon' => 'fas fa-user-clock',
                            'bg' => 'warning',
                        ],
                        [
                            'title' => __('messages.management.dashboard.stat_places'),
                            'id' => 'stat-place-total',
                            'value' => '0',
                            'icon' => 'fas fa-map-marked-alt',
                            'bg' => 'success',
                        ],
                        [
                            'title' => __('messages.management.dashboard.stat_events'),
                            'id' => 'stat-event-count',
                            'value' => '0',
                            'icon' => 'fas fa-calendar-alt',
                            'bg' => 'info',
                        ],
                        [
                            'title' => __('messages.management.dashboard.stat_comments'),
                            'id' => 'stat-comments-count',
                            'value' => '0',
                            'icon' => 'fas fa-comments',
                            'bg' => 'secondary',
                        ],
                        [
                            'title' => __('messages.management.dashboard.stat_gallery'),
                            'id' => 'stat-gallery-count',
                            'value' => '0',
                            'icon' => 'fas fa-images',
                            'bg' => 'dark',
                        ],
                        [
                            'title' => __('messages.management.dashboard.stat_blogs'),
                            'id' => 'stat-blog-count',
                            'value' => '0',
                            'icon' => 'fas fa-blog',
                            'bg' => 'danger',
                        ],
                        [
                            'title' => __('messages.management.dashboard.stat_not_verified'),
                            'id' => 'stat-user-not-verified',
                            'value' => '0',
                            'icon' => 'fas fa-user-shield',
                            'bg' => 'warning',
                        ],
                        [
                            'title' => __('messages.management.dashboard.stat_avg_checkin'),
                            'id' => 'stat-avg-checkin',
                            'value' => '00:00:00',
                            'icon' => 'fas fa-clock',
                            'bg' => 'info',
                        ],

                        [
                            'title' => __('messages.management.dashboard.stat_fastest_checkin'),
                            'id' => 'stat-fastest-checkin',
                            'value' => '00:00:00',
                            'icon' => 'fas fa-bolt',
                            'bg' => 'success',
                        ],

                        [
                            'title' => __('messages.management.dashboard.stat_slowest_checkin'),
                            'id' => 'stat-slowest-checkin',
                            'value' => '00:00:00',
                            'icon' => 'fas fa-hourglass-end',
                            'bg' => 'danger',
                        ],
                    ];
                @endphp
            @else
                @php
                    $stats = [
                        [
                            'title' => __('messages.management.dashboard.stat_places'),
                            'id' => 'stat-place-total',
                            'value' => '0',
                            'icon' => 'fas fa-map-marked-alt',
                            'bg' => 'success',
                        ],
                        [
                            'title' => __('messages.management.dashboard.stat_events'),
                            'id' => 'stat-event-count',
                            'value' => '0',
                            'icon' => 'fas fa-calendar-alt',
                            'bg' => 'info',
                        ],
                        [
                            'title' => __('messages.management.dashboard.stat_comments'),
                            'id' => 'stat-comments-count',
                            'value' => '0',
                            'icon' => 'fas fa-comments',
                            'bg' => 'secondary',
                        ],
                        [
                            'title' => __('messages.management.dashboard.stat_avg_checkin'),
                            'id' => 'stat-avg-checkin',
                            'value' => '00:00:00',
                            'icon' => 'fas fa-clock',
                            'bg' => 'info',
                        ],

                        [
                            'title' => __('messages.management.dashboard.stat_fastest_checkin'),
                            'id' => 'stat-fastest-checkin',
                            'value' => '00:00:00',
                            'icon' => 'fas fa-bolt',
                            'bg' => 'success',
                        ],

                        [
                            'title' => __('messages.management.dashboard.stat_slowest_checkin'),
                            'id' => 'stat-slowest-checkin',
                            'value' => '00:00:00',
                            'icon' => 'fas fa-hourglass-end',
                            'bg' => 'danger',
                        ],
                    ];
                @endphp
            @endif


            @foreach ($stats as $item)
                <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 mb-4">

                    <div class="card stats-card modern-stat-card">

                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-start">

                                <div>

                                    <div class="stats-title">
                                        {{ $item['title'] }}
                                    </div>
                                    @php
                                        $formattedValue = is_numeric($item['value'])
                                            ? number_format($item['value'])
                                            : $item['value'] ?? '-';
                                    @endphp

                                    <div class="stats-value" id="{{ $item['id'] }}">
                                        {{ $formattedValue }}
                                    </div>

                                </div>

                                <div class="stats-icon bg-{{ $item['bg'] }} text-white">
                                    <i class="{{ $item['icon'] }}"></i>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>
            @endforeach

        </div>

        {{-- MAP --}}
        <div id="mapSection" class="card analytics-card  d-none">

            <div class="card-header analytics-map-header">

                <div class="analytics-map-header-left">
                    <h5 class="mb-1">
                        {{ __('messages.management.dashboard.map_title') }}
                    </h5>

                    <small class="text-muted">
                        {!! __('messages.management.dashboard.map_guide_hint') !!}
                    </small>
                </div>

                <div class="analytics-map-header-right">

                    {{-- RESET --}}
                    <button class="btn btn-light btn-sm btn-reset-map" onclick="resetMapNavigation()" title="Reset Map">
                        <i class="fas fa-times"></i>
                        <span>{{ __('messages.management.dashboard.map_reset') }}</span>
                    </button>

                    {{-- GUIDE --}}
                    <button class="btn btn-primary btn-sm px-3" data-toggle="modal" data-target="#mapGuideModal">
                        <i class="fas fa-info-circle mr-1"></i>
                        {{ __('messages.management.dashboard.map_how_to_use') }}
                    </button>

                </div>

            </div>

            <div class="card-body">

                <div class="breadcrumb-map" id="mapBreadcrumb">
                    <span class="breadcrumb-item-map active">
                        Indonesia
                    </span>
                </div>
                <div class="analytics-wrapper map-ui-wrapper">

                    <div class="loading-overlay" id="mapLoading">
                        <div class="spinner-border text-primary"></div>
                    </div>

                    <div id="analyticsMap"></div>
                    <div class="map-side-panel hidden" id="mapSidePanel">
                        <div class="map-side-title" id="mapSideTitle">
                            {{ __('messages.management.dashboard.map_region_summary') }}
                        </div>

                        <div class="map-side-subtitle" id="mapSideSubtitle">
                            {{ __('messages.management.dashboard.map_click_bubble') }}
                        </div>

                        <div id="mapBreakdownContent"></div>
                    </div>

                </div>

                <div id="districtVillageContainer" class="mt-4"></div>

            </div>

        </div>

        {{-- RUNNING SCAN TIME --}}
        <div class="card analytics-card mt-4" id="runningScanCard">

            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2" id="runningScanHeader">

                <div>
                    <h5 class="mb-1">
                        {{ __('messages.management.dashboard.running_scan_title') }}
                    </h5>

                    <small class="text-muted">
                        {{ __('messages.management.dashboard.running_scan_subtitle') }}
                    </small>
                </div>

                <div class="d-flex align-items-center">

                    @if (Auth::user()->hasRole('superadmin'))
                        {{-- SEND RECAP --}}
                        <button class="btn btn-primary btn-sm mr-2" id="btnSendRecapToday">
                            <i class="fas fa-paper-plane mr-1"></i>
                            {{ __('messages.management.dashboard.send_recap') }}
                        </button>
                    @endif

                    {{-- STATUS --}}
                    <span class="badge badge-success px-3 py-2">
                        <i class="fas fa-circle mr-1" style="font-size:10px;"></i>
                        {{ __('messages.management.dashboard.realtime') }}
                    </span>

                </div>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-striped table-hover table-bordered" id="runningScanTable">
                        <thead>
                            <tr>
                                @if(Auth::user()->hasRole('superadmin'))
                                <th>{{ __('messages.management.dashboard.col_user') }}</th>
                                @endif
                                <th>{{ __('messages.management.dashboard.col_place') }}</th>
                                <th>{{ __('messages.management.dashboard.col_browser') }}</th>
                                <th>{{ __('messages.management.dashboard.col_platform') }}</th>
                                <th>{{ __('messages.management.dashboard.col_checked_time') }}</th>
                            </tr>
                        </thead>

                        <tbody></tbody>

                    </table>

                </div>

            </div>

        </div>

        {{-- TOP PLACES --}}
        <div class="row">

            {{-- TOP PLACES --}}
            <div id="topPlacesSection" class="{{ Auth::user()->hasRole('superadmin') ? 'col-lg-6' : 'col-lg-12' }}">

                <div class="card analytics-card h-100">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex flex-column">
                            <h5>{{ __('messages.management.dashboard.top_places_title') }}</h5>
                            <small>{{ __('messages.management.dashboard.top_places_subtitle') }}</small>
                        </div>

                        <span class="badge badge-primary px-3 py-2" id="chartRangeLabel">
                            Last 6 Months
                        </span>
                    </div>

                    <div class="card-body">
                        <div id="topPlacesChart" class="chart-container"></div>
                    </div>

                </div>

            </div>

            {{-- USER GROWTH --}}
            @if (Auth::user()->hasRole('superadmin'))
                <div class="col-lg-6">

                    <div class="card analytics-card h-100">

                        <div class="card-header">
                            <h5>{{ __('messages.management.dashboard.user_growth_title') }}</h5>
                        </div>

                        <div class="card-body">
                            <div id="userGrowthChart" class="chart-container"></div>
                        </div>

                    </div>

                </div>
            @endif

        </div>
    </div>

    {{-- MAP GUIDE MODAL --}}
    <div class="modal fade" id="mapGuideModal" tabindex="-1" role="dialog" aria-labelledby="mapGuideModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">

            <div class="modal-content border-0 shadow-lg" style="border-radius:24px;overflow:hidden;">

                <div class="modal-header border-0"
                    style="
                    background:linear-gradient(135deg,#2563eb,#3b82f6);
                    color:white;
                    padding:20px 24px;
                ">
                    <div>
                        <h4 class="modal-title font-weight-bold mb-1">
                            Location Analytics Guide
                        </h4>

                        <small style="opacity:.9">
                            Panduan penggunaan analytics map
                        </small>
                    </div>

                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"
                        style="opacity:1;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body p-0">

                    {{-- TAB --}}
                    <ul class="nav nav-pills px-4 pt-4" id="guideTab" role="tablist">
                        <li class="nav-item mr-2">

                            <a class="nav-link active px-4 py-2" id="english-tab" data-toggle="pill"
                                href="#english-guide" role="tab">
                                🇺🇸 English
                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link px-4 py-2" id="indo-tab" data-toggle="pill" href="#indo-guide"
                                role="tab">
                                🇮🇩 Indonesia
                            </a>

                        </li>
                    </ul>

                    <div class="tab-content px-4 pb-4 pt-3">

                        {{-- ENGLISH --}}
                        <div class="tab-pane fade show active" id="english-guide" role="tabpanel">

                            <div class="guide-step">

                                <div class="guide-number">1</div>

                                <div>
                                    <div class="guide-title">
                                        Select Date Range
                                    </div>

                                    <div class="guide-desc">
                                        Use the date range picker at the top-right
                                        of the dashboard to filter analytics data.
                                    </div>
                                </div>

                            </div>

                            <div class="guide-step">

                                <div class="guide-number">2</div>

                                <div>
                                    <div class="guide-title">
                                        Analytics Auto Refresh
                                    </div>

                                    <div class="guide-desc">
                                        All dashboard statistics, charts, and map
                                        data will automatically reload based on
                                        selected dates.
                                    </div>
                                </div>

                            </div>

                            <div class="guide-step">

                                <div class="guide-number">3</div>

                                <div>
                                    <div class="guide-title">
                                        Explore Region
                                    </div>

                                    <div class="guide-desc">
                                        Click the blue bubble or polygon area on the
                                        map to open detailed regional analytics.
                                    </div>
                                </div>

                            </div>

                            <div class="guide-step">

                                <div class="guide-number">4</div>

                                <div>
                                    <div class="guide-title">
                                        Drill Down Territory
                                    </div>

                                    <div class="guide-desc">
                                        Province → Regency → District → Village
                                        analytics can be explored interactively.
                                    </div>
                                </div>

                            </div>

                            <div class="guide-step mb-0">

                                <div class="guide-number">5</div>

                                <div>
                                    <div class="guide-title">
                                        Breakdown Panel
                                    </div>

                                    <div class="guide-desc">
                                        The right-side panel shows detailed place
                                        distribution and territory summaries.
                                    </div>
                                </div>

                            </div>

                        </div>

                        {{-- INDONESIA --}}
                        <div class="tab-pane fade" id="indo-guide" role="tabpanel">

                            <div class="guide-step">

                                <div class="guide-number">1</div>

                                <div>
                                    <div class="guide-title">
                                        Pilih Rentang Tanggal
                                    </div>

                                    <div class="guide-desc">
                                        Gunakan date range picker di kanan atas
                                        dashboard untuk memfilter data analytics.
                                    </div>
                                </div>

                            </div>

                            <div class="guide-step">

                                <div class="guide-number">2</div>

                                <div>
                                    <div class="guide-title">
                                        Analytics Otomatis Refresh
                                    </div>

                                    <div class="guide-desc">
                                        Semua statistik dashboard, chart, dan map
                                        akan otomatis diperbarui sesuai tanggal
                                        yang dipilih.
                                    </div>
                                </div>

                            </div>

                            <div class="guide-step">

                                <div class="guide-number">3</div>

                                <div>
                                    <div class="guide-title">
                                        Explore Wilayah
                                    </div>

                                    <div class="guide-desc">
                                        Klik bubble biru atau area polygon pada map
                                        untuk melihat detail analytics wilayah.
                                    </div>
                                </div>

                            </div>

                            <div class="guide-step">

                                <div class="guide-number">4</div>

                                <div>
                                    <div class="guide-title">
                                        Drill Down Wilayah
                                    </div>

                                    <div class="guide-desc">
                                        Analytics Province → Regency → District →
                                        Village dapat dieksplor secara interaktif.
                                    </div>
                                </div>

                            </div>

                            <div class="guide-step mb-0">

                                <div class="guide-number">5</div>

                                <div>
                                    <div class="guide-title">
                                        Breakdown Panel
                                    </div>

                                    <div class="guide-desc">
                                        Panel kanan menampilkan distribusi place dan
                                        ringkasan analytics wilayah secara detail.
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

    {{-- REQUEST LIMIT MODAL --}}
    @if (!Auth::user()->hasRole('superadmin'))
    <div class="modal fade" id="requestLimitModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" style="max-width:460px;">
            <div class="modal-content" style="border-radius:22px;overflow:hidden;border:none;box-shadow:0 20px 60px rgba(0,0,0,.15);">

                <div class="modal-header border-0" style="background:linear-gradient(135deg,#2563eb,#3b82f6);color:white;padding:22px 26px;">
                    <div>
                        <h5 class="modal-title font-weight-bold mb-1">
                            <i class="fas fa-arrow-circle-up mr-2"></i>Request Penambahan Limit
                        </h5>
                        <small style="opacity:.85;">Kirim permintaan ke admin untuk meningkatkan batas tempat Anda.</small>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" onclick="$('#requestLimitModal').modal('hide')" style="opacity:1;">&times;</button>
                </div>

                <div class="modal-body p-4">

                    <div class="d-flex align-items-center gap-3 p-3 mb-4"
                        style="background:#f0f9ff;border-radius:14px;border:1px solid #bae6fd;">
                        <div style="width:40px;height:40px;border-radius:12px;background:#2563eb;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-map text-white" style="font-size:16px;"></i>
                        </div>
                        <div style="padding-left:4px;">
                            <div style="font-size:11px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;">Limit Saat Ini</div>
                            <div style="font-size:20px;font-weight:800;color:#111827;" id="modalCurrentLimit">-</div>
                        </div>
                    </div>

                    <div id="pendingAlert" class="alert alert-warning d-none" style="border-radius:14px;">
                        <i class="fas fa-clock mr-2"></i>
                        Anda sudah memiliki permintaan yang sedang diproses. Tunggu hasil review admin.
                    </div>

                    <div id="requestForm">
                        <div class="form-group">
                            <label class="font-weight-bold small" style="color:#374151;">
                                Jumlah Limit yang Diinginkan <span class="text-danger">*</span>
                            </label>
                            <input type="number" id="inputRequestedLimit" class="form-control"
                                placeholder="Contoh: 10" min="1" max="9999"
                                style="border-radius:12px;border:1px solid #e5e7eb;padding:12px 16px;font-weight:600;">
                            <small class="text-muted">Masukkan total limit yang Anda inginkan, bukan tambahan.</small>
                        </div>

                        <div class="form-group mb-0">
                            <label class="font-weight-bold small" style="color:#374151;">
                                Alasan Permintaan
                            </label>
                            <textarea id="inputReason" class="form-control" rows="3"
                                placeholder="Jelaskan kebutuhan Anda…"
                                style="border-radius:12px;border:1px solid #e5e7eb;padding:12px 16px;resize:none;"></textarea>
                        </div>
                    </div>

                </div>

                <div class="modal-footer border-0 px-4 pb-4" id="requestFormFooter">
                    <button type="button" class="btn btn-light btn-sm px-4" data-dismiss="modal"
                        onclick="$('#requestLimitModal').modal('hide')"
                        style="border-radius:10px;font-weight:600;">Batal</button>
                    <button type="button" class="btn btn-primary btn-sm px-5" id="btnSubmitRequest"
                        style="border-radius:10px;background:#2563eb;border:none;font-weight:700;">
                        <i class="fas fa-paper-plane mr-1"></i>Kirim Permintaan
                    </button>
                </div>

            </div>
        </div>
    </div>
    @endif

    {{-- TUTORIAL FAB --}}
    <button id="dashboardTutorialBtn" class="dashboard-tutorial-fab" title="Tutorial" onclick="showDashboardTutorialModal()">
        <i class="fas fa-question"></i>
    </button>

    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <script>
            let runningScanTable = null;
            let hasMapAccess = false;
            let currentLevel = 'province';
            let currentParentId = null;
            const isSuperAdmin =
                {{ Auth::user()->hasRole('superadmin') ? 'true' : 'false' }};

            let breadcrumbStack = [{
                level: 'province',
                parent_id: null,
                name: 'Indonesia'
            }];

            let map;
            let markerLayer;
            let polygonLayer;

            let savedRange = JSON.parse(
                localStorage.getItem('dashboard_date_range')
            );

            let startDate = savedRange ?
                moment(savedRange.start_date) :
                moment().subtract(5, 'months').startOf('month');

            let endDate = savedRange ?
                moment(savedRange.end_date) :
                moment().endOf('month');

            $(document).ready(function() {

                initDateRange();

                loadDashboardStats();
                initRunningScanTable();
                if (isSuperAdmin) {
                    loadUserGrowthChart();
                }
            });

            const i18nDashboard = {
                recapTitle:    @json(__('messages.management.dashboard.swal_recap_title')),
                recapText:     @json(__('messages.management.dashboard.swal_recap_text')),
                recapConfirm:  @json(__('messages.management.dashboard.swal_recap_confirm')),
                sending:       @json(__('messages.management.dashboard.sending')),
                successTitle:  @json(__('messages.management.common.swal_success')),
                recapSuccess:  @json(__('messages.management.dashboard.swal_recap_success')),
                failedTitle:   @json(__('messages.management.dashboard.swal_failed')),
                recapError:    @json(__('messages.management.dashboard.swal_recap_error')),
                sendRecap:     @json(__('messages.management.dashboard.send_recap')),
            };

            $(document).on('click', '#btnSendRecapToday', function() {

                Swal.fire({
                    title: i18nDashboard.recapTitle,
                    text: i18nDashboard.recapText,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: i18nDashboard.recapConfirm
                }).then((result) => {

                    if (!result.isConfirmed) return;

                    $.ajax({
                        url: '/management/master/dashboard/send-recap-today',
                        method: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },

                        beforeSend: function() {

                            $('#btnSendRecapToday')
                                .prop('disabled', true)
                                .html(`
                        <span class="spinner-border spinner-border-sm mr-1"></span>
                        ${i18nDashboard.sending}
                    `);
                        },

                        success: function(res) {

                            Swal.fire({
                                icon: 'success',
                                title: i18nDashboard.successTitle,
                                text: res.message ?? i18nDashboard.recapSuccess
                            });
                        },

                        error: function() {

                            Swal.fire({
                                icon: 'error',
                                title: i18nDashboard.failedTitle,
                                text: i18nDashboard.recapError
                            });
                        },

                        complete: function() {

                            $('#btnSendRecapToday')
                                .prop('disabled', false)
                                .html(`
                        <i class="fas fa-paper-plane mr-1"></i>
                        ${i18nDashboard.sendRecap}
                    `);
                        }
                    });
                });
            });

            function initRunningScanTable() {

                runningScanTable = $('#runningScanTable').DataTable({
                    processing: false,
                    serverSide: true,
                    ordering: false,
                    responsive: true,
                    pageLength: 10,
                    dom: '<"top"<"dataTables_length"l><"dataTables_filter"f>><"table-responsive-wrapper"rt><"bottom"<"dataTables_info"i><"dataTables_paginate"p>>',
                    ajax: {
                        url: "{{ route('dashboard.running-scan-time') }}",
                        type: 'GET',

                        data: function(d) {
                            d.start_date =
                                startDate.format('YYYY-MM-DD');

                            d.end_date =
                                endDate.format('YYYY-MM-DD');
                        }
                    },

                    columns: [
                        ...(isSuperAdmin ? [{ data: 'user_name', name: 'user_name' }] : []),
                        {
                            data: 'place_name',
                            name: 'place_name'
                        },
                        {
                            data: 'browser_name',
                            name: 'browser_name'
                        },
                        {
                            data: 'platform',
                            name: 'platform'
                        },

                        {
                            data: 'checked_at',
                            name: 'checked_at'
                        }
                    ]
                });

                /*
                |--------------------------------------------------------------------------
                | AUTO REFRESH
                |--------------------------------------------------------------------------
                */

                setInterval(() => {

                    if (runningScanTable) {
                        runningScanTable.ajax.reload(null, false);
                    }

                }, 10000); // 10 sec
            }

            function initDateRange() {

                function saveDateRange(start, end, label = null) {

                    localStorage.setItem(
                        'dashboard_date_range',
                        JSON.stringify({
                            start_date: start.format('YYYY-MM-DD'),
                            end_date: end.format('YYYY-MM-DD'),
                            label: label
                        })
                    );
                }

                function cb(start, end, label = null) {

                    startDate = start;
                    endDate = end;

                    $('#dashboardDateRange').val(
                        start.format('DD MMM YYYY') +
                        ' - ' +
                        end.format('DD MMM YYYY')
                    );

                    saveDateRange(start, end, label);

                    reloadAllDashboardData();

                    $('#chartRangeLabel').text(
                        label ??
                        (
                            start.format('DD MMM YYYY') +
                            ' - ' +
                            end.format('DD MMM YYYY')
                        )
                    );
                }


                $('#dashboardDateRange').daterangepicker({
                    startDate: startDate,
                    endDate: endDate,

                    autoUpdateInput: false,

                    showDropdowns: true,
                    linkedCalendars: false,
                    singleDatePicker: false,
                    showCustomRangeLabel: true,

                    alwaysShowCalendars: window.innerWidth > 768,
                    opens: 'left',

                    locale: {
                        format: 'DD MMM YYYY',
                        cancelLabel: 'Cancel',
                        applyLabel: 'Apply'
                    },

                    ranges: {
                        'Today': [moment(), moment()],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'Last 3 Months': [
                            moment().subtract(2, 'months').startOf('month'),
                            moment().endOf('month')
                        ],
                        'Last 6 Months': [
                            moment().subtract(5, 'months').startOf('month'),
                            moment().endOf('month')
                        ],
                        'This Year': [
                            moment().startOf('year'),
                            moment().endOf('year')
                        ]
                    }
                }, cb);

                if ($(window).width() < 768) {
                    $('#dashboardDateRange').data('daterangepicker').container.addClass('single');
                }

                /*
                |--------------------------------------------------------------------------
                | INITIAL VALUE
                |--------------------------------------------------------------------------
                */

                $('#dashboardDateRange').val(
                    startDate.format('DD MMM YYYY') +
                    ' - ' +
                    endDate.format('DD MMM YYYY')
                );
            }

            $(document).on('change', '#dashboardDateRange', function() {

                let value = $(this).val();

                if (!value.includes(' - ')) return;

                let split = value.split(' - ');

                let start = moment(split[0], 'DD MMM YYYY');
                let end = moment(split[1], 'DD MMM YYYY');

                if (!start.isValid() || !end.isValid()) {
                    return;
                }

                startDate = start;
                endDate = end;

                const customLabel =
                    start.format('DD MMM YYYY') +
                    ' - ' +
                    end.format('DD MMM YYYY');

                localStorage.setItem(
                    'dashboard_date_range',
                    JSON.stringify({
                        start_date: start.format('YYYY-MM-DD'),
                        end_date: end.format('YYYY-MM-DD'),
                        label: null
                    })
                );

                /*
                |--------------------------------------------------------------------------
                | RESET RANGE LABEL
                |--------------------------------------------------------------------------
                */

                $('#chartRangeLabel').text(customLabel);

                reloadAllDashboardData();
            });

            function reloadAllDashboardData() {

                loadDashboardStats();

                if (hasMapAccess) {
                    loadMapData(
                        currentLevel,
                        currentParentId
                    );

                    loadTopPlacesChart();
                }

                if (isSuperAdmin) {
                    loadUserGrowthChart();
                }
            }

            function initMap() {

                if (map) {
                    map.remove();
                }

                map = L.map('analyticsMap', {
                    zoomControl: true,
                    scrollWheelZoom: true
                }).setView([-2.5, 118], 5);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                markerLayer = L.layerGroup().addTo(map);

                polygonLayer = L.layerGroup().addTo(map);

                setTimeout(() => {
                    map.invalidateSize();
                }, 200);
            }

            function animateValue(selector, value) {

                $({
                    countNum: parseInt($(selector).text().replace(/,/g, '')) || 0
                }).animate({
                    countNum: value
                }, {
                    duration: 700,
                    easing: 'swing',

                    step: function() {
                        $(selector).text(
                            Math.floor(this.countNum).toLocaleString()
                        );
                    },

                    complete: function() {
                        $(selector).text(
                            this.countNum.toLocaleString()
                        );
                    }
                });
            }

            function loadDashboardStats() {

                $.ajax({
                    url: "{{ route('dashboard.stats') }}",
                    method: 'GET',

                    data: {
                        start_date: startDate.format('YYYY-MM-DD'),
                        end_date: endDate.format('YYYY-MM-DD')
                    },

                    success: function(res) {

                        animateValue('#stat-user-count', res.user_count ?? 0);
                        animateValue('#stat-user-pending', res.user_pending ?? 0);

                        animateValue('#stat-place-total', res.place_total ?? 0);
                        animateValue(
                            '#stat-event-count', res.event_count ?? 0);
                        animateValue('#stat-comments-count',
                            res.comments_count ?? 0);
                        animateValue('#stat-gallery-count', res
                            .gallery_count ?? 0);
                        animateValue('#stat-blog-count', res.blog_count ??
                            0);
                        animateValue('#stat-user-not-verified', res.user_not_verified ?? 0);

                        $('#stat-avg-checkin').text(
                            res.checkin_analytics?.avg_checkin_time ?? '00:00:00'
                        );

                        $('#stat-fastest-checkin').text(
                            res.checkin_analytics?.fastest_checkin_time ?? '00:00:00'
                        );

                        $('#stat-slowest-checkin').text(
                            res.checkin_analytics?.slowest_checkin_time ?? '00:00:00'
                        );

                        $('#placeLimitText').text(
                            res.account_limit ?? '-'
                        );

                        /*
                        |--------------------------------------------------------------------------
                        | MAP ACCESS BASED ON PLACE LIMIT
                        |--------------------------------------------------------------------------
                        */

                        const placeLimit = parseInt(res.account_limit ?? 0);

                        hasMapAccess = placeLimit > 1 || res.account_limit == 'Unlimited';
                        console.log('Map Access:', hasMapAccess);
                        if (hasMapAccess) {
                            loadTopPlacesChart();
                            $("topPlacesSection").removeClass('d-none');
                            $('#mapSection').removeClass('d-none');

                            // init sekali saja
                            if (!map) {
                                initMap();
                                loadMapData();
                            }

                        } else {

                            $('#topPlacesSection').addClass('d-none');
                            $('#mapSection').addClass('d-none');
                        }
                    }
                });
            }

            function loadMapData(level = 'province', parentId = null) {

                currentLevel = level;
                currentParentId = parentId;

                $('#mapLoading').css('display', 'flex');

                markerLayer.clearLayers();
                polygonLayer.clearLayers();

                $.ajax({
                    url: "{{ route('dashboard.map-data') }}",
                    method: 'GET',
                    data: {
                        level: level,
                        parent_id: parentId,
                        start_date: startDate.format('YYYY-MM-DD'),
                        end_date: endDate.format('YYYY-MM-DD')
                    },

                    success: function(res) {

                        markerLayer.clearLayers();
                        polygonLayer.clearLayers();

                        if (!res.length) {
                            $('#mapLoading').hide();
                            return;
                        }

                        const bounds = [];

                        res.forEach(item => {

                            if (!item.latitude || !item.longitude)
                                return;

                            let total = parseInt(item.total_places ?? 0);

                            let radius = Math.max(18, Math.min(total * 3, 65));

                            let polygon = null;

                            if (item.polygon_path) {

                                try {

                                    let coords = JSON.parse(item.polygon_path);

                                    /*
                                    |--------------------------------------------------------------------------
                                    | Normalize coordinate format
                                    |--------------------------------------------------------------------------
                                    */

                                    function normalizeCoords(arr) {

                                        return arr.map(coord => {

                                            // MULTI DIMENSION
                                            if (Array.isArray(coord[0])) {
                                                return normalizeCoords(coord);
                                            }

                                            return [
                                                parseFloat(coord[0]),
                                                parseFloat(coord[1])
                                            ];
                                        });
                                    }

                                    coords = normalizeCoords(coords);

                                    /*
                                    |--------------------------------------------------------------------------
                                    | AUTO DETECT MULTI POLYGON
                                    |--------------------------------------------------------------------------
                                    */

                                    const isMultiPolygon =
                                        Array.isArray(coords[0]) &&
                                        Array.isArray(coords[0][0]) &&
                                        Array.isArray(coords[0][0][0]);

                                    if (isMultiPolygon) {

                                        polygon = L.multiPolygon(coords, {
                                            color: '#2563eb',
                                            weight: 2,
                                            fillColor: '#3b82f6',
                                            fillOpacity: 0.18
                                        });

                                    } else {

                                        polygon = L.polygon(coords, {
                                            color: '#2563eb',
                                            weight: 2,
                                            fillColor: '#3b82f6',
                                            fillOpacity: 0.18
                                        });
                                    }

                                    polygon.addTo(polygonLayer);
                                    polygon.bringToFront();

                                    /*
                                    |--------------------------------------------------------------------------
                                    | FIT BOUNDS
                                    |--------------------------------------------------------------------------
                                    */

                                    bounds.push(...polygon.getBounds().getNorthEast() ? [
                                        [
                                            polygon.getBounds().getSouthWest().lat,
                                            polygon.getBounds().getSouthWest().lng
                                        ],
                                        [
                                            polygon.getBounds().getNorthEast().lat,
                                            polygon.getBounds().getNorthEast().lng
                                        ]
                                    ] : []);

                                } catch (e) {

                                    console.log('Polygon Error:', e);
                                    console.log(item.polygon_path);
                                }
                            }

                            const circle = L.circleMarker([
                                item.latitude,
                                item.longitude
                            ], {
                                radius: radius,
                                fillColor: '#2563eb',
                                color: '#ffffff',
                                weight: 3,
                                opacity: 1,
                                fillOpacity: 0.88
                            });

                            circle.bindPopup(`
                    <div style="min-width:200px">
                        <div style="font-size:18px;font-weight:800;color:#111827;">
                            ${item.name}
                        </div>

                        <div style="margin-top:10px">
                            <div style="font-size:14px;">
                                Total Places
                            </div>

                            <div style="font-size:26px;font-weight:800;color:#2563eb;">
                                ${total}
                            </div>
                        </div>

                        <div style="margin-top:10px;color:#6b7280;font-size:13px;">
                            Click to explore region
                        </div>
                    </div>
                `, {
                                className: 'custom-popup'
                            });

                            const label = L.marker([
                                item.latitude,
                                item.longitude
                            ], {
                                interactive: true,
                                icon: L.divIcon({
                                    className: 'bubble-label clickable',
                                    html: `
                            <div class="bubble-content">
                                ${item.name}
                                <small>${total} Places</small>
                            </div>
                        `,
                                    iconSize: [120, 40]
                                })
                            });

                            markerLayer.addLayer(circle);
                            markerLayer.addLayer(label);

                            if (polygon) {

                                polygon.on('mouseover', function() {
                                    polygon.setStyle({
                                        fillOpacity: 0.35
                                    });
                                });

                                polygon.on('mouseout', function() {
                                    polygon.setStyle({
                                        fillOpacity: 0.18
                                    });
                                });
                            }

                            function handleRegionClick() {

                                showBreakdownPanel(item);

                                let nextLevel = null;

                                if (level === 'province') {
                                    nextLevel = 'regency';
                                }

                                if (!nextLevel) return;

                                /*
                                |--------------------------------------------------------------------------
                                | ZOOM TO POLYGON
                                |--------------------------------------------------------------------------
                                */

                                if (polygon) {

                                    map.fitBounds(
                                        polygon.getBounds(), {
                                            padding: [40, 40],
                                            maxZoom: 10
                                        }
                                    );

                                } else {

                                    map.setView(
                                        [item.latitude, item.longitude],
                                        9
                                    );
                                }

                                /*
                                |--------------------------------------------------------------------------
                                | BREADCRUMB
                                |--------------------------------------------------------------------------
                                */

                                const alreadyExists = breadcrumbStack.find(x =>
                                    x.level === nextLevel &&
                                    x.parent_id == item.id
                                );

                                if (!alreadyExists) {

                                    breadcrumbStack.push({
                                        level: nextLevel,
                                        parent_id: item.id,
                                        name: item.name
                                    });
                                }

                                renderBreadcrumb();

                                /*
                                |--------------------------------------------------------------------------
                                | LOAD NEXT DATA
                                |--------------------------------------------------------------------------
                                */

                                loadMapData(nextLevel, item.id);
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | CLICK EVENTS
                            |--------------------------------------------------------------------------
                            */

                            circle.on('click', handleRegionClick);

                            if (polygon) {
                                polygon.on('click', handleRegionClick);
                            }

                            label.on('click', handleRegionClick);
                            bounds.push([
                                item.latitude,
                                item.longitude
                            ]);
                        });

                        if (bounds.length) {

                            map.fitBounds(bounds, {
                                padding: [60, 60]
                            });
                        }

                        $('#mapLoading').hide();

                        setTimeout(() => {
                            map.invalidateSize();
                        }, 200);
                    },

                    complete: function() {
                        $('#mapLoading').hide();
                    }
                });
            }

            function showBreakdownPanel(item) {

                $('#mapSidePanel').removeClass('hidden');

                $('#mapSideTitle').html(item.name);

                $('#mapSideSubtitle').html(
                    currentLevel === 'province' ?
                    'Regency, district & village summary' :
                    'District & village summary'
                );

                let html = '';

                if (!item.breakdown || !item.breakdown.length) {

                    html = `
                        <div style="padding:20px;text-align:center;color:#6b7280;">
                            No breakdown data available
                        </div>
                    `;

                    $('#mapBreakdownContent').html(html);
                    return;
                }

                /*
                |--------------------------------------------------------------------------
                | PROVINCE STRUCTURE
                |--------------------------------------------------------------------------
                */

                if (currentLevel === 'province') {

                    item.breakdown.forEach(regency => {

                        html += `
                <div class="breakdown-group">

                    <div style="
                        font-size:16px;
                        font-weight:800;
                        margin-bottom:14px;
                        color:#111827;
                    ">
                        ${regency.regency_name}
                    </div>
                `;

                        regency.districts.forEach(district => {

                            html += `
                    <div class="breakdown-header">
                        <span>${district.district_name}</span>
                        <span>${district.total_places} Places</span>
                    </div>
                `;

                            district.villages.forEach(village => {

                                html += `
                        <div class="breakdown-item">

                            <div class="breakdown-item-name">
                                ${village.name}
                            </div>

                            <div class="breakdown-item-total">
                                ${village.total}
                            </div>

                        </div>
                    `;
                            });
                        });

                        html += `</div>`;
                    });
                }

                /*
                |--------------------------------------------------------------------------
                | REGENCY STRUCTURE
                |--------------------------------------------------------------------------
                */
                else {

                    item.breakdown.forEach(group => {

                        html += `
                <div class="breakdown-group">

                    <div class="breakdown-header">
                        <span>${group.district_name}</span>
                        <span>${group.total_places} Places</span>
                    </div>
             `;

                        group.villages.forEach(village => {

                            html += `
                    <div class="breakdown-item">

                        <div class="breakdown-item-name">
                            ${village.name}
                        </div>

                        <div class="breakdown-item-total">
                            ${village.total}
                        </div>

                    </div>
                `;
                        });

                        html += `</div>`;
                    });
                }

                $('#mapBreakdownContent').html(html);
            }

            function resetBreakdownPanel() {

                $('#mapSidePanel').addClass('hidden');

                $('#mapSideTitle').html('Region Summary');

                $('#mapSideSubtitle').html(
                    'Click region bubble to see details'
                );

                $('#mapBreakdownContent').html('');
            }

            function renderDistrictVillageList(data, level) {

                let html = `
                    <div class="card analytics-card mt-4">

                        <div class="card-header">
                            <h5>
                                ${
                                    level === 'district'
                                    ? 'District Analytics'
                                    : 'Village Analytics'
                                }
                            </h5>
                        </div>

                        <div class="card-body">
                `;

                data.forEach(item => {

                    html += `
                        <div class="district-list-item"
                            onclick="
                                ${
                                    level === 'district'
                                    ? `openVillage(${item.id}, '${item.name}')`
                                    : ''
                                }
                            "
                        >

                            <div class="d-flex justify-content-between align-items-center">

                                <div>

                                    <div style="
                                        font-weight:700;
                                        font-size:16px;
                                    ">
                                        ${item.name}
                                    </div>

                                    <small class="text-muted">
                                        Territory Analytics
                                    </small>

                                </div>

                                <div class="text-right">

                                    <div class="district-total">
                                        ${item.total_places ?? 0}
                                    </div>

                                    <small>
                                        Total Places
                                    </small>

                                </div>

                            </div>

                        </div>
                    `;
                });

                html += `
                        </div>
                    </div>
                `;

                $('#districtVillageContainer').html(html);
            }

            function openVillage(id, name) {

                breadcrumbStack.push({
                    level: 'village',
                    parent_id: id,
                    name: name
                });

                renderBreadcrumb();

                loadMapData('village', id);
            }

            function renderBreadcrumb() {

                let unique = [];

                breadcrumbStack.forEach(item => {

                    const exists = unique.find(x =>
                        x.level === item.level &&
                        x.parent_id == item.parent_id
                    );

                    if (!exists) {
                        unique.push(item);
                    }
                });

                breadcrumbStack = unique;

                let html = '';

                breadcrumbStack.forEach((item, index) => {

                    const isLast = index === breadcrumbStack.length - 1;

                    html += `
            <span 
                class="breadcrumb-item-map ${isLast ? 'active' : ''}" 
                onclick="navigateBreadcrumb(${index})"
            >
                ${item.name}
            </span>
        `;

                    if (!isLast) {
                        html += `
                <i class="fas fa-chevron-right" style="font-size:11px;color:#9ca3af;"></i>
            `;
                    }
                });

                $('#mapBreadcrumb').html(html);
            }

            function navigateBreadcrumb(index) {

                breadcrumbStack = breadcrumbStack.slice(0, index + 1);

                const item = breadcrumbStack[index];

                /*
                |--------------------------------------------------------------------------
                | RESET SUMMARY IF BACK TO INDONESIA
                |--------------------------------------------------------------------------
                */

                if (item.level === 'province' && item.parent_id === null) {

                    resetBreakdownPanel();

                    map.setView([-2.5, 118], 5);
                }

                renderBreadcrumb();

                loadMapData(
                    item.level,
                    item.parent_id
                );
            }

            function resetMapNavigation() {

                /*
                |--------------------------------------------------------------------------
                | RESET STATE
                |--------------------------------------------------------------------------
                */

                currentLevel = 'province';
                currentParentId = null;

                breadcrumbStack = [{
                    level: 'province',
                    parent_id: null,
                    name: 'Indonesia'
                }];

                /*
                |--------------------------------------------------------------------------
                | RESET UI
                |--------------------------------------------------------------------------
                */

                renderBreadcrumb();
                resetBreakdownPanel();

                $('#districtVillageContainer').html('');

                /*
                |--------------------------------------------------------------------------
                | RESET MAP POSITION
                |--------------------------------------------------------------------------
                */

                map.setView([-2.5, 118], 5);

                /*
                |--------------------------------------------------------------------------
                | LOAD DEFAULT DATA
                |--------------------------------------------------------------------------
                */

                loadMapData('province', null);
            }

            function loadTopPlacesChart() {

                fetch(
                        `/management/master/dashboard/data/chart?start_date=${startDate.format('YYYY-MM-DD')}&end_date=${endDate.format('YYYY-MM-DD')}`
                    )
                    .then(response => response.json())
                    .then(data => {

                        const places = data?.data?.place_code?.[0] ?? [];
                        const views = data?.data?.no?.[0] ?? [];

                        const hasData = places.length > 0;

                        const labels = hasData ?
                            places.map(item =>
                                item.title ?
                                item.title :
                                item.code
                            ) : [];

                        const options = {

                            chart: {
                                type: 'bar',
                                height: 380,
                                toolbar: {
                                    show: false
                                },
                                animations: {
                                    enabled: true
                                }
                            },

                            series: hasData ? [{
                                name: 'Views',
                                data: views
                            }] : [],

                            noData: {
                                text: 'No top places data available',
                                align: 'center',
                                verticalAlign: 'middle',
                                style: {
                                    fontSize: '14px'
                                }
                            },

                            colors: ['#2563eb'],

                            plotOptions: {
                                bar: {
                                    borderRadius: 12,
                                    columnWidth: '48%',
                                    distributed: false
                                }
                            },

                            dataLabels: {
                                enabled: false
                            },

                            grid: {
                                borderColor: '#f1f5f9'
                            },

                            xaxis: {
                                categories: labels,
                                labels: {
                                    style: {
                                        fontSize: '12px'
                                    }
                                }
                            },

                            yaxis: {
                                labels: {
                                    formatter: function(val) {
                                        return val.toLocaleString();
                                    }
                                }
                            },

                            tooltip: {
                                theme: 'light'
                            }
                        };

                        if (window.topPlacesChartObj) {
                            window.topPlacesChartObj.destroy();
                        }

                        window.topPlacesChartObj = new ApexCharts(
                            document.querySelector("#topPlacesChart"),
                            options
                        );

                        window.topPlacesChartObj.render();
                    })
                    .catch(error => {

                        console.error('Top Places Chart Error:', error);

                        if (window.topPlacesChartObj) {
                            window.topPlacesChartObj.destroy();
                        }

                        window.topPlacesChartObj = new ApexCharts(
                            document.querySelector("#topPlacesChart"), {
                                chart: {
                                    type: 'bar',
                                    height: 380
                                },
                                series: [],
                                noData: {
                                    text: 'Failed to load chart data'
                                }
                            }
                        );

                        window.topPlacesChartObj.render();
                    });
            }

            function loadUserGrowthChart() {

                fetch(
                        `/management/master/dashboard/data/user-growth/chart?start_date=${startDate.format('YYYY-MM-DD')}&end_date=${endDate.format('YYYY-MM-DD')}`
                    )
                    .then(response => response.json())
                    .then(data => {

                        const hasData = Array.isArray(data) && data.length > 0;

                        const labels = hasData ?
                            data.map(item => {

                                const date = new Date(item.month);

                                return date.toLocaleString('default', {
                                    month: 'short',
                                    year: 'numeric'
                                });
                            }) : [];

                        const userCounts = hasData ?
                            data.map(item => item.user_count) : [];

                        const options = {

                            chart: {
                                type: 'area',
                                height: 380,
                                toolbar: {
                                    show: false
                                },
                                zoom: {
                                    enabled: false
                                }
                            },

                            colors: ['#2563eb'],

                            series: hasData ? [{
                                name: 'Users',
                                data: userCounts
                            }] : [],

                            noData: {
                                text: 'No user growth data available',
                                align: 'center',
                                verticalAlign: 'middle',
                                style: {
                                    fontSize: '14px'
                                }
                            },

                            dataLabels: {
                                enabled: false
                            },

                            stroke: {
                                curve: 'smooth',
                                width: 4
                            },

                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shadeIntensity: 1,
                                    opacityFrom: 0.4,
                                    opacityTo: 0.05,
                                    stops: [0, 90, 100]
                                }
                            },

                            grid: {
                                borderColor: '#f1f5f9'
                            },

                            markers: {
                                size: 5
                            },

                            xaxis: {
                                categories: labels
                            },

                            tooltip: {
                                x: {
                                    show: true
                                }
                            }
                        };

                        if (window.userGrowthChartObj) {
                            window.userGrowthChartObj.destroy();
                        }

                        window.userGrowthChartObj = new ApexCharts(
                            document.querySelector("#userGrowthChart"),
                            options
                        );

                        window.userGrowthChartObj.render();
                    });
            }
        </script>

        <script src="https://cdn.jsdelivr.net/npm/intro.js@7.2.0/minified/intro.min.js"></script>
        <script>
            const dashboardTutorialSteps = {
                id: [
                    {
                        element: '#dashboardHeaderSection',
                        intro: '<strong>Selamat Datang di Dashboard!</strong><br>Halaman ini menampilkan gambaran umum analytics platform dan data real-time seluruh aktivitas dalam satu tampilan.',
                        position: 'bottom'
                    },
                    {
                        element: '#placeLimitChip',
                        intro: '<strong>Batas Tempat</strong><br>Menampilkan batas akses tempat akun Anda berdasarkan paket langganan yang aktif.',
                        position: 'bottom'
                    },
                    {
                        element: '#filterInfoChip',
                        intro: '<strong>Info Filter</strong><br>Menampilkan rentang tanggal filter yang sedang aktif. Semua statistik dan chart mengikuti filter ini.',
                        position: 'bottom'
                    },
                    {
                        element: '#dashboardDateRange',
                        intro: '<strong>Pilih Rentang Tanggal</strong><br>Klik di sini untuk memilih rentang tanggal kustom. Semua statistik, chart, dan peta akan diperbarui otomatis sesuai tanggal yang dipilih.',
                        position: 'bottom'
                    },
                    {
                        element: '#statsWrapper',
                        intro: '<strong>Kartu Statistik</strong><br>Metrik utama secara sekilas: total pengguna, tempat, event, komentar, galeri, blog, dan analitik waktu check-in.',
                        position: 'top'
                    },
                    {
                        element: '#runningScanHeader',
                        intro: '<strong>Tabel Running Scan</strong><br>Tabel real-time yang menampilkan aktivitas check-in dan scan pengguna terbaru. Data diperbarui setiap 10 detik secara otomatis.',
                        position: 'bottom'
                    },
                    {
                        element: '#topPlacesSection',
                        intro: '<strong>Chart Top Tempat</strong><br>Bar chart yang menampilkan tempat paling banyak dikunjungi dalam rentang tanggal yang dipilih. Gunakan filter tanggal untuk mengubah periode analitik.',
                        position: 'top'
                    },
                    {
                        element: '#mapSection',
                        intro: '<strong>Peta Analitik Lokasi</strong><br>Peta interaktif yang menampilkan distribusi tempat di seluruh wilayah Indonesia. Klik bubble atau area untuk menjelajah lebih dalam (Provinsi → Kabupaten → Kecamatan → Desa).',
                        position: 'top'
                    }
                ],
                en: [
                    {
                        element: '#dashboardHeaderSection',
                        intro: '<strong>Welcome to Dashboard!</strong><br>This page provides an overview of all platform analytics and real-time activity data in one place.',
                        position: 'bottom'
                    },
                    {
                        element: '#placeLimitChip',
                        intro: '<strong>Place Limit</strong><br>Shows your current place access limit based on your active subscription plan.',
                        position: 'bottom'
                    },
                    {
                        element: '#filterInfoChip',
                        intro: '<strong>Filter Info</strong><br>Displays the currently active date range filter. All statistics and charts follow this filter.',
                        position: 'bottom'
                    },
                    {
                        element: '#dashboardDateRange',
                        intro: '<strong>Date Range Picker</strong><br>Click here to select a custom date range. All stats, charts, and map data will automatically reload based on the selected dates.',
                        position: 'bottom'
                    },
                    {
                        element: '#statsWrapper',
                        intro: '<strong>Statistics Cards</strong><br>Key metrics at a glance: total users, places, events, comments, gallery, blogs, and check-in time analytics.',
                        position: 'top'
                    },
                    {
                        element: '#runningScanHeader',
                        intro: '<strong>Running Scan Table</strong><br>Real-time table showing recent user check-in and scan activity. Data refreshes automatically every 10 seconds.',
                        position: 'bottom'
                    },
                    {
                        element: '#topPlacesSection',
                        intro: '<strong>Top Places Chart</strong><br>Bar chart displaying the most-visited places within the selected date range. Use the date filter to change the analytics period.',
                        position: 'top'
                    },
                    {
                        element: '#mapSection',
                        intro: '<strong>Location Analytics Map</strong><br>Interactive map showing place distribution across Indonesian regions. Click bubbles or areas to drill down (Province → Regency → District → Village).',
                        position: 'top'
                    }
                ]
            };

            function startDashboardTutorial(lang) {
                const steps = dashboardTutorialSteps[lang] ?? dashboardTutorialSteps['en'];

                const validSteps = steps.filter(step => {
                    const el = document.querySelector(step.element);
                    return el && el.offsetParent !== null;
                });

                introJs()
                    .setOptions({
                        steps: validSteps,
                        nextLabel: lang === 'id' ? 'Lanjut ›' : 'Next ›',
                        prevLabel: lang === 'id' ? '‹ Kembali' : '‹ Back',
                        doneLabel: lang === 'id' ? 'Selesai' : 'Done',
                        showBullets: true,
                        showProgress: true,
                        exitOnOverlayClick: false,
                        scrollToElement: false,
                        overlayOpacity: 0.5
                    })
                    .onbeforechange(function(el) {
                        if (el) {
                            setTimeout(function() {
                                el.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'center',
                                    inline: 'nearest'
                                });
                            }, 50);
                        }
                    })
                    .oncomplete(function() {
                        localStorage.setItem('dashboard_tutorial_seen', '1');
                    })
                    .onexit(function() {
                        localStorage.setItem('dashboard_tutorial_seen', '1');
                    })
                    .start();
            }

            function showDashboardTutorialModal() {
                Swal.fire({
                    title: '👋 Welcome',
                    html: `
                        <p class="text-muted mb-4">
                            Please choose your preferred tutorial language
                            or skip the tutorial.
                        </p>

                        <div class="row">

                            <div class="col-6 mb-3">
                                <button
                                    id="dashboard-lang-id"
                                    class="btn btn-primary btn-block py-3">
                                    🇮🇩<br>
                                    <strong>Bahasa Indonesia</strong>
                                </button>
                            </div>

                            <div class="col-6 mb-3">
                                <button
                                    id="dashboard-lang-en"
                                    class="btn btn-outline-primary btn-block py-3">
                                    🇺🇸<br>
                                    <strong>English</strong>
                                </button>
                            </div>

                        </div>

                        <hr>

                        <button
                            id="dashboard-skip"
                            class="btn btn-link text-muted">
                            Skip Tutorial
                        </button>
                    `,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: function() {
                        document.getElementById('dashboard-lang-id').addEventListener('click', function() {
                            localStorage.setItem('dashboard_tutorial_lang', 'id');
                            Swal.close();
                            startDashboardTutorial('id');
                        });
                        document.getElementById('dashboard-lang-en').addEventListener('click', function() {
                            localStorage.setItem('dashboard_tutorial_lang', 'en');
                            Swal.close();
                            startDashboardTutorial('en');
                        });
                        document.getElementById('dashboard-skip').addEventListener('click', function() {
                            localStorage.setItem('dashboard_tutorial_seen', '1');
                            Swal.close();
                        });
                    }
                });
            }

            document.addEventListener('DOMContentLoaded', function() {
                const seen = localStorage.getItem('dashboard_tutorial_seen');
                if (!seen) {
                    setTimeout(function() {
                        showDashboardTutorialModal();
                    }, 800);
                }
            });
        </script>

        @if (!Auth::user()->hasRole('superadmin'))
        <script>
            function openRequestLimitModal() {
                // Show current limit in modal
                const currentLimitText = document.getElementById('placeLimitText')?.innerText ?? '-';
                document.getElementById('modalCurrentLimit').innerText = currentLimitText;

                // Reset form state
                document.getElementById('pendingAlert').classList.add('d-none');
                document.getElementById('requestForm').classList.remove('d-none');
                document.getElementById('requestFormFooter').classList.remove('d-none');
                document.getElementById('inputRequestedLimit').value = '';
                document.getElementById('inputReason').value = '';

                // Check if already has pending request
                $.get('{{ route('place-limit-request.check-pending') }}', function (res) {
                    if (res.has_pending) {
                        document.getElementById('pendingAlert').classList.remove('d-none');
                        document.getElementById('requestForm').classList.add('d-none');
                        document.getElementById('requestFormFooter').classList.add('d-none');
                    }
                });

                $('#requestLimitModal').modal('show');
            }

            $('#btnSubmitRequest').on('click', function () {
                const limit  = $('#inputRequestedLimit').val().trim();
                const reason = $('#inputReason').val().trim();

                if (!limit || parseInt(limit) < 1) {
                    Swal.fire({ icon: 'warning', title: 'Isian tidak valid', text: 'Masukkan jumlah limit yang valid.' });
                    return;
                }

                const $btn = $(this).prop('disabled', true).html('<span class="spinner-border spinner-border-sm mr-1"></span>Mengirim...');

                $.ajax({
                    url: '{{ route('place-limit-request.store') }}',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        requested_limit: limit,
                        reason: reason,
                    },
                    success: function (res) {
                        $('#requestLimitModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Permintaan Terkirim!',
                            text: res.message,
                            timer: 3000,
                            showConfirmButton: false,
                        });
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: xhr.responseJSON?.message ?? 'Terjadi kesalahan, coba lagi.',
                        });
                    },
                    complete: function () {
                        $btn.prop('disabled', false).html('<i class="fas fa-paper-plane mr-1"></i>Kirim Permintaan');
                    }
                });
            });
        </script>
        @endif
    @endpush
@endsection
