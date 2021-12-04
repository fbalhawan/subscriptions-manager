<?php

namespace Output;

/**
 * Response
 */
class Response
{
    public static $SUCCESS = ["code"=>200,"title"=>"Success"],
                  $UNAUTHORIZED = ["code"=>403, "title"=>"Unauthorized"],
                  $ERROR = ["code"=>400, "title"=>"Error"];


    private
        $code,
        $status,
        $data;

    /**
     * __construct
     *
     * @param  int $code
     * @param  string $status
     * @param  array $data
     * @return void
     */
    public function __construct($code=400,$status="error",$data=array())
    {
        $this->code = $code;
        $this->status = $status;
        $this->data = $data;
    }
    
    /**
     * setCode
     *
     * @param  int $code
     * @return void
     */
    public function setCode($code){
        $this->code = $code;
    }
        
    /**
     * setStatus
     *
     * @param  string $status
     * @return void
     */
    public function setStatus($status){
        $this->status = $status;
    }
    
    /**
     * setData
     *
     * @param  array $data
     * @return void
     */
    public function setData($data){
        $this->data = $data;
    }
    
    /**
     * setResponse
     *
     * @param  int $code
     * @param  string $status
     * @param  array $data
     * @return void
     */
    public function setResponse($code, $status, $data){
        $this->code = $code;
        $this->status = $status;
        $this->data = $data;
    }
    
    /**
     * getJsonResponse
     *
     * @return Response
     */
    public function getJsonResponse(){
            header('Content-type: application/json');
            return json_encode([
                "code" => $this->code,
                "status" => $this->status,
                "data" => $this->data
            ]);
        
    }
    
}
