<?php
 function _h_openclose($TZ, $gmt=0) {
  foreach($TZ as $key=>$value) {
      $TZ[$key]->h_open = ($TZ[$key]->open + $gmt) % 24;
      $TZ[$key]->h_open = $TZ[$key]->h_open<0 ? $TZ[$key]->h_open + 24 : $TZ[$key]->h_open;
      $TZ[$key]->h_open = (($TZ[$key]->h_open<10) ? "0": "").$TZ[$key]->h_open.":00";

      $TZ[$key]->h_close = ($TZ[$key]->close + $gmt) % 24;
      $TZ[$key]->h_close = $TZ[$key]->h_close<0 ? $TZ[$key]->h_close + 24 : $TZ[$key]->h_close;
      $TZ[$key]->h_close = (($TZ[$key]->h_close<10) ? "0": "").$TZ[$key]->h_close.":00";
      }
  }


 function _TZ($gmt=0) {
  return 'GMT '.($gmt > 0 ? "+" : "").$gmt;
}

 function _baseGMT() {
  return 
      ( ($_SESSION['BaseGMT']!=$_SESSION['GMT'])
          ? "<small class='colorGreen'>Shown as GMT ".(($_SESSION['GMT']>=0) ? "+" : "")."{$_SESSION['GMT']}</small>"
          : "<small>Base GMT ".(($_SESSION['BaseGMT']>=0) ? "+" : "")."{$_SESSION['BaseGMT']}</small>");
  }

 function _gmt_options() {
  for ($i=-14; $i<=14; $i++) {
      $title = "GMT ".($i<0 ? "" : "+").$i;
      $res[] = "\t\t\t\t<option value='$i'>{$title}</option>\n";
      }
  return implode('', $res);
  }

 function _timeframe_options() {

  $data = [
    'MN'  => '43800',
    'W1'  => '10080',
    'D1'  => '1440',
    'H4'  => '240',
    'H1'  => '60',
    'M30' => '30',
    'M15' => '15',
    'M5'  => '5',
    'M1'  => '1',
  ];

  foreach($data as $key => $value) {
    $res[] = "\t\t\t\t<option value='$value'>{$key}</option>\n";
  }
  return implode('', $res);
}
function resizer($input_image_name, $new_x, $new_y, $crop=false) {
    if (!filesize($input_image_name)) return;
    if (!is_array(@$image_info = getimagesize($input_image_name)))  return;
    @$exif_info = exif_read_data($input_image_name);

    $image_type   = $image_info[2];
    $input_x  = $image_info[0];
    $input_y  = $image_info[1];

    switch($image_type) {
        case IMAGETYPE_JPEG : {
                $img = imagecreatefromjpeg($input_image_name);
                break;
            }

        case IMAGETYPE_GIF : {
                $img = imagecreatefromgif($input_image_name);
                break;
            }

        case IMAGETYPE_PNG : {
                $img = imagecreatefrompng($input_image_name);
                break;
            }
        }

    if(!empty($exif_info['Orientation'])) {
        switch($exif_info['Orientation']) {
            case 8: {
                $img = imagerotate($img,90,0);
                $tmp = $input_x;
                        $input_x = $input_y;
                $input_y = $tmp;
                break;
                }
            case 3: {
                $img = imagerotate($img,180,0);
                break;
                }
            case 6: {
                $img = imagerotate($img,-90,0);
                $tmp = $input_x;
                        $input_x = $input_y;
                $input_y = $tmp;
                break;
                }
                    } 
        }

    imageAlphaBlending($img, false);
    imageSaveAlpha ($img, true);

    // соотношение сторон входного изображения
    $ratio    = $input_x / $input_y;    

    // соотношение сторон выходного изображения (рамки)
    $new_ratio  = $new_x / $new_y;        

    // абсолютное соотношение сторон между входным и выходным изображением (рамок)
    $abs_ratio  = ($ratio > $new_ratio)*1;  
    
    if ($crop) {
        // вырезание изображение делается по другим законам
        // сначала нужно преобразовать изображение так, чтобы новые размеры лежали внутри изображения

        if ($abs_ratio) {
            // вписываем рамки в горизотальное изображение 
            $width_y = $new_y;
            $width_x = round ($new_y * $ratio);

            // установим верхнюю левую точку для crop
            $x = round ( ($width_x - $new_x) / 2 );
            $y = 0;
            } else  {
                // вписываем рамки в вертикальное изображение
                $width_x = $new_x;
                $width_y = round ($new_x / $ratio);

                // установим верхнюю левую точку для crop
                $x = 0;
                $y = round ( ($width_y - $new_y) / 2 );
                }

        // меняем размеры изображения так, чтобы получилось, что рамки crop попадают внутрь изображения
        $img_res = imagecreatetruecolor($width_x, $width_y);
        imageAlphaBlending($img_res, false);
        imageSaveAlpha ($img_res, true);

        imagecopyresampled($img_res, $img, 0, 0, 0, 0, $width_x, $width_y, $input_x, $input_y);

        // вырезаем crop из изображения
        $img_out = imagecreatetruecolor($new_x, $new_y);
        imageAlphaBlending($img_out, false);
        imageSaveAlpha ($img_out, true);

        imagecopy($img_out, $img_res, 0, 0, $x, $y, $new_x, $new_y);

        // удаляем промежуточное изображение
        imagedestroy($img_res);
        // конец кода для crop
        } else  {
            // вписываем картинку в заданную рамку, увеличивая или уменьшая оригинал
            if ($abs_ratio) {
                // вписываем горизотальное изображение в вертикальные рамки
                $width_x = $new_x;
                $width_y = round ($width_x / $ratio);
                } else  {
                    // вписываем горизотальное изображение в горизонтальные рамки
                    $width_y = $new_y;
                    $width_x = round ($width_y * $ratio);
                    }

            // производим ресемплирование выходного изображения
            $img_out = imagecreatetruecolor($width_x, $width_y);
            imageAlphaBlending($img_out, false);
            imageSaveAlpha ($img_out, true);

            imagecopyresampled($img_out, $img, 0, 0, 0, 0, $width_x, $width_y, $input_x, $input_y);
            }

    return $img_out;
    }
?>