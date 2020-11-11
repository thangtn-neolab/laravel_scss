<?php

namespace Thangtn\Scss;

if( class_exists( 'scssc' ) ){

	class compile_scss{

		public $scss;

		private $dir_css, $dir_scss;

		function __construct( $dir_scss, $dir_css ){

		    $this->dir_scss = $dir_scss;
		    $this->dir_css = $dir_css;

		    var_dump( $this->dir_css, $this->dir_scss);
			$this->scss = new scssc();

			/* import path libary scss */
			$this->scss->setImportPaths( $this->dir_scss );
			var_dump( );

			/* import path file compile over time */
//			$this->run();

		}

		public function genaral_file( $file ){

			$dir = $this->$dir_css;

			$this->scss->setFormatter("scss_formatter_compressed");

            file_put_contents( $dir . $file . '.css', $this->get_compile_css( $file ) );

		}

		public function get_compile_css( $file ){
			return $this->scss->compile('@import "' . $file . '.scss"');
		}

		public function run(){

			$dir = ROOT_CHILD_DIR . '/assets/scss/';
			$files = array_diff( (array)scandir($dir), array('..', '.') );

			foreach ( $files as $file ) {
				if( pathinfo( $file, PATHINFO_EXTENSION ) == 'scss' ){

					if( substr($file, 0, 1) != "_" ){

						$this->genaral_file( pathinfo( $file, PATHINFO_FILENAME ) );

					}
				}

			}

		}

	}

	new compile_scss();

}
