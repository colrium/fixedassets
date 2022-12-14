<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2016  Collins Riungu
//
// author: Mutugi Riungu

---------------------------------------------------------------------*/

class Qrcode{
	public $bgcolor = array(255,255,255);
    public $fgcolor = array(0,0,0);

    public $cacheable = true;
    public $cachedir = 'application/cache/';
    public $errorlog = 'application/logs/';
    public $quality = true;
    public $size = 1024;

	public function __construct(){
        $this->init();
	}

	public function __get($var){
    	return get_instance()->$var;
  	}


    public function init() {
        
        // use cache - more disk reads but less CPU power, masks and format templates are stored there
        if (!defined('QR_CACHEABLE')){
            define('QR_CACHEABLE', $this->cacheable);
        } 
        
        // used when QR_CACHEABLE === true
        if (!defined('QR_CACHE_DIR')){
            define('QR_CACHE_DIR', $this->cachedir);
        } 
        
        // default error logs dir
        if (!defined('QR_LOG_DIR')){
            define('QR_LOG_DIR', $this->errorlog);
        } 
        
        // if true, estimates best mask (spec. default, but extremally slow; set to false to significant performance boost but (propably) worst quality code
        if ($this->quality) {
            if (!defined('QR_FIND_BEST_MASK')) {
                define('QR_FIND_BEST_MASK', true);
            }
        } else {
            if (!defined('QR_FIND_BEST_MASK')) {
                define('QR_FIND_BEST_MASK', false);
            }
            if (!defined('QR_DEFAULT_MASK')){
               define('QR_DEFAULT_MASK', $this->quality); 
            } 
        }
        
        // if false, checks all masks available, otherwise value tells count of masks need to be checked, mask id are got randomly
        if (!defined('QR_FIND_FROM_RANDOM')){
            define('QR_FIND_FROM_RANDOM', false);
        } 
        
        // maximum allowed png image width (in pixels), tune to make sure GD and PHP can handle such big images
        if (!defined('QR_PNG_MAXIMUM_SIZE')){
           define('QR_PNG_MAXIMUM_SIZE',  $this->size); 
        } 
    }

    public function qrcodehtml(){
        
    }

    public function qrcodepng(){
        
    }

    public function qrcodejpg(){
        
    }


    private function encode($intext) {
        $code = new QRcode();

        if($this->eightbit) {
            $code->encodeString8bit($intext, $this->version, $this->level);
        } 
        else {
            $code->encodeString($intext, $this->version, $this->level, $this->hint, $this->casesensitive);
        }
                    
        $this->markTime('after_encode');
        if ($this->createfile!== false) {
            file_put_contents($outfile, join("\n", QRtools::binarize($code->data)));
        } 
        else {
            return QRtools::binarize($code->data);
        }
    }

    public function test(){
        return $this->bgcolor;
    }
  	






































































        /*
         * PHP QR Code encoder
         *
         * Tool function, handy and debug utilites.
         */

        //----------------------------------------------------------------------
        public static function binarize($frame){
            $len = count($frame);
            foreach ($frame as &$frameLine) {
                
                for($i=0; $i<$len; $i++) {
                    $frameLine[$i] = (ord($frameLine[$i])&1)?'1':'0';
                }
            }
            
            return $frame;
        }
        
        //----------------------------------------------------------------------
        public static function tcpdfBarcodeArray($code, $mode = 'QR,L', $tcPdfVersion = '4.5.037'){
            $barcode_array = array();
            
            if (!is_array($mode))
                $mode = explode(',', $mode);
                
            $eccLevel = 'L';
                
            if (count($mode) > 1) {
                $eccLevel = $mode[1];
            }
                
            $qrTab = QRcode::text($code, false, $eccLevel);
            $size = count($qrTab);
                
            $barcode_array['num_rows'] = $size;
            $barcode_array['num_cols'] = $size;
            $barcode_array['bcode'] = array();
                
            foreach ($qrTab as $line) {
                $arrAdd = array();
                foreach(str_split($line) as $char)
                    $arrAdd[] = ($char=='1')?1:0;
                $barcode_array['bcode'][] = $arrAdd;
            }
                    
            return $barcode_array;
        }
        
        //----------------------------------------------------------------------
        public static function clearCache(){
            self::$frames = array();
        }
        
        //----------------------------------------------------------------------
        public static function buildCache(){
            $this->markTime('before_build_cache');
            
            $mask = new QRmask();
            for ($a=1; $a <= QRSPEC_VERSION_MAX; $a++) {
                $frame = QRspec::newFrame($a);
                if (QR_IMAGE) {
                    $fileName = QR_CACHE_DIR.'frame_'.$a.'.png';
                    QRimage::png(self::binarize($frame), $fileName, 1, 0);
                }
                
                $width = count($frame);
                $bitMask = array_fill(0, $width, array_fill(0, $width, 0));
                for ($maskNo=0; $maskNo<8; $maskNo++)
                    $mask->makeMaskNo($maskNo, $width, $frame, $bitMask, true);
            }
            
           $this->markTime('after_build_cache');
        }

        //----------------------------------------------------------------------
        public static function log($outfile, $err){
            if (QR_LOG_DIR !== false) {
                if ($err != '') {
                    if ($outfile !== false) {
                        file_put_contents(QR_LOG_DIR.basename($outfile).'-errors.txt', date('Y-m-d H:i:s').': '.$err, FILE_APPEND);
                    } else {
                        file_put_contents(QR_LOG_DIR.'errors.txt', date('Y-m-d H:i:s').': '.$err, FILE_APPEND);
                    }
                }    
            }
        }
        
        //----------------------------------------------------------------------
        public static function dumpMask($frame){
            $width = count($frame);
            for($y=0;$y<$width;$y++) {
                for($x=0;$x<$width;$x++) {
                    echo ord($frame[$y][$x]).',';
                }
            }
        }
        
        //----------------------------------------------------------------------
        public static function markTime($markerId){
            list($usec, $sec) = explode(" ", microtime());
            $time = ((float)$usec + (float)$sec);
            
            if (!isset($GLOBALS['qr_time_bench'])){
                $GLOBALS['qr_time_bench'] = array();
            }
            
            $GLOBALS['qr_time_bench'][$markerId] = $time;
        }
        
        //----------------------------------------------------------------------
        public static function timeBenchmark(){
            self::markTime('finish');
        
            $lastTime = 0;
            $startTime = 0;
            $p = 0;
            echo '<table cellpadding="3" cellspacing="1">
                    <thead><tr style="border-bottom:1px solid silver"><td colspan="2" style="text-align:center">BENCHMARK</td></tr></thead>
                    <tbody>';

            foreach($GLOBALS['qr_time_bench'] as $markerId=>$thisTime) {
                if ($p > 0) {
                    echo '<tr><th style="text-align:right">till '.$markerId.': </th><td>'.number_format($thisTime-$lastTime, 6).'s</td></tr>';
                } else {
                    $startTime = $thisTime;
                }
                
                $p++;
                $lastTime = $thisTime;
            }
            
            echo '</tbody><tfoot>
                <tr style="border-top:2px solid black"><th style="text-align:right">TOTAL: </th><td>'.number_format($lastTime-$startTime, 6).'s</td></tr>
            </tfoot>
            </table>';
        }
}