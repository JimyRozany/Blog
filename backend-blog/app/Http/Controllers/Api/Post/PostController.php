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
            $newImageName = time() . '.' . $imageName; //change image name
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

   // get one post by id
    public function show(Request $request)
    {
        $post = Post::find($request->input('post_id'));

        if(!$post){
            return $this->responseError('post not found' ,404); 
        }
        return PostResource::make($post); 


    }

    public function update(Request $request)
    {
        $post = Post::find($request->input('post_id'));

        if($post->user_id == Auth::user()->id)
        {
            if($request->input('title'))
            {
                $post -> title = $request -> input('title');
                $post -> save();
            }

            if($request->input('description'))
            {
                $post -> description = $request -> input('description');
                $post -> save();
            }
  
            if($request->input('image'))
            {
                $imageName = $request->file('image')->getClientOriginalExtension(); //real image name
                $newImageName = time() . '.' . $imageName; //change image name
                $request->file('image')->move(public_path('images/post/') ,$newImageName); // store image with new name in "public/images/post"
    
                $post->path_image = 'images/post/' . $newImageName;
                $post->save();
            }

            return $this->responseSuccess('post edit successfully' ,200); 
        }else{
            return $this->responseError('Editing permission is forbidden' ,403); 

        }
        
    }

   
    public function destroy(Request $request)
    {
        $post = Post::find($request->input('post_id'));

        if(!$post){
            return $this->responseError('post not found' ,404); 

        }
        if($post->user_id == Auth::user()->id)
        {
           $post -> delete();
           return $this->responseSuccess('post deleted successfully' ,200); 

        }else{
            return $this->responseError('Editing permission is forbidden' ,403); 

        }
    }
}
