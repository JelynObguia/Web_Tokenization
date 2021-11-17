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

class SeafoodController extends Controller {
    public $successStatus = 200;

    public function getAllseafoodresto(Request $request) {
        $token = $request['t']; // t=token
        $userid = $request['u']; //u = userid

        $user = User::where('id', $userid)->where('remember_token', $token)->first();

        if ($user != null) {
            $seafoodrestos = seafoodresto::all();

            return response()->json($seafoodrestos, $this->successStatus);
        } else {
            return response()->json(['response' => 'Bad Call'], 501);
        }
    }
    
    public function getSeafoodrestos(Request $request) {
        $id = $request['pid']; // pid = seafoodresto id
        $token = $request['t']; // t=token
        $userid = $request['u']; //u = userid

        $user = User::where('id', $userid)->where('remember_token', $token)->first();

        if ($user != null) {
            $seafoodrestos = seafoodresto::where('id', $id)->first();

            if($seafoodrestos != null) {
                return response()->json(['response' => 'Seafoodresto not found!'], 404);
            } else {

            }
        } else {
            return response()->json(['response' => 'Bad Call'], 501);
        }
    }

    public function searchSeafoodrestos(Request $request) {
        $params = $request['p']; // p = params
        $token = $request['t']; // t=token
        $userid = $request['u']; //u = userid

        $user = User::where('id', $userid)->where('remember_token', $token)->first();

        if ($user != null) {
            $seafoodrestos = seafoodresto::where('CostumerName', 'LIKE', '%' . $params . '%')
                ->orWhere('CostumerAddress',  'LIKE', '%' . $params . '%')
                ->get();
            // SELECT = FROM seafodrestos WHERE CostumerName LIKE '%params%' OR CostumerAddress LIKE '%PARAMS%'
            if($seafoodrestos != null) {
               return response()->json($seafoodrestos, $this->successStatus);
            } else {
                return response()->json(['response' => 'Seafoodresto not found!'], 404);
            }
        } else {
            return response()->json(['response' => 'Bad Call'], 501);
        }
    }
}