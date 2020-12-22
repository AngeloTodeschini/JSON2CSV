<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Json2csvController extends Controller
{
    public function index(){
        return view('index');
    }

    //Função que fará toda a conversão de JSON para CSV.
    public function converte(Request $request){
        $jsonArray = $request->json;
        $jsonArray = json_decode($jsonArray, true);

        $header = array();
        $csv = array();
        $jsonReplace = array();
        
        if(is_array($jsonArray)){
            //Verifica se existem múltiplos JSONs
            if(array_keys($jsonArray) == range(0, count($jsonArray) - 1)){
                foreach($jsonArray as $json){
                    $result = $this->make_header($json, $header);
                    $header = $result[0];
                    $jsonReplace[] = $result[1];
                }
                
                $csv[] = '"' . implode('","', $header) . '"';
                
                foreach($jsonReplace as $json){
                    $result = $this->make_values($json, $header);
                    $csv[] = '"' . implode('","', $result) . '"';
                }
            }
            else{
                $result = $this->make_header($jsonArray, $header);
                $header = $result[0];
                $jsonReplace = $result[1];

                $csv[] = '"' . implode('","', $header) . '"';

                $result = $this->make_values($jsonReplace, $header);
                $csv[] = '"' . implode('","', $result) . '"';
            }
            
            $finalCSV = implode("\n", $csv);
            return view('index', compact('finalCSV'));
            
        }
        else{
            return view('index');
        }
        
    }

    //Função para alterar as chaves do array de um dos campos do JSON caso exista.
    function change_key( $array, $old_key, $new_key ) {

        if( ! array_key_exists( $old_key, $array ) )
            return $array;
    
        $keys = array_keys( $array );
        $keys[ array_search( $old_key, $keys ) ] = $new_key;
    
        return array_combine( $keys, $array );
    }

    //Função para Criar o Cabeçalho do CSV.
    function make_header($json, $header){
        $jsonKeys = array_keys($json);

        foreach($jsonKeys as $key){
            if(!in_array($key, $header)){
                $header[] = $key;
            }
        }

        foreach($json as $key => $value){
            if(is_array($value)){
                for($i = 1; $i < count($value); $i++){
                    $header[] = $key . $i;
                    $value = $this->change_key($value, $i, $key.$i);           
                }
                $json[$key] = $value;
            }
        }

        return array($header, $json);
    }

    //Função para criar o corpo do CSV.
    function make_values($json, $header){
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
        return $fieldValues;
    }
}
