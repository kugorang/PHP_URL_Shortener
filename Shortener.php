<?php
class Shortener
{
  protected $db;

  public function __construct()
  {
    // DB 접속
    $this->db = new mysqli('localhost', 'root', 'rootTest!', 'website');
  }

  protected function generateCode($num)
  {
    $randNum = $this->base62Encode(rand(1,62));

    return strrev($randNum.$this->base62Encode($num + time()));
  }

  public function makeCode($url)
  {
    $url = trim($url);

    if (!filter_var($url, FILTER_VALIDATE_URL))
    {
      return '';
    }

    $url = $this->db->escape_string($url);

    // Check if URL already exists
    $exists = $this->db->query("SELECT code FROM links WHERE url='{$url}'");

    if ($exists->num_rows)
    {
      // return code
      return $exists->fetch_object()->code;
    }
    else
    {
      // Generate code based on inserted ID
      $code = $this->generateCode($this->db->insert_id);

      // Insert recode without a code
      $this->db->query("INSERT INTO links (url, code, created) VALUES ('{$url}', '{$code}', NOW())");

      return $code;
    }

    return $url;
  }

  public function getUrl($code)
  {
    $code = $this->db->escape_string($code);
    $code = $this->db->query("SELECT url FROM links WHERE code = '$code'");

    if($code->num_rows)
    {
      return $code->fetch_object()->url;
    }

    return '';
  }

  function base62Encode($num)
  {
      $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $result = '';

      while ($num >= 62)
      {
          $r = $num % 62;
          $result = $chars[$r].$result;
          $num /= 62;
      }

      return $chars[$num].$result;
  }

  function base62Decode($id)
  {
      $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

      $idLen = strlen($id);

      for ($i = 0; $i < $idLen; $i++)
      {
          $value = strpos($chars, $id[$i]);
          $num = $value * pow(62, $idLen-($i+1));
          $final += $num;
      }

      return $final;
  }
}
 ?>
