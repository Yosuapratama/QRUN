<?php

namespace App\Http\Controllers;

use App\Exports\HistoryScanExport;
use App\Models\PlaceCheckpoint;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class HistoryScanController extends Controller
{
    // Superadmin — all checkpoints
    public function index(Request $request)
    {
        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        if ($request->ajax()) {
            $isSuperAdmin = $authUser->hasRole('superadmin');

            $query = PlaceCheckpoint::query()
                ->with($isSuperAdmin
                    ? ['place:id,place_code,title', 'user:id,name,email']
                    : ['place:id,place_code,title'])
                ->select('place_checkpoints.*');

            if (!$isSuperAdmin) {
                $query->whereHas('place', fn($q) => $q->where('creator_id', Auth::id()));
            }

            if ($request->filled('place_code')) {
                $query->where('place_checkpoints.place_code', 'like', '%' . $request->place_code . '%');
            }

            if ($request->filled('user')) {
                $query->whereHas('user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->user . '%')
                      ->orWhere('email', 'like', '%' . $request->user . '%');
                });
            }

            if ($request->filled('device')) {
                $query->where('place_checkpoints.device_type', 'like', '%' . $request->device . '%');
            }

            if ($request->filled('platform')) {
                $query->where('place_checkpoints.platform', 'like', '%' . $request->platform . '%');
            }

            if ($request->filled('date_start') && $request->filled('date_end')) {
                $query->whereBetween('checked_at', [
                    Carbon::parse($request->date_start)->startOfDay(),
                    Carbon::parse($request->date_end)->endOfDay(),
                ]);
            }

            $stripColumns = [
                'id', 'place_id', 'user_id', 'session_id', 'referrer', 'user_agent',
                'browser_name', 'browser_version', 'is_mobile', 'device_name',
                'ip_address', 'city', 'country', 'created_at', 'updated_at', 'place', 'user',
            ];

            $datatable = DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('place_title', fn($row) => optional($row->place)->title ?? '-')
                ->addColumn('user_name', fn($row) => optional($row->user)->name ?? '<span class="text-muted">Guest</span>')
                ->addColumn('user_email', fn($row) => optional($row->user)->email ?? '-')
                ->editColumn('checked_at', fn($row) => $row->checked_at ? $row->checked_at->format('d M Y H:i') : '-')
                ->editColumn('device_type', fn($row) => $row->device_type ?? '-')
                ->editColumn('platform', fn($row) => $row->platform ?? '-')
                ->editColumn('browser', fn($row) => $row->browser ?? '-')
                ->blacklist(['place_title', 'user_name', 'user_email']);

            foreach ($stripColumns as $col) {
                $datatable->removeColumn($col);
            }

            if (!$isSuperAdmin) {
                $datatable->removeColumn('user_name')->removeColumn('user_email');
            } else {
                $datatable->rawColumns(['user_name']);
            }

            return $datatable->orderColumn('checked_at', 'checked_at $1')->make(true);
        }

        return view('Pages.Management.Master.history-scan.index', [
            'isSuperAdmin' => $authUser->hasRole('superadmin'),
        ]);
    }

    public function export(Request $request)
    {
        /** @var \App\Models\User $exporter */
        $exporter = Auth::user();
        $isSuperAdmin = $exporter->hasRole('superadmin');
        $filename = 'history-scan-' . now()->format('Ymd-His') . '.xlsx';
        return Excel::download(new HistoryScanExport($request, !$isSuperAdmin, $isSuperAdmin), $filename);
    }

    // Regular user — only their own place
    public function myIndex(Request $request)
    {
        if ($request->ajax()) {
            $userId = Auth::id();

            $query = PlaceCheckpoint::query()
                ->with(['place:id,place_code,title'])
                ->whereHas('place', fn($q) => $q->where('creator_id', $userId))
                ->select('place_checkpoints.*');

            if ($request->filled('place_code')) {
                $query->where('place_checkpoints.place_code', 'like', '%' . $request->place_code . '%');
            }

            if ($request->filled('device')) {
                $query->where('place_checkpoints.device_type', 'like', '%' . $request->device . '%');
            }

            if ($request->filled('platform')) {
                $query->where('place_checkpoints.platform', 'like', '%' . $request->platform . '%');
            }

            if ($request->filled('date_start') && $request->filled('date_end')) {
                $query->whereBetween('checked_at', [
                    Carbon::parse($request->date_start)->startOfDay(),
                    Carbon::parse($request->date_end)->endOfDay(),
                ]);
            }

            $stripColumns = [
                'id', 'place_id', 'user_id', 'session_id', 'referrer', 'user_agent',
                'browser_name', 'browser_version', 'is_mobile', 'device_name',
                'ip_address', 'city', 'country', 'created_at', 'updated_at', 'place', 'user',
                'user_name', 'user_email',
            ];

            $datatable = DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('place_title', fn($row) => optional($row->place)->title ?? '-')
                ->editColumn('checked_at', fn($row) => $row->checked_at ? $row->checked_at->format('d M Y H:i') : '-')
                ->editColumn('device_type', fn($row) => $row->device_type ?? '-')
                ->editColumn('platform', fn($row) => $row->platform ?? '-')
                ->editColumn('browser', fn($row) => $row->browser ?? '-')
                ->blacklist(['place_title']);

            foreach ($stripColumns as $col) {
                $datatable->removeColumn($col);
            }

            return $datatable->orderColumn('checked_at', 'checked_at $1')->make(true);
        }

        return view('Pages.Management.Master.history-scan.my-index');
    }

    public function myExport(Request $request)
    {
        $filename = 'my-history-scan-' . now()->format('Ymd-His') . '.xlsx';
        return Excel::download(new HistoryScanExport($request, true), $filename);
    }
}
