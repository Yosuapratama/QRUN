<?php

namespace App\Http\Controllers;

use App\Models\LogActivities;
use App\Models\User;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserApproved;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Detail Of Users Controller
    |--------------------------------------------------------------------------
    |
    | This Controllers Contains :
    | -> For Superadmin : 
    |  1. /users, Func Name : index, Route Name : users
    |  2. /users/blocked, Func Name : indexBlocked, Route Name : users.blocked
    |  3. /users/pending-approval, Func Name : pendingApproval, Route Name : users.pending
    |  4. /users/store, Func Name : store, Route Name : users.store
    |  5. /users/update, Func Name : update, Route Name : users.update
    |  6. /users/{id}/approve, Func Name : approve, Route Name : users.approve
    |  7. /users/{id}/unapprove, Func Name : unapprove, Route Name : users.unapprove
    |  8. /users/{id}/block, Func Name : block, Route Name : users.block
    |  9. /users/{id}/unblock, Func Name : unblock, Route Name : users.unblock
    |  10. /users/detail/{id}, Func Name : getUserDetail, Route Name : users.detail
    | 
    | -> For Users :
    |  11. /profile, Func Name : viewProfile, Route Name : profile
    |  12. /profile/update, Func Name : updateProfile, Route Name : profile.update
    |  
    */

    // (1) This index function is superadmin to manage all data of users
    function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::whereNotNull('email_verified_at')->latest();

            if ($request->name) {
                $data = $data->where('name', 'like', '%' . $request->name . '%');
            }

            if ($request->email) {
                $data = $data->where('email', 'like', '%' . $request->email . '%');
            }

            if ($request->phone) {
                $data = $data->where('phone', 'like', '%' . $request->phone . '%');
            }

            if ($request->status) {
                if ($request->status == 'approved') {
                    $data = $data->whereNotNull('approved_at');
                } else if ($request->status == 'pending') {
                    $data = $data->whereNull('approved_at');
                }
            }

            if ($request->block) {
                if ($request->block == 'blocked') {
                    $data = $data->whereNotNull('deleted_at')->withTrashed();
                } else if ($request->block == 'active') {
                    $data = $data->whereNull('deleted_at');
                }
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return $row->approved_at ? 'Approved' : 'Pending';
                })
                ->rawColumns(['status_acc'])
                ->addIndexColumn()
                ->addColumn('status_acc', function ($row) {
                    return $row->deleted_at ? 'Blocked' : '-';
                })
                ->rawColumns(['status_acc'])

                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = "
    <div class='dropdown'>
        <button 
            class='btn btn-primary btn-sm dropdown-toggle'
            type='button'
            data-toggle='dropdown'
            aria-expanded='false'
        >
            <i class='fas fa-cog'></i> Action
        </button>

        <div class='dropdown-menu dropdown-menu-right shadow animated--fade-in'>
    ";

                    // Detail selalu ada
                    $btn .= "
        <button
            id='{$row->id}'
            class='detailUser dropdown-item'
        >
            <i class='fas fa-eye text-primary mr-2'></i>
            Detail
        </button>
    ";

                    // Edit selalu ada
                    $btn .= "
        <button
            id='{$row->id}'
            class='editUser dropdown-item'
        >
            <i class='fas fa-edit text-warning mr-2'></i>
            Edit
        </button>
    ";

                    // Jangan bisa manage diri sendiri
                    if (Auth::user()->id !== $row->id) {

                        // Approve / Unapprove
                        if ($row->approved_at) {

                            $btn .= "
                <button
                    id='{$row->id}'
                    class='unapprove dropdown-item text-danger'
                >
                    <i class='fas fa-times-circle mr-2'></i>
                    UnApprove
                </button>
            ";
                        } else {

                            $btn .= "
                <button
                    id='{$row->id}'
                    class='approve dropdown-item text-success'
                >
                    <i class='fas fa-check-circle mr-2'></i>
                    Approve
                </button>
            ";
                        }

                        $btn .= "<div class='dropdown-divider'></div>";

                        // Block / Unblock
                        if ($row->deleted_at) {

                            $btn .= "
                <button
                    id='{$row->id}'
                    class='unBlockUser dropdown-item text-success'
                >
                    <i class='fas fa-user-check mr-2'></i>
                    Unblock User
                </button>
            ";
                        } else {

                            $btn .= "
                <button
                    id='{$row->id}'
                    class='blockUser dropdown-item text-danger'
                >
                    <i class='fas fa-user-slash mr-2'></i>
                    Block User
                </button>
            ";
                        }
                    }

                    $btn .= "
        </div>
    </div>
    ";

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }


        return view('Pages.Management.Master.manageUsers.users.index');
    }

    // (2) This for admin to see blocked users
    function indexBlocked(Request $request)
    {
        if ($request->ajax()) {
            $data = User::whereNotNull('deleted_at')->withTrashed()->latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return $row->approved_at ? 'Approved' : 'Pending';
                })
                ->rawColumns(['status_acc'])
                ->addIndexColumn()
                ->addColumn('status_acc', function ($row) {
                    return $row->deleted_at ? 'Blocked' : '-';
                })
                ->rawColumns(['status_acc'])

                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = "<div class='d-flex'>";


                    if ($row->approved_at) {
                        $btn = $btn . "<button id='$row->id' class='unapprove btn btn-danger btn-sm mr-1'>UnApprove</button>";
                    } else {
                        $btn = $btn . "<button id='$row->id' class='approve btn btn-success btn-sm mr-1'>Approve</button>";
                    }


                    $btn = $btn . "<button id='$row->id' class='detailUser btn btn-primary btn-sm mr-1'>Detail</button>";
                    $btn = $btn . "<button id='$row->id' class='editUser btn btn-warning btn-sm mr-1'>Edit</button>";

                    $btn = $btn . "<button id='$row->id' class='unBlockUser btn btn-danger btn-sm mr-1'>Restore</button>";

                    $btn = $btn . "</div>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }


        return view('Pages.Management.Master.manageUsers.blocked.index');
    }

    // (3) This is for admin to see the users pending approval
    function pendingApproval(Request $request)
    {
        if ($request->ajax()) {
            $data = User::whereNull('approved_at')->whereNotNull('email_verified_at')->latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return $row->approved_at ? 'Approved' : 'Pending';
                })
                ->rawColumns(['status_acc'])
                ->addIndexColumn()
                ->addColumn('status_acc', function ($row) {
                    return $row->deleted_at ? 'Blocked' : '-';
                })
                ->rawColumns(['status_acc'])

                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = "<div class='d-flex'>";


                    if ($row->approved_at) {
                        $btn = $btn . "<button id='$row->id' class='unapprove btn btn-danger btn-sm mr-1'>UnApprove</button>";
                    } else {
                        $btn = $btn . "<button id='$row->id' class='approve btn btn-success btn-sm mr-1'>Approve</button>";
                    }


                    $btn = $btn . "<button id='$row->id' class='detailUser btn btn-primary btn-sm mr-1'>Detail</button>";
                    $btn = $btn . "<button id='$row->id' class='editUser btn btn-warning btn-sm mr-1'>Edit</button>";

                    $btn = $btn . "<button id='$row->id' class='blockUser btn btn-danger btn-sm mr-1'>Delete</button>";

                    $btn = $btn . "</div>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Pages.Management.Master.manageUsers.pending-approval.index');
    }
    // (4) This is for admin to store users data
    function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'email' => ['required', Rule::unique('users', 'email')],
            'password' => 'required|min:8',
            'password2' => 'required|min:8'
        ], [
            'password2.required' => 'Confirm Password Required'
        ]);
        if ($Validator->fails()) {
            return response()->json([
                'errors' => 'Invalid Fields !',
                'status' => 'All fields must be filled',
                'detail' => $Validator->errors()
            ]);
        }

        if ($request->password !== $request->password2) {
            return response()->json([
                'errors' => 'Password Not Match !',
                'status' => 'Failed To Save Data'
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => $request->auto_verified == "1" ? Carbon::now() : null,
            'approved_at' => $request->auto_approved == "1" ? Carbon::now() : null,
        ]);

        $user->assignRole('localadmin');

        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "Registered New Users at " . Carbon::now()->format('Y-m-d H:i:s'),
            "type" => LogActivities::TYPE_CREATE_USER
        ]);

        return response()->json([
            'message' => 'Create Data Success !',
            'status' => 'Success'
        ]);
    }
    // (5) This update function is used to update users data by admin
    function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'address' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'password' => 'nullable|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $User = User::find($request->id);

        if (!$User) {
            return response()->json([
                'errors' => 'User Not Found !'
            ], 404);
        }

        $User->name = $request->name;
        $User->phone = $request->phone;
        $User->address = $request->address;
        if ($request->auto_approved == "1") {
            $User->approved_at = Carbon::now();
        } else {
            $User->approved_at = null;
        }

        if ($request->auto_verified == "1") {
            $User->email_verified_at = Carbon::now();
        } else {
            $User->email_verified_at = null;
        }

        if ($request->password) {
            $User->password = Hash::make($request->password);
        }

        $User->update();

        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "Updated user id : " . $User->id . " at " . Carbon::now()->format('Y-m-d H:i:s'),
            "type" => LogActivities::TYPE_UPDATE_USER
        ]);

        return response()->json([
            'message' => 'Update Data Success !'
        ], 200);
    }
    // (6) This is for admin to approve users account
    function approve($id)
    {
        $FindUsers = User::find($id);

        if (!$FindUsers) {
            return response()->json([
                'errors' => 'User Not Found !'
            ], 404);
        }
        $FindUsers->approved_at = Carbon::now();
        $FindUsers->update();

        //Mail::to(config('mail.to.address'))->send(new NewUserApproved($FindUsers));
        // Mail::to($FindUsers->email)->send(new NewUserApproved($FindUsers));
        if (!Str::endsWith($FindUsers->email, '@qrun.online')) {
            Mail::to($FindUsers->email)->send(new NewUserApproved($FindUsers));
        }

        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "Approved user id : " . $id . " at " . Carbon::now()->format('Y-m-d H:i:s'),
            "type" => LogActivities::TYPE_APPROVE_USER
        ]);


        return response()->json([
            'message' => 'Approve Success',
            'status' => $FindUsers->email . ' has approved to use this system'
        ], 200);
    }

    // (7) This is for admin to unapprove an users
    function unapprove($id)
    {
        $FindUsers = User::find($id);

        if (!$FindUsers) {
            return response()->json([
                'errors' => 'User Not Found !'
            ], 404);
        }
        $FindUsers->approved_at = null;
        $FindUsers->update();

        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "UnApproved user id : " . $id . " at " . Carbon::now()->format('Y-m-d H:i:s'),
            "type" => LogActivities::TYPE_UNAPPROVE_USER
        ]);

        return response()->json([
            'message' => 'UnApprove Success',
            'status' => $FindUsers->email . ' has been downgraded to user'
        ], 200);
    }

    // (8) This function is used to get user detail data by json response
    function getUserDetail($id)
    {
        $FindUsers = User::find($id);

        if (!$FindUsers) {
            return response()->json([
                'errors' => 'User Not Found !'
            ], 404);
        }

        return response()->json([
            'message' => 'Success',
            'data' => $FindUsers
        ], 200);
    }

    // (9) This function is used to block users account by admin
    function block($id)
    {
        $FindUsers = User::find($id);

        if (!$FindUsers) {
            return response()->json([
                'errors' => 'User Not Found !'
            ], 404);
        }
        $FindPlace = Place::where('creator_id', $id)->latest()->first();
        if ($FindPlace) {
            $FindPlace->delete();
        }

        $FindUsers->delete();

        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "Deleted/Blocked user id : " . $id . " at " . Carbon::now()->format('Y-m-d H:i:s'),
            "type" => LogActivities::TYPE_DELETE_USER
        ]);


        return response()->json([
            'message' => 'User Deleted Success',
            'status' => $FindUsers->email . ' has been Deleted by admin'
        ], 200);
    }

    // (10) This is for admin to unblock users account
    function unblock($id)
    {
        $FindUsers = User::withTrashed()->find($id);

        if (!$FindUsers) {
            return response()->json([
                'errors' => 'User Not Found !'
            ], 404);
        }
        $FindPlace = Place::withTrashed()->where('creator_id', $id)->latest()->first();
        if ($FindPlace) {
            $FindPlace->restore();
        }

        $FindUsers->restore();

        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "Undo Delete/Blocked user id : " . $id . " at " . Carbon::now()->format('Y-m-d H:i:s'),
            "type" => LogActivities::TYPE_RESTORE_USER
        ]);

        return response()->json([
            'message' => 'User UnBlocked Success',
            'status' => $FindUsers->email . ' has been unblocked admin'
        ], 200);
    }

    // (11) This is for users to see their profile data 
    function viewProfile()
    {
        $User = User::where('id', Auth::user()->id)->first();

        return view('Pages.Management.Master.profile.index', compact('User'));
    }
    // (12) This is for users to modify their account profile
    function updateProfile(Request $request)
    {
        $Validate = $request->validate([
            'address' => 'required',
            'name' => 'required',
            'phone' => 'required'
        ], [
            'address.required' => 'Address is required',
            'name.required' => 'Name is required',
            'phone.required' => 'Phone Number is required'
        ]);

        $User = User::where('id', Auth::user()->id)->first();
        $User->address = $request->address;
        $User->name = $request->name;
        $User->phone = $request->phone;

        if ($request->currpassword) {
            if ($request->password) {
                if ($request->password2) {
                    if ($request->password !== $request->password2) {
                        return back()->withErrors('Your Confirm Password Is Wrong !');
                    }
                    if (strlen($request->password) < 8) {
                        return back()->withErrors('Your New Password Min 8 Characters !');
                    }
                    if (strlen($request->password2) < 8) {
                        return back()->withErrors('Your Confirm Password Min 8 Characters !');
                    }
                    if (Hash::check($request->currpassword, Auth::user()->password)) {
                        $User->password = $request->password;
                    } else {
                        return back()->withErrors('Your Current Password is Wrong !');
                    }
                } else {
                    return back()->withErrors('Confirm Password Required');
                }
            } else {
                return back()->withErrors('New Password Required');
            }
        }


        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "Updated user profile with id : " . $User->id . " at " . Carbon::now()->format('Y-m-d H:i:s'),
            "type" => LogActivities::TYPE_UPDATE_PROFILE_USER
        ]);

        $User->update();

        return back()->with('success', 'Profile Updated Successfully !');
    }

    function pendingVerify(Request $request)
    {
        if ($request->ajax()) {
            $data = User::whereNull('email_verified_at')->latest();

            if ($request->name) {
                $data = $data->where('name', 'like', '%' . $request->name . '%');
            }

            if ($request->email) {
                $data = $data->where('email', 'like', '%' . $request->email . '%');
            }

            if ($request->phone) {
                $data = $data->where('phone', 'like', '%' . $request->phone . '%');
            }

            if ($request->status) {
                if ($request->status == 'approved') {
                    $data = $data->whereNotNull('approved_at');
                } else if ($request->status == 'pending') {
                    $data = $data->whereNull('approved_at');
                }
            }

            if ($request->address) {
                $data = $data->where('address', 'like', '%' . $request->address . '%');
            }

            if ($request->block) {
                if ($request->block == 'blocked') {
                    $data = $data->whereNotNull('deleted_at')->withTrashed();
                } else if ($request->block == 'active') {
                    $data = $data->whereNull('deleted_at');
                }
            }

            $data = $data->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return $row->approved_at ? 'Approved' : 'Pending';
                })
                ->rawColumns(['status_acc'])
                ->addIndexColumn()
                ->addColumn('status_acc', function ($row) {
                    return $row->deleted_at ? 'Blocked' : '-';
                })
                ->rawColumns(['status_acc'])

                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = "
    <div class='dropdown'>
        <button 
            class='btn btn-primary btn-sm dropdown-toggle'
            type='button'
            data-toggle='dropdown'
            aria-expanded='false'
        >
            <i class='fas fa-cog'></i> Action
        </button>

        <div class='dropdown-menu dropdown-menu-right shadow animated--fade-in'>
    ";

                    // Verify User
                    $btn .= "
        <button
            id='{$row->id}'
            class='verifyUser dropdown-item text-success'
        >
            <i class='fas fa-check-circle mr-2'></i>
            Verify Account
        </button>
    ";

                    $btn .= "<div class='dropdown-divider'></div>";

                    // Delete User
                    $btn .= "
        <button
            id='{$row->id}'
            class='deleteUser dropdown-item text-danger'
        >
            <i class='fas fa-trash-alt mr-2'></i>
            Delete User
        </button>
    ";

                    $btn .= "
        </div>
    </div>
    ";

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Pages.Management.Master.manageUsers.pending-verify.index');
    }

    function verifyAccountManual($id)
    {
        $User = User::find($id);
        if (!$User) {
            return response()->json([
                'errors' => 'Data not found'
            ]);
        }

        if ($User->email_verified_at) {
            return response()->json([
                'errors' => 'This account has been verified !'
            ]);
        }

        $User->email_verified_at = Date::now();
        $User->save();


        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "Verify Account with account id : " . $User->id . " at " . Carbon::now()->format('Y-m-d H:i:s'),
            "type" => LogActivities::TYPE_VERIFY_USER
        ]);

        return response()->json([
            'status' => 'Verify Account Success !',
            'message' => 'Successfully verified !'
        ]);
    }
}
