<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller

    {
        public function create(Request $request){
            try{
                $data=$request->validate([
                    'email'=>'required|email|unique:users',
                    'role'=>'required|integer',
                    'telephone'=>'required|unique:users',
                    'password'=>'required',
                    'name'=>'required'
                ]);
                
                $data=$request->all();
                $data['email']=$request['email'];
                $data['unique_user']= uniqid();
                $data['password']=Hash::make($request->password);
                // if ((Auth::user()->id!=1)) {
                //     return response()->json([
                //         'message'=>'vous n\'etes pas un asministrateur vous ne pouvez pas creer un utilisateur',
                //         'status'=>false, 
                //     ]);
                //     die();
                // }
                if (($request['role']==1)||($request['role'])>2){
                    return response()->json([
                        'message'=>'vous n\'avez pas le droit de creer un etilisateur qui a votre role ou un role autre que celui de la secretaire',
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

                
                $user=User::create($data);
                return response()->json([
                    'message'=>'User create',
                    'user_id'=>$user->id,
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
                $users = User::all(['email','name','telephone','role']);//Récupération de toutes la catégories.
                    $data['id']=Auth::user()->id;
                    return response()->json([
                        'message'=>'Affichages des utilisateurs',
                        'users'=>$users,
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
               $user=User::where('email',$request['email'])->first(['name','email','telephone']);
                if (!$user){
                    return response()->json([
                        'message'=>'Cette utilisateur n\'existe pas!',
                        'status'=>false,
                        
                    ]);
                    die();
                }
               return response()->json([
                'message'=>'Affichages des details',
                'name'=>$user,
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
                $user=User::find($email);
                $id=User::where('email',$request['email'])->first(['id']);
                if ((!$id)){
                    return response()->json([
                        'message'=>'Cette utilisateur n\'existe pas!',
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
               
                if (($request['role']==1)||($request['role'])>2){
                    return response()->json([
                        'message'=>'vous n\'avez pas le droit de creer un etilisateur qui a votre role ou un role autre que celui de la secretaire',
                        'status'=>false, 
                    
                    ]);
                    die();
                }
                if ((Auth::user()->id)==1) {
                     $id->update($data);
                     return response()->json([
                    'message'=>'User Update',
                    'status'=>true,  
                    'user'=>$id->email
                ]);
                }

                else{
                    return response()->json([
                        'message'=>'seul l\'administrateur peut modifier une secretaire',
                        'status'=>false,  
                        ]);
                }
              
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
    
        public function login(Request $request)
        {
            try {
                $data=$request->validate([
                    'email'=>'required|email',
                    'password'=>'required'  
                ]);
                $credentials=$request->only('email','password');
                if(Auth::attempt($credentials))
                {
                    $user=User::where('email',$request['email'])->first(['id','name','email','telephone','role']);
                    $token=$user->createToken('Auth_token')->plainTextToken;
                    return response()->json(
                        [   'user'=>$user,
                            'token'=>$token,
                            'message'=>'Authentifacation reussi',
                            'status'=>true
                        ]);
                }
                else
                {
                    return response()->json(
                        ['message'=>'vos identifiants ne correspondent pas!',
                        'status'=>false
                        ] );
                }
               
            } catch (\Throwable $th) {
                return response()->json(
                    ['message'=>$th->getMessage(),
                    'status'=>false
                    ]);
            }
        }
}
