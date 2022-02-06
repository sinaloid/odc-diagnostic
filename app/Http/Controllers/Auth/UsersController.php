<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function register(Request $request)
    {
        
        $data = $request->validate([
            'nom' => 'required|max:255',
            'prenom' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string'
        ]);

        $data['password'] = bcrypt($request->password);

        $user = User::create($data);

        $token = $user->createToken('API Token')->accessToken;

        return response([ 'user' => $user, 'token' => $token]);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if (!auth()->attempt($data)) {
            return response()->json([
                'error_message' => 'Informations incorrects, veuilliez réessayer'
            ], 401);
        }

        $token = auth()->user()->createToken('API Token')->accessToken;

        return response()->json([
            'user is connected' => auth()->user(),
            'token_type' => 'Bearer', 
            'token' => $token
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|max:255',
            'prenom' => 'required|max:255',
            'role_id' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string'
        ]);
        
        $tmpUser = auth()->user();
        if(isset($tmpUser)){
            $userRole = $tmpUser->role()->first();
            if(isset($userRole) && $userRole->role === "admin"){
                $data["id_creator"] = $tmpUser->id;

                $data['password'] = bcrypt($request->password);

                $user = User::create($data);

                $token = $user->createToken('API Token')->accessToken;

                return response([ 'user' => $user, 'token' => $token]);
            }
            
        };

        return "Vous n'avez pas le droit de creer un utilisateur";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $tmpUser = auth()->user();
        if(isset($tmpUser)){
            $userRole = $tmpUser->role()->first();
            if(isset($userRole) && $userRole->role === "admin"){
                
                $user->delete();

                return $user;
            }
            
        };

        return "Vous n'avez pas le droit de voir un utilisateur";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'nom' => 'required|max:255',
            'prenom' => 'required|max:255',
            'role_id' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string'
        ]);
        
        $tmpUser = auth()->user();
        if(isset($tmpUser)){
            $userRole = $tmpUser->role()->first();
            if(isset($userRole) && $userRole->role === "admin"){
                $data["id_creator"] = $tmpUser->id;

                $data['password'] = bcrypt($request->password);

                $user->nom = data['nom'];
                $user->prenom = data['prenom'];
                $user->role_id = data['role_id'];
                $user->id_creator = $tmpUser->id;
                $user->email = data['email'];
                $user->password = bcrypt($data['password']);
                $token = $user->createToken('API Token')->accessToken;
                $user->update();
                return response([ 'user update' => $user, 'token' => $token]);
            }
            
        };

        return "Vous n'avez pas le droit de creer un utilisateur";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {   
        $tmpUser = auth()->user();
        if(isset($tmpUser)){
            $userRole = $tmpUser->role()->first();
            if(isset($userRole) && $userRole->role === "admin"){
                
                $user->delete();

                return "L'utilisateur a bien ete supprimer";
            }
            
        };

        return "Vous n'avez pas le droit de supprimer un utilisateur";
    }
}
