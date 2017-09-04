<?php
if (isset($_POST['submit']))
{
	if ((!empty($_POST['text'])) && (!empty($_POST['color'])))
	{
		$text=trim($_POST['text']);
		$color=$_POST['color'];
		//echo $color;
		$im=imagecreatefrompng("red-button.png");
		//echo $im;
		$width_image=imagesx($im);
		$height_image=imagesy($im);
		$width_image_margins=$width_image-(2*18);
		$height_image_margins=$height_image-(2*18);
		
		///echo $width_image_margins.'<br/>';
		//echo $height_image_margins.'<br/>';
		$font_size=33;
		putenv('GDFONTPATH=C:\Windows\Fonts');
		$fontname='.\simkai.ttf';
		do
		 {
			 $font_size--;
			 $bbox=imagettfbbox($font_size,0,$fontname,$text);
			 $text_width=$bbox[2]-$bbox[0];
			 $text_height=$bbox[7]-$bbox[1];
			 
			 
		  }
           while(($font_size>8) && ( $text_width>$width_image_margins ||  $text_height>$height_image_margins ));
			
		if ( $text_width>$width_image_margins ||  $text_height>$height_image_margins )
		{
			//echo  $text_width.'<br/>'.$width_image_margins.'<br/>';
			
			echo   $text_height.'<br/>'.$height_image_margins;
			
			
			echo 'the text can not make button!';
			
			}
			else
			{ $tx=$width_image_margins/2-$text_width/2;
			  $ty=$height_image_margins/2- $text_height/2;
			  if ($bbox[0]<0)
			  {$tx+=abs($bbox[0]);
				  }
			  
			  $ty+=abs($bbox[7]);
			  $ty-=2;
			  $white=imagecolorallocate($im,255,255,255);
		imagettftext($im,$font_size,0,$tx,$ty,$white,$fontname,$text);
		 
		header('content-type: image/png');
imagepng($im);
imagedestroy($im);
			}
		
		}
	}
?>