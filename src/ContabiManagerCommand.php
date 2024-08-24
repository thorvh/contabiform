<?php

namespace Badore\ContabiManager;

use Illuminate\Console\Command;
use InvalidArgumentException;
use Symfony\Component\Console\Attribute\AsCommand;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\SplFileInfo;
use Illuminate\Support\Str;

#[AsCommand(name: 'contabimanager:zacca')]
class ContabiManagerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contabimanager:zacca
                     { type=bootstrap : The preset type (bootstrap) }
                    {--views : Only scaffold the authentication views}
                    {--force : Overwrite existing views by default}'; 

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cosa deve fare';

    /**
     * The views that need to be exported.
     *
     * @var array
     */
    protected $views = [
        'admin_views/admin-login-modal.stub' => 'contabimanager/admin-login-modal.blade.php',
		'admin_views/create-model.stub' => 'contabimanager/create-model.blade.php',
		'admin_views/create.stub' => 'contabimanager/create.blade.php',
		'admin_views/error.stub' => 'contabimanager/error.blade.php',
		'admin_views/forbidden.stub' => 'contabimanager/forbidden.blade.php',
		'admin_views/index.stub' => 'contabimanager/index.blade.php',
		'admin_views/success.stub' => 'contabimanager/success.blade.php',
		'admin_views/table.stub' => 'contabimanager/table.blade.php',
		'admin_views/table_column.stub' => 'contabimanager/table_column.blade.php',
		'admin_views/table_success.stub' => 'contabimanager/table_success.blade.php',
		'admin_views/setup_complete.stub' => 'contabimanager/setup_complete.blade.php',
		'admin_views/menu/index.stub' => 'contabimanager/menu/index.blade.php',
		'admin_views/menu/create.stub' => 'contabimanager/menu/create.blade.php',
		'admin_views/menu/backoffice/icons.stub' => 'contabimanager/menu/backoffice/icons.blade.php',
		'admin_views/menu/backoffice/menuleft.stub' => 'contabimanager/menu/backoffice/menuleft.blade.php',
		'admin_views/settings/edit.stub' => 'contabimanager/settings/edit.blade.php',
		'hyper-contabi.stub' => 'layouts/hyper-contabi.blade.php',
		'hyper-contabi-admin.stub' => 'layouts/hyper-contabi-admin.blade.php',
		'hyper-menu.stub' => 'layouts/hyper-menu.blade.php',
		'partials_contabi/footer.stub' => 'layouts/partials_contabi/footer.blade.php',
		'partials_contabi/leftside.stub' => 'layouts/partials_contabi/leftside.blade.php',
		'partials_contabi/theme_settings.stub' => 'layouts/partials_contabi/theme_settings.blade.php',
		'partials_contabi/topbar.stub' => 'layouts/partials_contabi/topbar.blade.php',
    ];

	protected $vendor_path = 'vendor/badore/contabi/'; 
	
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
		$bar = $this->output->createProgressBar(5);
 
		$bar->start();
		//
		
		
        if (! in_array($this->argument('type'), ['bootstrap'])) {
            throw new InvalidArgumentException('Invalid preset.');
        }

        $this->ensureDirectoriesExist();
			$bar->advance();
        
		$this->exportViews();
			$bar->advance();

        if (! $this->option('views')) {
            $this->exportBackend();
				$bar->advance();
        }
		
		
		
		//copia files hyper
		$origine = dirname(base_path())."/__hyper/Hyper_v5.1/creative/assets";
		$destinazione =  base_path()."/public/hyper";
		$this->copyDirectory($origine, $destinazione);
			$bar->advance();
		
			$bar->finish();
			
		$this->info(" ");
		$this->info('  ');
        $this->info('ContabiManager scaffolding generated successfully. ');
		$this->info('***********************************************');
		$this->info('-----------------BELLA MOSSA--------------------');		
		$this->info('***********************************************');
		$this->info('vai a '.url('contabi/manager'));
    }

    /**
     * Create the directories for the files.
     *
     * @return void
     */
    protected function ensureDirectoriesExist()
    {
		$directories = [
            
			app_path('Contabi'),
			app_path('Models'),
			app_path('Http/Controllers/ContabiManager'),
			base_path('vendor/badore/contabi/src'),
			base_path('contabimanager_tests'),
            $this->vendor_path . 'src/backoffice/default_controller',
            $this->vendor_path . 'src/backoffice/default_model',
            $this->vendor_path . 'src/backoffice/default_views',
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
            //$this->info("Directory [$path] created.");
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
            'layouts/partials_contabi',
            'contabimanager/menu/backoffice',
            'contabimanager/settings',
			'contabimanager/form',
        ];

        foreach ($directories as $directory) {
            $this->createDirectory($this->getViewPath($directory));
        }
		
		foreach ($this->views as $key => $value) {
            if (file_exists($view = $this->getViewPath($value)) && ! $this->option('force')) {
                /* if (! $this->components->confirm("The [$value] view already exists. Do you want to replace it?")) {
                    continue;
                } */
            }

            copy(
               __DIR__.'/../stubs/'.$this->argument('type').'-stubs/'.$key,
                $view
            );
        }
    }

    /**
     * Export the authentication backend.
     *
     * @return void
     */
    protected function exportBackend()
    {
		$filesystem = new Filesystem;

        collect($filesystem->allFiles(__DIR__.'/../stubs/Controller'))
            ->each(function (SplFileInfo $file) use ($filesystem) {
                $filesystem->copy(
                    $file->getPathname(),
                    app_path('Http/Controllers/ContabiManager/'.Str::replaceLast('.stub', '.php', $file->getFilename()))
                );
            });
		$this->info("Http/Controllers/ContabiManager created.");	
		//backoffice
		//copia files di sistema su vendor
		
		

		
		$filesystem = new Filesystem;

        collect($filesystem->allFiles(__DIR__.'/../stubs/backoffice/default_model'))
            ->each(function (SplFileInfo $file) use ($filesystem) {
                $filesystem->copy(
                    $file->getPathname(),
					base_path('vendor/badore/contabi/src/backoffice/default_model/'.Str::replaceLast('.stub', '.php', $file->getFilename()))
					
                );
            });
			
		$filesystem = new Filesystem;

        collect($filesystem->allFiles(__DIR__.'/../stubs/backoffice/default_controller'))
            ->each(function (SplFileInfo $file) use ($filesystem) {
                $filesystem->copy(
                    $file->getPathname(),
					base_path('vendor/badore/contabi/src/backoffice/default_controller/'.Str::replaceLast('.stub', '.php', $file->getFilename()))
					
                );
            });
			
		$filesystem = new Filesystem;

        collect($filesystem->allFiles(__DIR__.'/../stubs/backoffice/default_views'))
            ->each(function (SplFileInfo $file) use ($filesystem) {
                $filesystem->copy(
                    $file->getPathname(),
					base_path('vendor/badore/contabi/src/backoffice/default_views/'.Str::replaceLast('.stub', '.php', $file->getFilename()))
					
                );
            });
			
			
		$filesystem = new Filesystem;

        collect($filesystem->allFiles(__DIR__.'/../stubs/bootstrap-stubs/admin_views/form'))
            ->each(function (SplFileInfo $file) use ($filesystem) {
                $filesystem->copy(
                    $file->getPathname(),
					resource_path('views/contabimanager/form')
					
                );
            });
			
			
		$this->info("backoffice created.");
		//
		
		
		
			
        $filesToCopy = [
            ['src' =>  __DIR__.'/../stubs/ContabiManager.php', 'dest' => app_path('Contabi/ContabiManager.php')],
			['src' =>  __DIR__.'/../stubs/MenuManager.php', 'dest' => app_path('Contabi/MenuManager.php')],
			['src' =>  __DIR__.'/../stubs/Form.php', 'dest' => app_path('Contabi/Form.php')],
			
			//models
			['src' =>  __DIR__.'/../stubs/Models/Menu.php', 'dest' => app_path('Models/Menu.php')],
            ['src' =>  __DIR__.'/../stubs/Models/Role.php', 'dest' => app_path('Models/Role.php')],
            ['src' =>  __DIR__.'/../stubs/Models/Settings.php', 'dest' => app_path('Models/Settings.php')],
            
			//vendor
			['src' =>  __DIR__.'/../stubs/Models/UserModel.stub', 'dest' => base_path('vendor/badore/contabi/src/UserModel.stub')],
			['src' =>  __DIR__.'//../stubs/setup.stub', 'dest' => base_path('vendor/badore/contabi/src/setup.stub')],
			//config
			['src' =>  __DIR__.'/../stubs/config/contabimanager.php', 'dest' => config_path('contabimanager.php')],
			
			
        ];

        foreach ($filesToCopy as $file) {
            $this->copyFile($file['src'], $file['dest']);
			$dir = $file['dest'];
			$this->info("Directory $dir created.");
        }

       // Config
        $configFile = config_path('contabimanager.php');
        $this->copyFile(__DIR__.'/../stubs/config/contabimanager.php', $configFile);
		
		

		/* if (! file_exists(app_path('Http/Middleware/IsAdmin.php'))) {
            copy(
               __DIR__.'/../stubs/stubs/Middleware/IsAdmin.php',
                app_path('Http/Middleware/IsAdmin.php')
            );
        } */
		
		
		//
		
		//copia routes.php 
		file_put_contents(
			base_path('routes/web.php'),
			file_get_contents(__DIR__.'//../stubs/routes.stub'),
			FILE_APPEND
		);
		
					
	
		//aggiorna App/Models/User.php
		//
		if( strpos(file_get_contents( app_path('Models/User.php' )), 'public function authAdmin()' == false) ){
			if( strpos(file_get_contents( app_path('Models/User.php' )), 'public function isAdmin()' == false) ){
				$find = '}'; //chiusura file
				$this->appendReplace(app_path('Models/User.php'), $find, file_get_contents(__DIR__.'//../stubs/Models/UserModel.stub'));
			}
		}
		
		//aggiorna App/Models/Settings.php
		//
		if( strpos(file_get_contents( app_path('Models/Settings.php' )), 'public static function ifMenu()' === false) ){
			$find = '}'; //chiusura file
			$this->appendReplace(app_path('Models/Settings.php'), $find, file_get_contents(__DIR__.'//../stubs/Models/SettingModel.stub'));
		}
		
        
        
    }



	 /**
     * Copy a file to the destination path.
     *
     * @param  string  $src
     * @param  string  $dest
     * @return void
     */
    protected function copyFile($src, $dest)
    {
        if (! file_exists($dest)) {
            copy( $src, $dest );
			
			//$this->info("File [$dest] created.");
        }
		
    }
	
	
	
    /**
     * Compiles the given stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function compileStub($stub)
    {
        return str_replace(
            '{{namespace}}',
            $this->laravel->getNamespace(),
            file_get_contents(__DIR__.'//../stubs/'.$stub.'.stub')
        );
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
	
	
	
	
	
	protected function appendReplace($filename, $find, $replace)
    {
       
		// Leggi il file in un array di righe
		$file_lines = file($filename);

		// Trova l'ultima riga che contiene $find es: '}'
		for ($i = count($file_lines) - 1; $i >= 0; $i--) {
			if (strpos($file_lines[$i], $find) !== false) {
				// Sostituisci questa riga con una funzione
				$file_lines[$i] = $replace;
				break;
			}
		}

		// Scrivi il contenuto modificato di nuovo nel file
		return file_put_contents($filename, implode("", $file_lines));
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
