<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use App\User;
use App\Contact;

class AuthController extends Controller
{
    
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function getUser(){
        return response()->json([
            'status' => 'success', 
            'data' => [
                'user_data'=>Auth::user(),
                'contactList' => Contact::where('user_id', Auth::user()->id)->orderBy('name', 'asc')->get()
            ]
        ], 200);
    }

    public function loginHuggyCallback(Request $request){

        $code = $request->code;
        if($code){

            
            // Requisita access_token
            // ========================================
            $client = new Client([ 'headers' => ['content-type'  => 'application/json'] ]);
            $response = $client->request('POST', "https://auth.huggy.app/oauth/access_token", [
                'json' => [
                    "grant_type" => "authorization_code",
                    "redirect_uri" => env('HUGGY_REDIRECT_URL'),
                    "client_id" => env('HUGGY_CLIENT_ID'),
                    "client_secret" => env('HUGGY_CLIENT_SECRET'),
                    "code" => $code
                ]
            ]);
            $body_json = json_decode($response->getBody()->getContents());

            // Requisita o perfil do usuário e identifica o email
            // ========================================
            $client = new Client([
                'headers' => [
                    'Accept' => 'application/json',
                    'content-type'  => 'application/json',
                    'Authorization' => 'Bearer '.$body_json->access_token
                ]
            ]);
            $response = $client->request('GET', "https://api.huggy.app/v3/agents/profile");
            $body_json = json_decode($response->getBody()->getContents());

            // Verifica se é um login ou um cadastro
            // ========================================
            $email = $body_json->email;
            $user = User::where('email', $email)->first();

            if(!$user){
                $user = new User();
                $user->name = $body_json->name;
                $user->photo = $body_json->photo;
                $user->email = $email;
                $user->key_flow = str_random(40);

                $user->save();
            }
            
            // Autentica e gera um token de acesso à aplicação
            // ========================================
            $token = auth()->login($user);
            return redirect(env('CLIENT_URL').'?access_token='.$token);
        }
    }

    public function logout()
    {
        auth()->logout();
        return response()->json([
            'status' => 'success', 
            'data' => [
                'msg'=> 'Successfully logged out'
            ]
        ], 200);
    }
}
