<?php

namespace App\Http\Controllers\Api\Post;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseTrait;
use App\Http\Controllers\Controller;

class LikeController extends Controller
{
    use ResponseTrait ;
   
    // like or dislike control
    public function like(Request $request)
    {
        
        $post = Post::find($request->input('post_id'));
        if(!$post)
        {
            return $this->responseError('post not found' ,404);
        }
        $likes = $post->likes()->where('user_id' ,auth()->user()->id)->get();
        foreach($likes as $like){
            if($like->like == 1)
            {
               $likeobj = Like::find($like->id);
               $likeobj->like = 0;
               $likeobj->save();
               return $this->responseSuccess('dislike successe' ,200);
            }else{
                $likeobj = Like::find($like->id);
                $likeobj->like = 1;
                $likeobj->save();
               return $this->responseSuccess('like successe' ,200);
            }
        }
    }

}
