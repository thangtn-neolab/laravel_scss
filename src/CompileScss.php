<?php

namespace Scss\Scss;

use Illuminate\Filesystem\Filesystem;
use Scss\Scss\Scssc;
use Scss\Scss\compile;

class CompileScss
{

    public $scss;

    private $dir_setting, $file_setting, $dir_scss, $dir_css, $root_dir;

    /*
     * input: directory two folder css and scss
     *
     * */
    function __construct(){

        $this->root_dir = rtrim( base_path(), '/' );

        $this->dir_setting = $this->root_dir . '/ScssSetting/';

        $this->file_setting = 'compile_setting.json';

        $this->Create_Setting_Compile();

        $this->Create_folder_Compile();

        $this->scss = new Scssc();


        /* import path libary scss */
        $this->scss->setImportPaths( $this->dir_scss );
        /* import path file compile over time */

        $this->exec();

    }

    public function Create_Setting_Compile()
    {
        $dir_setting = $this->root_dir . '/ScssSetting/';
        $file_setting = 'compile_setting.json';

        /*
         * create folder save file compile_setting.json if directory not exits
         * */
        if ( !file_exists($this->dir_setting) ) {
            try {
                mkdir($this->dir_setting, 0755, true );
            } catch ( \Exception $exception ) {
                echo 'Error: ' . $exception->getMessage();
            }
        }

        /*
        * create file compile_setting.json if files not exits
        * */

        if ( !file_exists($this->dir_setting . $file_setting) ) {
            try {
                touch($dir_setting . $file_setting, strtotime('-1 days'));
                $json_data = '
                    {
                        "SCSS_DIR": "resources/sass/",
                        "CSS_DIR": "public/assets/css/"
                    }
                ';
                if ( file_exists($dir_setting . $file_setting) )
                {
                    file_put_contents($dir_setting . $file_setting, $json_data);
                }

            } catch ( \Exception $exception ) {
                echo 'Error: ' . $exception->getMessage();
            }
        }
    }


    public function Create_folder_Compile()
    {
        $filesystem = new Filesystem();
        $content_obj = json_decode( $filesystem->get( $this->dir_setting . $this->file_setting ) );

        $this->dir_scss = $this->root_dir . '/' . $content_obj->SCSS_DIR;
        $this->dir_css = $this->root_dir . '/' . $content_obj->CSS_DIR;

    }

    public function genaral_file( $file )
    {
        $filesystem = new Filesystem();

        if ( !file_exists($this->dir_css) ) {
            try {
                mkdir($this->dir_css, 0755, true );
            } catch ( \Exception $exception ) {
                echo 'Error: ' . $exception->getMessage();
            }
        }
        $this->scss->setFormatter("scss_formatter_compressed");
        $filesystem->replace($this->dir_css . $file . '.css', $this->get_compile_css( $file ) );

    }

    public function get_compile_css( $file )
    {
        return $this->scss->compile('@import "' . $file . '.scss"');
    }

    public function exec()
    {
        $files = array_diff( (array)scandir($this->dir_scss), array('..', '.') );

        foreach ( $files as $file ) {
            if( pathinfo( $file, PATHINFO_EXTENSION ) == 'scss' ){
                if( substr($file, 0, 1) != "_" ){
                    $this->genaral_file( pathinfo( $file, PATHINFO_FILENAME ) );
                }
            }

        }
    }

    public static function run_compile(){
        new CompileScss();
    }

}
