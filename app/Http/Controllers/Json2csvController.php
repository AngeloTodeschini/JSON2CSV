<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Json2csvController extends Controller
{
    public function index(){
        return view('index');
    }

    public function converte(Request $request){
        $jsonArray = $request->json;
        $jsonArray = json_decode($jsonArray, true);

        $csv = array();
        $header = array();
        $jsonReplace = array();
        
        if(is_array($jsonArray)){
            foreach($jsonArray as $json){
                $jsonKeys = array_keys($json);

                foreach($jsonKeys as $key){
                    if(!in_array($key, $header)){
                        $header[] = $key;
                    }
                }

                foreach($json as $key => $value){
                    if(is_array($value)){
                        for($i = 1; $i < sizeof($value); $i++){
                            $header[] = $key . $i;
                            $value = $this->change_key($value, $i, $key.$i);           
                        }
                        $json[$key] = $value;
                    }
                }
                $jsonReplace[] = $json;
            }
            
            $csv[] = '"' . implode('","', $header) . '"';

            foreach($jsonReplace as $json){
                $fieldValues = array();

                foreach($header as $index){
                    if(array_key_exists($index, $json)){
                        if(is_array($json[$index])){
                            $indexArray = $json[$index];
                            $fieldValues[] = htmlspecialchars($indexArray[0]);
                        }
                        else{
                            $fieldValues[] = htmlspecialchars($json[$index]);
                            
                        }
                    }
                    else{
                        foreach($json as $key => $value){
                            if(is_array($value) && array_key_exists($index, $value)){
                                $thereIsArray = true;
                                $fieldValues[] = htmlspecialchars($value[$index]);
                                break;
                            }
                            else{
                                $thereIsArray = false;
                            }
                        }
                        if(!$thereIsArray){
                            $fieldValues[] = htmlspecialchars('');
                        }
                    }
                }
                $csv[] = '"' . implode('","', $fieldValues) . '"';
            }
            
            dd($csv);
            
            $finalCSV = implode("\n", $csv);
                
                return view('index', compact('finalCSV'));
            
        }
        else{
            return view('index');
        }
        
    }

    function change_key( $array, $old_key, $new_key ) {

        if( ! array_key_exists( $old_key, $array ) )
            return $array;
    
        $keys = array_keys( $array );
        $keys[ array_search( $old_key, $keys ) ] = $new_key;
    
        return array_combine( $keys, $array );
    }

    function make_header(){
        
    }
    
}
