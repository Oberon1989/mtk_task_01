<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{

    public function getUsers(Request $request)
    {
        $part_name = $request->query('part_name');


        $response = Http::get('https://jsonplaceholder.typicode.com/users');


        if ($response->successful()) {

            $users = $response->json();


            $filteredNames = array_filter($users, function ($user) use ($part_name) {
                return stripos($user['username'], $part_name) !== false;
            });


            $names = array_map(function ($user) {
                return $user['username'];
            }, $filteredNames);

            $existingNames = User::pluck('username')->toArray();

            return view('users', ['names' => $names, 'existingNames' => $existingNames]);
        }


        return view('users', ['names' => [], 'existingNames' => []]);
    }

    public function saveUser(Request $request)
    {

        $username = $request->input('username');


        $user = User::firstOrCreate(['username' => $username]);


        if ($user->wasRecentlyCreated) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function deleteUser($id){

        $user = User::find($id);

        if ($user) {

            $user->delete();

            return response()->json(['success' => true, 'message' => 'User deleted']);
        } else {

            return response()->json(['success' => false, 'message' => 'User not found']);
        }
    }

    public function allUsers()
    {

        $users = User::all(['id', 'username']);


        $response = [
            'users' => $users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->username
                ];
            })
        ];


        return response()->json($response);
    }

    public function saveUserApi(Request $request){
        $validated = $request->validate([
            'username' => 'required|string|max:255',
        ]);
        $username = $validated['username'];

        $user = User::firstOrCreate(['username' => $username]);


        if ($user->wasRecentlyCreated) {
            return response()->json(['success' => true,'message'=>'User created']);
        } else {
            return response()->json(['success' => false,'message'=>'user is exists']);
        }

    }
}
