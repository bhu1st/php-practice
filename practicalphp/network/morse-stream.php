<?php
    class StreamMorse {
        public $varname;
        public $fp;
        public $morse;

        private function stream_open ($path, $mode, $options, &$opened_path) {
            // store the filename just in case
            $this->varname = substr($path, 8);
            $this->fp = fopen($this->varname, $mode);
            // our conversion array
            $this->morse = array("a" => "Dit dah ", "b" => "Dah dit dit dit ", "c" => "Dah dit dah dit ", "d" => "Dah dit dit ", "e" => "Dit ", "f" => "Dit dit dah dit ", "g" => "Dah dah dit ", "h" => "Dit dit dit dit ", "i" => "Dit dit ", "j" => "Dit dah dah dah ", "k" => "Dah dit dah ", "l" => "Dit dah dit dit ", "m" => "Dah dah ", "n" => "Dah dit ", "o" => "Dah dah dah ", "p" => "Dit dah dah dit ", "q" => "Dah dah dit dah ", "r" => "Dit dah dit ", "s" => "Dit dit dit ", "t" => "Dah ", "u" => "Dit dit dah ", "v" => "Dit dit dit dah ", "w" => "Dit dah dah ", "x" => "Dah dit dit dah ", "y" => "Dah dit dah dah ", "z" => "Dah dah dit dit ", "0" => "Dah dah dah dah dah ", "1" => "Dit dah dah dah dah ", "2" => "Dit dit dah dah dah ", "3" => "Dit dit dit dah dah ", "4" => "Dit dit dit dit dah ", "5" => "Dit dit dit dit dit ", "6" => "Dah dit dit dit dit ", "7" => "Dah dah dit dit dit ", "8" => "Dah dah dah dit dit ", "9" => "Dah dah dah dah dit ", "." => "Dit dah dit dah dit dah ", "," => "Dah dah dit dit dah dah ", "?" => "Dit dit dah dah dit dit ", "@" => "Dah dit dah dit dah dit ", "\n" => "\n");
            return true;
        }

        private function stream_read($count) {
            // read in the requested amount of text, and convert
            // to lowercase because we only have lowercase Morse
            $in = strtolower(fread($this->fp, $count));
            $inlen = strlen($in);
            $out = "";

            for ($i = 0; $i < $inlen; ++$i) {
                // skip letters we do not have a conversion for
                if (isset($this->morse[ $in{$i} ])) {
                    $out .= $this->morse[ $in{$i} ];
                }
            }

            return $out;
        }

        private function stream_eof() {
            return feof($this->fp);
        }

        private function stream_close() {
            fclose($this->fp);
            return true;
        }
    }

    stream_wrapper_register("morse", "StreamMorse");
    $fp = fopen("morse://sample.txt","r");
    print fread($fp, 1024);
    fclose($fp);
?>