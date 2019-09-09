<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use App\Helpers\Guzzle;
use Yajra\Datatables\Datatables;
use App\User;
use App\Role;
use App\UserRole;


class UserController extends Controller
{
    //view page
    public function index()
    {
        $title = 'User Management';

        return view('user::index')->withTitle($title);
    }

    //get data fot DataTable
    public function data(Request $request)
    {
        $user = User::get();
        
        return datatables::of($user)->make(true);
    }

    public function setCashier($id)
    {
        $model = User::findOrFail($id);
        $model->level = 3;

        if(!$model->update()){
            $data = [
                'status' => 2,
                'message' => 'Fail Approve Data'
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => 'Success Approve Data'
            ];
        }

        return json_encode($data);

    }

    public function setRegular($id)
    {
        $model = User::findOrFail($id);
        $model->level = 2;

        if(!$model->update()){
            $data = [
                'status' => 2,
                'message' => 'Fail Approve Data'
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => 'Success Approve Data'
            ];
        }

        return json_encode($data);

    }

    //store data
    public function store(Request $request)
    {

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->level = 2;
        //
        $user->password = \Hash::make($request->password);
        $user->is_verified = 0;

        $user->save();
        
        $data = [
            'status' => 1,
            'message' => 'Success Update Data'
        ];

        return json_encode($data);
    }

    //get data for Edit
    public function edit($id, Request $request)
    {
        $data = User::where('id', $id)->first();

        return json_encode($data);
    }

    //update data
    public function update($id, Request $request)
    {
        
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;

        if(!$user->update()){
            $data = [
                'status' => 2,
                'message' => 'Fail Update Data'
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => 'Success Update Data'
            ];
        }


        return json_encode($data);

    }

    //approve data
    public function approve($id, Request $request)
    {
        $model = User::findOrFail($id);
        $model->is_verified = 1;

        if(!$model->update()){
            $data = [
                'status' => 2,
                'message' => 'Fail Approve Data'
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => 'Success Approve Data'
            ];
        }

        return json_encode($data);
    }

    //decline data
    public function decline($id, Request $request)
    {
        $model = User::findOrFail($id);
        $model->is_verified = 0;

        if(!$model->update()){
            $data = [
                'status' => 2,
                'message' => 'Fail Update Data'
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => 'Success Update Data'
            ];
        }

        return json_encode($data);
    }

    //delete data
    public function destroy($id, Request $request)
    {
        $user = User::where('id', $id);
        $user->delete();

        if(!$user->delete()){
            $data = [
                'status' => 2,
                'message' => 'Fail Update Data'
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => 'Success Update Data'
            ];
        }

        return json_encode($data);
    }

    //get info data
    public function info(Request $request)
    {
        $model = User::get();

        $verified = 0;
        $unverified = 0;
        $total = 0;
        foreach($model as $key){
            if($key->status){
                ++$verified;
            }else{
                ++$unverified;
            }
        }

        $info = [
            'totalverified' => $verified,
            'totalunverified' => $unverified,
            'total' => $verified+$unverified
        ];
        return json_encode($info);
    }

    //profil 
    public function profil()
    {
        $user = User::findOrFail(Auth::user()->id);
        // $instansi = Instansi::get();
        $title = 'PROFIL';
        return view('user::profil')->withData($user)->withTitle($title);
    }

    public function updateprofil(Request $request)
    {
        $user = User::findOrFail($request->id);
        
        if($request->new_password != NULL){
            if($request->new_password == $request->confirm_password)
            {
                $user->username = $request->username;
                $user->email = $request->email;
                $user->password = \Hash::make($request->new_password);
                $user->save();

                $data = [
                    'status' => 1,
                    'message' => 'Success Update Data'
                ];

                return \Redirect::back()->with('status', 'Data Update Success');
            } else {
                $data = [
                    'status' => 2,
                    'message' => 'Fail Update Data'
                ];
                return \Redirect::back()->with('danger', 'Your Password Confirmation is Incorrect');
            }
        } else {
            $user->username = $request->username;
            $user->email = $request->email;
            $user->save();

            $data = [
                'status' => '1',
                'message' => 'Success Update Data'
            ];

            return \Redirect::back()->with('status', 'Data Update Success');
        }       
    }

    public function updateprofilpic(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'foto' => 'required|file|max:100000000',
        ]);

        if ($validator->fails()){
            $data = [
                'status' => 2,
                'message' => 'Fail Update Data'
            ];

            return json_encode($data);
        }else{
            $foto = Storage::disk('sftp')->put('foto', $request->file('foto'));
            if ($foto) {
                $model = User::findOrFail($request->id);
                $model->image = $foto;
                $model->update();
                $request->session()->regenerate();
                $data = [
                    'status' => 1,
                    'message' => 'Success Update Data'
                ];
                return json_encode($data);
            }else{
                $data = [
                    'status' => 2,
                    'message' => 'Fail Update Data'
                ];
                return json_encode($data);
            }
        }
    }

    public function deletepic(Request $request)
    {
        $model = User::findOrFail($request->id);
        $model->image = null;
        $model->update();
        $request->session()->regenerate();
        $data = [
            'status' => 1,
            'message' => 'Success Update Data'
        ];
        return redirect()->route('profil.index');
    }
}
