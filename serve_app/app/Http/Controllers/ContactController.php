<?php

namespace App\Http\Controllers;

use App\Contact;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function create (Request $request){
        $validatedData = $request->validate([
            'name' =>  'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'nullable',
            'district' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
        ]);

        DB::beginTransaction();
        try {
            $contact = new Contact();
            $contact->name = $validatedData['name'];
            $contact->user_id = Auth::user()->id;
            $contact->email = $validatedData['email'];
            $contact->phone = $validatedData['phone'];
            $contact->address = $validatedData['address'];
            $contact->district = $validatedData['district'];
            $contact->city = $validatedData['city'];
            $contact->state = $validatedData['state'];

            $contact->save();
        } catch (\Throwable $th) {
            DB::rollback();
            request()->flash();
            return response()->json([
                'status' => 'fail', 
                'data' => [
                    'msg'=>'Try again later.'
                ]
            ], 500);
        }

        DB::commit();
        return response()->json([
            'status' => 'success', 
            'data' => [
                'msg'=>'Contato registrado com sucesso',
                'contactList' => Contact::where('user_id', Auth::user()->id)->orderBy('name', 'asc')->get()
            ]
        ], 200);


    }

    public function createFlow (Request $request, $key_flow){
        
        $validatedData = $request->validate([
            'name' =>  'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'nullable',
            'district' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
        ]);

        DB::beginTransaction();
        try {
            $user = User::where('key_flow', $key_flow)->first();
            
            $contact = new Contact();
            $contact->name = $validatedData['name'];
            $contact->user_id = $user->id;
            $contact->email = $validatedData['email'];
            $contact->phone = $validatedData['phone'];
            $contact->address = $validatedData['address'];
            $contact->district = $validatedData['district'];
            $contact->city = $validatedData['city'];
            $contact->state = $validatedData['state'];

            $contact->save();
        } catch (\Throwable $th) {
            DB::rollback();
            request()->flash();
            return response()->json([
                'status' => 'fail', 
                'data' => [
                    'msg'=>'Try again later.'
                ]
            ], 500);
        }

        DB::commit();
        return response()->json([
            'status' => 'success', 
            'data' => [
                'msg'=>'Contato registrado com sucesso',
            ]
        ], 200);
    }
    
    public function update (Request $request, $id){
        $validatedData = $request->validate([
            'name' =>  'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'nullable',
            'district' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
        ]);

        DB::beginTransaction();
        try {
            $contact = Contact::where('id', $id)->where('user_id', Auth::user()->id)->first();
            $contact->name = $validatedData['name'];
            $contact->email = $validatedData['email'];
            $contact->phone = $validatedData['phone'];
            $contact->address = $validatedData['address'];
            $contact->district = $validatedData['district'];
            $contact->city = $validatedData['city'];
            $contact->state = $validatedData['state'];

            $contact->save();
        } catch (\Throwable $th) {
            DB::rollback();
            request()->flash();
            return response()->json([
                'status' => 'fail', 
                'data' => [
                    'msg'=>'Try again later.'
                ]
            ], 500);
        }

        DB::commit();
        return response()->json([
            'status' => 'success', 
            'data' => [
                'msg'=>'Contato atualizado com sucesso',
                'contactList' => Contact::where('user_id', Auth::user()->id)->orderBy('name', 'asc')->get()
            ]
        ], 200);
    }
    
    public function delete ($id){
        DB::beginTransaction();
        try {
            $contact = Contact::where('id', $id)->where('user_id', Auth::user()->id)->first();
            $contact->delete();
        } catch (\Throwable $th) {
            DB::rollBack();
            request()->flash();
            return response()->json([
                'status' => 'fail', 
                'data' => [
                    'msg'=>'Try again later.'
                ]
            ], 500);
        }
        DB::commit();
        return response()->json([
            'status' => 'success', 
            'data' => [
                'msg'=>'Contato deletado com sucesso',
                'contactList' => Contact::where('user_id', Auth::user()->id)->orderBy('name', 'asc')->get()
            ]
        ], 200);
    }
    

    public function getById ($id){
        $contact = $contact = Contact::where('id', $id)->where('user_id', Auth::user()->id)->first();
        if($contact){
            return response()->json([
                'status' => 'success', 
                'data' => [
                    'contact'=>$contact
                ]
            ], 200);
        }
        else{
            return response()->json([
                'status' => 'fail', 
                'data' => [
                    'msg'=>'Contato não encontrado.'
                ]
            ], 400);
        }
    }

    public function getByName(Request $reques){

        if(!$reques->search || ($reques->search == '#'))
            $contacts = Contact::where('user_id', Auth::user()->id)->orderBy('name', 'asc')->get();
        else
            $contacts = Contact::where('name', 'LIKE', '%'.$reques->search.'%' )->where('user_id', Auth::user()->id)->orderBy('name', 'asc')->get();
        
        return response()->json([
            'status' => 'success', 
            'data' => [
                'contactList'=>$contacts
            ]
        ], 200);
    }
}
