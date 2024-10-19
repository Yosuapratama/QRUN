<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

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
            $data = User::latest()->get();

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
                    $btn = "<div class='d-flex justify-content-center'>";
                    if (Auth::user()->id !== $row->id) {

                        if ($row->approved_at) {
                            $btn = $btn . "<button id='$row->id' class='unapprove btn btn-danger btn-sm mr-1'>UnApprove</button>";
                        } else {
                            $btn = $btn . "<button id='$row->id' class='approve btn btn-success btn-sm mr-1'>Approve</button>";
                        }

                        $btn = $btn . "<button id='$row->id' class='detailUser btn btn-primary btn-sm mr-1'>Detail</button>";
                        $btn = $btn . "<button id='$row->id' class='editUser btn btn-warning btn-sm mr-1'>Edit</button>";
                       
                        $btn = $btn . "<button id='$row->id' class='blockUser btn btn-danger btn-sm mr-1'>Delete</button>";
                       
                    } else {
                        $btn = $btn . "<button id='$row->id' class='detailUser btn btn-primary btn-sm mr-1'>Detail</button>";
                        $btn = $btn . "<button id='$row->id' class='editUser btn btn-warning btn-sm mr-1'>Edit</button>";
                    }


                    $btn = $btn . "</div>";
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
            $data = User::latest()->get();

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


        return view('Pages.Management.Master.manageUsers.blocked.index');
    }

    // (3) This is for admin to see the users pending approval
    function pendingApproval(Request $request)
    {
        if ($request->ajax()) {
            $data = User::whereNull('approved_at')->latest()->get();

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
            'password' => Hash::make($request->password)
        ]);

        $user->assignRole('localadmin');

        return response()->json([
            'message' => 'Create Data Success !',
            'status' => 'Success'
        ]);
    }
    // (5) This update function is used to update users data by admin
    function update(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'id' => 'required',
            'address' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'password' => 'required'
        ]);

        $User = User::find($request->id);

        if (!$User) {
            return response()->json([
                'errors' => 'User Not Found !'
            ], 404);
        }

        $User->name = $request->name;
        $User->phone = $request->phone;
        $User->address = $request->address;
        $User->update();

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

        return response()->json([
            'message' => 'Approve Success',
            'status' => $FindUsers->email . ' has been upgraded to local admin'
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
        $FindUsers->approved_at = Carbon::now();
        $FindUsers->update();

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

        return response()->json([
            'message' => 'User Deleted Success',
            'status' => $FindUsers->email . ' has been Deleted by admin'
        ], 200);
    }

    // (10) This is for admin to unblock users account
    function unblock($id)
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

        $User->update();

        return back()->with('success', 'Profile Updated Successfully !');
    }
}
