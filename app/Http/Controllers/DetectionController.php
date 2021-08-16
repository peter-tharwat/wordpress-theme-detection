<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DetectionController extends Controller
{

    public $default_image;
    public $style_path;
    public $url;
    public $prefix_path;
    public $theme_path;
    public $protocol;
    public $theme_name;
    public $final_response;

    public function init(){
        $this->default_image= "https://discountseries.com/wp-content/uploads/2017/09/default.jpg";
        $this->style_path   = "/style.css";
        $this->url = $this->remove_last_slash();
        $this->protocol     = parse_url($this->url, PHP_URL_SCHEME);
        $this->prefix_path  = "/wp-content/themes/";
    }
    public function remove_last_slash(){
       return rtrim($this->url,"/");
    }
    public function detect_theme_name(){
        $response = \Http::get($this->url);
        $lists = $this->get_theme_links($response->body());
        $theme_name="";
        if(count($lists)>0){
            $exploded = explode('/', $lists[0]);

            for($i = 0 ; $i < count($exploded) ; $i++){ 
                if(
                    isset($exploded[$i-2]) && $exploded[$i-2] == "wp-content"
                &&  isset($exploded[$i-1]) && $exploded[$i-1] == "themes"
                ){ 
                    $theme_name= $exploded[$i];
                    break;
                }
            } 
        }
        $this->theme_name=$theme_name;
        $this->theme_path=$this->url.$this->prefix_path.$this->theme_name;
    }
    public function detect(Request $request)
    { 

        $request->validate(['url'=>"required|url"]);
        $this->url=$request->url;
        $this->init();
        $this->detect_theme_name(); 
        if($this->theme_name!=null){
            $this->prepare_response([
                'status'=>200,
                'message'=>"رائع، تم إيجاد القالب !",
                'message_type'=>"success",
                'data'=>[
                    'theme_name'=>$this->theme_name,
                    'thumbnail'=>$this->get_thumbnail(),
                    'readme'=>$this->get_readme(),
                    'style_links'=>$this->get_all_links(file_get_contents($this->theme_path.$this->style_path))
                ]
            ]);
        }else{ 
            $this->prepare_response([
                'status'=>404,
                'message'=>"عفواً لم نتمكن من إيجاد القالب",
                'message_type'=>"danger",
            ]);
        }
        return $this->final_response;

    }
    public function get_theme_links($string){
        $pattern = "~(http|ftp)s?://[a-z0-9.-]+\.[a-z]{2,7}(/\S*)?~i";
        $links=[];
        if($num_found = preg_match_all($pattern, $string, $out))
        {
            foreach($out[0] as $link){
                if(str_contains($link,$this->prefix_path))
                    array_push($links, $link);
            }
            return $links;
        }
    }
    public function get_all_links($string){
        $pattern = "~(http|ftp)s?://[a-z0-9.-]+\.[a-z]{2,7}(/\S*)?~i";
        $links=[];
        if($num_found = preg_match_all($pattern, $string, $out))
        { 
                return $out[0];
        }
    }
    public function get_thumbnail(){
        $thumbnail_link=$this->url.$this->prefix_path.$this->theme_name;
        $tries=[
            'screenshot.png',
            'screenshot.jpg',
            'screenshot.jpeg'
        ];
        foreach($tries as $try){
            $response = \Http::get($thumbnail_link."/".$try); 
            if($response->status()==200){
               $thumbnail_link.="/".$try;
               break;
            }
        }
        if($thumbnail_link==$this->url.$this->prefix_path.$this->theme_name)return $this->default_image;
        return $thumbnail_link;
    }
    public function get_readme(){
        $readme_link=$this->url.$this->prefix_path.$this->theme_name;
        $tries=[
            'readme.txt',
            'readme.md',
            'readme.xml',

        ];
        foreach($tries as $try){
            $response = \Http::get($readme_link."/".$try); 
            if($response->status()==200){
               $readme_link.="/".$try;
               break;
            }
        }
        if($readme_link==$this->url.$this->prefix_path.$this->theme_name)return null;
        return $readme_link;
    }
    public function prepare_response($array=[]){
        $this->final_response=$array;
    }
}
