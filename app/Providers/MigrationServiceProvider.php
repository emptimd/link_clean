<?php

namespace App\Providers;

/**
 * A new MigrationServiceProvider that generates and migrate using unique class names!
 *
 */
class MigrationServiceProvider extends \Illuminate\Database\MigrationServiceProvider
{

    protected function registerMigrator()
    {
        $this->app->singleton('migrator', function ($app) {
            $repository = $app['migration.repository'];

            return new class($repository, $app['db'], $app['files']) extends \Illuminate\Database\Migrations\Migrator {
                public function resolve($file)
                {
                    $fileParts = explode('_', $file);
                    $class = \Illuminate\Support\Str::studly(implode(' ', array_slice($fileParts, 4))) . 'Migration_' . implode('', array_slice($fileParts, 0, 4));

                    if (!class_exists($class)) {
                        return parent::resolve($file);
                    }

                    return new $class;
                }
            };
        });
    }

    protected function registerCreator()
    {
        $this->app->singleton('migration.creator', function ($app) {
            return new class($app['files']) extends \Illuminate\Database\Migrations\MigrationCreator {
                protected function getClassName($name)
                {
                    return parent::getClassName($name) . 'Migration_' . str_replace('_', '', $this->getDatePrefix());
                }
            };
        });
    }
}