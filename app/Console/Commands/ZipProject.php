<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Generate Directory ZIP
 */
class DirectoryZipper
{
    private $ZipProjectObj;

    private $directory;
    private $output_zip_file;
    private $directory_scan_result;

    private $excludes = [
        'public/assets/',
        'public/uploads/',
        'vendor/',
        '.git/',
        '*.zip',
        '*.bat',
    ];

    public function __construct($directory, $output_zip_file, $ZipProjectObj)
    {
        $this->ZipProjectObj = $ZipProjectObj;

        $this->directory = $directory;
        $this->output_zip_file = $output_zip_file;
        $this->directory_scanner($directory);
    }
    
    public function zip_folder_hierachy($init=false) {
        if ( is_file($this->directory . $this->output_zip_file) && $init ) {
            unlink($this->directory . $this->output_zip_file);
        }

        try {
            $zipClass = new \ZipArchive();
            
            if( $zipClass->open($this->directory . $this->output_zip_file, \ZipArchive::CREATE) ){

                foreach ($this->directory_scan_result as $file) {
                    $full = $this->directory . $file;

                    $checkExclusion = false;
                    foreach ($this->excludes as $exclude) {
                        $exclude = preg_quote($exclude, '/');

                        if ( preg_match("/^{$exclude}/i", $file) ) {
                            $checkExclusion = true;
                            break;
                        }
                    }

                    if ( $checkExclusion ) {
                        continue;
                    }

                    if ( is_dir($full) ) {
                        $this->ZipProjectObj->info($full . ' -- DIR');
                        $zipClass->addEmptyDir( $file . '/' );
                    } else {
                        $this->ZipProjectObj->info($full . ' -- FILE');
                        $zipClass->addFile($full, $file);
                    }
                }

                $zipClass->close(); 
            } else {
                exit ('Could not create a zip archive, migth be write permissions or other reason.');
            }

        } catch (\Exception $e) {
            
        }
    }

    private function directory_scanner($directory, $add=null){
        $ffs = scandir($directory);

        unset($ffs[array_search('.', $ffs, true)]);
        unset($ffs[array_search('..', $ffs, true)]);

        // prevent empty ordered elements
        if (count($ffs) < 1) {
            return;
        }

        foreach($ffs as $ff){
            $this->directory_scan_result[] = ltrim($add . '/' . $ff, '/');

            if(is_dir($directory.'/'.$ff)) {
                $this->directory_scanner($directory.'/'.$ff, $add . '/' . $ff);
            }
        }
    }

}


class ZipProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zip:project';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exporter le projet sous forme zipper !';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ( ! app()->environment('local') ) {
            return 1;
        }
        
        $root_dir = base_path() . DS;

        $DirectoryZipper = new DirectoryZipper($root_dir, 'project.zip', $this);
        $DirectoryZipper->zip_folder_hierachy(true);

        return 0;
    }
}
