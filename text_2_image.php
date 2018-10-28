<?php

class TexttoImage {

    public function __construct() {
        
    }

    public function text2image($msg, $PNGfileName) {
        $font = 20;
        $string = $msg;

        $im = @imagecreatetruecolor(strlen($string) * $font / 1.4, ($font + 10));
        imagesavealpha($im, true);
        imagealphablending($im, false);

        $white = imagecolorallocatealpha($im, 255, 255, 255, 127);
        imagefill($im, 0, 0, $white);

        $lime = imagecolorallocate($im, 255, 255, 255); // For white
//        $lime = imagecolorallocate($im, 1, 1, 1); // For black

        $black = imagecolorallocate($im, 255, 255, 255);
        imagecolortransparent($im, $black);
        //OstrichSans
//        $fontFamity = 'overlay_fonts/OstrichSans/OstrichSans-Heavy.otf';
        //BEER
//        $fontFamity = 'overlay_fonts/BEER/BEER.TTF';
        //nue
//        $fontFamity = 'overlay_fonts/nue/Nue_Bold.ttf';
        //coluna
//        $fontFamity = 'overlay_fonts/coluna/Coluna_Rounded.otf';
        //alegre_sans_nc
//        $fontFamity = 'overlay_fonts/alegre_sans_nc/AlegreSansRegular.ttf';
        //BebasNeue
//        $fontFamity = 'overlay_fonts/BebasNeue/BebasNeueRegular.ttf';
        //gobold
        $fontFamity = 'overlay_fonts/gobold/Gobold Bold.otf';
        //times new romans          
        // $fontFamity = 'overlay_fonts/Times_New_Roman_Normal.ttf';
        //Arial          
        // $fontFamity = 'overlay_fonts/arial.ttf';
        imagettftext($im, $font, 0, 0, $font + 8, $lime, $fontFamity, $string);

        
        $PNGimage = imagepng($im, $_SERVER['DOCUMENT_ROOT'] .'/api/upload/generatepng/' . $PNGfileName . '.png');
        imagedestroy($im);
        return $PNGimage;
    }

}

?>