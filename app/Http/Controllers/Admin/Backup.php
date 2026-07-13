<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Spatie\DbDumper\Databases\MySql;
use Illuminate\Support\Facades\File;

class Backup extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $admin = admin();
        $dumpFileName = "administrator_"; // . date("m_Y_") . $admin->id;

        $filename = "backup-" . \Carbon\Carbon::now()->format('Y-m-d') . ".sql";
        // Create backup folder and set permission if not exist.
        $storageAt = storage_path() . "/app/backup/";
        if(!File::exists($storageAt)) {
            File::makeDirectory($storageAt, 0755, true, true);
        }
        $command = env('DB_DUMP_PATH', 'mysqldump')." --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  | gzip > " . $storageAt . $filename;
        $returnVar = NULL;
        $output = NULL;
        $data = exec($command, $output, $returnVar);
        dd( $data );
        die;

        try {
            
            MySql::create()
                ->setDbName( env('DB_DATABASE') )
                ->setUserName( env('DB_USERNAME') )
                ->setPassword( env('DB_PASSWORD') )
                ->dumpToFile( $dumpFileName . '.sql' );

        } catch (\Exception $e) {
            dd( $e->getMessage() );
            return back_With_Error();
        }

        die;
        $filename = 'backups' . DS . "administrator_" . date("m_Y_") . $admin->id . '.json';
        if (is_file(WEBROOT . $filename)) {
            unlink(WEBROOT . $filename);
        }
        
        /**
         * Backup data
         */
        $tables = DB::select("SHOW TABLES");

        $paramsDATA = array();
        foreach ($tables as $results) {
            foreach ($results as $table) {
                $query = DB::table($table)->select("*");
                if ($table == 'admins') {
                    $query = $query->whereId($admin->id);
                }
                $backups = json_encode($this->database->allQuery($query, $paramsDATA));
                file_put_contents(WEBROOT . $filename, $backups, FILE_APPEND);
            }
        }
        
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='. basename($filename));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filename));
        echo file_get_contents(SITE_ROOT . $filename);
        exit;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
