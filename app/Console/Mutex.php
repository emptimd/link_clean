<?php

namespace App\Console;


/**
 * Class Mutex
 * @author yourname
 */
class Mutex
{
    protected $command;

    public function __construct( $command )
    {
        $this->command = $command;
    }

    public function exists()
    {
        return file_exists( $this->filename() );
    }

    public function lock()
    {
        return $this->write( '' );
    }

    public function unlock()
    {
        if($this->exists())
            return unlink( $this->filename() );
        return true;
    }

    public function read()
    {
        return file_get_contents( $this->filename() );
    }

    public function write( $text )
    {
        return file_put_contents( $this->filename(), $text );
    }

    public function filename()
    {
        return storage_path( 'framework' . DIRECTORY_SEPARATOR . 'artisan-' . sha1($this->command->getName()).'campaign_id-'.$this->command->argument('id') );
    }
}