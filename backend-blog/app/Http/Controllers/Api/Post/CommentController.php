<?php

namespace App\Http\Controllers\Api\Post;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CommentCollection;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    use ResponseTrait;

    // get all cmments on one post
    public function index(Request $request)
    {
        $post = Post::find($request -> input('post_id'));
        if(!$post)
        {
            return $this->responseError('post not found' ,404);
        }
        return CommentCollection::make($post->comments);
    }

//    create comment 
    public function store(Request $request)
    {
        $post = Post::find($request->input('post_id'));
        if(!$post)
        {
            return $this->responseError('post not found',404);
        }
        // validation 
        $validator = Validator::make($request->all() ,[
            'post_id' => 'required',
            'comment' => 'required'
        ]);
        if($validator -> fails())
        {
            return $this->responseError($validator ->errors() ,400);
        }

        $comment = Comment::create([
            'user_id' => Auth::user()->id,
            'post_id' => $request -> input('post_id'),
            'comment' => $request -> input('comment'),
        ]);

        return $this->responseSuccess('comment created successfully',200);
        
    }
//    update comment 
    public function update(Request $request)
    {
        // comment id 
        $comment = Comment::find($request->input('comment_id'));
        if(! $comment)
        {
            return $this->responseError('comment not found',404);
        }

        if(auth::user()->id == $comment->user_id)
        {
            $validator = Validator::make($request->all(),[
                'comment' => 'required'
            ]);
            if($validator->fails())
            {
                return $this->responseError($validator ->errors() ,400);
            }
    
            $comment->update([
                'comment' => $request->input('comment'),
            ]);
    
            return $this->responseSuccess('comment updated successfully',200);
        }else{
            return $this->responseError('Editing permission is forbidden' ,403); 
        }

    }


    // delete comment 
    public function destroy(Request $request)
    {
        $comment = Comment::find($request->input('comment_id'));
        if(! $comment)
        {
            return $this->responseError('comment not found',404);
        }

        if(auth::user()->id == $comment->user_id)
        {
            $comment->delete();
            return $this->responseSuccess('comment deleted successfully',200);
        }else{
            return $this->responseError('Editing permission is forbidden' ,403); 
        }
    }
}
