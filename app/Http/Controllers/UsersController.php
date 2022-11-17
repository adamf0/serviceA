<?php

namespace App\Http\Controllers;

use App\Jobs\SubmitEmailJob;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(){
        return response()->json(User::all());
    }

    public function store(Request $request){
        $validated = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validated->fails()){
            return response()->json(["status"=>500,"message"=>"gagal","error"=>$validated->errors()]);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        
        try {
            $user->save();
            Log::info('User success to save.', ['id' => $user->id]);
            $emailJob = (new SubmitEmailJob($request->email, ["message"=>"hello world"]));
            dispatch($emailJob);
            
            return response()->json(["status"=>200,"message"=>"berhasil","error"=>null]);
        } catch (Exception $e) {
            return response()->json(["status"=>500,"message"=>"gagal","error"=>$e->getMessage()]);
        }
    }
}
