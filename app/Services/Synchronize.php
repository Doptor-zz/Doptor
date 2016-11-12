<?php namespace Services;
/*
=================================================
CMS Name  :  DOPTOR
CMS Version :  v1.2
Available at :  www.doptor.org
Copyright : Copyright (coffee) 2011 - 2015 Doptor. All rights reserved.
License : GNU/GPL, visit LICENSE.txt
Description :  Doptor is Opensource CMS.
===================================================
*/
use App, Config, Exception, File, Input, Str, View, Redirect, Response;

use Backup;

use Guzzle\Service\Client as GuzzleClient;
use Guzzle\Plugin\Cookie\Cookie;
use Guzzle\Plugin\Cookie\CookiePlugin;
use Guzzle\Plugin\Cookie\CookieJar\ArrayCookieJar;

class Synchronize {

    protected $listener;

    /**
     * What is backed up(can be database, modules, public directory)
     * @var array
     */
    protected $includes;

    public function __construct($listener)
    {
        $this->listener = $listener;
        $this->includes = [];

        if (!File::exists(backup_path())) {
            File::makeDirectory(backup_path());
        }

        if (!File::exists(restore_path())) {
            File::makeDirectory(restore_path());
        }
    }

    protected function dbConnections()
    {
        $this->host = Config::get('database.connections.mysql.host');
        $this->database = Config::get('database.connections.mysql.database');
        $this->username = Config::get('database.connections.mysql.username');
        $this->password = Config::get('database.connections.mysql.password');
    }

    public function startLocalToRemoteSync($input)
    {
        try {
            $this->startBackup();

            $this->syncToRemote($this->listener->current_time, $this->listener->backup_file, $input);

            return $this->listener->syncSucceeds('Successfully synchronized local to remote.');
        } catch (Exception $e) {
            return $this->listener->syncFails($e->getMessage(), 'backend/synchronize/localToWeb');
        }
    }

    public function startRemoteToLocalSync($input)
    {
        try {
            $this->syncFromRemote($this->listener->current_time, $this->listener->restore_file, $input);

            $this->restore($this->listener->restore_file);

            return $this->listener->syncSucceeds('Successfully synchronized remote to local.');
        } catch (Exception $e) {
            return $this->listener->syncFails($e->getMessage(), 'backend/synchronize/webToLocal');
        }
    }

    public function startBackup($backup_db=true, $backup_modules=true, $backup_public=true)
    {
        $backup_dir = backup_path() . "/backup/";

        if ($backup_db) {
            $this->includes[] = 'Database';
            $this->backupDB($this->listener->current_time);
        }

        if ($backup_modules) {
            $this->includes[] = 'Modules';
            $this->backupModules($this->listener->current_time);
        }

        if ($backup_public) {
            $this->includes[] = 'Public';
            $this->backupPublic($this->listener->current_time);
        }

        $this->Zip($backup_dir, $this->listener->backup_file);

        File::deleteDirectory($backup_dir);
    }

    /**
     * Save the information of the created backup to database
     * @return Object
     */
    public function saveBackupToDB($description='')
    {
        $backup = Backup::create([
            'file' => $this->listener->backup_file,
            'includes' => $this->includes,
            'description' => $description
        ]);

        return $backup;
    }

    /**
     * Create backup of the current database
     * @param  string $current_time "Current time in string"
     */
    public function backupDB($current_time)
    {
        $this->dbConnections();

        $destination = backup_path() . "/backup/db/";

        // Clean the backup directory, before making any backup
        File::cleanDirectory(backup_path());

        File::makeDirectory(backup_path() . "/backup");
        File::makeDirectory($destination);

        $backup_filename = 'database_backup.sql';

        $path = \Setting::value('mysqldump_path', 'mysqldump');

        if (false) {
            if ($this->password == '') {
                //without password
                $command = $path . " -u " . $this->username . " " . $this->database . " > " . $destination . $backup_filename;
            } else {
                //with password
                $command = $path . " -u " . $this->username . " -p " . $this->password . " " . $this->database . " > " . $destination . $backup_filename;
            }

            system($command);
        } else {
            $this->backupTables($this->host, $this->username, $this->password, $this->database, $destination . $backup_filename);
        }
    }

