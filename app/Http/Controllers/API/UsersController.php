<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Seafoodresto;
use App\Repositories\SeafoodrestoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Logs;
use Flash;
use Response;

class UsersController extends Controller {

    public $successStatus = 200;

    public function login() {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();

            $success['token'] = Str::random(64);
            $success['email'] = $user->email;
            $success['id'] = $user->id;
            $success['name'] = $user->name;
            $logs = new Logs();
            $logs->userid = $user->id;
            $logs->log = "Login";
            $logs->logdetails = "User $user->name has logged in to my system";
            $logs->logtype = "API login";
            $logs->save();



            // SAVE TOKEN
            $user->remember_token = $success['token'];
            $user->save();
            return response()->json($success, $this->successStatus);
        } else {
            return response()->json(['response' => 'Email not Found'], 404);
        }
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['response' => $validator->errors()], 401);
        } else {
            $input = $request->all();

            if (User::where('email')->exists()) {
                return response()->json(['response' => 'Email already exists'], 401);
            } else {
                $input['password'] = bcrypt($input['password']);
                $user = User::create($input);

                $success['token'] = Str::random(64);
                $success['email'] = $user->email;
                $success['id'] = $user->id;
                $success['name'] = $user->name;

                return response()->json($success, $this->successStatus);
            }
        }
    }
    public function resetPassword(Request $request) {
        $user = User::where('email', $request['email'])->first();

        if ($user != null) {
            $user->password = bcrypt($request['password']);
            $user->save();

            return response()->json(['response' => 'User has successfully resetted his/her password'], $this->successStatus);
        } else {
            return response()->json(['response' => 'User not found'], 404);
        }
    }
}
?>