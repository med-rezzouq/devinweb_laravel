<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */



    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nom' => ['required', 'min:5'],
            'prenom' => ['required', 'min:5'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'nom.min' => 'LE :attribute doit contient 5 caracteres au minimum ',
            'prenom.min' => 'LE :attribute doit contient 8 caracteres au minimum',
            'confirmed' => 'Les deux mot de passe ne sont pas identiques ',

        ]);
    }

    public function showRegistrationForm()
    {
        return view('frontoffice.register');
    }

    public function create(Request $request)
    {


        $verification = false;

        $users = User::all();
        if (count($users) > 4) {
            return response()->json(array(
                'success' => false,
                'errors' => ["error1" => array("On a atteind le maximum de 5 inscriptions")]

            ), 400);
        } else {
            // dd($request->all());
            $membre =  $request->all();
            $validation =  $this->validator($request->all());
            $verification = $validation == true ? $validation : $validation;

            if ($validation->fails()) {
                return response()->json(array(
                    'success' => false,
                    'errors' => $validation->getMessageBag()->toArray()

                ), 400); // 400 being the HTTP code for an invalid request.
            }



            $member = User::create([
                'nom' => mb_strtolower($membre['nom'], 'utf8'),
                'prenom' => mb_strtolower($membre['prenom'], 'utf8'),
                'email' => $membre['email'],
                'password' => Hash::make($membre['password']),

            ]);



            return response()->json(['message' => 'Inscription avec succés</a> '], 200);
        }
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
}