    /**
     * Backup all the modules installed
     * @param  string $current_time "Current time in string"
     */
    public function backupModules($current_time)
    {
        $modules_path = app_path() . '/Modules';
        $destination = backup_path() . "/backup/Modules";

        $status = File::copyDirectory($modules_path, $destination);
    }

    /**
     * Backup the public folder
     * @param  string $current_time "Current time in string"
     */
    public function backupPublic($current_time)
    {
        $uploads_path = public_path() . '/uploads';
        $destination = backup_path() . "/backup/uploads";

        $status = File::copyDirectory($uploads_path, $destination);
    }

    /**
     * Send the backup file to remote server for synchronization
     * @param  string $current_time "Current time in string"
     * @param  [type] $backup_file  "The backup file"
     */
    public function syncToRemote($current_time, $backup_file, $input)
    {
        try {
            $client = $this->authorizeRemote($input);
            $request = $client
                            ->post('backend/synchronize/syncFromFile')
                            ->addPostFields(array('current_time'=>$current_time))
                            ->addPostFile('file', $backup_file)
                            ->removeHeader('Expect')
                            ->send();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function syncFromRemote($current_time, $restore_file, $input)
    {
        try {
            $client = $this->authorizeRemote($input);

            $response = $client
                            ->post('backend/synchronize/syncToFile')
                            ->setResponseBody($restore_file)
                            ->send();

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Authorize the user on the remote server
     * @param  Input $input
     * @return GuzzleClient
     */
    public function authorizeRemote($input)
    {
        $client = new GuzzleClient($input['remote_url']);
        $client->setSslVerification(FALSE);

        $cookieJar = new ArrayCookieJar();
        // Create a new cookie plugin
        $cookiePlugin = new CookiePlugin($cookieJar);
        // Add the cookie plugin to the client
        $client->addSubscriber($cookiePlugin);

        $post_data = array(
                    'username' => $input['username'],
                    'password' => $input['password'],
                    'remember' => 'checked',
                    'api'      => true,
                );

        $response = $client->post('login/backend', array(), $post_data)->send();

        $response_json = $response->json();
        if (isset($response_json['error'])) {
            throw new Exception($response_json['error']);
        }

        return $client;
    }

    /**
     * Copy the backup file received from the post data to the restore folder
     * @param  Input $input "The post input data"
     * @return string        "Filename"
     */
    public function copyToRestore($input)
    {
        File::cleanDirectory(restore_path());

        $file = $input['file'];
        $destinationPath = restore_path();

        $filename = $file->getClientOriginalName();
        // $extension = $file->getClientOriginalExtension();
        $uploadSuccess = $file->move($destinationPath, $filename);

        if ($uploadSuccess) {
            $file = $destinationPath . '/' . $filename;
            return $file;
        } else {
            return false;
        }
    }

    /**
     * Restore the database and modules from the restore file
     * @param  string $restore_file "The location of teh restore zip file"
     */
    public function restore($restore_file)
    {
        @ini_set('max_execution_time', 300);     // Temporarily increase maximum execution time

        $this->Unzip($restore_file, restore_path());
        $restore_dir = restore_path() . '/backup';

        // $this->dropTables();
        $this->restoreDB($restore_dir);
        $this->restoreModules($restore_dir);
        $this->restorePublic($restore_dir);
    }

    /**
     * Drop all the tables in the database
     */
    public function dropTables()
    {
        $all_tables = \Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();

        \DB::statement("SET foreign_key_checks = 0");
        foreach ($all_tables as $table) {
            \DB::statement('DROP TABLE IF EXISTS ' . $table);
        }
    }

    /**
     * Restore the database from the restore folder
     * @param  string $restore_dir
     */
    public function restoreDB($restore_dir)
    {
        $restore_db_file = "{$restore_dir}/db/database_backup.sql";

        if (!File::exists(stored_backups_path($restore_db_file))) {
            return;
        }

        $this->dbConnections();

        $delimiter = "-- --------------------------------------------------------\n";
        $fp = fopen($restore_db_file, 'r');

        $buffer = '';

        while (!feof($fp)) {
            // Read the sql files in chunks to avoid problems with large files
            $buffer .= fread($fp, 100);
            if (str_contains($buffer, $delimiter)) {
                list($statement, $extra) = explode($delimiter, $buffer, 2);
                $buffer = $extra;
                try {
                    \DB::unprepared($statement);
                } catch (\Illuminate\Database\QueryException $e) {
                    // Do nothing, if empty statement is occured
                }
            }
        }
    }

    /**
     * Restore all the modules
     * @param  string $restore_dir
     */
    public function restoreModules($restore_dir)
    {
        $restore_modules_dir = "{$restore_dir}/Modules/";

        if (!File::exists($restore_modules_dir)) {
            return;
        }

        File::cleanDirectory(app_path() . '/Modules/');
        File::copyDirectory($restore_modules_dir, app_path() . '/Modules/');
    }

    /**
     * Restore public folder
     * @param  string $restore_dir
     */
    public function restorePublic($restore_dir)
    {
        $restore_public_dir = "{$restore_dir}/uploads/";

        if (!File::exists($restore_public_dir)) {
            return;
        }

        File::cleanDirectory(public_path() . '/uploads/');
        File::copyDirectory($restore_public_dir, public_path() . '/uploads/');
    }


    /**
     * Generate a sql file of the current database
     * @param  string $host
     * @param  string $user
     * @param  string $password
     * @param  string $database
     * @param  string $file_name
     * @param  string $tables
     */
    function backupTables($host, $user, $password, $database, $file_name, $tables = '*')
    {
        $output = '';
        try {
             // open the connection to the database - $host, $user, $password, $database should already be set
             $mysqli = new \mysqli($host, $user, $password, $database);
             // did it work?
             if ($mysqli->connect_errno) {
                 throw new Exception("Failed to connect to MySQL: " . $mysqli->connect_error);
             }
             // start buffering output

             ob_start();
             $f_output = fopen($file_name, 'w');
             // put a few comments into the SQL file
             $output .= "-- SQL Dump\n";
             $output .= "-- Server version:".$mysqli->server_info."\n";
             $output .= "-- Generated: ".date('Y-m-d h:i:s')."\n";
             $output .= '-- Current PHP version: '.phpversion()."\n";
             $output .= '-- Host: '.$host."\n";
             $output .= '-- Database:'.$database."\n";
             //get a list of all the tables
             $aTables = array();
             $strSQL = 'SHOW TABLES';            // I put the SQL into a variable for debuggin purposes - better that "check syntax near '), "
             if (!$res_tables = $mysqli->query($strSQL))
                 throw new Exception("MySQL Error: " . $mysqli->error . 'SQL: '.$strSQL);
             while($row = $res_tables->fetch_array()) {
                 $aTables[] = $row[0];
             }
             // Don't really need to do this (unless there is loads of data) since PHP will tidy up for us but I think it is better not to be sloppy
             // I don't do this at the end in case there is an Exception
             $res_tables->free();
             $delimiter = "\n-- --------------------------------------------------------\n";
             //now go through all the tables in the database
             foreach($aTables as $table)
             {
                 $output .= $delimiter;
                 $output .= "-- Structure for '". $table."'\n";
                 $output .= "--\n\n";
                 // remove the table if it exists
                 $output .= 'DROP TABLE IF EXISTS '.$table.';';
                 $output .= $delimiter;
                 // ask MySQL how to create the table
                 $strSQL = 'SHOW CREATE TABLE '.$table;
                 if (!$res_create = $mysqli->query($strSQL))
                     throw new Exception("MySQL Error: " . $mysqli->error . 'SQL: '.$strSQL);
                 $row_create = $res_create->fetch_assoc();
                 $output .= "\n".$row_create['Create Table'].";\n";
                 $output .= $delimiter;
                 $output .= '-- Dump Data for `'. $table."`\n";
                 $output .= "--\n\n";
                 $res_create->free();
                 // get the data from the table
                 $strSQL = 'SELECT * FROM '.$table;
                 if (!$res_select = $mysqli->query($strSQL))
                     throw new Exception("MySQL Error: " . $mysqli->error . 'SQL: '.$strSQL);
                 // get information about the fields
                 $fields_info = $res_select->fetch_fields();
                 // now we can go through every field/value pair.
                 // for each field/value we build a string strFields/strValues
                 while ($values = $res_select->fetch_assoc()) {
                     $strFields = '';
                     $strValues = '';
                     foreach ($fields_info as $field) {
                         if ($strFields != '') $strFields .= ',';
                         $strFields .= "`".$field->name."`";
                         // put quotes round everything - MYSQL will do type conversion - also strip out any nasty characters
                         if ($strValues != '') $strValues .= ',';
                         $strValues .= "'".preg_replace('/[^(\x20-\x7F)\x0A]*/','',$values[$field->name]."'");
                     }
                     // now we can put the values/fields into the insert command.
                     $output .= "INSERT INTO ".$table." (".$strFields.") VALUES (".$strValues.");\n";
                     $output .= $delimiter;
                 }
                 $output .= "\n\n\n";
                 $res_select->free();
             }
         } catch (Exception $e) {
            dd($e->getMessage());
         }
         fwrite($f_output,$output);
         fclose($f_output);
         $mysqli->close();
        //save file
        // $handle = fopen($file_name, 'w+');
        // fwrite($handle,$return);
        // fclose($handle);
    }

    /**
     * Compresses a folder
     * @param [type] $source
     * @param [type] $destination
     */
    public function Zip($source, $destination, $include_dir = true)
    {
        if (!extension_loaded('zip') || !file_exists($source)) {
            return false;
        }

        if (file_exists($destination)) {
            unlink ($destination);
        }

        $zip = new \ZipArchive();
        if (!$zip->open($destination, \ZIPARCHIVE::CREATE)) {
            return false;
        }
        $source = str_replace('\\', '/', realpath($source));
        if (is_dir($source) === true) {
            $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($source), \RecursiveIteratorIterator::SELF_FIRST);

            if ($include_dir) {
                $arr = explode("/", $source);
                $maindir = $arr[count($arr)- 1];

                $source = "";
                for ($i=0; $i < count($arr) - 1; $i++) {
                    $source .= '/' . $arr[$i];
                }

                $source = substr($source, 1);

                $zip->addEmptyDir($maindir);
            }

            foreach ($files as $file) {
                // Ignore "." and ".." folders
                if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
                    continue;

                $file = realpath($file);
                $file = str_replace('\\', '/', $file);

                if (is_dir($file) === true) {
                    $dir = str_replace($source . '/', '', $file . '/');
                    $zip->addEmptyDir($dir);
                } else if (is_file($file) === true) {
                    $new_file = str_replace($source . '/', '', $file);
                    $zip->addFromString($new_file, file_get_contents($file));
                }
            }
        } else if (is_file($source) === true) {
            $zip->addFromString(basename($source), file_get_contents($source));
        }

        return $zip->close();
    }

    /**
     * Decompress a folder
     * @param [type] $file
     * @param [type] $path
     */
    public function Unzip($file, $path)
    {
        $zip = new \ZipArchive;
        $res = $zip->open($file);

        if ($res === true) {
            // extract it to the path we determined above
            try {
                $zip->extractTo($path);
            } catch (ErrorException $e) {
                //skip
            }
            $zip->close();
            return true;
        } else {
            return false;
        }
    }
}
