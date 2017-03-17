<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\User;
use App\Cats;
use App\Advertisements as ADV;
use App\Posts;
use App\Pages;
use App\post_click;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    protected $id;
    protected $user;

    public function __construct(){
        $this->middleware('auth');
        $this->id = Auth::user()->id;
        $this->user = User::find($this->id);
    }

    public function index(){

        return view('user/admin/index');
    }

    public function users(){
        $users = User::all();
        return view('user/admin/users', compact('users'));
    }

    public function news(){
        $posts = DB::table('posts')->orderBy('updated_at', 'DESC')->paginate(20);
        return view('user/admin/news', compact('posts'));
    }

    public function adv(){
        $adv = DB::table('advertisements')->paginate(10);
        return view('user/admin/adv', compact('adv'));
    }

    public function cats(){
        $cats = Cats::all();
        $click_cats = post_click::all();
        return view('user/admin/cats', compact('cats','click_cats'));
    }

    public function post($id){
        $post = Posts::find($id);
        return view('user/admin/post', compact('post'));
    }

    public function payment(){
        $user = User::where(['role' => 3])->get();
        return view('user/admin/payment', compact('user'));
    }

    public function info(Request $request){
        $data = $request->all();
        $data['id'] = $this->id;
        User::find($this->id)->update($data);
        return redirect()->back();
    }

    public function update_password(Request $request){
        if(User::find($this->id)->password == $request->password){
            $data = [
                'id' => $this->id, 'password' => bcrypt($request->confirm)
            ];
            User::find($this->id)->update($data);
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function advertisement($id){
        $adv = ADV::find($id);
        return view('user/admin/advertisement', compact('adv'));
    }

    public function pages(){
        $pages = Pages::all();
        return view('user/admin/pages', compact('pages'));
    }

    public function update_page(Request $request){
        $page = Pages::findOrFail($request->id);
        $page->update($request->all());
        return redirect('/admin/pages');
    }

    public function cat_store(Request $request){
        $data = [
            'name' => $request->name, 'position' => $request->position + 1
        ];
        Cats::create($data);
        return redirect('admin/cats');
    }

    # Click cats
    public function click_cat_store(Request $request){
        $price_click = abs((int) $request->price_click);
        $percent = abs((int) $request->percent);
        $title = "Клик ".$price_click." тг. + ".$percent."%";
        post_click::create([
            'title' => $title, 'price_click' => $price_click, 'percent' => $percent
        ]);
        return redirect('admin/cats');
    }
    # По клике показать офферы в розыгрыше
    public function in_draw($id){
        $id = (int) $id;
        $post = Posts::findOrFail($id);
        $post->update([
            'filter' => 1, 'updated_at' => $post->updated_at
        ]);
        return Redirect::back();
    }
    # По клике не показывать офферы в розыгрыше
    public function no_draw($id){
        $id = (int) $id;
        $post = Posts::findOrFail($id);
        $post->update([
            'filter' => 0, 'updated_at' => $post->updated_at
        ]);
        return Redirect::back();
    }
}
