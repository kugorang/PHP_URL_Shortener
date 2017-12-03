<?php
class Shortener
{
  private $db;

  public function __construct()
  {
    // DB에 접속한다.
    $this->db = new mysqli('localhost', 'root', 'rootTest!', 'website');

    // DB의 주소가 localhost가 아닐 때에는
    // 접속이 잘 됬는지에 대한 예외처리도 필요하다.
  }

  // code를 생성하는 함수이다.
  private function generateCode($num)
  {
    // 현재 시간(타임스탬프값)에 인자로 받은 숫자를 뺀 후
    // randNum을 pos에 넣고 문자열을 뒤집은 후 반환한다.
    return strrev(substr_replace($this->base62Encode(time() - $num), $randNum, $pos, 0));
  }

  // code를 반환하는 함수이다.
  public function makeCode($url)
  {
    // url에 포함된 공백을 제거한다.
    $url = trim($url);

    // 만약
    if (!filter_var($url, FILTER_VALIDATE_URL))
    {
      return '';
    }

    // SQL 인젝션을 방지하기 위해 사용한다.
    $url = $this->db->real_escape_string($url);

    // url이 이미 DB에 등록이 되어 있는지 확인한다.
    $exists = $this->db->query("SELECT `code` FROM `links` WHERE `url`='{$url}'");

    // url이 존재한다면
    if ($exists->num_rows)
    {
      // DB에 등록되어 있는 코드를 반환한다.
      return $exists->fetch_object()->code;
    }
    else
    {
      // DB에 등록되어 있지 않다면 url을 DB에 넣어준 후
      $this->db->query("INSERT INTO `links` (url, created) VALUES ('{$url}', NOW())");

      // insert_id를 이용하여 code를 만들고 update을 해준다.
      $code = $this->generateCode($this->db->insert_id);
      $this->db->query("UPDATE `links` SET `code` = '{$code}' WHERE `url` = '{$url}'");

      return $code;
    }

    return $url;
  }

  // url을 얻는 함수이다.
  public function getUrl($code)
  {
    // SQL 인젝션 방지를 위해 사용한다.
    $code = $this->db->real_escape_string($code);

    // DB에 code가 있는지 확인한다.
    $code = $this->db->query("SELECT `url` FROM `links` WHERE `code` = '{$code}'");

    // 만약 code가 있다면
    if ($code->num_rows)
    {
      // code의 url 값을 반환한다.
      return $code->fetch_object()->url;
    }

    // 없다면 빈 값을 반환한다.
    return '';
  }

  // 어떤 숫자 값을 Base62으로 인코딩하는 함수이다.
  private function base62Encode($num)
  {
      // 0~9, a~z, A~Z의 문자열을 준비한다.
      $chars = 'utDGMAQSlnEmsJbyPTZaiz8OwxgovLVUjCIRNch0k146dWBe7Xq3Y2fFH95rpK';
      $result = '';

      // 숫자가 62보다 크다면
      do
      {
          // 62로 나눈 나머지 값을 구하고
          $r = $num % 62;
          // chars 배열의 위치로 가 result 뒤에 붙인다.
          $result = $chars[$r].$result;
          // 그 후 62를 나눈다.
          $num /= 62;
      } while(($num >= 62));

      return $result;
  }

  // // Base62으로 암호한 값을 복호화 하는 함수이다.
  // // 현재에는 사용할 일이 없으나 추후를 위해 주석으로 처리하였다.
  // private function base62Decode($id)
  // {
  //     // Encode 함수와 같은 문자열을 준비한다.
  //     $chars = 'utDGMAQSlnEmsJbyPTZaiz8OwxgovLVUjCIRNch0k146dWBe7Xq3Y2fFH95rpK';
  //
  //     // id의 길이를 구하여
  //     $idLen = strlen($id);
  //
  //     // 복호화를 진행한다.
  //     for ($i = 0; $i < $idLen; $i++)
  //     {
  //         $value = strpos($chars, $id[$i]);
  //         $num = $value * pow(62, $idLen-($i+1));
  //         $final += $num;
  //     }
  //
  //     // 복호화가 완료된 값을 반환한다.
  //     return $final;
  // }
}
 ?>
