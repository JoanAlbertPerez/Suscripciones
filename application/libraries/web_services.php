<?php if (! defined('BASEPATH')) exit('No direct script access allowe');

/**
 *
 */
class Web_services {

  public function WSRequest($url, $xml)
  {
      $username= 'jperez';
      $password= 'GNd44TRj';

      $ch=curl_init($url);
      curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
      curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $output = curl_exec($ch);
      curl_close($ch);

      return $output;
  }
}
