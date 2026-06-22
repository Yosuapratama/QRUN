@extends('TemplateLayout.AdminLayout')

@section('content')
    @push('title')
        <title>Place Limit Requests - QRUN</title>
    @endpush

    @push('css')
        <style>
            .toggle-column:disabled + .custom-control-label { opacity: .5; cursor: not-allowed; }

            .req-card {
                border-radius: 20px;
                border: none;
                box-shadow: 0 4px 20px rgba(0,0,0,.05);
            }
            .req-card .card-header {
                background: white;
                border-bottom: 1px solid #f1f5f9;
                padding: 20px 24px;
                border-radius: 20px 20px 0 0;
            }
            .badge-pending  { background: #fef3c7; color: #92400e; }
            .badge-approved { background: #d1fae5; color: #065f46; }
            .badge-rejected { background: #fee2e2; color: #991b1b; }
        </style>
    @endpush

    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <div>
                <h4 class="font-weight-bold text-gray-900 mb-1">Place Limit Requests</h4>
                <p class="text-muted mb-0 small">Kelola permintaan penambahan batas tempat dari pengguna.</p>
            </div>
            <span class="badge badge-primary px-3 py-2" id="pendingCountBadge">
                <i class="fas fa-clock mr-1"></i> Loading...
            </span>
        </div>

        {{-- TABLE CARD --}}
        <div class="card req-card">

            <div class="card-header d-flex justify-content-between align-items-center flex-wrap" style="gap:12px;">
                <h5 class="mb-0 font-weight-bold">Daftar Permintaan</h5>
                <div class="d-flex align-items-center" style="gap:8px;">
                    <select id="filterStatus" class="form-control form-control-sm" style="width:140px;border-radius:10px;">
                        <option value="">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                    {{-- Column Visibility --}}
                    <div class="dropdown">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                            id="colVisDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-columns mr-1"></i>Columns
                        </button>
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow" style="min-width:200px;">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="tog-user" data-column="1" checked>
                                <label class="custom-control-label" for="tog-user">User</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="tog-email" data-column="2" checked>
                                <label class="custom-control-label" for="tog-email">Email</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="tog-limit" data-column="3" checked>
                                <label class="custom-control-label" for="tog-limit">Requested Limit</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="tog-reason" data-column="4" checked>
                                <label class="custom-control-label" for="tog-reason">Alasan</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="tog-status" data-column="5" checked>
                                <label class="custom-control-label" for="tog-status">Status</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="tog-notes" data-column="6" checked>
                                <label class="custom-control-label" for="tog-notes">Catatan Admin</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="tog-reviewer" data-column="7" checked>
                                <label class="custom-control-label" for="tog-reviewer">Reviewed By</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input toggle-column" id="tog-reviewed-at" data-column="8" checked>
                                <label class="custom-control-label" for="tog-reviewed-at">Reviewed At</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input toggle-column" id="tog-submitted-at" data-column="9" checked>
                                <label class="custom-control-label" for="tog-submitted-at">Submitted At</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="requestTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Email</th>
                                <th>Requested Limit</th>
                                <th>Alasan</th>
                                <th>Status</th>
                                <th>Catatan Admin</th>
                                <th>Reviewed By</th>
                                <th>Reviewed At</th>
                                <th>Submitted At</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- APPROVE MODAL --}}
    <div class="modal fade" id="approveModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" style="max-width:480px;">
            <div class="modal-content" style="border-radius:20px;overflow:hidden;border:none;box-shadow:0 20px 60px rgba(0,0,0,.12);">

                {{-- Header --}}
                <div style="background:linear-gradient(135deg,#16a34a,#22c55e);padding:20px 24px;display:flex;align-items:center;justify-content:space-between;">
                    <div style="display:flex;align-items:center;gap:12px;">
                        <div style="width:38px;height:38px;border-radius:10px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-check-circle text-white" style="font-size:16px;"></i>
                        </div>
                        <div style="padding-left:4px;">
                            <h5 class="mb-0 font-weight-bold text-white" style="font-size:15px;">Approve Request</h5>
                            <small style="color:rgba(255,255,255,.75);">Assign place limit ke pengguna</small>
                        </div>
                    </div>
                    <button type="button" onclick="$('#approveModal').modal('hide')"
                        style="background:rgba(255,255,255,.15);border:none;border-radius:8px;width:32px;height:32px;color:#fff;font-size:16px;line-height:1;cursor:pointer;">&times;</button>
                </div>

                <div class="modal-body" style="padding:24px;">

                    {{-- User info chip --}}
                    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:12px 16px;margin-bottom:20px;">
                        <div style="font-size:11px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Permintaan</div>
                        <div style="font-size:15px;font-weight:700;color:#111827;">
                            <i class="fas fa-user-circle text-success mr-1"></i>
                            <span id="approveUserName"></span>
                            <span style="color:#6b7280;font-weight:500;margin:0 6px;">minta</span>
                            <span id="approveLimit" style="color:#16a34a;font-weight:800;"></span>
                            <span style="color:#6b7280;font-weight:500;"> tempat</span>
                        </div>
                    </div>

                    {{-- Tab-style toggle --}}
                    <div style="margin-bottom:16px;">
                        <div style="font-size:12px;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px;">
                            Assign Place Limit
                        </div>
                        <div style="display:flex;background:#f3f4f6;border-radius:10px;padding:4px;gap:4px;">
                            <label for="optExisting" id="tabExisting"
                                style="flex:1;text-align:center;padding:7px 12px;border-radius:7px;cursor:pointer;font-size:13px;font-weight:600;margin:0;transition:all .2s;background:#fff;color:#16a34a;box-shadow:0 1px 4px rgba(0,0,0,.1);">
                                <i class="fas fa-list mr-1"></i>Pilih yang ada
                            </label>
                            <label for="optNew" id="tabNew"
                                style="flex:1;text-align:center;padding:7px 12px;border-radius:7px;cursor:pointer;font-size:13px;font-weight:600;margin:0;transition:all .2s;color:#6b7280;">
                                <i class="fas fa-plus mr-1"></i>Buat baru
                            </label>
                            <input type="radio" id="optExisting" name="limitOption" value="existing" checked class="d-none">
                            <input type="radio" id="optNew" name="limitOption" value="new" class="d-none">
                        </div>
                    </div>

                    {{-- Section: existing --}}
                    <div id="sectionExisting" style="margin-bottom:16px;">
                        @if($placeLimits->isEmpty())
                            <div style="padding:12px;background:#fef9c3;border-radius:10px;border:1px solid #fde68a;font-size:13px;color:#92400e;">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Belum ada place limit tersedia. Gunakan tab <strong>Buat baru</strong>.
                            </div>
                        @else
                            <select id="selectPlaceLimit" class="form-control" style="border-radius:10px;font-size:14px;">
                                @foreach($placeLimits as $pl)
                                    <option value="{{ $pl->id }}" data-total="{{ $pl->total_limit }}">
                                        {{ $pl->name }} — {{ $pl->total_limit }} tempat
                                    </option>
                                @endforeach
                            </select>
                        @endif
                    </div>

                    {{-- Section: new --}}
                    <div id="sectionNew" class="d-none" style="margin-bottom:16px;">
                        <div class="row no-gutters" style="gap:10px;flex-wrap:nowrap;">
                            <div style="flex:1;">
                                <label class="small font-weight-bold text-muted mb-1">Nama Limit</label>
                                <input type="text" id="newLimitName" class="form-control form-control-sm"
                                    placeholder="cth. Premium 20" style="border-radius:10px;">
                            </div>
                            <div style="width:110px;flex-shrink:0;">
                                <label class="small font-weight-bold text-muted mb-1">Total Tempat</label>
                                <input type="number" id="newLimitTotal" class="form-control form-control-sm"
                                    min="1" placeholder="20" style="border-radius:10px;">
                            </div>
                        </div>
                    </div>

                    {{-- Notes --}}
                    <div>
                        <label class="small font-weight-bold text-muted mb-1">Catatan untuk pengguna <span style="font-weight:400;">(opsional)</span></label>
                        <textarea id="approveNotes" class="form-control" rows="2"
                            placeholder="Tambahkan catatan jika perlu..." style="border-radius:10px;font-size:14px;resize:none;"></textarea>
                    </div>

                </div>

                {{-- Footer --}}
                <div style="padding:16px 24px 20px;display:flex;justify-content:flex-end;gap:10px;border-top:1px solid #f1f5f9;">
                    <button type="button" onclick="$('#approveModal').modal('hide')"
                        style="border-radius:10px;border:1px solid #e5e7eb;background:#fff;color:#374151;font-weight:600;font-size:13px;padding:8px 20px;cursor:pointer;">
                        Batal
                    </button>
                    <button type="button" id="confirmApprove"
                        style="border-radius:10px;border:none;background:#16a34a;color:#fff;font-weight:700;font-size:13px;padding:8px 24px;cursor:pointer;">
                        <i class="fas fa-check mr-1"></i>Approve
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- REJECT MODAL --}}
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:18px;overflow:hidden;border:none;">
                <div class="modal-header" style="background:linear-gradient(135deg,#dc2626,#ef4444);color:white;border:none;padding:18px 22px;">
                    <h5 class="modal-title font-weight-bold mb-0"><i class="fas fa-times-circle mr-2"></i>Reject Request</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" style="opacity:1;">&times;</button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted mb-3">Tolak permintaan dari <strong id="rejectUserName"></strong>?</p>
                    <div class="form-group">
                        <label class="font-weight-bold small text-gray-700">Alasan penolakan <span class="text-danger">*</span></label>
                        <textarea id="rejectNotes" class="form-control" rows="3" placeholder="Tuliskan alasan penolakan..." style="border-radius:12px;"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-light btn-sm px-4" data-dismiss="modal" style="border-radius:10px;">Batal</button>
                    <button type="button" class="btn btn-danger btn-sm px-5" id="confirmReject" style="border-radius:10px;">
                        <i class="fas fa-times mr-1"></i>Reject
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('script')
    <script>
        let currentRequestId = null;
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        const table = $('#requestTable').DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            responsive: true,
            pageLength: 10,
            ajax: {
                url: '{{ route('place-limit-request.index') }}',
                data: function (d) {
                    d.status = $('#filterStatus').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex',      name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'user.name',        name: 'user.name' },
                { data: 'user.email',       name: 'user.email',
                    render: function(d, t, row) { return row.user?.email ?? '-'; } },
                { data: 'requested_limit',  name: 'requested_limit',
                    render: function(d) { return '<strong class="text-primary">' + d + '</strong> tempat'; } },
                { data: 'reason',           name: 'reason',
                    render: function(d) { return d ? '<span title="'+d+'">' + (d.length > 60 ? d.substring(0,60)+'…' : d) + '</span>' : '<span class="text-muted">-</span>'; } },
                { data: 'status',           name: 'status' },
                { data: 'admin_notes',      name: 'admin_notes',
                    render: function(d) { return d ?? '<span class="text-muted">-</span>'; } },
                { data: 'reviewer.name',    name: 'reviewer.name',
                    render: function(d, t, row) { return row.reviewer?.name ?? '-'; } },
                { data: 'reviewed_at',      name: 'reviewed_at' },
                { data: 'created_at',       name: 'created_at' },
                { data: 'action',           name: 'action', orderable: false, searchable: false },
            ]
        });

        $('#filterStatus').on('change', function () { table.ajax.reload(); });

        // Keep dropdown open on checkbox click
        $('#colVisDropdown').siblings('.dropdown-menu').on('click', function(e) { e.stopPropagation(); });

        // ===========================
        // COLUMN VISIBILITY
        // ===========================
        const STORAGE_KEY = 'place_limit_request_column_visibility';
        const defaultColumns = { 1:true, 2:true, 3:true, 4:true, 5:true, 6:true, 7:true, 8:true, 9:true };

        function getSavedColumnState() {
            const saved = localStorage.getItem(STORAGE_KEY);
            if (!saved) return defaultColumns;
            try { return { ...defaultColumns, ...JSON.parse(saved) }; }
            catch (e) { return defaultColumns; }
        }

        function saveColumnState() {
            let state = {};
            $('.toggle-column').each(function() { state[$(this).data('column')] = $(this).is(':checked'); });
            localStorage.setItem(STORAGE_KEY, JSON.stringify(state));
        }

        function updateColumnCheckboxState() {
            const checkedCount = $('.toggle-column:checked').length;
            $('.toggle-column').prop('disabled', false);
            if (checkedCount <= 1) $('.toggle-column:checked').prop('disabled', true);
        }

        function applySavedColumnState() {
            const savedState = getSavedColumnState();
            $('.toggle-column').each(function() {
                const col = $(this).data('column');
                const isVisible = savedState[col] ?? true;
                $(this).prop('checked', isVisible);
                table.column(col).visible(isVisible, false);
            });
            table.columns.adjust().draw(false);
            updateColumnCheckboxState();
        }

        $('.toggle-column').on('change', function() {
            table.column($(this).data('column')).visible($(this).is(':checked'));
            saveColumnState();
            updateColumnCheckboxState();
        });

        applySavedColumnState();

        // Count pending
        function refreshPendingCount() {
            $.get('{{ route('place-limit-request.index') }}', { draw:1, start:0, length:0, 'columns[0][data]':'id', status:'pending' }, function(res) {
                const count = res.recordsFiltered ?? 0;
                $('#pendingCountBadge').html('<i class="fas fa-clock mr-1"></i>' + count + ' Pending');
            });
        }
        refreshPendingCount();

        // APPROVE — toggle existing / new (tab style)
        function updateApproveTab(val) {
            if (val === 'existing') {
                $('#sectionExisting').removeClass('d-none');
                $('#sectionNew').addClass('d-none');
                $('#tabExisting').css({ background: '#fff', color: '#16a34a', boxShadow: '0 1px 4px rgba(0,0,0,.1)' });
                $('#tabNew').css({ background: 'transparent', color: '#6b7280', boxShadow: 'none' });
            } else {
                $('#sectionExisting').addClass('d-none');
                $('#sectionNew').removeClass('d-none');
                $('#tabNew').css({ background: '#fff', color: '#16a34a', boxShadow: '0 1px 4px rgba(0,0,0,.1)' });
                $('#tabExisting').css({ background: 'transparent', color: '#6b7280', boxShadow: 'none' });
            }
        }

        $('input[name="limitOption"]').on('change', function () {
            updateApproveTab($(this).val());
        });

        $(document).on('click', '.btn-approve', function () {
            currentRequestId = $(this).data('id');
            const requestedLimit = $(this).data('limit');
            $('#approveUserName').text($(this).data('user'));
            $('#approveLimit').text(requestedLimit);
            $('#approveNotes').val('');
            // Reset to "existing" option
            $('#optExisting').prop('checked', true);
            updateApproveTab('existing');
            // Pre-fill "new" fields with requested values
            $('#newLimitName').val('Custom ' + requestedLimit);
            $('#newLimitTotal').val(requestedLimit);
            $('#approveModal').modal('show');
        });

        $('#confirmApprove').on('click', function () {
            const option = $('input[name="limitOption"]:checked').val();
            let postData = { _token: csrfToken, admin_notes: $('#approveNotes').val() };

            if (option === 'existing') {
                const selectedId = $('#selectPlaceLimit').val();
                if (!selectedId) {
                    Swal.fire({ icon: 'warning', title: 'Pilih Place Limit', text: 'Harap pilih place limit yang tersedia.' });
                    return;
                }
                postData.place_limit_id = selectedId;
            } else {
                const name  = $('#newLimitName').val().trim();
                const total = parseInt($('#newLimitTotal').val());
                if (!name || !total || total < 1) {
                    Swal.fire({ icon: 'warning', title: 'Data tidak lengkap', text: 'Isi nama dan total limit dengan benar.' });
                    return;
                }
                postData.new_limit_name  = name;
                postData.new_limit_total = total;
            }

            const $btn = $(this).prop('disabled', true).html('<span class="spinner-border spinner-border-sm mr-1"></span>Processing...');
            $.ajax({
                url: '/management/master/place-limit-request/' + currentRequestId + '/approve',
                method: 'POST',
                data: postData,
                success: function (res) {
                    $('#approveModal').modal('hide');
                    table.ajax.reload(null, false);
                    refreshPendingCount();
                    Swal.fire({ icon: 'success', title: 'Approved!', text: res.message, timer: 2500, showConfirmButton: false });
                },
                error: function (xhr) {
                    Swal.fire({ icon: 'error', title: 'Error', text: xhr.responseJSON?.message ?? 'Terjadi kesalahan.' });
                },
                complete: function () { $btn.prop('disabled', false).html('<i class="fas fa-check mr-1"></i>Approve'); }
            });
        });

        // REJECT
        $(document).on('click', '.btn-reject', function () {
            currentRequestId = $(this).data('id');
            $('#rejectUserName').text($(this).data('user'));
            $('#rejectNotes').val('');
            $('#rejectModal').modal('show');
        });

        $('#confirmReject').on('click', function () {
            const notes = $('#rejectNotes').val().trim();
            if (!notes) { Swal.fire({ icon: 'warning', title: 'Isian kosong', text: 'Harap isi alasan penolakan.' }); return; }
            const $btn = $(this).prop('disabled', true).html('<span class="spinner-border spinner-border-sm mr-1"></span>Processing...');
            $.ajax({
                url: '/management/master/place-limit-request/' + currentRequestId + '/reject',
                method: 'POST',
                data: { _token: csrfToken, admin_notes: notes },
                success: function (res) {
                    $('#rejectModal').modal('hide');
                    table.ajax.reload(null, false);
                    refreshPendingCount();
                    Swal.fire({ icon: 'success', title: 'Rejected', text: res.message, timer: 2500, showConfirmButton: false });
                },
                error: function (xhr) {
                    Swal.fire({ icon: 'error', title: 'Error', text: xhr.responseJSON?.message ?? 'Terjadi kesalahan.' });
                },
                complete: function () { $btn.prop('disabled', false).html('<i class="fas fa-times mr-1"></i>Reject'); }
            });
        });
    </script>
    @endpush
@endsection
