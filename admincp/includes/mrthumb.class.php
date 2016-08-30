<?php
	/***************************************
	* Mr. Thumb 
	* Version 1.0 ( Build 1 )
	* By Jordan Thompson (WASasquatch)
	****************************************/
	
	 class MrThumb {
	 
		// This is your array of supported image formats. 
		// Exclude types you don't want rendered.
		var $valid_ext = array( 'png', 'jpg', 'jpeg', 'gif', 'bmp', 'wbmp' );
	 
		// Whether or not that script should continue
		var $halt = false;
		
		// Image Configuration array and Source Image
		var $image = array();
		var $s_image;
		
		// Mr. Thumb Version
		var $name = 'Mr. Thumb';
		var $version = '1.0';
		var $build = 1;
		var $developer = 'Jordan Thompson';
		var $contact = 'jordanslost at gmail';
		public function about () {
		
			echo $this->name.' Version '.$this->version.' build '.$this->build;
			echo '<br />By '.$this->developer.' ('.$this->contact.')';
		}
		
		public function render ( $source ) {
		
			$this->s_image = $source;
			list( $this->image['width'], $this->image['height'] ) = getimagesize( $source );
			$this->image['extension'] = strtolower( preg_replace( '/^.*\.([^.]+)$/D', '$1', $this->s_image ) );
			if ( ! ( in_array( $this->image['extension'], $this->valid_ext ) ) ) {
				echo 'Invalid format!';	
				$this->halt = true;	
			}
			switch ( $this->image['extension'] ) {
				case 'png';
					$this->image['render'] = imagecreatefrompng( $this->s_image );
					imagealphablending( $this->image['render'], false );
					imagesavealpha( $this->image['render'], true );
				break;
				case 'jpg';
					$this->image['render'] = imagecreatefromjpeg( $this->s_image );
				break;
				case 'jpeg';
					$this->image['render'] = imagecreatefromjpeg( $this->s_image );
				break;
				case 'gif';
					$this->image['render'] = imagecreatefromgif( $this->s_image );
				break;
				case 'bmp';
					$this->image['render'] = imagecreatefromwbmp( $this->s_image );
				break;
				case 'wbmp';
					$this->image['render'] = imagecreatefromwbmp( $this->s_image );
				break;
			}
		
		}
		
		public function contrain ( $width, $height ) {
		
			if ( ! ( $this->halt ) ) {
				if ( $this->image['extension'] == 'gif' ) {
					$this->image['composite'] = imagecreatetruecolor( $width, $height );
					imagecopyresample( $this->image['composite'], $this->image['render'], 0, 0, 0, 0, $width, $height, $this->image['width'], $this->image['height'] );
					$this->image['colorcount'] = imagecolorstotal( $this->image['render'] );
					imagetruecolortopalette( $this->image['composite'], true, $this->image['colorcount'] );
					imagepalettecopy( $this->image['composite'], $this->image['render'] );
					$this->image['transparentcolor'] = imagecolortransparent( $this->image['render'] );
					imagefill( $this->image['composite'], 0, 0, $this->image['transparentcolor'] );
					imagecolortransparent( $this->image['composite'], $this->image['transparentcolor'] );
				} else {
					$this->image['composite'] = imagecreatetruecolor( $width, $height );
					imagecopyresample( $this->image['composite'], $this->image['render'], 0, 0, 0, 0, $width, $height, $this->image['width'], $this->image['height'] );
				}
			} else {
				echo 'Execution halted!';
			}
		
		}
		
		public function proportion ( $max_width, $max_height ) {
		
			if ( ! ( $this->halt ) ) {
				if ( $this->image['extension'] == 'gif' ) {
					$this->image['ratio'] = ( $this->image['width'] > $this->image['height'] ) ? $max_width / $this->image['width'] : $max_height/$this->image['height']; 
					if( $this->image['width'] > $max_width || $this->image['height'] > $max_height ) { 
						$new_width = $this->image['width'] * $this->image['ratio']; 
						$new_height = $this->image['height'] * $this->image['ratio']; 
					} else {
						$new_width = $this->image['width']; 
						$new_height = $this->image['height'];
					} 
					$this->image['composite'] = imagecreatetruecolor( $new_width, $new_height );
					imagecopyresampled( $this->image['composite'], $this->image['render'], 0, 0, 0, 0, $new_width, $new_height, $this->image['width'], $this->image['height'] );
					$this->image['colorcount'] = imagecolorstotal( $this->image['render'] );
					imagetruecolortopalette( $this->image['composite'], true, $this->image['colorcount'] );
					imagepalettecopy( $this->image['composite'], $this->image['render'] );
					$this->image['transparentcolor'] = imagecolortransparent( $this->image['render'] );
					imagefill( $this->image['composite'], 0, 0, $this->image['transparentcolor'] );
					imagecolortransparent( $this->image['composite'], $this->image['transparentcolor'] );
				} else {
					$this->image['ratio'] = ( $this->image['width'] > $this->image['height'] ) ? $max_width / $this->image['width'] : $max_height/$this->image['height']; 
					if( $this->image['width'] > $max_width || $this->image['height'] > $max_height ) { 
						$new_width = $this->image['width'] * $this->image['ratio']; 
						$new_height = $this->image['height'] * $this->image['ratio']; 
					} else {
						$new_width = $this->image['width']; 
						$new_height = $this->image['height'];
					} 
					$this->image['composite'] = imagecreatetruecolor( $new_width, $new_height );
					imagecopyresampled( $this->image['composite'], $this->image['render'], 0, 0, 0, 0, $new_width, $new_height, $this->image['width'], $this->image['height'] );
				}
			} else {
				echo 'Execution halted!';
			}
		
		}
		
		public function output ( $quality = 100 ) {
		
			if ( ! ( is_numeric( $quality ) ) ) {
				$quality = 100;
			}
			if ( ! ( $this->halt ) ) {
				switch ( $this->image['extension'] ) {
					case 'png';
						header( 'Content-Type: image/png' );
						imagepng( $this->image['composite'], null, null );
					break;
					case 'jpg';
						header( 'Content-Type: image/jpeg' );
						imagejpeg( $this->image['composite'], null, $quality );
					break;
					case 'jpeg';
						header( 'Content-Type: image/jpeg' );
						imagejpeg( $this->image['composite'], null, $quality );
					break;
					case 'gif';
						header( 'Content-Type: image/gif' );
						imagegif( $this->image['composite'], null, $quality );
					break;
					case 'bmp';
						header( 'Content-Type: image/wbmp' );
						imagewbmp( $this->image['composite'], null, null );
					break;
					case 'wbmp';
						header( 'Content-Type: image/wbmp' );
						imagewbmp( $this->image['composite'], null, null );
					break;
				}
			} else {
				echo 'Execution halted!';
			}
		}
		
		public function saveto ( $destination, $filename, $quality = 100 ) {
		
			if ( ! ( is_numeric( $quality ) ) ) {
				$quality = 100;
			}
			if ( ! ( $this->halt ) ) {
				switch ( $this->image['extension'] ) {
					case 'png';
						imagepng( $this->image['composite'], $destination . $filename . '.' . $this->image['extension'], null );
					break;
					case 'jpg';
						imagejpeg( $this->image['composite'], $destination . $filename . '.' . $this->image['extension'], $quality );
					break;
					case 'jpeg';
						imagejpeg( $this->image['composite'], $destination . $filename . '.' . $this->image['extension'], $quality );
					break;
					case 'gif';
						imagegif( $this->image['composite'], $destination . $filename . '.' . $this->image['extension'], $quality );
					break;
					case 'bmp';
						imagewbmp( $this->image['composite'], $destination . $filename . '.' . $this->image['extension'], null );
					break;
					case 'wbmp';
						imagewbmp( $this->image['composite'], $destination . $filename . '.' . $this->image['extension'], null );
					break;
				}
			} else {
				echo 'Execution halted!';
			}
		
		}
		
		public function clear_cache () {
		
			imagedestroy( $this->image['composite'] );
			imagedestroy( $this->image['render'] );
			unset( $this->image );
			unset( $this->s_image );
			$this->halt = false;
			
		}
		
	}
?>