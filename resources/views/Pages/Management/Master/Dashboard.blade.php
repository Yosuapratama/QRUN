@extends('TemplateLayout.AdminLayout')

@section('content')
    @push('title')
        <title>Dashboard Admin - QRUN Website</title>
    @endpush

    @push('css')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

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
                    max-height: unset;
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
        | FILTER INFO
        |--------------------------------------------------------------------------
        */

            .filter-info-chip {
                display: flex;
                align-items: center;
                gap: 10px;

                background: #ffffff;
                border: 1px solid #e5e7eb;

                border-radius: 14px;

                padding: 10px 14px;

                min-height: 58px;

                box-shadow: 0 3px 10px rgba(0, 0, 0, .04);
            }

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
            }

            .filter-info-content {
                line-height: 1.1;
            }

            .filter-info-label {
                display: block;
                color: #6b7280;
                font-size: 11px;
                font-weight: 700;
                margin-bottom: 4px;
            }

            .filter-info-value {
                font-size: 13px;
                font-weight: 700;
                color: #111827;
            }

            /*
        |--------------------------------------------------------------------------
        | PLACE LIMIT
        |--------------------------------------------------------------------------
        */

            .place-limit-chip {
                display: flex;
                align-items: center;
                gap: 10px;

                background: #ffffff;
                border: 1px solid #e5e7eb;

                border-radius: 14px;

                padding: 10px 14px;

                min-height: 58px;

                box-shadow: 0 3px 10px rgba(0, 0, 0, .04);
            }

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
            }

            .place-limit-content {
                line-height: 1.1;
            }

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

            /*
        |--------------------------------------------------------------------------
        | DATE RANGE
        |--------------------------------------------------------------------------
        */

            .date-range-wrapper {
                min-width: 280px;
            }

            #dashboardDateRange {
                background: #fff;
                cursor: pointer;

                border: 1px solid #e5e7eb;
                border-radius: 14px;

                width: 100%;

                padding: 15px 18px;

                font-weight: 700;
                font-size: 14px;

                color: #111827;

                box-shadow: 0 3px 10px rgba(0, 0, 0, .04);
            }

            /*
        |--------------------------------------------------------------------------
        | MOBILE
        |--------------------------------------------------------------------------
        */

            @media(max-width:768px) {

                .dashboard-header {
                    align-items: stretch;
                }

                .dashboard-toolbar {
                    width: 100%;
                    flex-direction: column;
                    align-items: stretch;
                }

                .filter-info-chip,
                .place-limit-chip {
                    width: 100%;
                }

                .date-range-wrapper {
                    width: 100%;
                    min-width: 100%;
                }

                #dashboardDateRange {
                    width: 100%;
                }
            }

            @media(max-width:768px) {

                .place-limit-card {
                    width: auto;
                    min-width: unset;
                    padding: 8px 12px;
                    height: 46px;
                }

                .place-limit-value {
                    font-size: 14px;
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
        </style>
    @endpush

    <div class="container-fluid">

        <div class="dashboard-header">

            <div class="dashboard-title">
                <h1>Dashboard</h1>
                <p>
                    Analytics overview, territory monitoring & performance insights
                </p>
            </div>

            <div class="dashboard-toolbar">

                {{-- PLACE LIMIT --}}
                <div class="place-limit-chip">

                    <div class="place-limit-icon">
                        <i class="fas fa-layer-group"></i>
                    </div>

                    <div class="place-limit-content">

                        <small class="place-limit-label">
                            Place Limit
                        </small>

                        <div class="place-limit-value" id="placeLimitText">
                            {{ $data['account_limit'] ?? '-' }}
                        </div>

                    </div>

                </div>

                {{-- FILTER INFO --}}
                <div class="filter-info-chip">

                    <div class="filter-info-icon">
                        <i class="fas fa-filter"></i>
                    </div>

                    <div class="filter-info-content">

                        <small class="filter-info-label">
                            Statistics Filter
                        </small>

                        <div class="filter-info-value">
                            Selected Date Range
                        </div>

                    </div>

                </div>

                
                {{-- DATE RANGE --}}
                <div class="date-range-wrapper">
                    <input type="text" id="dashboardDateRange">
                </div>

            </div>

        </div>

        {{-- STAT CARD --}}
        <div class="row" id="statsWrapper">

            @if (Auth::user()->hasRole('superadmin'))
                @php
                    $stats = [
                        [
                            'title' => 'Total Users',
                            'id' => 'stat-user-count',
                            'value' => '0',
                            'icon' => 'fas fa-users',
                            'bg' => 'primary',
                        ],
                        [
                            'title' => 'Pending Users',
                            'id' => 'stat-user-pending',
                            'value' => '0',
                            'icon' => 'fas fa-user-clock',
                            'bg' => 'warning',
                        ],
                        [
                            'title' => 'Places',
                            'id' => 'stat-place-total',
                            'value' => '0',
                            'icon' => 'fas fa-map-marked-alt',
                            'bg' => 'success',
                        ],
                        [
                            'title' => 'Events',
                            'id' => 'stat-event-count',
                            'value' => '0',
                            'icon' => 'fas fa-calendar-alt',
                            'bg' => 'info',
                        ],
                        [
                            'title' => 'Comments',
                            'id' => 'stat-comments-count',
                            'value' => '0',
                            'icon' => 'fas fa-comments',
                            'bg' => 'secondary',
                        ],
                        [
                            'title' => 'Gallery',
                            'id' => 'stat-gallery-count',
                            'value' => '0',
                            'icon' => 'fas fa-images',
                            'bg' => 'dark',
                        ],
                        [
                            'title' => 'Blogs',
                            'id' => 'stat-blog-count',
                            'value' => '0',
                            'icon' => 'fas fa-blog',
                            'bg' => 'danger',
                        ],
                        [
                            'title' => 'Not Verified',
                            'id' => 'stat-user-not-verified',
                            'value' => '0',
                            'icon' => 'fas fa-user-shield',
                            'bg' => 'warning',
                        ],
                        [
                            'title' => 'Avg Checkin Time',
                            'id' => 'stat-avg-checkin',
                            'value' => '00:00:00',
                            'icon' => 'fas fa-clock',
                            'bg' => 'info',
                        ],

                        [
                            'title' => 'Fastest Checkin',
                            'id' => 'stat-fastest-checkin',
                            'value' => '00:00:00',
                            'icon' => 'fas fa-bolt',
                            'bg' => 'success',
                        ],

                        [
                            'title' => 'Slowest Checkin',
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
                            'title' => 'Places',
                            'id' => 'stat-place-total',
                            'value' => '0',
                            'icon' => 'fas fa-map-marked-alt',
                            'bg' => 'success',
                        ],
                        [
                            'title' => 'Events',
                            'id' => 'stat-event-count',
                            'value' => '0',
                            'icon' => 'fas fa-calendar-alt',
                            'bg' => 'info',
                        ],
                        [
                            'title' => 'Comments',
                            'id' => 'stat-comments-count',
                            'value' => '0',
                            'icon' => 'fas fa-comments',
                            'bg' => 'secondary',
                        ],
                        [
                            'title' => 'Avg Checkin Time',
                            'id' => 'stat-avg-checkin',
                            'value' => '00:00:00',
                            'icon' => 'fas fa-clock',
                            'bg' => 'info',
                        ],

                        [
                            'title' => 'Fastest Checkin',
                            'id' => 'stat-fastest-checkin',
                            'value' => '00:00:00',
                            'icon' => 'fas fa-bolt',
                            'bg' => 'success',
                        ],

                        [
                            'title' => 'Slowest Checkin',
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
        <div class="card analytics-card">

            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">

                <div>
                    <h5 class="mb-1">Location Analytics Map</h5>

                    <small class="text-muted">
                        Click <strong>How to Use</strong> for interaction guide
                    </small>
                </div>

                <button class="btn btn-primary btn-sm px-3" data-toggle="modal" data-target="#mapGuideModal">
                    <i class="fas fa-info-circle mr-1"></i>
                    How to Use
                </button>

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
                            Region Summary
                        </div>

                        <div class="map-side-subtitle" id="mapSideSubtitle">
                            Click region bubble to see details
                        </div>

                        <div id="mapBreakdownContent"></div>
                    </div>

                </div>

                <div id="districtVillageContainer" class="mt-4"></div>

            </div>

        </div>

        {{-- TOP PLACES --}}
        <div class="row">

            {{-- TOP PLACES --}}
            <div class="col-lg-6">

                <div class="card analytics-card h-100">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Top 5 Places by Views</h5>

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
            <div class="col-lg-6">

                <div class="card analytics-card h-100">

                    <div class="card-header">
                        <h5>User Growth</h5>
                    </div>

                    <div class="card-body">
                        <div id="userGrowthChart" class="chart-container"></div>
                    </div>

                </div>

            </div>

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

    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <script>
            let currentLevel = 'province';
            let currentParentId = null;

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

                initMap();
                initDateRange();

                loadDashboardStats();
                loadMapData();

                loadTopPlacesChart();
                loadUserGrowthChart();
            });

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

                localStorage.setItem(
                    'dashboard_date_range',
                    JSON.stringify({
                        start_date: start.format('YYYY-MM-DD'),
                        end_date: end.format('YYYY-MM-DD')
                    })
                );

                reloadAllDashboardData();
            });

            function reloadAllDashboardData() {

                loadDashboardStats();

                loadMapData(
                    currentLevel,
                    currentParentId
                );

                loadTopPlacesChart();
                loadUserGrowthChart();
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

                        animateValue('#stat-event-count', res.event_count ?? 0);

                        animateValue('#stat-comments-count', res.comments_count ?? 0);

                        animateValue('#stat-gallery-count', res.gallery_count ?? 0);

                        animateValue('#stat-blog-count', res.blog_count ?? 0);

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

            function loadTopPlacesChart() {

                fetch(
                        `/management/master/dashboard/data/chart?start_date=${startDate.format('YYYY-MM-DD')}&end_date=${endDate.format('YYYY-MM-DD')}`
                    )
                    .then(response => response.json())
                    .then(data => {

                        const places = data.data.place_code[0];
                        const views = data.data.no[0];

                        const labels = places.map(item =>
                            item.title ? item.title : item.code
                        );

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

                            series: [{
                                name: 'Views',
                                data: views
                            }],

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

                        window.topPlacesChartObj =
                            new ApexCharts(
                                document.querySelector("#topPlacesChart"),
                                options
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

                        const labels = data.map(item => {

                            const date = new Date(item.month);

                            return date.toLocaleString(
                                'default', {
                                    month: 'short',
                                    year: 'numeric'
                                }
                            );
                        });

                        const userCounts = data.map(
                            item => item.user_count
                        );

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

                            series: [{
                                name: 'Users',
                                data: userCounts
                            }],

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

                        window.userGrowthChartObj =
                            new ApexCharts(
                                document.querySelector("#userGrowthChart"),
                                options
                            );

                        window.userGrowthChartObj.render();
                    });
            }
        </script>
    @endpush
@endsection
