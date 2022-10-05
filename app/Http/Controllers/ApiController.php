<?php

namespace App\Http\Controllers;

use App\Models\Link;
use AshAllenDesign\ShortURL\Facades\ShortURL;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getlink(){
        $input = file_get_contents('php://input');

        if($input){
            $body = json_decode($input,true);
            if(isset($body['link']) and !empty($body['link'])){
                try{
                    $short_link = ShortURL::destinationUrl($body['link'])->make();
                    Link::create(['short_link'=>$short_link->url_key,'long_link'=>$body['link']]);
                    $result = env('APP_URL') . '/' . $short_link->url_key;
                    $res['result'] = true;
                    $res['shortLink'] = $result;
                } catch (QueryException $qe){
                    $res['result'] = false;
                    $res['error'] = 'Помилка додавання у базу';
                }

                print_r(json_encode($res));

            }
        }
    }
}
