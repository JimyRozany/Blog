<?php

namespace App\Http\Controllers\Api\User;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseTrait;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;


class UserController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // register 
    public function userRegister(Request $request)
    {
        // validation 
        $validate = $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required',
        ]);

        if( $validate ){
            try {
                $user = User::create([
                    'name'=>$request->input('name'),
                    'email'=>$request->input('email'),
                    'password'=>bcrypt($request->input('password')),
                ]);
                return $this->responseSuccess('registration successfully' ,201);
            } catch (\Exception $ex) {
                return $this->responseError($ex->getMessage() ,$ex->getCode());
            }
        }else{
            return $this->responseError('registration error' ,417);
        }

    }
    // login 
    public function userLogin(Request $request)
    {
        try{
            // validation
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',

            ]) ;
            $credentials = $request->only(['email' ,'password']);
            // generate toke
            $token = Auth::guard('user-api')->attempt($credentials);
    
            if(!$token){
                return $this->responseError('user not found',404);
            }
    
            $user = Auth::guard('user-api')->user();
            return $this->responseData('user' ,$user ,$token ,false ,'login successfully' ,200);
                
        }catch(Exception $ex){
            return $this->responseError($ex->getMessage(),200);
        }
        
    }
    // logout 
    public function userLogout(Request $request)
    {
       $token = $request->input('token');
        
       if($token)
       {
        try {
            JWTAuth::setToken($token)->invalidate();
            return $this->responseSuccess('logged out successfully' ,200);
        } catch (TokenInvalidException $ex) {
            return $this->responseError('invalid Token',498);
        }
       }else{
        return $this->responseError('invalid Token',498);
       }
    }
}
