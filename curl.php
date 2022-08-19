<?php

class curl{

    // class variable that will hold the curl request handler
    private $handler = null;    

    // class variable that will hold the url
    private $url = '';          

    // class variable that will hold the info of our request
    public $info = []; 

    // class variable that will hold the data inputs of our request
    private $data = [];
    
    // class variable that will tell us what type of request method to use (defaults to get)
    private $method = 'get';
    
    // class variable that will hold the response of the request in string
    public $content = '';
    
    // function to set data inputs to send 
    public function url( $url = '' ){
        $this->url = $url;
        return $this;
    }
    
    // function to set data inputs to send 
    public function data( $data = [] ){
        $this->data = $data;
        return $this;
    }
    
    // function to set request method (defaults to get)
    public function method( $method = 'get' ){
        $this->method = $method;
        return $this;
    }

    // function that will send our request
    public function send(){
        try{

            if( $this->handler == null ){
                $this->handler = curl_init( );
            }
            
            switch( strtolower( $this->method ) ){
                case 'get':
                    curl_setopt_array ( $this->handler , [
                        CURLOPT_URL => $this->url,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'GET',
                        CURLOPT_HTTPHEADER => array(
                            'accept: application/json',
                        ),
                    ]);
                break;
                case 'post':
                    curl_setopt_array ( $this->handler , [
                        CURLOPT_URL => $this->url,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_POST => count($this->data),
                        CURLOPT_POSTFIELDS => http_build_query($this->data),
                    ] );
                break;
                case 'put':
                    curl_setopt_array ( $this->handler , [
                        CURLOPT_URL => $this->url,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_CUSTOMREQUEST => 'PUT',
                        CURLOPT_POSTFIELDS => http_build_query($this->data),
                    ] );
                break;
                case 'delete':
                    curl_setopt_array ( $this->handler , [
                        CURLOPT_URL => $this->url,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_CUSTOMREQUEST => 'DELETE',
                        CURLOPT_POSTFIELDS => http_build_query($this->data),
                    ] );
                break;                    
                
                default:
                    curl_setopt_array ( $this->handler , [
                        CURLOPT_URL => $this->url,
                        CURLOPT_RETURNTRANSFER => true,
                    ] );
                break;

            }

            $this->content = curl_exec($this->handler);

            $this->info = curl_getinfo($this->handler);

        }catch( Exception $e ){
            die( $e->getMessage() );
        }
    
    }       

    // function that will close the connection of the curl handler
    public function close(){
    
       curl_close ( $this->handler );
       $this->handler = null;
       
    }
    
}