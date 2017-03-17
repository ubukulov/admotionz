<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Posts;

class ModeratorController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('user/moderator/index');
    }

    public function news(){
        $posts = DB::table('posts')->orderBy('updated_at', 'DESC')->paginate(10);
        return view('user/moderator/news', compact('posts'));
    }

    public function post($id){
        $post = Posts::find($id);
        return view('user/moderator/post', compact('post'));
    }
}
