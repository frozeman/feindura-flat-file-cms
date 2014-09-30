<?php
/*
 @author: AlexanderC 2011
 @version: 0.1
 @usage:
   GLOBALS["RECACHE"] == true; // optional. Force document recaching

   // cache directory(with slash at the end), unical key for user or user group, max cache age, cache files extension
   new cache("cache/", "unical key", 1800, "cch" );
*/
class cache
{
    private $timeout;
    private $ext;
    private $ch_buffer;
    private $dir;
    private $filename;
    private $last_mod;
    private $ct;

    // class constructor
    // @access private
    // @params str, str, int, str
    // @return bool or null if POST request
    function __construct($dir = "/", $key = "", $timeout = 1800, $ext = "cch" )
    {
      // check if it's not a post request, and the directory exist
      if ( !is_dir($dir) || $_SERVER['REQUEST_METHOD'] == "POST" )
         return;

      $this->timeout = $timeout;
      $this->ext = $ext;
      $this->dir = $dir;
      $this->key = $key;
      $c = $this->check_cache();
      if ( $c == true )
         $this->show_cache();
      else
      {
         register_shutdown_function( array($this, "make_cache") );
         $this->ct = microtime();
         ob_start();
      }
    }

    // transform microtime to sec (float)
    // @access private
    // @param int
    // @return float
    private function microtime_float( $mt )
    {
      list($usec, $sec) = explode(" ", $mt);
      return ((float)$usec + (float)$sec);
    }

    // get memory usage
    // return str
    function gmu()
    {
      $size = memory_get_usage(true);
      $unit=array('b','kb','mb','gb','tb','pb');
      return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    }
    // cache builder
    // @access public
    // @return void
    // @param content to be cached
    public function build_cache($buffer)
    {
      $tdif = $this->microtime_float( microtime() - $this->ct );
      $tstr = "\n<!-- Cached in ".$tdif." seconds, memory used ".$this->gmu()." -->\n";
      @file_put_contents($this->dir.$this->filename, $buffer.$tstr, LOCK_EX);
    }

    // cache checker
    // @access private
    // @return bool
    private function check_cache()
    {
      // destroy old cache
      $this->destroy_cache();
      $uri = md5($_SERVER["DOCUMENT_ROOT"]."/".$_SERVER["REQUEST_URI"].$this->key);
      $filename = $uri.".".$this->ext;
      $this->filename = $filename;

      // recache if required
      if ( @$GLOBALS["RECACHE"] == true )
        return false;
      if ( !file_exists($this->dir.$filename) )
        return false;
      $last_mod = filectime($this->dir.$filename);
      if ( $last_mod < time()-$this->timeout  )
        return false;
      $this->last_mod = $last_mod;
      $this->ch_buffer = file_get_contents($this->dir.$filename);
      return true;
    }

    // cache viewer
    // @access private
    // @return void
    private function show_cache()
    {
      // BENCHMARK end
      // $timer = explode( ' ', microtime() );
      // $endTime = $timer[1] + $timer[0];
      // $time = round($endTime - $GLOBALS['startTime'],4).'<br>';
      // echo $time;
      exit($this->ch_buffer."<!--
Cached on ".date("d M Y (H:i:s)", $this->last_mod).";
Expires on ".date("d M Y (H:i:s)", $this->last_mod + $this->timeout)."
-->");
    }

    // delete old cache files
    // @access private
    // @return void
    private function destroy_cache()
    {
      // delete cache once a day
      if ( file_exists($this->dir.date("dmY")) )
        return;
      $dh = opendir($this->dir);
      while ( false !==($f = readdir($dh)) )
      {
        if($f != "." && $f != ".." && $f[0] != '.')
           @unlink($this->dir.$f);
      }
      file_put_contents($this->dir.date("dmY"), "This is just a checker");
    }

    // get buffer and write it
    // @access private
    // @return void
    function make_cache()
    {
      $temp = ob_get_contents();
      ob_end_flush();
      $this->build_cache($temp);
    }
}
?>
