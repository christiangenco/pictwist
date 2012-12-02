<?php

function black($r, $g, $b)
{
   if( ($r>=0 && $r<63) && ($g>=0 && $g<63) && ($b>=0 && $b<127) )
   {return true;}
   else
   {return false;}
}
function brown($r, $g, $b)
{
   if( ($r>=63 && $r<190) && ($g>=0 && $g<63) && ($b>=0 && $b<63) )
   {return true;}
   else
   {return false;}
}
function gray($r, $g, $b)
{
   if( ($r>=63 && $r<190) && ($g>=63 && $g<190) && ($b>=63 && $b<190) )
   {return true;}
   else
   {return false;}
}
function white($r, $g, $b)
{
   if( ($r>=190 && $r<=255) && ($g>=190 && $g<=255) && ($b>=190 && $b<=255) )
   {return true;}
   else
   {return false;}
}
function red($r, $g, $b)
{
   if( ($r>=63 && $r<190) && ($g>=0 && $g<63) && ($b>=0 && $b<127) )
   {return true;}
   else
   {return false;}
}
function orange($r, $g, $b)
{
   if( ($r>=190 && $r<=255) && ($g>=63 && $g<190) && ($b>=0 && $b<190) )
   {return true;}
   else
   {return false;}
}
function yellow($r, $g, $b)
{
   if( ($r>=190 && $r<=255) && ($g>=190 && $g<=255) && ($b>=0 && $b<190) )
   {return true;}
   else
   {return false;}
}
function green($r, $g, $b)
{
   if( ($r>=0 && $r<190) && ($g>=63 && $g<=255) && ($b>=0 && $b<190) )
   {return true;}
   else
   {return false;}
}
function blue($r, $g, $b)
{
   if( ($r>=0 && $r<190) && ($g>=0 && $g<190) && ($b>=127 && $b<=255) )
   {return true;}
   else
   {return false;}
}
function purple($r, $g, $b)
{
   if( ($r>=63 && $r<190) && ($g>=0 && $g<63) && ($b>=63 && $b<190) )
   {return true;}
   else
   {return false;}
}
function magenta($r, $g, $b)
{
   if( ($r>=190 && $r<=255) && ($g>=0 && $g<190) && ($b>=127 && $b<=255) )
   {return true;}
   else
   {return false;}
}
function cyan($r, $g, $b)
{
   if( ($r>=0 && $r<190) && ($g>=63 && $g<=255) && ($b>=63 && $b<=255) )
   {return true;}
   else
   {return false;}
}

function roundColor($r, $g, $b)
{
   if(black($r, $g, $b))
   {
      return "black";//sprintf('%02X%02X%02X', 0x00, 0x00, 0x00);  
   }
   else if(gray($r, $g, $b))
   {
      return "gray";//sprintf('%02X%02X%02X', 0x77, 0x77, 0x77);
   }
   else if(white($r, $g, $b))
   {
      return "white";//sprintf('%02X%02X%02X', 0xff, 0xff, 0xff);
   }
   else if(brown($r, $g, $b))
   {
      return "brown";//sprintf('%02X%02X%02X', 0xaa, 0x33, 0x33);
   }
   else if(red($r, $g, $b))
   {
      return "red";//sprintf('%02X%02X%02X', 0xff, 0x00, 0x00);
   }
   else if(orange($r, $g, $b))
   {
      return "orange";//sprintf('%02X%02X%02X', 0xff, 0xaa, 0x00);
   }
   else if(yellow($r, $g, $b))
   {
      return "yellow";//sprintf('%02X%02X%02X', 0xff, 0xff, 0x00);
   }
   else if(green($r, $g, $b))
   {
      return "green";//sprintf('%02X%02X%02X', 0x00, 0xff, 0x00);      
   }
   else if(blue($r, $g, $b))
   {
      return "blue";//sprintf('%02X%02X%02X', 0x00, 0x00, 0xff);
   }
   else if(purple($r, $g, $b))
   {
      return "purple";//sprintf('%02X%02X%02X', 0xaa, 0x00, 0xaa);
   }
   else if(magenta($r, $g, $b))
   {
      return "magenta";//sprintf('%02X%02X%02X', 0xff, 0x00, 0xff);
   }
   else if(cyan($r, $g, $b))
   {
      return "cyan";//sprintf('%02X%02X%02X', 0x00, 0xff, 0xff);
   }
   /*
   else
   {
      return sprintf('%02X%02X%02X', $r, $g, $b);
   }
   */
}

