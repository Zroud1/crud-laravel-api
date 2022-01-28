<?php


namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Resources\Post as PostResource;
use App\Http\Resources\Product;
use Illuminate\Support\Facades\Validator ;
use Illuminate\Support\Facades\Auth;

class PostController extends BaseController
{

    public function index()
    {
        $posts=Post::all();
        return $this->sendResponse('get All Posts',PostResource::collection($posts));
    }

    public function getPostByUser($userId){
        $posts=Post::where('user_id',$userId)->get();
        return $this->sendResponse('get Post by user',PostResource::collection($posts));
    }


    public function store(Request $request)
    {
        $input=$request->all();

        $validetor=Validator::make($input,[
            'title'=>'required',
            'description'=>'required',
        ]);

        if($validetor->fails()){
            return $this->sendError('validetor errors',$validetor->errors());
        }
        $post=new Post();
        $post->title = $input['title'];
        $post->description = $input['description'];
        $post->user_id = Auth::id();
        $post->save();
        return $this->sendResponse('post inserted successfully',new PostResource($post));
    }

    public function show($id)
    {

       $post=Post::find($id);
       if($post->user_id!=Auth::id()) {
        return $this->sendError('validetor errors',[]);
     }
       if(is_null($post))
        return $this->sendError('post not found');
       return $this->sendResponse('post show successfully', PostResource::collection($post));

    }


    public function update(Request $request,  $id)
    {
        $input=$request->all();

        $validetor=Validator::make($input,[
            'title'=>'required',
            'description'=>'required',
        ]);

        if($validetor->fails()){
            return $this->sendError('validetor errors',$validetor->errors());
        }
        $post=Post::find($id);
        if($post->user_id!=Auth::id()) {
            return $this->sendError('validetor errors',$validetor->errors());
        }
        $post->title = $input['title'];
        $post->description = $input['description'];
        $post->save();
        return $this->sendResponse('post updated successfully',new PostResource($post));
    }


    public function destroy(Post $post)
    {
        if($post->user_id!=Auth::id()) {
            return $this->sendError('validetor errors',[]);
         }
        $post->delete();
        return $this->sendResponse('post deleted successfully',new PostResource($post));
    }
}
