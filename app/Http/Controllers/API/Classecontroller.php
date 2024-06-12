<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Classe;
use App\Models\User;

class Classecontroller extends Controller
{
    public function create(Request $request){
        try{
            $data=$request->validate([
                'nameclasse'=>'required'
            ]);
            $data=$request->all();
            $data['unique_classe']= uniqid();
            // $class=Classe::find($request('nameclasse'));
            $class=Classe::where('nameclasse',$request['nameclasse'])->first(['id']);
            if ((Auth::user()->id!=2)) {
                return response()->json([
                    'message'=>'seul la secretaire a le droit de creer une classe',
                    'status'=>false, 
                ]);
                die();
            }

            if ($class) {
                return response()->json([
                    'message'=>'cette classe existe deja',
                    'status'=>false, 
                ]);
                die();
            }
            $classe=Classe::create($data);
            return response()->json([
                'message'=>'classe create',
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
            $classe = Classe::all(['nameclasse']);//Récupération de toutes la catégories.
                return response()->json([
                    'message'=>'Affichages des classes',
                    'users'=>$classe,
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
           $classe=Classe::where('nameclasse',$request['nameclasse'])->first(['nameclasse','id']);
            if (!$classe){
                return response()->json([
                    'message'=>'Cette classe n\'existe pas!',
                    'status'=>false,
                    
                ]);
                die();
            }
           return response()->json([
            'message'=>'Affichages des details',
            'name'=>$classe,
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
            $idclasse=Classe::where('id',$request['id'])->first(['id']);
            if ((!$idclasse)){
                return response()->json([
                    'message'=>'Cette classe n\'existe pas!',
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
                 $idclasse->update($data);
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
