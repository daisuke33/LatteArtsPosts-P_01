<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Latte; //Latte Modelが使えるようになる

class LatteController extends Controller
{
    //
    
    public function add() {
        return view('admin.latte.create');
    }
    
    public function create(Request $request)
    {
      // validationを行う
        $this->validate($request, Latte::$rules); 
        $latte = new latte;
        $form = $request->all();
      
      // フォームから画像が送信されてきたら保存して、$latte->image_path に画像のパスを保存する
        if (isset($form['image'])) {
            $path = $request->file('image')->store('public/image');
            $latte->image_path = basename($path);
        } else {
            $latte->image_path = null;
        }
      // フォームから送信されてきた _token を削除する
            unset($form['_token']);
            // フォームから送信されてきた image を削除する
            unset($form['image']);
            //データベースに保存する
            $latte->fill($form);
            $latte->save();
            // admin/latte/createにリダイレクトする
            return redirect('admin/latte/create');
    }  
    
    public function index(Request $request) 
    {
        // 投稿を表示する
        $cond_title = $request->cond_title;
        if ($cond_title != '') {
            // 検索されたら検索結果を取得する
            $posts = Latte::where('title', $cond_title)->get();
        } else {
            // それ以外は全てを取得する
            $posts = Latte::all();
        }
            return view('admin.latte.index', ['posts' => $posts, 'cond_title' => $cond_title]
        );
    }
    
    public function edit()
    {
         // News Modelからデータを取得する
    //   $latte = Latte::find($request->id);
    //   if (empty($latte)) {
    //     abort(404);    
    //   }
    //   return view('admin.latte.edit', ['latte_form' => $latte]);
    }
    
    public function delete()
    {
        
    }
}