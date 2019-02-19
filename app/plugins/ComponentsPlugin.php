<?php
namespace plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Events\Event;

class ComponentsPlugin extends \Phalcon\Mvc\User\Component
{
     public function csrf($redirect = false)
    {
        if ($this->security->checkToken() == false) {
            /*$this->flash->error('Invalid CSRF Token');
            if ($redirect) {
                $this->response->redirect($redirect);
            }*/
            $this->alert("Invalid CSRF Token", $redirect);
            return false;
        }
    }
    public function alert($message, $redirect = "")
    {
        if (!$message) {
            $message = "메세지를 입력 하세요.";
        }
        if ($redirect) {
            $url = "location.href='" . $_SERVER['CONTEXT_PREFIX'].$redirect . "';";
        }
        $heredoc = <<< HERE
        <script type="text/javascript">
            alert('$message');
            $url
         </script>
HERE;
        echo $heredoc;
        return false;
    }
    public function printr($arr)
    {
        if (is_object($arr)) {
            echo "<xmp>";
            var_dump($arr);
            echo "</xmp>";
        } else {
            if (is_array($arr)) {
                echo "<xmp>";
                print_r($arr);
                echo "</xmp>";
            }
        }
        return false;
    }
    public function dateformate($format = "Y-m-d H:i:s", $str)
    {
        $temp = "";
        if ($str) {
            $temp = date($format, strtotime($str));
        }
        return $temp;
    }
    public function set_thumbnail_images($board_id, $file_name, $width = "140", $height = "140")
    {
        if (!is_dir($this->config->application->storageDir . "/board/".$board_id."/thumbnail/")) {
            mkdir($this->config->application->storageDir . "/board/" . $board_id."/thumbnail/", 0777);
        }
        $image = new \Phalcon\Image\Adapter\Gd( $this->config->application->dataDir . "/board/".$board_id."/".$file_name);
        $image->resize($width, $height);
        $image->save($this->config->application->storageDir . "/board/" . $board_id."/thumbnail/".$file_name);
    }
    public function get_thumbnail_images($board_id = "" , $file_name = "") {
        if (file_exists($this->config->application->storageDir."/board/".$board_id."/thumbnail/".$file_name)) {
            return  "/storage/board/".$board_id."/thumbnail/".$file_name;
        }
    }
    /*
    function resizeImage($source, $dest, $new_width, $new_height, $quality)
    {
        // Taken from http://salman-w.blogspot.com/2009/04/crop-to-fit-image-using-aspphp.html
        $image = new Phalcon\Image\Adapter\GD($source);
        $source_height = $image->getHeight();
        $source_width = $image->getWidth();
        $source_aspect_ratio = $source_width / $source_height;
        $desired_aspect_ratio = $new_width / $new_height;
        if ($source_aspect_ratio > $desired_aspect_ratio) {
            $temp_height = $new_height;
            $temp_width = ( int ) ($new_height * $source_aspect_ratio);
        } else {
            $temp_width = $new_width;
            $temp_height = ( int ) ($new_width / $source_aspect_ratio);
        }
        $x0 = ($temp_width - $new_width) / 2;
        $y0 = ($temp_height - $new_height) / 2;
        $image->resize($temp_width, $temp_height)->crop($new_width, $new_height, $x0, $y0);
        $image->save($dest, $quality);
    }
    */
    public function is_file_check($board_id, $file_name)
    {
        if (file_exists($this->config->application->storageDir."/board/".$board_id."/".$file_name)) {
            return  true;
        } else {
            return false;
        }
    }
}