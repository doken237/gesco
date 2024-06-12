<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\Enseignant;
use  App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Enseignantcontroller extends Controller
{
    public function create(Request $request){
        try{
            $data=$request->validate([
                'email'=>'required|email|unique:enseignants',
                'telephone'=>'required|unique:enseignants',
                'password'=>'required',
                'name'=>'required'
            ]);
            $data=$request->all();
            $data['email']=$request['email'];
            $data['unique_enseignant']= uniqid();
            $data['password']=Hash::make($request->password);
            if ((Auth::user()->id!=2)) {
                return response()->json([
                    'message'=>'seul la secretaire a le droit de creer un enseignant',
                    'status'=>false, 
                ]);
                die();
            }
            
            if (isset($request['email'])) {
                if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
                    return response()->json([
                        'message'=>'l\'email entree n\'est pas valide',
                        'status'=>false, 
                    ]);
                    die();
            }
           
            }
            $enseignant=Enseignant::create($data);
            return response()->json([
                'message'=>'enseignant create',
                'user_id'=>$enseignant->id,
                'status'=>true
            ]);
        }
        catch(\Throwable $th)
        {
                return response()->json(
                ['message'=>$th->getMessage(),
                'status'=>false
                ] );  
        }
    }


    public function details(Request $request){ 
        try{
            $enseignant = Enseignant::all(['email','name','telephone']);//Récupération de toutes la catégories.
                return response()->json([
                    'message'=>'Affichages des utilisateurs',
                    'users'=>$enseignant,
                    'status'=>true
                ]);
        }
        catch(\Throwable $th)
        {
            return response()->json(
                ['message'=>$th->getMessage(),
                'status'=>false
                ] );
                
            
        }
    }

    public function search(Request $request){ 
        try{
           $enseignant=Enseignant::where('email',$request['email'])->first(['name','email','telephone']);
            if (!$enseignant){
                return response()->json([
                    'message'=>'Cette utilisateur n\'existe pas!',
                    'status'=>false,
                    
                ]);
                die();
            }
           return response()->json([
            'message'=>'Affichages des details',
            'name'=>$enseignant,
            'statut'=>true
        ]);
        }
        catch(\Throwable $th)
        {
            return response()->json(
                ['message'=>$th->getMessage(),
                'status'=>false
                ] );
   
        }
    }

    public function update(Request $request){
        try{
            $data=$request->all();
            $email=$request['email'];
            $enseignant=Enseignant::find($email);
            $id=Enseignant::where('email',$request['email'])->first(['id']);
            if ((!$id)){
                return response()->json([
                    'message'=>'Cette enseignant n\'existe pas!',
                    'status'=>false,
                ]);
                die();
            }
            // verification de l'adresse Email

            if (isset($request['email'])) {
                if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
                    return response()->json([
                        'message'=>'l\'email entree n\'est pas valide',
                        'status'=>false,  
                    ]);
                    die();
            }
            }
            if ((Auth::user()->id)!=2) {
                return response()->json([
                    'message'=>'seul la secretaire peut modifier un enseignant',
                    'status'=>false,
                ]);
                die();
            }
                 $id->update($data);
                 return response()->json([
                'message'=>'enseignant Update',
                'status'=>true,  
             
            ]);

        }
        catch(\Throwable $th)
        {
            return response()->json(
                ['message'=>$th->getMessage(),
                'status'=>false,
                'se'=>$email
                ] );   
        }
    }

}
