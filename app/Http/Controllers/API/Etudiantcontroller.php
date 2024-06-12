<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Etudiant;
use App\Models\User;
use App\Models\Classe;

use Illuminate\Support\Facades\Auth;

class Etudiantcontroller extends Controller
{
    public function create(Request $request){
        try{
            $data=$request->validate([
                'email'=>'required|email',
                'telephone'=>'required',
                'nameclasse'=>'required',
                'name'=>'required'
            ]);
            $data=$request->all();
            $data['matricule']= uniqid();
            $data['classe_id']=Classe::where('nameclasse',$request['nameclasse'])->first(['id']);
            $tel=Etudiant::where('telephone',$request['telephone'])->first(['id']);
            $email=Etudiant::where('email',$request['email'])->first(['id']);

            if ((Auth::user()->id!=2)) {
                return response()->json([
                    'message'=>'seul la secretaire a le droit de creer un etudiant',
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
            if ($tel || $email) {
                return response()->json([
                    'message'=>'l\'email ou le numero de telephoe existe deja',
                    'status'=>false, 
                ]);
                die();
            }
            if (!$data['classe_id']) {
                return response()->json([
                    'message'=>'cette classe n\'existe pas',
                    'status'=>false, 
                ]);
                die();
            }
         
           
            }
            $etudiant=Etudiant::create($data);
            return response()->json([
                'message'=>'etudiant create',
                'user_id'=>$etudiant->id,
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
            $etudiant = Etudiant::all(['email','name','telephone','classe_id']);//Récupération de toutes la catégories.
                return response()->json([
                    'message'=>'Affichages des utilisateurs',
                    'users'=>$etudiant,
                    
                    'status'=>true
                ]);
        }
        catch(\Throwable $th)
        {
            return response()->json(
                ['message'=>$th->getMessage(),
                'status'=>false
                ]);  
        }
    }

    public function search(Request $request){ 
        try{
           $etudiant=Etudiant::where('email',$request['email'])->first(['name','email','telephone']);
            if (!$etudiant){
                return response()->json([
                    'message'=>'Cette etudiant n\'existe pas!',
                    'status'=>false,
                    
                ]);
                die();

            }
            
           return response()->json([
            'message'=>'Affichages des details',
            'name'=>$etudiant,
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
            $etudiant=Etudiant::find($email);
            $id=Etudiant::where('email',$request['email'])->first(['id']);
            $tel=Etudiant::where('telephone',$request['telephone'])->first(['id']);
            $email=Etudiant::where('email',$request['email'])->first(['id']);

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
                    'message'=>'seul la secretaire peut modifier un etudiant',
                    'status'=>false,
                ]);
                die();
            }
            if (!$email) {
                return response()->json([
                    'message'=>'l\'email ou le numero de telephoe existe deja',
                    'status'=>false, 
                ]);
                die();
            }
            if (!$data['email']) {
                return response()->json([
                    'message'=>'cette etudiant n\'existe pas',
                    'status'=>false, 
                ]);
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

