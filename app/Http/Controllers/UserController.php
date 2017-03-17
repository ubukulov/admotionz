<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Relation;
use App\Posts;
use App\Cats;
use App\Advertising_costs as  ADVcost;
use App\post_click;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $id;

    public function __construct()
    {
        $this->middleware('auth');
        $this->id = Auth::user()->id;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Request::cookie('refs')){
            $user_id = get_user_id_by_login(Request::cookie('refs'));
            $ref_id = $this->id;
            if(check_refs($user_id,$ref_id) AND ($user_id != $ref_id)){
                Relation::create([
                    'user_id' => $user_id,
                    'ref_id'  => $ref_id
                ]);
            }
        }
        return view('user/executor/index');
    }
    # Выход из личного кабинета
    public function logout(){
        Auth::logout();
        unset($_SESSION);
        return Redirect::route('/');
    }
    # Рефералы
    public function refs(){
        // Получить данные о платежи распространителей моих новостей
        $profit = DB::table('advertising_costs')
                        ->whereIn('id_post', function($query){
                            $query->select(DB::raw('id'))
                                ->from('posts')
                                ->where(['id_user' => $this->id]);
                        })
                        ->where('id_user', '!=', $this->id)
                        ->get();
        // 
        $data = DB::table('advertising_costs')
                        ->select(DB::raw('sum(paid) as paid'))
                        ->whereIn('id_post', function($query){
                            $query->select(DB::raw('id'))
                                ->from('posts')
                                ->where(['id_user' => $this->id]);
                        })
                        ->where('id_user', '!=', $this->id)
                        ->get();
        $profit_refs = ($data[0]->paid) / 2;
        return view('user/executor/refs', compact('profit', 'profit_refs'));
    }
    # Профиль
    public function profile(){
        return view('user/executor/profile');
    }
    # Новости испольнителя
    public function news(){
        $news = DB::table('posts')->where('id_user', $this->id)->orderBy('updated_at', 'DESC')->paginate(20);
        return view('user/executor/news', compact('news'));
    }
    # Форма добавление новости
    public function create_news(){
        $cat = Cats::orderBy('position')->get();
        return view('user/executor/add_news',compact('cat'));
    }
    # Процесс добавление новости в базу данных
    public function store_news(\Illuminate\Http\Request $request){
        $data = $request->all();
        $extension = [
            'image/jpeg', 'image/jpg', 'image/png', 'image/gif'
        ];
//        $validator = Validator::make($data, Posts::$rules);
//        if($validator->fails()) {
//            return redirect('user/news/create')->withErrors($validator)->withInput();
//        }

        if($request->hasFile('img')){
            $img = $request->file('img');
            $mime = $img->getClientMimeType();
            $size = $img->getSize();
            $ext = $img->getClientOriginalExtension();
            if(($size > 1000000) || !(in_array($mime,$extension))){
                return redirect('user/news/create');
            }
            $filename = "news_".date("YmdHis").".$ext";
            $destination = "uploads/news/";
            $img->move($destination,$filename);
            $path = "/".$destination.$filename;
            $data['img'] = $path;
            $data['id_user'] = $this->id;
            Posts::create($data);
            return redirect('user/news');
        }
    }
    # Форма редактирование новости
    public function edit_news($id){
        $id = (int) $id;
        $post = Posts::find($id);
        $cat = Cats::all();
        $post_click = post_click::all();
        return view('user/executor/edit_news',compact('post','cat','post_click'));
    }
    # Процесс изменение и сохранение новости
    public function update_news(\Illuminate\Http\Request $request){
        $id = $request->input('id');
        $data = $request->all();
        $extension = [
            'image/jpeg', 'image/jpg', 'image/png', 'image/gif'
        ];
        $post = Posts::findOrFail($id);
        if($request->hasFile('img')){
            $img = $request->file('img');
            $mime = $img->getClientMimeType();
            $size = $img->getSize();
            $ext = $img->getClientOriginalExtension();
            if(($size > 1000000) || !(in_array($mime,$extension))){
                return redirect('user/news/edit/'.$id);
            }
            $filename = "news_".date("YmdHis").".$ext";
            $destination = "uploads/news/";
            $img->move($destination,$filename);
            $path = "/".$destination.$filename;
            $data['img'] = $path;
            $data['id_user'] = $this->id;
        }
        $post->update($data);
        return redirect('user/news');
    }
    # Обновление личных данных
    public function update(\Illuminate\Http\Request $request){
        $data = $request->all();
        $user = User::findOrFail($this->id);
        $user->update($data);
        return redirect('user/profile');
    }

    public function destroy_news($id){
        $id = (int) $id;
        Posts::destroy($id);
        return redirect('/user/news');
    }

    public function profit(){
        // Доходы от своих новостей
        $profit1 = DB::table('advertising_costs')
                            ->select(DB::raw('sum(paid) as paid'))
                            ->whereIn('id_post', function($query){
                                $query->select(DB::raw('id'))
                                    ->from('posts')
                                    ->where(['id_user' => $this->id]);
                            })
                            ->where('id_user', '=', $this->id)
                            ->get();
        // Доходы от распространение других новостей
        $profit2 = DB::table('advertising_costs')
                            ->select(DB::raw('sum(paid) as paid'))
                            ->whereNotIn('id_post', function($query){
                                $query->select(DB::raw('id'))
                                    ->from('posts')
                                    ->where(['id_user' => $this->id]);
                            })
                            ->where('id_user', '=', $this->id)
                            ->get();
        $profit = $profit1[0]->paid + ($profit2[0]->paid)/2;
        $data = DB::table('advertising_costs')
                            ->select(DB::raw('id_post,id_user,sum(paid) as paid, created_at'))
                            ->where(['id_user' => $this->id])
                            ->groupBy('id_post')
                            ->get();
        return view('user/executor/profit', compact('data', 'profit'));
    }
}
