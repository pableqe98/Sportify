<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    private $client;

    public function __construct(){
        $this->client = Client::find(1);
    }

    public function login(Request $request){
        $this->validate($request,[
            'email' => 'required',
            'password' => 'required'
        ]);

        $params = [
            'grant_type' => 'password',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'username' => request('email'),
            'password' => request('password'),
            'scope' => '*'
        ];

        $request->request->add($params);

        $proxy = Request::create('oauth/token','POST');

        return Route::dispatch($proxy);

    }

    public function refresh(Request $request){
        $this->validate($request,[
            'refresh_token' => 'required',
        ]);

        $params = [
            'grant_type' => 'refresh_token',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'username' => request('email'),
            'password' => request('password'),
            'scope' => '*'
        ];

        $request->request->add($params);

        $proxy = Request::create('oauth/token','POST');

        return Route::dispatch($proxy);

    }

    public function logout(Request $request){
        
        $id = Auth::user()->id_individual;
        $accessToken = DB::table('oauth_access_tokens')->where('user_id',$id)->first();
        

        DB::table('oauth_refresh_tokens')
            ->where('access_token_id',$accessToken->id)
            ->update(['revoked' => 1]);

        DB::table('oauth_access_tokens')
            ->where('id',$accessToken->id)
            ->update(['revoked' => 1]);

        return response()->json([], 204);
    }


}



