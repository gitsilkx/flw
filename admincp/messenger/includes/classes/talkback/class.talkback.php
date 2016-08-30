<?php
/*
  ListMessenger TalkBack Client 2.1.0
  Copyright © 2007 Silentweb [http://www.silentweb.ca]

  Originally:    HTTPPost v1.0 by Daniel Kushner
  Re-Developed By:  Matt Simpson <msimpson@listmessenger.com>

  For the most recent version, visit the ListMessenger website:
  [http://www.listmessenger.com]

  License Information is found in docs/licence.html
  $Id: class.talkback.php 107 2007-03-25 19:49:18Z matt.simpson $

  Original Copyright Notice:
    HTTPPost ver 1.0.0
    Author:  Daniel Kushner
    Email:  daniel@websapp.com
    Release:  2 Nov 2001 - Copyright 2001
    Domain:  www.websapp.com/classes
*/
class TalkBack {

  var $url;
  var $uri;
  var $version      = "2.1.0";
  var $dataArray      = array();
  var $responseBody    = '';
  var $responseHeaders  = '';
  var $errors      = '';

  function TalkBack($type = "", $dataArray = "", $authInfo = false) {
    switch($type) {
      case "registration" :
        $this->setURL("1.txt");
      break;
      case "trip" :
        $this->setURL("2.txt");
      break;
      case "version" :
      default:
        $this->setURL("3.txt");
      break;
    }

    $this->setDataArray($dataArray);
    $this->authInfo = $authInfo;
  }

  function setUrl($url) {
    if($url != '') {
      $url      = ereg_replace("^http://", "", $url);
      $this->url  = substr($url, 0, strpos($url, "/"));
      $this->uri  = strstr($url, "/");

      return true;
    } else {
      return false;
    }
  }

  function setDataArray($dataArray) {
    if(is_array($dataArray)) {
      $this->dataArray = $dataArray;
      return true;
    } else {
      return false;
    }
  }

  // Can be called as: setAuthInfo(array('user', 'pass')) or setAuthInfo('user', 'pass')
  function setAuthInfo($user, $pass = false) {
    if(is_array($user)) {
      $this->authInfo = $user;
    } else {
      $this->authInfo = array($user, $pass);
    }
  }

  function getResponseHeaders(){
    return $this->responseHeaders;
  }

  function getResponseBody(){
    return $this->responseBody;
  }

  function getErrors(){
    return $this->errors;
  }

  function prepareRequestBody(&$array,$index=''){
    foreach($array as $key => $val) {
      if(is_array($val)) {
        if($index) {
          $body[] = $this->prepareRequestBody($val,$index.'['.$key.']');
        } else {
          $body[] = $this->prepareRequestBody($val,$key);
        }
      } else {
        if($index) {
          $body[] = $index.'['.$key.']='.urlencode($val);
        } else {
          $body[] = $key.'='.urlencode($val);
        }
      }
    }

    return implode('&', $body);
  }

  function post() {
    $this->responseHeaders  = '';
    $this->responseBody    = '';

    $requestBody = $this->prepareRequestBody($this->dataArray);

    if($this->authInfo) {
      $auth = base64_encode("{$this->authInfo[0]}:{$this->authInfo[1]}");
    }

    $contentLength  = strlen($requestBody);
    $request  = "POST ".$this->uri." HTTP/1.1\r\n";
    $request .= "Host: ".$this->url."\r\n";
    $request .= "User-Agent: ListMessenger TalkBack Client ".$this->version."\r\n";
    $request .= "Content-Type: application/x-www-form-urlencoded\r\n";
    $request .= "Content-Length: ".$contentLength."\r\n\r\n";
    $request .= $requestBody."\r\n";

    $socket  = @fsockopen($this->url, 80, $errno, $errstr, 5);
    if(!$socket) {
      $this->error['errno']  = $errno;
      $this->error['errstr']  = $errstr;

      return $this->getResponseBody();
    }

    fputs($socket, $request);

    $isHeader    = true;
    $blockSize  = 0;

    while (!feof($socket)) {
      if($isHeader) {
        $line = fgets($socket, 1024);
        $this->responseHeaders .= $line;

        if(trim($line) == "") {
          $isHeader = false;
        }
      } else {
        if(!$blockSize) {
          $line = fgets($socket, 1024);
          if($blockSizeHex = trim($line)) {
            $blockSize = hexdec($blockSizeHex);
          }
        } else {
          $this->responseBody .= fread($socket,$blockSize);
          $blockSize = 0;
        }
      }
    }
    fclose($socket);
    return $this->getResponseBody();
  }
}
?>