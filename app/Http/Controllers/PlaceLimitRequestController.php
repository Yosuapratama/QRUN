<?php

namespace App\Http\Controllers;

use App\Models\LogActivities;
use App\Models\PlaceLimit;
use App\Models\PlaceLimitRequest;
use App\Models\UserHasPlaceLimit;
use App\Services\TelegramService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PlaceLimitRequestController extends Controller
{
    /**
     * Superadmin: list all requests.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PlaceLimitRequest::with('user', 'reviewer')->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
                    $map = [
                        'pending'  => ['bg-warning',  'fa-clock',       'Pending'],
                        'approved' => ['bg-success',  'fa-check-circle','Approved'],
                        'rejected' => ['bg-danger',   'fa-times-circle','Rejected'],
                    ];
                    [$bg, $icon, $label] = $map[$row->status] ?? ['bg-secondary', 'fa-circle', $row->status];
                    return "<span class='badge {$bg}'><i class='fas {$icon} mr-1'></i>{$label}</span>";
                })
                ->editColumn('user.name', function ($row) {
                    return $row->user?->name ?? '-';
                })
                ->editColumn('reviewed_at', function ($row) {
                    return $row->reviewed_at ? $row->reviewed_at->format('d M Y H:i') : '-';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i');
                })
                ->addColumn('action', function ($row) {
                    $actions = '';
                    if ($row->status === 'pending') {
                        $actions .= "
                            <button class='btn btn-success btn-sm mr-1 btn-approve' data-id='{$row->id}' data-user='" . e($row->user?->name) . "' data-limit='{$row->requested_limit}'>
                                <i class='fas fa-check mr-1'></i>Approve
                            </button>
                            <button class='btn btn-danger btn-sm btn-reject' data-id='{$row->id}' data-user='" . e($row->user?->name) . "'>
                                <i class='fas fa-times mr-1'></i>Reject
                            </button>
                        ";
                    }
                    return $actions ?: '<span class="text-muted small">—</span>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        $placeLimits = PlaceLimit::orderBy('total_limit')->get(['id', 'name', 'total_limit']);
        return view('Pages.Management.Master.place-limit-request.index', compact('placeLimits'));
    }

    /**
     * Any logged-in user: submit a place limit request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'requested_limit' => 'required|integer|min:1|max:9999',
            'reason'          => 'nullable|string|max:1000',
        ]);

        $existing = PlaceLimitRequest::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Anda masih memiliki permintaan yang sedang diproses.',
            ], 422);
        }

        $req = PlaceLimitRequest::create([
            'user_id'         => Auth::id(),
            'requested_limit' => $request->requested_limit,
            'reason'          => $request->reason,
            'status'          => 'pending',
        ]);

        LogActivities::create([
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'user_id'    => Auth::id(),
            'activities' => 'User submitted place limit request #' . $req->id . ' at ' . Carbon::now()->format('Y-m-d H:i:s'),
            'type'       => 'REQUEST_PLACE_LIMIT',
        ]);

        try {
            $user = Auth::user();
            TelegramService::send(
                "📋 <b>Place Limit Request</b>\n\n" .
                "👤 <b>User:</b> {$user->name}\n" .
                "📧 <b>Email:</b> {$user->email}\n" .
                "🔢 <b>Requested Limit:</b> {$req->requested_limit}\n" .
                "💬 <b>Reason:</b> " . ($req->reason ?: '-') . "\n" .
                "🕐 <b>Submitted:</b> " . Carbon::now()->format('d M Y H:i') . "\n\n" .
                "➡️ <a href=\"" . url('/management/master/place-limit-request') . "\">Review permintaan</a>"
            );
        } catch (\Exception $e) {
            // Telegram failure should not block the user
        }

        return response()->json([
            'success' => true,
            'message' => 'Permintaan berhasil dikirim. Tim kami akan segera meninjau.',
        ]);
    }

    /**
     * Superadmin: approve a request.
     */
    public function approve(Request $request, $id)
    {
        $req = PlaceLimitRequest::findOrFail($id);

        if ($req->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Request sudah diproses.'], 422);
        }

        if ($request->filled('place_limit_id')) {
            $placeLimit = PlaceLimit::findOrFail($request->place_limit_id);
        } else {
            $request->validate([
                'new_limit_name'  => 'required|string|max:255',
                'new_limit_total' => 'required|integer|min:1',
            ]);
            $placeLimit = PlaceLimit::create([
                'name'        => $request->new_limit_name,
                'total_limit' => $request->new_limit_total,
            ]);
        }

        // Assign (or update) the user's place limit
        UserHasPlaceLimit::updateOrCreate(
            ['user_id' => $req->user_id],
            ['place_limit_id' => $placeLimit->id]
        );

        $req->update([
            'status'      => 'approved',
            'admin_notes' => $request->admin_notes,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        LogActivities::create([
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'user_id'    => Auth::id(),
            'activities' => 'Superadmin approved place limit request #' . $req->id . ' at ' . Carbon::now()->format('Y-m-d H:i:s'),
            'type'       => 'APPROVE_PLACE_LIMIT_REQUEST',
        ]);

        try {
            TelegramService::send(
                "✅ <b>Place Limit Request APPROVED</b>\n\n" .
                "👤 <b>User:</b> " . ($req->user?->name ?? '-') . "\n" .
                "🔢 <b>New Limit:</b> {$req->requested_limit}\n" .
                "🛡️ <b>Approved by:</b> " . Auth::user()->name . "\n" .
                "📝 <b>Notes:</b> " . ($req->admin_notes ?: '-') . "\n" .
                "🕐 <b>At:</b> " . Carbon::now()->format('d M Y H:i')
            );
        } catch (\Exception $e) {
            //
        }

        return response()->json(['success' => true, 'message' => 'Request berhasil di-approve.']);
    }

    /**
     * Superadmin: reject a request.
     */
    public function reject(Request $request, $id)
    {
        $req = PlaceLimitRequest::findOrFail($id);

        if ($req->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Request sudah diproses.'], 422);
        }

        $req->update([
            'status'      => 'rejected',
            'admin_notes' => $request->admin_notes,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        LogActivities::create([
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'user_id'    => Auth::id(),
            'activities' => 'Superadmin rejected place limit request #' . $req->id . ' at ' . Carbon::now()->format('Y-m-d H:i:s'),
            'type'       => 'REJECT_PLACE_LIMIT_REQUEST',
        ]);

        try {
            TelegramService::send(
                "❌ <b>Place Limit Request REJECTED</b>\n\n" .
                "👤 <b>User:</b> " . ($req->user?->name ?? '-') . "\n" .
                "🔢 <b>Requested Limit:</b> {$req->requested_limit}\n" .
                "🛡️ <b>Rejected by:</b> " . Auth::user()->name . "\n" .
                "📝 <b>Reason:</b> " . ($req->admin_notes ?: '-') . "\n" .
                "🕐 <b>At:</b> " . Carbon::now()->format('d M Y H:i')
            );
        } catch (\Exception $e) {
            //
        }

        return response()->json(['success' => true, 'message' => 'Request berhasil di-reject.']);
    }

    /**
     * Non-superadmin: check if they have a pending request (for UI state).
     */
    public function checkPending()
    {
        $pending = PlaceLimitRequest::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        return response()->json(['has_pending' => (bool) $pending]);
    }
}
