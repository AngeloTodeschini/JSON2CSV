<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Json2csvController extends Controller
{
    public function index(){
        return view('index');
    }

    public function converte(Request $request){
        
        $json = $request->json;
        $json = json_decode($json, true);
        if(is_array($json)){
            $jsonKeys = array_keys($json);
            
            $csv = array();
            $header = array();
            
            foreach($jsonKeys as $key){
                $header[] = $key;
            }
            
            $fieldValues = array();
            foreach ($json as $key => $value){
                if(is_array($value)){
                    for($i = 1; $i < sizeof($value); $i++){
                        $header[] = $key . $i;
                    }
                    foreach($value as $content){
                        $fieldValues[] = htmlspecialchars($content);
                    }
                }
                else{
                    $fieldValues[] = htmlspecialchars($value);
                }
            }
            $csv[] = '"' . implode('","', $header) . '"';
            $csv[] = '"' . implode('","', $fieldValues) . '"';
            
            $finalCSV = implode("\n", $csv);
            
            return view('index', compact('finalCSV'));
        }
        else{
            return view('index');
        }
        
    }
    
}
