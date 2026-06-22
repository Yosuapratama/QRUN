  <style>
      :root {
          --primary: #4e73df;
          --primary-light: #e7f0ff;
          --secondary: #858796;
          --success: #1cc88a;
          --danger: #e74c3c;
          --warning: #f39c12;
          --light: #f8f9fc;
          --border: #e3e6f0;
      }

      /* Fix toolbar dropdowns clipped by editor container */
      .note-editor.note-frame { overflow: visible !important; }
      .note-editor .note-toolbar { overflow: visible !important; position: relative; z-index: 10; }
      .note-editor .note-toolbar .dropdown-menu { z-index: 1051 !important; }

      .note-editor .note-editable p,
      .note-editor .note-editable div {
          margin-bottom: 10px !important;
          line-height: 1.7;
      }

      .note-editor .note-editable h1,
      .note-editor .note-editable h2,
      .note-editor .note-editable h3,
      .note-editor .note-editable h4,
      .note-editor .note-editable h5,
      .note-editor .note-editable h6 {
          margin: 12px 0 !important;
          line-height: 1.4;
      }

      .note-editor .note-editable br {
          line-height: 1.5;
      }

      /* Summernote content responsive */
      .note-editor .note-editable iframe,
      .note-editor .note-editable video,
      .note-editor .note-editable embed,
      .note-editor .note-editable object {
          width: 100% !important;
          max-width: 100% !important;
          height: auto;
          min-height: 220px;
          border: 0;
          border-radius: 12px;
          display: block;
      }

      /* responsive youtube/vimeo ratio */
      .note-editor .note-editable iframe[src*="youtube"],
      .note-editor .note-editable iframe[src*="youtu.be"],
      .note-editor .note-editable iframe[src*="vimeo"] {
          aspect-ratio: 16 / 9;
          height: auto !important;
      }

      .note-toolbar {
          display: flex !important;
          flex-wrap: wrap !important;
      }

      .card-header {
          gap: 0px !important;
      }

      body {
          background: var(--light);
      }

      /* Page Header */
      .page-header-wrapper {
          padding: 0 1px;
          margin-bottom: 40px;
      }

      .page-title {
          font-size: 38px;
          font-weight: 700;
          color: #1a202c;
          letter-spacing: -0.5px;
          line-height: 1.3;
          margin-bottom: 12px;
      }

      .page-title i {
          font-size: 40px;
      }

      .page-subtitle {
          font-size: 18px;
          color: #4a5568;
          font-weight: 500;
          line-height: 1.6;
      }

      /* Cards */
      .form-card {
          border-radius: 16px;
          overflow: hidden;
          transition: box-shadow 0.3s ease;
      }

      .form-card:hover {
          box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08) !important;
      }

      .card-header {
          background: linear-gradient(135deg, #f5f7fc 0%, #ffffff 100%) !important;
          border-bottom: 2px solid #e8ecf8 !important;
          padding: 28px 32px !important;
          display: flex;
          align-items: center;
          gap: 16px;
      }

      .card-header h5 {
          font-size: 20px !important;
          color: #1a202c !important;
          line-height: 1.4 !important;
          letter-spacing: 0.2px;
      }

      .card-body {
          background: #fff;
          padding: 32px !important;
          line-height: 1.8;
      }

      .card-footer {
          background: #f8f9fc !important;
          border-top: 2px solid #e8ecf8 !important;
          padding: 24px 32px !important;
      }

      /* Badges */
      .badge-primary-light {
          background: var(--primary-light) !important;
          color: var(--primary) !important;
          font-weight: 700;
          padding: 8px 14px;
          border-radius: 8px;
          font-size: 16px;
          min-width: 44px;
          text-align: center;
          flex-shrink: 0;
      }

      .badge-icon {
          min-width: 44px;
          height: 44px;
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 18px;
      }

      /* Form Labels */
      .form-label {
          font-weight: 700;
          color: #1a202c;
          margin-bottom: 12px;
          font-size: 16px;
          letter-spacing: 0.3px;
          display: flex;
          align-items: center;
          line-height: 1.5;
      }

      /* Form Controls */
      .form-control {
          border-radius: 12px;
          min-height: 54px;
          border: 2px solid #dde1ec;
          padding: 14px 18px;
          transition: all 0.3s ease;
          font-size: 16px;
          line-height: 1.6;
          color: #1a202c;
          background: #fff;
          font-weight: 500;
      }

      .form-control::placeholder {
          color: #9ca3af;
          font-weight: 500;
          font-size: 15px;
      }

      textarea.form-control {
          min-height: 140px;
          padding: 18px;
          resize: vertical;
          font-size: 16px;
          line-height: 1.7;
      }

      .form-control:hover {
          border-color: #4e73df;
          background: #f9fbff;
          box-shadow: 0 2px 8px rgba(78, 115, 223, 0.08);
      }

      .form-control:focus {
          border-color: #4e73df;
          box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.12);
          background: #fff;
          outline: none;
      }

      /* Location Wrapper */
      .location-wrapper {
          background: #fafbfc;
          border-radius: 12px;
          padding: 0;
          border: none;
      }

      /* Alert Styling */
      .alert-success-custom {
          background: #d4edda;
          border: 2px solid #28a745;
          color: #155724;
          padding: 20px 24px;
          border-radius: 12px;
      }

      .alert-success-custom strong {
          font-weight: 700;
          font-size: 17px;
      }

      .alert-success-custom i {
          font-size: 22px;
      }

      .alert-danger-custom {
          background: #f8d7da;
          border: 2px solid #e74c3c;
          color: #721c24;
          padding: 20px 24px;
          border-radius: 12px;
      }

      .alert-danger-custom strong {
          font-weight: 700;
          font-size: 17px;
      }

      .alert-danger-custom li {
          font-size: 16px;
          margin-bottom: 8px;
          font-weight: 500;
      }

      .alert-danger-custom i {
          font-size: 22px;
      }


      /* Select2 Styling */
      .select2-container--default .select2-selection--single {
          height: 54px !important;
          border-radius: 12px !important;
          border: 2px solid #dde1ec !important;
          display: flex !important;
          align-items: center !important;
          background: #fff !important;
          transition: all 0.3s ease !important;
      }

      .select2-container--default .select2-selection--single:hover {
          border-color: #4e73df !important;
          box-shadow: 0 2px 8px rgba(78, 115, 223, 0.08) !important;
      }

      .select2-container--default.select2-container--focus .select2-selection--single {
          border-color: var(--primary) !important;
          box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.12) !important;
      }

      .select2-container .select2-selection--single {
          height: 45px !important;
      }

      .select2-container--default .select2-selection--single {
          position: relative !important;
      }

      .select2-container--default .select2-selection--single .select2-selection__clear {
          position: absolute !important;

          right: 38px !important;
          top: 50% !important;

          transform: translateY(-50%) !important;

          margin: 0 !important;
          padding: 0 !important;

          font-size: 18px !important;
          font-weight: 700 !important;

          color: #9ca3af !important;

          z-index: 10;
      }

      .select2-container--default .select2-selection--single .select2-selection__clear:hover {
          color: #e74c3c !important;
      }

      .select2-selection__rendered {
          line-height: 52px !important;
          padding-left: 16px !important;
          color: #1a202c !important;
          font-weight: 600 !important;
          font-size: 16px !important;
      }

      .select2-selection__arrow {
          height: 52px !important;
      }

      .select2-container {
          width: 100% !important;
      }

      .select2-dropdown {
          border-radius: 12px !important;
          border: 2px solid #e8ecf8 !important;
          box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12) !important;
      }

      .select2-results__option {
          padding: 14px 18px !important;
          font-size: 16px !important;
          font-weight: 500 !important;
          line-height: 1.6 !important;
      }

      .select2-results__option--highlighted {
          background: var(--primary-light) !important;
          color: var(--primary) !important;
          font-weight: 600 !important;
      }

      /* Summernote Editor */
      .note-editor.note-frame {
          border-radius: 12px !important;
          overflow: hidden;
          border: 2px solid #dde1ec !important;
          transition: all 0.3s ease !important;
      }

      .note-editor.note-frame:hover {
          border-color: #4e73df !important;
          box-shadow: 0 2px 8px rgba(78, 115, 223, 0.08) !important;
      }

      .note-editor.note-frame.note-focus {
          border-color: var(--primary) !important;
          box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.12) !important;
      }

      .note-toolbar {
          background: #f8f9fc;
          border-bottom: 1px solid #e8ecf8;
          padding: 14px !important;
      }

      .note-toolbar .note-btn {
          border-radius: 8px !important;
          transition: all 0.2s ease !important;
          font-size: 15px !important;
          padding: 6px 10px !important;
      }

      .note-toolbar .note-btn:hover {
          background: white !important;
          color: var(--primary) !important;
          box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
      }

      .note-editable {
          min-height: 320px;
          font-size: 17px;
          line-height: 1.8;
          padding: 24px !important;
          text-align: left;
          color: #1a202c;
      }

      /* Comment Toggle Section */
      .comment-toggle {
          display: flex;
          justify-content: space-between;
          align-items: center;
          gap: 24px;
          background: #f8f9fc;
          border: 1px solid #e8ecf8;
          padding: 24px;
          border-radius: 12px;
      }

      .comment-toggle h6 {
          font-size: 18px !important;
          font-weight: 700 !important;
          color: #1a202c !important;
          margin: 0 !important;
      }

      .comment-toggle small {
          font-size: 16px !important;
          font-weight: 500 !important;
          color: #4a5568 !important;
      }

      /* Toggle Switch */
      .switch {
          position: relative;
          display: inline-block;
          width: 66px;
          height: 40px;
          flex-shrink: 0;
      }

      .switch input {
          opacity: 0;
          width: 0;
          height: 0;
      }

      .slider-custom {
          position: absolute;
          cursor: pointer;
          inset: 0;
          background-color: #cbd5e0;
          transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
          border-radius: 50px;
          box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.08);
      }

      .slider-custom:before {
          position: absolute;
          content: "";
          height: 32px;
          width: 32px;
          left: 4px;
          top: 4px;
          background-color: white;
          transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
          border-radius: 50%;
          box-shadow: 0 3px 8px rgba(0, 0, 0, 0.18);
      }

      .switch input:checked+.slider-custom {
          background-color: var(--primary);
          box-shadow: inset 0 2px 6px rgba(78, 115, 223, 0.25);
      }

      .switch input:checked+.slider-custom:before {
          transform: translateX(26px);
          box-shadow: 0 3px 8px rgba(78, 115, 223, 0.35);
      }

      /* Buttons */
      .submit-btn {
          height: 54px;
          min-width: 180px;
          border-radius: 12px;
          font-weight: 700;
          font-size: 17px;
          transition: all 0.3s ease;
          border: none;
          display: inline-flex;
          align-items: center;
          justify-content: center;
          box-shadow: 0 4px 12px rgba(78, 115, 223, 0.2);
          letter-spacing: 0.3px;
      }

      .submit-btn:hover {
          transform: translateY(-3px);
          box-shadow: 0 6px 16px rgba(78, 115, 223, 0.3);
      }

      .submit-btn:active {
          transform: translateY(-1px);
      }

      .reset-btn {
          height: 54px;
          border-radius: 12px;
          font-weight: 700;
          font-size: 17px;
          transition: all 0.3s ease;
          border: 2px solid var(--border);
          letter-spacing: 0.3px;
      }

      .reset-btn:hover {
          background: white !important;
          border-color: #4e73df !important;
          color: #4e73df !important;
          box-shadow: 0 4px 12px rgba(78, 115, 223, 0.15);
      }

      /* Gap utility */
      .gap-3 {
          gap: 12px;
      }

      /* Responsive Design */
      @media (max-width: 768px) {
          .page-title {
              font-size: 24px;
          }

          .card-body {
              padding: 20px !important;
          }

          .card-footer {
              flex-direction: column;
              gap: 16px;
              align-items: flex-start !important;
          }

          .comment-toggle {
              flex-direction: column;
              align-items: flex-start;
              gap: 16px;
          }

          .submit-btn,
          .reset-btn {
              width: 100%;
          }

          .d-flex.justify-content-between {
              flex-direction: column;
          }

          .d-flex.gap-3 {
              flex-direction: column;
              width: 100%;
          }

          .d-flex.gap-3 button {
              width: 100%;
          }

          /* Section Description */
          .section-description {
              font-size: 16px;
              color: #4a5568;
              font-weight: 500;
              line-height: 1.6;
              margin-top: 8px;
          }

          .form-section {
              margin-bottom: 8px;
          }

          /* Improved spacing for better readability */
          .form-section .row {
              margin-bottom: 0;
          }

          .form-section .col-md-6,
          .form-section .col-12 {
              margin-bottom: 28px;
          }

          .form-section .col-md-6:last-child,
          .form-section .col-12:last-child {
              margin-bottom: 0;
          }

          .text-danger {
              color: #e74c3c !important;
              font-weight: 700;
              /* font-size: 18px; */
          }

          /* Error message styling */
          .text-danger.d-block {
              font-size: 15px !important;
              font-weight: 600 !important;
              margin-top: 8px;
          }
  </style>