function colorPalette($imageFile, $numColors, $granularity = 5) 
{ 
   $granularity = max(1, abs((int)$granularity)); 
   $colors = array(); 
   $size = @getimagesize($imageFile); 
   if($size === false) 
   { 
      user_error("Unable to get image size data"); 
      return false; 
   } 

   //$fhandle = finfo_open(FILEINFO_MIME);
   $mime_type = $size['mime'];//finfo_file($fhandle,$imageFile);
   //echo "type: " . $mime_type . "<br/>";
   if($mime_type == "image/jpeg")
   {
      $img = @imagecreatefromjpeg($imageFile); 
      //echo "<br/>jpeg<br/>";
   }
   else if($mime_type == "image/png")
   {
      $img = @imagecreatefrompng($imageFile);
      echo "<br/>png<br/>";
   }
   else if($mime_type == "image/gif")
   {
      $img = @imagecreatefromgif($imageFile);
      echo "<br/>gif<br/>";
   }

   if(!$img) 
   { 
      user_error("Unable to open image file"); 
      return false; 
   } 
   for($x = 0; $x < $size[0]; $x += $granularity) 
   { 
      for($y = 0; $y < $size[1]; $y += $granularity) 
      { 
         $thisColor = imagecolorat($img, $x, $y); 
         $rgb = imagecolorsforindex($img, $thisColor); 
         $red = round(round(($rgb['red'] / 0x33)) * 0x33); 
         $green = round(round(($rgb['green'] / 0x33)) * 0x33); 
         $blue = round(round(($rgb['blue'] / 0x33)) * 0x33); 
         $thisRGB = sprintf('%02X%02X%02X', $red, $green, $blue); 
         if(array_key_exists($thisRGB, $colors)) 
         { 
            $colors[$thisRGB]++; 
         } 
         else 
         { 
            $colors[$thisRGB] = 1; 
         } 
      } 
   } 
   arsort($colors); 
   return array_slice(array_keys($colors), 0, $numColors); 
} 

function display($file)
{
// sample usage: 

$exif = exif_read_data($file);
$model = $exif['Model'];
$iso = $exif['ISOSpeedRatings'];
$taken = $exif['DateTime'];
$palette = colorPalette($file, 10, 10); 
echo "model: " . $model . " iso: " . $iso . " taken: " . $taken . "<br/>";
echo "<table>\n"; 
foreach($palette as $color) 
{ 
   echo "<tr><td style='background-color:#$color;width:2em;'>&nbsp;</td><td>#$color</td>\n"; 
   $red = $color[0].$color[1];
   $green = $color[2].$color[3];
   $blue = $color[4].$color[5];
   $rgb = str_split($color, 2);
   $r = hexdec('0x'.$rgb[0]);
   $g = hexdec('0x'.$rgb[1]);
   $b = hexdec('0x'.$rgb[2]);
   
   $rounded = roundColor($r, $g, $b);
   $r_rgb = str_split($rounded, 2);
   $rr = hexdec('0x'.$r_rgb[0]);
   $rg = hexdec('0x'.$r_rgb[1]);
   $rb = hexdec('0x'.$r_rgb[2]);
   echo "<td style='background-color:#$rounded;width:2em;'>&nbsp;</td><td>#$rounded</td>";
   echo "<td>red: " . $r . " green: " . $g . " blue: " . $b . "<td/>";
   echo "<td>red: " . $rr . " green: " . $rg . " blue: " . $rb . "<td/>";

} 
   echo "</table>\n";
	echo "<img src=".$file." height=\"150\" width=\"150\" alt=\"getimagesize() example\" />";
}

function getPhotoInfo($file)
{
   list($mime, $width, $height) = getimagesize($file);

   if($mime == "image/jpeg")
   {
      $exif = exif_read_data($file);
      $model = $exif['Model'];
      $iso = $exif['ISOSpeedRatings'];
      $taken = $exif['DateTime'];
   }

   $info = array(
            "camera_model" => $model,
            "date_taken" => $taken,
            "width" => $width,
            "height" => $height
        );
   return $info;
}

function getPhotoColors($file)
{
   $palette = colorPalette($file, 10, 10); 
   $colors = array();
   foreach($palette as $color) 
   { 
      $rgb = str_split($color, 2);
      $r = hexdec('0x'.$rgb[0]);
      $g = hexdec('0x'.$rgb[1]);
      $b = hexdec('0x'.$rgb[2]);
      $colors[] = roundColor($r, $g, $b);
   }
   return $colors;
} 

?>