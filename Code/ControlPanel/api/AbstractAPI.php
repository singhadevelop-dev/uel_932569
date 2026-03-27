<?php
class AbstractAPI 
{
    private $jsonInputRequest = null;
    public $userId = "admin";
    public function CheckPermissionToken()
    {
        try 
        {
            $userId = "";
            return true;
        } catch (Throwable $th) 
        {
            return false;
        }
    }

    public function GetParam($key)
    {
        if(isset($_GET[$key]))
        {
            return $_GET[$key];
        }
        if(isset($_POST[$key]))
        {
            return $_POST[$key];
        }
        $this->GetJsonInput();
        global $jsonInputRequest;
        if(!empty($jsonInputRequest[$key]))
        {
            return $jsonInputRequest[$key];
        }
        return  '';
    }

    public function GetJsonInput()
    {
        global $jsonInputRequest;
        if($jsonInputRequest == null)
        {
            $jsonInputRequest = json_decode(file_get_contents('php://input'), true);
            if($jsonInputRequest == null)
            {
                parse_str(file_get_contents("php://input"),$jsonInputRequest);
                if($jsonInputRequest == null)
                {
                    $jsonInputRequest = array();
                }
            }
        }
       return $jsonInputRequest;
    }
     
    public function OK($message,$result)
    {
        $this->PrivateResponse("OK",200,$message,$result);
    }
    
    public function BadRequest($message,$result)
    {
        $this->PrivateResponse("BadRequest",200,$message,$result);
    }

    private function PrivateResponse($status,$status_number,$message,$result)
    {
        header_remove();
        header("Content-Type: application/json; charset=UTF-8");
        http_response_code($status_number);
        $dt = new DateTime("now", new DateTimeZone("Asia/Bangkok"));
        $post_data = array(
            'status' => $status,
            'message' => $message,
            'result' => $result,
            'result_time' => $dt->format(DATE_ISO8601));
        echo json_encode($post_data,JSON_UNESCAPED_UNICODE);
    }

    public function GetCurrentServerStringDateTime()
    {
        $date = new DateTime("now", new DateTimeZone("Asia/Bangkok"));
       return $date->format('YmdHis');
    }
}

?>