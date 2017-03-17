<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Cats;
use App\Advertisements as ADV;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Posts;
use App\Advertising_costs as ADVcosts;
use App\Adv_cat;

class AdvertiserController extends Controller
{
    protected $id;

    public function __construct()
    {
        $this->middleware('auth');
        $this->id = Auth::user()->id;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user/advertiser/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cats = Cats::orderBy('position')->get();
        return view('user/advertiser/create',compact('cats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $extension = [
            'image/jpeg', 'image/jpg', 'image/png', 'image/gif'
        ];
        $data = [
            'title' => $request->input('title'),
            'video' => $request->input('video'),
            'url' => $request->input('url'),
            'publish' => $request->input('publish'),
            'id_advertiser' => Auth::user()->id
        ];
        if($request->hasFile('img')){
            $img = $request->file('img');
            $mime = $img->getClientMimeType();
            $size = $img->getSize();
            $ext = $img->getClientOriginalExtension();
            if(($size > 1000000) || !(in_array($mime,$extension))){
                return redirect('advertiser/create');
            }
            $filename = "rek_".date("YmdHis").".$ext";
            $destination = "uploads/reklamodatel/";
            $img->move($destination,$filename);
            $path = "/".$destination.$filename;
            $data['img'] = $path;
        }

        $validator = Validator::make($data, ADV::$rules);
        if($validator->fails()) {
            return redirect('advertiser/create')->withErrors($validator)->withInput();
        }
        $cat = $request->input('id_cat');
        $id = ADV::create($data)->id;
        for($i=0; $i<count($cat); $i++){
            Adv_cat::create([
                'id_adv' => $id, 'id_cat' => $cat[$i]
            ]);
        }
        return redirect('advertiser/adv');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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

    public function spending(){
        $adv = DB::table('advertising_costs')
                    ->whereIn('id_adv', function($query){
                        $query->select(DB::raw('id'))
                              ->from('advertisements')
                              ->whereRaw('id_advertiser = ' . $this->id);
                    })
                    ->get();
        $data = array();
        $sum = '';
        for($i=0; $i<count($adv); $i++){
            $data[$i]['id_adv'] = $adv[$i]->id_adv;
            $data[$i]['adv_title'] = ADV::find($adv[$i]->id_adv)['title'];
            $data[$i]['post_title'] = Posts::find($adv[$i]->id_post)['title'];
            $data[$i]['view'] = Posts::find($adv[$i]->id_post)['view_count'];
            $data[$i]['paid'] = $adv[$i]->paid;
            $data[$i]['host_name'] = $adv[$i]->host_name;
            $data[$i]['country'] = $adv[$i]->country;
            $sum = $sum + $adv[$i]->paid;
        }
        return view('user/advertiser/spending', compact('data', 'sum'));
    }

    public function contact(Request $request){
        $data = $request->all();
        $user = User::findOrFail($this->id);
        $user->update($data);
        return Redirect::back();
    }

    public function change_password(Request $request){
        $data = $request->all();
        $user = User::findOrFail($this->id);
        $user->update($data);
        return Redirect::back();
    }
}
