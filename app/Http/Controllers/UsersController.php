<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Place;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    function index(Request $request)
    {   
        if ($request->ajax()) {
            $data = User::latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return $row->is_approved === 1 ? 'Approved' : 'Pending';
                })
                ->rawColumns(['status_acc'])
                ->addIndexColumn()
                ->addColumn('status_acc', function ($row) {
                    return $row->is_deleted === 1 ? 'Blocked' : '-';
                })
                ->rawColumns(['status_acc'])

                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = "<div class='d-flex justify-content-center'>";
                    if(Auth::user()->id !== $row->id){
                        if($row->is_deleted === 0){
                            if($row->is_approved === 1){
                                $btn = $btn. "<button id='$row->id' class='unapprove btn btn-danger btn-sm mr-1'>UnApprove</button>";
                            }else{
                                $btn = $btn. "<button id='$row->id' class='approve btn btn-success btn-sm mr-1'>Approve</button>";
                            }
                        }
                        $btn = $btn."<button id='$row->id' class='detailUser btn btn-primary btn-sm mr-1'>Detail</button>";
                        $btn = $btn."<button id='$row->id' class='editUser btn btn-warning btn-sm mr-1'>Edit</button>";
                        if($row->is_deleted === 0){
                            $btn = $btn."<button id='$row->id' class='blockUser btn btn-danger btn-sm mr-1'>Block</button>";
                        }else{
                            $btn = $btn."<button id='$row->id' class='unBlockUser btn btn-secondary btn-sm mr-1'>UnBlock</button>";
                        }
                    }else{
                        $btn = $btn."<button id='$row->id' class='detailUser btn btn-primary btn-sm mr-1'>Detail</button>";
                        $btn = $btn."<button id='$row->id' class='editUser btn btn-warning btn-sm mr-1'>Edit</button>";
                    }
                   
                  
                    $btn = $btn."</div>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    

        return view('Pages.Users.Users');
    }
    // Setup Blocked Page
    function indexBlocked(Request $request){
        if ($request->ajax()) {
            $data = User::where('is_deleted', 1)->latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return $row->is_approved === 1 ? 'Approved' : 'Pending';
                })
                ->rawColumns(['status_acc'])
                ->addIndexColumn()
                ->addColumn('status_acc', function ($row) {
                    return $row->is_deleted === 1 ? 'Blocked' : '-';
                })
                ->rawColumns(['status_acc'])

                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = "<div class='d-flex'>";

                    if($row->is_deleted === 0){
                        if($row->is_approved === 1){
                            $btn = $btn. "<button id='$row->id' class='unapprove btn btn-danger btn-sm mr-1'>UnApprove</button>";
                        }else{
                            $btn = $btn. "<button id='$row->id' class='approve btn btn-success btn-sm mr-1'>Approve</button>";
                        }
                    }

                    $btn = $btn."<button id='$row->id' class='detailUser btn btn-primary btn-sm mr-1'>Detail</button>";
                    $btn = $btn."<button id='$row->id' class='editUser btn btn-warning btn-sm mr-1'>Edit</button>";
                    if($row->is_deleted === 0){
                        $btn = $btn."<button id='$row->id' class='blockUser btn btn-danger btn-sm mr-1'>Block</button>";
                    }else{
                        $btn = $btn."<button id='$row->id' class='unBlockUser btn btn-secondary btn-sm mr-1'>UnBlock</button>";
                    }
                    $btn = $btn."</div>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    

        return view('Pages.Users.BlockedUsers');
    }
    function pendingApproval(Request $request){
        if ($request->ajax()) {
            $data = User::where('is_deleted', 0)->where('is_approved', 0)->latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return $row->is_approved === 1 ? 'Approved' : 'Pending';
                })
                ->rawColumns(['status_acc'])
                ->addIndexColumn()
                ->addColumn('status_acc', function ($row) {
                    return $row->is_deleted === 1 ? 'Blocked' : '-';
                })
                ->rawColumns(['status_acc'])

                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = "<div class='d-flex'>";

                    if($row->is_deleted === 0){
                        if($row->is_approved === 1){
                            $btn = $btn. "<button id='$row->id' class='unapprove btn btn-danger btn-sm mr-1'>UnApprove</button>";
                        }else{
                            $btn = $btn. "<button id='$row->id' class='approve btn btn-success btn-sm mr-1'>Approve</button>";
                        }
                    }

                    $btn = $btn."<button id='$row->id' class='detailUser btn btn-primary btn-sm mr-1'>Detail</button>";
                    $btn = $btn."<button id='$row->id' class='editUser btn btn-warning btn-sm mr-1'>Edit</button>";
                    if($row->is_deleted === 0){
                        $btn = $btn."<button id='$row->id' class='blockUser btn btn-danger btn-sm mr-1'>Block</button>";
                    }else{
                        $btn = $btn."<button id='$row->id' class='unBlockUser btn btn-secondary btn-sm mr-1'>UnBlock</button>";
                    }
                    $btn = $btn."</div>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Pages.Users.PendingApproval');
    }
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
        if($Validator->fails()){
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
            'is_approved' => 0,
            'is_deleted' => 0
        ]);

        $user->assignRole('localadmin');

        return response()->json([
            'message' => 'Create Data Success !',
            'status' => 'Success'
        ]);
    }
    function update(Request $request){
        $Validator = Validator::make($request->all(), [
            'id' => 'required',
            'address' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'password' => 'required'
        ]);
  
        $User = User::find($request->id);

        if(!$User){
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
    function approve($id){
        $FindUsers = User::find($id);

        if(!$FindUsers){
            return response()->json([
                'errors' => 'User Not Found !'
            ], 404);
        }
        $FindUsers->is_approved = 1;
        $FindUsers->update();

        return response()->json([
            'message' => 'Approve Success',
            'status' => $FindUsers->email . ' has been upgraded to local admin'
        ], 200);
    }

    function unapprove($id){
        $FindUsers = User::find($id);

        if(!$FindUsers){
            return response()->json([
                'errors' => 'User Not Found !'
            ], 404);
        }
        $FindUsers->is_approved = 0;
        $FindUsers->update();

        return response()->json([
            'message' => 'UnApprove Success',
            'status' => $FindUsers->email . ' has been downgraded to user'
        ], 200);
    }
    
    function getUserDetail($id){
        $FindUsers = User::find($id);

        if(!$FindUsers){
            return response()->json([
                'errors' => 'User Not Found !'
            ], 404);
        }

        return response()->json([
            'message' => 'Success',
            'data' => $FindUsers
        ], 200);
    }
    
    function block($id){
        $FindUsers = User::find($id);

        if(!$FindUsers){
            return response()->json([
                'errors' => 'User Not Found !'
            ], 404);
        }
        $FindPlace = Place::where('creator_id', $id)->latest()->first();
        $FindPlace->is_deleted = 1;
        $FindPlace->save();
       
        $FindUsers->is_deleted = 1;
        $FindUsers->update();

        return response()->json([
            'message' => 'User Blocked Success',
            'status' => $FindUsers->email . ' has been blocked by admin'
        ], 200);
    }
    function unblock($id){
        $FindUsers = User::find($id);

        if(!$FindUsers){
            return response()->json([
                'errors' => 'User Not Found !'
            ], 404);
        }
        $FindPlace = Place::where('creator_id', $id)->latest()->first();
        $FindPlace->is_deleted = 0;
        $FindPlace->save();

        $FindUsers->is_deleted = 0;
        $FindUsers->update();

        return response()->json([
            'message' => 'User UnBlocked Success',
            'status' => $FindUsers->email . ' has been unblocked admin'
        ], 200);
    }

    function viewProfile(){
        $User = User::where('id', Auth::user()->id)->first();

        return view('Pages.profile', compact('User'));
    }
    function updateProfile(Request $request){
        $Validate = $request->validate([
            'address' => 'required',
            'name' => 'required',
            'phone' => 'required'
        ]);

        $User = User::where('id', Auth::user()->id)->first();
        $User->address = $request->address;
        $User->name = $request->name;
        $User->phone = $request->phone;
        
        if($request->currpassword){
            if($request->password){
                if($request->password2){
                    if($request->password !== $request->password2){
                        return back()->withErrors('Your Confirm Password Is Wrong !');
                    }
                    if(strlen($request->password) < 8){
                        return back()->withErrors('Your New Password Min 8 Characters !');
                    }
                    if(strlen($request->password2) < 8){
                        return back()->withErrors('Your Confirm Password Min 8 Characters !');
                    }
                    if(Hash::check($request->currpassword,Auth::user()->password )){
                        $User->password = $request->password;
                    }else{
                        return back()->withErrors('Your Current Password is Wrong !');
                    }
                }else{
                    return back()->withErrors('Confirm Password Required');
                }
                
            }else{
                return back()->withErrors('New Password Required');

            }
            
        }
        
        $User->update();

        return back()->with('success', 'Profile Updated Successfully !');
    }
}
