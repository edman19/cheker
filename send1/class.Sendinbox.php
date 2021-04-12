<?php
class Modules
{
    public function version(){
        return "1.0.5";
    }
	public function stuck($msg){
            echo "[Sendinbox] ".$msg;
            $answer =  rtrim( fgets( STDIN ));
            return $answer;
    }
    public function load($file){
        $file = file_get_contents($file);
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $file = explode("\r\n", $file);
        } else {
            $file = explode("\n", $file);
        }
        $file = array_unique($file);
        return array(
        	'total' => count($file),
        	'list'  => $file, 
        );  
    }
    public function arrayrandom($array){
        return $array[mt_rand(0, count($array) - 1)];
    }
    public function randomf($jenis,$length = 10) {
        switch ($jenis) {
            case 'textrandom':
                $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            break;
            case 'numrandom':
                $characters = '0123456789';
            break;
            case 'textnumrandom':
                $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            break;
            
            default:
                $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            break;
        }
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function check_random($data){
        preg_match_all('/{(.*?)}/', $data, $matches);
        $explode = explode(",", $matches[1][0]);
        if(!empty($explode[0])){
            $random = $this->randomf($explode[0] , $explode[1]);
            return  str_replace($matches[0][0], $random, $data);
        }else{
            return $data;
        }
    }

}