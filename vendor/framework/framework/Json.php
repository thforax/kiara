<?php
/**
 * Minimum framework for Kiara
 *
 * Copyright (c) Thibault Forax
 *
 * Licensed under MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 */
namespace Framework;

class Json
{
    private $success = true;
    private $errorCode;
    private $errorMessage;
    private $data;

    public function __toString()
    {
        return $this->get();
    }

    public function get()
    {
        $returnList = array(
            'success' => $this->success
        );
        if ($this->success === false) {
            $returnList['error'] = array(
                'code' => $this->errorCode,
                'message' => $this->errorMessage
            );
        } else {
            $returnList['data'] = $this->data;
        }
        return json_encode($returnList);
    }

    public function send()
    {
        header('Content-Type: application/json');
        echo $this->get();
    }

    public function setSuccess($success)
    {
        $this->success = $success;
    }

    public function setError($errorCode, $errorMessage)
    {
        $this->errorCode = $errorCode;
        $this->errorMessage = $errorMessage;
    }

    public function setData($data)
    {
        $this->data = $data;
    }
}
