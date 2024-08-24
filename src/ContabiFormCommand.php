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
       
		$directories = [
            'contabiform',
        ];

        foreach ($directories as $directory) {
            $this->createDirectory($this->getViewPath($directory));
        }
		
		$filesystem = new Filesystem;

        
			
		collect($filesystem->allFiles(__DIR__.'/../stubs/views'))
            ->each(function (SplFileInfo $file) use ($filesystem) {
                $filesystem->copy(
                    $file->getPathname(),
					$this->getViewPath('contabiform')
					
                );
            });
			
		$this->info("views created.");	
		
    }

    


	
	

    /**
     * Get full view path relative to the application's configured view path.
     *
     * @param  string  $path
     * @return string
     */
    protected function getViewPath($path)
    {
        return implode(DIRECTORY_SEPARATOR, [
            config('view.paths')[0] ?? resource_path('views'), $path,
        ]);
    }
	
	
	
	
	
	
    
}
