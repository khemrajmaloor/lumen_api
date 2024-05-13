<?php
namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //Fetch all admin data..
    public function showAllAdmins()
    {
        return response()->json(Admin::all());
    }
    //fetch admin data by id..
    public function showOneAdmin($id)
    {
        return response()->json(Admin::find($id));
    }
    //Register admin here..
    public function createAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_login'   => 'required',
            'user_email'   => 'required|email|unique:admins',
            'user_pass'    => 'required',
            'user_nicename'=> 'nullable',
            'user_url'     => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Validation passed, proceed with creating the admin...
        $admin = new Admin();
        $admin->user_login      = $request->input('user_login');
        $admin->user_email      = $request->input('user_email');
        $admin->user_pass       = Hash::make($request->input('user_pass'));
        $admin->user_nicename   = $request->input('user_login');
        $admin->user_url        = $request->fullUrl();
        $admin->role            = 'admin'; 
        $admin->user_registered = date('Y-m-d H:i:s');
        $admin->save();

        return response()->json(['message' => 'Admin registered successfully'], 201);
    }
    //Update admin data..
    public function updateAdmin($id, Request $request)
    {
        $admin = Admin::findOrFail($id);
        $admin->update($request->all());

        return response()->json($admin, 200);
    }
    //Detele admin
    public function deleteAdmin($id)
    {
        Admin::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
