<?php

namespace Badore\ContabiForm;

use Illuminate\Console\Command;
use InvalidArgumentException;
use Symfony\Component\Console\Attribute\AsCommand;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\SplFileInfo;
use Illuminate\Support\Str;

#[AsCommand(name: 'contabiform:zacca')]
class ContabiFormCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contabiform:zacca
                     { type=bootstrap : The preset type (bootstrap) }
                    {--views : Only scaffold the authentication views}
                    {--force : Overwrite existing views by default}'; 

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Easy Laravel Form';

   
	
    /**
     * Execute the console command.
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function handle()
    {
        //progressbar
		$bar = $this->output->createProgressBar(2);
 
		$bar->start();
		//
		
		$bar->advance();
        
		$this->exportViews();
		$bar->advance();

        		
		$bar->finish();
			
		$this->info(" ");
		$this->info('  ');
        $this->info('ContabiForm scaffolding generated successfully. ');
    }

    /**
     * Create the directories for the files.
     *
     * @return void
     */
    protected function ensureDirectoriesExist()
    {
		$directories = [
            
			app_path('contabiform'),
        ];

        foreach ($directories as $directory) {
            $this->createDirectory($directory);
        }
		$this->info(".");
		$this->info("Directory create.");
    }


	/**
     * Create a directory if it doesn't exist.
     *
     * @param  string  $path
     * @return void
     */
    protected function createDirectory($path)
    {
        if (!is_dir($path)) {
            mkdir($path, 0755, true);           
        }
    }
	
	
    /**
     * Export the authentication views.
     *
     * @return void
     */
    protected function exportViews()
    {
		$origine = __DIR__.'/../stubs/views';
		$destinazione =  resource_path('contabiform');
		$this->copyDirectory($origine, $destinazione);
					
		$this->info("views created.");			
    }

    

	/**
     * Copia ricorsivamente i file e le cartelle da una directory di origine a una di destinazione.
     *
     * @param string $src Percorso della cartella di origine
     * @param string $dst Percorso della cartella di destinazione
     * @return bool
     */
    public function copyDirectory($src, $dst)
    {
        // Verifica se la directory di origine esiste
        if (!file_exists($src)) {
            return response()->json(['error' => 'La directory di origine non esiste.'], 404);
        }

        // Se la cartella di destinazione non esiste, creala
        if (!file_exists($dst)) {
            mkdir($dst, 0755, true); // Crea la directory con permessi ricorsivi
        }

        // Apri la directory di origine
        $dir = opendir($src);

        // Scorri tutti i file e le cartelle nella directory
        while (($file = readdir($dir)) !== false) {
            // Ignora i riferimenti alla directory corrente (.) e alla directory superiore (..)
            if ($file != '.' && $file != '..') {
                $srcFilePath = $src . DIRECTORY_SEPARATOR . $file;
                $dstFilePath = $dst . DIRECTORY_SEPARATOR . $file;

                // Se è una directory, effettua una chiamata ricorsiva
                if (is_dir($srcFilePath)) {
                    $this->copyDirectory($srcFilePath, $dstFilePath); // Copia ricorsivamente
                } else {
                    // Copia il file nella destinazione
                    copy($srcFilePath, $dstFilePath);
                }
            }
        }

        // Chiudi la directory di origine
        closedir($dir);

        return true;
    }
	
    
}
