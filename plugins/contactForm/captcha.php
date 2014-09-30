<?php
  # Captcha Von Rene Schmidt (rene@reneschmidt.de)
  
  class captchaDigit {
  
    var $bits = array(1,2,4,8,16,32,64,128,256,512,1024,2048,4096,8192,16384);
    var $matrix  = array();
    var $bitmasks = array(31599, 18740, 29607, 31143, 18921, 31183, 31695, 18855, 31727, 31215);
  
    function captchaDigit( $dig ) {
      $this->matrix[] = array(0, 0, 0); // 2^0, 2^1, 2^2 ... usw.
      $this->matrix[] = array(0, 0, 0);
      $this->matrix[] = array(0, 0, 0);
      $this->matrix[] = array(0, 0, 0);
      $this->matrix[] = array(0, 0, 0); // ..., ..., 2^14
  
      ((int)$dig >= 0 && (int)$dig <= 9) && $this->setMatrix( $this->bitmasks[(int)$dig] );
    }
  
    function setMatrix( $bitmask ) {
      $bitsset = array();
  
      for ($i=0; $i<count($this->bits); ++$i)
        (($bitmask & $this->bits[$i]) != 0) && $bitsset[] = $this->bits[$i];
  
      foreach($this->matrix AS $row=>$col)
        foreach($col AS $cellnr => $bit)
          in_array( pow(2,($row*3+$cellnr)), $bitsset) && $this->matrix[$row][$cellnr] = 1;
    }
  }
  
  class captcha {
  
    var $num = 0;
    var $digits = array();
  
    function captcha
    ( $num ) {
      $this->num = (int)$num;
  
      $r = "{$this->num}";
      for( $i=0; $i<strlen($r); $i++ )
        $this->digits[] = new captchaDigit((int)$r[$i]);
    }
  
    function getNum() { return $this->num; }
  
    function printNumber() {
      $return = '';
      
      for($row=0; $row<count($this->digits[0]->matrix); $row++) {
        foreach( $this->digits as $digit ) {
          foreach($digit->matrix[$row] as $cell)
            $return .= ($cell === 1) ? '<span class="captcha_letters">&nbsp;</span>' : '<span class="captcha_background">&nbsp;</span>';
          $return .= '<span class="captcha_background">&nbsp;</span>';
        }
        $return .= "<br>\n";
      }
      
      return $return;
    }
  }
?>
