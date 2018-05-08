<?php
/**
 * Class SendSMS
 */

class SendSMS extends CComponent
{
    public $url = 'http://www.afe.ir/WebService/V4/BoxService.asmx?wsdl';
    public $username = 'zeinali.itclinic@gmail.com';
    public $password = 'qwerrewq1212';
    public $lineNumber = '30007957956090';

    private $_client;
    private $_invalid_numbers = array();
    private $_numbers = array();
    private $_messages = array();

    private $_result;

    public function __construct($line = false)
    {
        ini_set("soap.wsdl_cache_enabled", "0");
        if ($line)
            $this->lineNumber = $line;
        date_default_timezone_set('Asia/Tehran');
        try {
            @$this->_client = new SoapClient($this->url, array('encoding' => 'UTF-8'));
        } catch (Exception $e) {
            throw new CHttpException(501, $e->getMessage());
        }
    }


    /**
     * @param $number
     * @return $this
     */
    public function AddNumber($number)
    {
        $numberVal = doubleval($number);
        if ($numberVal && $this->ValidateNumber($numberVal))
            $this->_numbers[] = $numberVal;
        else
            $this->_invalid_numbers[] = $number;
        return $this;
    }

    /**
     * @param $numbers
     * @return $this
     * @throws CException
     */
    public function AddNumbers($numbers)
    {
        if ($numbers && is_array($numbers))
            foreach ($numbers as $number)
                $this->AddNumber($number);
        else
            throw new CException('پارامتر تابع AddNumbers باید یک آرایه باشد.');
        return $this;
    }

    /**
     * Validate Mobile Number
     * @param $number
     * @return bool|int
     */
    public function ValidateNumber($number)
    {
        if (array_search($number, $this->_numbers) === false)
            return preg_match('/^[9]+[0-9]{9}+$/', $number);
        return false;
    }

    /**
     * Validates Mobile Numbers array
     * @return $this
     */
    public function ValidateNumbers()
    {
        foreach ($this->_numbers as $number)
            $this->ValidateNumber($number);
        return $this;
    }

    /**
     * @param $message
     * @return $this
     */
    public function AddMessage($message)
    {
        $this->_messages = $message;
        return $this;
    }

    /**
     * Send Sms to receivers
     * @throws CException
     */
    public function SendWithLine()
    {
        if (!$this->lineNumber)
            throw new CException('شماره خط ارسال پیامک مشخص نشده است.');
        if (count($this->_numbers) < 1)
            throw new CException('شماره موبایلی وارد نشده است.');
        if (!$this->_messages || empty($this->_messages))
            throw new CException('متن پیامک وارد نشده است.');

        $params = array(
            'Username' => $this->username,
            'Password' => $this->password,
            'Number' => $this->lineNumber,
            'Mobile' => $this->getNumbers(),
            'Message' => $this->getMessage(),
            'Type' => "1"
        );
        try {
            $this->_result = $this->_client->SendMessage($params);
        } catch (Exception $e) {
            throw new CException('ارسال پیامک با مشکل مواجه است.');
        }

//        if($this->type == 'object')
//            return get_object_vars($result);
//        $merge = $this->method.'Result';
//        if($result->$merge->string != '')
//            return $result->$merge->string;
//        else
//            return $result->$merge;

        return $this->_result;
    }

    public function getNumbers()
    {
        return $this->ValidateNumbers()->_numbers;
    }

    public function getInvalidNumbers()
    {
        return $this->ValidateNumbers()->_invalid_numbers;
    }

    public function getMessage()
    {
        return $this->_messages;
    }

    public function getResult()
    {
        return $this->_result;
    }

    function __destruct()
    {
        unset($this->value, $this->url, $this->method, $this->type);
    }
}