<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Etudiant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Notecontoller extends Controller
{
    public function create(Request $request){
        try{
            $data=$request->validate([
                'note'=>'required',
                'matiere'=>'required',
                'etudiant_email'=>'required|email',
            ]);
            $data=$request->all();
            $data['unique_note']= uniqid();
            $data['etudiant_id']=Etudiant::where('email',$request['email'])->first(['id']);
            $data['matiere_id']=Matiere::where('matiere_id',$request['matiere'])->first(['id']);
            $tel=Etudiant::where('telephone',$request['telephone'])->first(['id']);
            $email=Etudiant::where('email',$request['email'])->first(['id']);

            if ((Auth::user()->id!=2)) {
                return response()->json([
                    'message'=>'seul la secretaire a le droit de creer un etudiant',
                    'status'=>false, 
                ]);
                die();
            }

            if (!is_numeric($request['note']))
            {
             return response()->json(
                 ['message'=>'cette note n\'est pas valide',
                 'status'=>false
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
           
            if (!$data['etudiant_email']) {
                return response()->json([
                    'message'=>'cette etudiant n\'existe pas',
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

}
