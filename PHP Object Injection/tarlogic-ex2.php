<?php
class File {
  public function flag() {
    $this->innocent();
  }
  public function innocent() {
    echo "Aquí no pasa nada :D\n";
  }
}
class GiveFlag extends File {
  public $offset = 23;
  public function innocent() {
    $stuff = fopen("flag.txt", "r");
    fseek($stuff, $this->offset);
    print fread($stuff, filesize("flag.txt"));
  }
}
class entry {
  public function __destruct(){
    $this->awesome->flag();
  }
}
unserialize($argv[1]);
?>
