<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenerateRequest;
use App\Models\Link;
use AshAllenDesign\ShortURL\Facades\ShortURL;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Config;


class LinkController extends Controller
{
    public function index(){
        return view('welcome');
    }

    public function generate(GenerateRequest $request){
        $input = $request->validated();

        $link = $input['link'];

        $id = Link::latest()->first()->id + 1;

        $short_link = ShortURL::destinationUrl($link)->make();



        Link::create(['short_link'=>$short_link->url_key,'long_link'=>$link]);

        $result = env('APP_URL') . '/' . $short_link->url_key;

        return redirect()->back()->with('success',$result);
    }

    public function redirect($shortUrl){
        try{
            $link = Link::select()->where('short_link','=',$shortUrl)->get();
            return redirect($link[0]->long_link);
        }catch (\ErrorException $e){
            return 'Помилка переадресації';
        }
    }
}
