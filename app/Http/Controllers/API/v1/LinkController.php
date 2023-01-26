<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Link;
use AshAllenDesign\ShortURL\Exceptions\ShortURLException;
use AshAllenDesign\ShortURL\Facades\ShortURL;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LinkController extends BaseController
{
    public function store(Request $request){
        $input = $request->input();
        $validator = Validator::make($request->all(),[
            'destination' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors(),[],400);
        }

        try{
            $shortURL = ShortURL::destinationUrl($input['destination'])->redirectStatusCode(302)->make()->default_short_url;
            return $this->sendResponse($shortURL,'ShortURL successfully created.');
        } catch (ShortURLException $e){
            return $this->sendError($e->getMessage(),[],400);
        }
    }
    public function getlink(){
        $input = file_get_contents('php://input');

        if($input){
            $body = json_decode($input,true);
            if(isset($body['link']) and !empty($body['link'])){
                try{
                    $links = Link::select()->where('long_link','=',$body['link'])->get();
                    if(count($links)){
                        $res['result'] = true;
                        $result = env('APP_URL') . '/' . $links[0]->short_link;
                        $res['shortLink'] = $result;
                    }else{
                        $short_link = ShortURL::destinationUrl($body['link'])->make();
                        Link::create(['short_link'=>$short_link->url_key,'long_link'=>$body['link']]);
                        $result = env('APP_URL') . '/' . $short_link->url_key;
                        $res['result'] = true;
                        $res['shortLink'] = $result;
                    }
                } catch (QueryException $qe){
                    $res['result'] = false;
                    $res['error'] = 'Помилка додавання у базу';
                }

                print_r(json_encode($res));

            }
        }
    }

    public function test(){

    }
}
