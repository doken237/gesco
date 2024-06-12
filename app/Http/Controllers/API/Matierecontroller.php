<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Matiere;
use App\Models\Classe;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class Matierecontroller extends Controller
{
    public function create(Request $request){
        try{
            $data=$request->validate([
                'libelle'=>'required',
                'nameclasse'=>'required'

            ]);
            $data=$request->all();
            $data['unique_matiere']= uniqid();
            $data['classe_id']=Classe::where('nameclasse',$request['nameclasse'])->first('id');
            $class=Classe::where('nameclasse',$request['nameclasse'])->first(['id']);
            if ((Auth::user()->id!=2)) {
                return response()->json([
                    'message'=>'seul la secretaire a le droit de creer une classe',
                    'status'=>false, 
                ]);
                die();
            }


            if (!$class) {
                return response()->json([
                    'message'=>'cette classe n\'existe deja',
                    'status'=>false, 
                ]);
                die();
            }
            $classe=Matiere::create($data);
            return response()->json([
                'message'=>'matiere create',
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
            $matiere = Matiere::all(['libelle','classe_id']);//Récupération de toutes la catégories.
                return response()->json([
                    'message'=>'Affichages des classes',
                    'users'=>$matiere,
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
           $matiere=Matiere::where('libelle',$request['libelle'])->first(['libelle','classe_id']);
            if (!$matiere){
                return response()->json([
                    'message'=>'Cette classe n\'existe pas!',
                    'status'=>false,
                    
                ]);
                die();
            }
           return response()->json([
            'message'=>'Affichages des details',
            'name'=>$matiere,
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
            $idmatiere=Matiere::where('id',$request['id'])->first(['id']);
            if ((!$idmatiere)){
                return response()->json([
                    'message'=>'Cette matiere n\'existe pas!',
                    'status'=>false,
                ]);
                die();
            }
            // verification de l'adresse Email

           
            if ((Auth::user()->id)!=2) {
                return response()->json([
                    'message'=>'seul la secretaire peut modifier un enseignant',
                    'status'=>false,
                ]);
                die();
            }
                 $idmatiere->update($data);
                 return response()->json([
                'message'=>'classe Update',
                'status'=>true,  
             
            ]);

        }
        catch(\Throwable $th)
        {
            return response()->json(
                ['message'=>$th->getMessage(),
                'status'=>false,
               
                ] );   
        }
    }

}
