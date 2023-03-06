<?php

namespace App\Http\Controllers\Api\Post;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    use ResponseTrait;
    // get all posts
    public function index()
    {
        $posts = Post::all();
        if( $posts ){
            return PostCollection::make($posts);
        }else{
            return $this->responseError('data not found' ,404);
        }
    }
 
    // create post
    public function store(Request $request)
    {
        // validation
        $validator = Validator::make($request->all() ,[
            'title'         => 'required',
            'description'   => 'required',
            'image'         => 'required|image',
        ]);

    
        if($validator -> fails())
        {
            return $this->responseError($validator ->errors() ,400);
            
        }else{
            $imageName = $request->file('image')->getClientOriginalExtension(); //real image name
            $newImageName = time() . $imageName; //change image name
            $request->file('image')->move(public_path('images/post/') ,$newImageName); // store image with new name in "public/images/post"

            try {
                $post = Post::create([
                    'user_id'     =>Auth::user()->id,
                    'title'       =>$request->input('title'),
                    'description' =>$request->input('description'),
                    'path_image'  =>'images/post/'. $newImageName
                ]);
                return $this->responseSuccess('post created successfully',200);
            } catch (\Throwable $th) {
                return $this->responseError($th->getMessage() ,200);
            }

        }


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
}
