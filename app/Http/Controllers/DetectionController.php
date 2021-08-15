<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DetectionController extends Controller
{
    public function detect(Request $request)
    {


 
        $url="https://freelancestation.net/";
        $response = \Http::get($url);
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

            return [
                'status'=>200,
                'message'=>"رائع، تم إيجاد الثيم",
                'data'=>[
                    'theme_name'=>$theme_name,
                    'thumbnail'=>$this->get_thumbnail($url."/wp-content/themes/".$theme_name),
                    'readme'=>$this->get_readme($url."/wp-content/themes/".$theme_name),
                    'links'=>$this->get_all_links(file_get_contents($url."/wp-content/themes/".$theme_name."/style.css"))
                ]
            ]; 

        }
        return [
            'status'=>404,
            'message'=>"لم يتم العثور على رابط وورد بريس"
        ];

        


    }
    public function get_theme_links($string)
    {

        //$pattern = '~[a-z]+://\S+~';
        $pattern = "~(http|ftp)s?://[a-z0-9.-]+\.[a-z]{2,7}(/\S*)?~i";
        $links=[];
        if($num_found = preg_match_all($pattern, $string, $out))
        {
          //echo "FOUND ".$num_found." LINKS:\n";
            foreach($out[0] as $link){
                if(str_contains($link,"/wp-content/themes/"))
                    array_push($links, $link);
            }
            return $links;
          //print_r($out[0]);
        }
    }
    public function get_all_links($string)
    {
        $pattern = "~(http|ftp)s?://[a-z0-9.-]+\.[a-z]{2,7}(/\S*)?~i";
        $links=[];
        if($num_found = preg_match_all($pattern, $string, $out))
        { 
                return $out[0];
        }
    }
    public function get_thumbnail($url){
        $thumbnail_link=$url;
        $tries=[
            'screenshot.png',
            'screenshot.jpg',
            'screenshot.jpeg'
        ];
        foreach($tries as $try){
            $response = \Http::get($url."/".$try); 
            if($response->status()==200){
               $thumbnail_link.="/".$try;
               break;
            }
        }
        if($thumbnail_link==$url)return null;
        return $thumbnail_link;
    }
    public function get_readme($url)
    {
        $readme_link=$url;
        $tries=[
            'readme.txt',
            'readme.md',
            'readme.xml',

        ];
        foreach($tries as $try){
            $response = \Http::get($url."/".$try); 
            if($response->status()==200){
               $readme_link.="/".$try;
               break;
            }
        }
        if($readme_link==$url)return null;
        return $readme_link;
    }
}
