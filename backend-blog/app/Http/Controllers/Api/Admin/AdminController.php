<?php

namespace App\Http\Controllers\Api\Admin;

use Exception;
use App\Models\Admin;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use App\Http\Traits\ResponseTrait;

class AdminController extends Controller
{
    use ResponseTrait;
    
    public function index()
    {
        //
    }

   
    public function store(Request $request)
    {
        //
    }

   
    public function show($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }


    // ---------------------
      // register 
    public function adminRegister(Request $request)
    {
        // validation 
        $validate = $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required',
        ]);

        // return $request-> name;

        if( $validate ){
            try {
                $admin = Admin::create([
                    'name'=>$request->input('name'),
                    'email'=>$request->input('email'),
                    'password'=>bcrypt($request->input('password'))
                ]);
                return $this->responseSuccess('registration successfully' ,201);
            } catch (\Exception $ex) {
                return $this->responseError($ex->getMessage() ,200);
            }
        }else{
            return $this->responseError('registration error' ,417);
        }

    }
     // login 
     public function adminLogin(Request $request)
     {
         
         try{
                // validation
                $request->validate([
                    'email' => 'required|email',
                    'password' => 'required',

                ]) ;
            
             $credentials = $request->only(['email' ,'password']);
             // generate toke
             $token = Auth::guard('admin-api')->attempt($credentials);
     
             if(!$token){
                 return $this->responseError('admin not found',404);
             }
     
             $admin = Auth::guard('admin-api')->user();
             return $this->responseData('admin' ,$admin ,$token ,false ,'login successfully' ,200);
                 
         }catch(Exception $ex){
             return $this->responseError($ex->getMessage(),200);
         }
         
     }
     // logout 
     public function adminLogout(Request $request)
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
