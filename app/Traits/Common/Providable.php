<?php
namespace App\Traits\Common;

use Illuminate\Foundation\AliasLoader;

trait Providable
{
    /**
     * Register aliases. Format of aliases array on the service provider should be:
     *
     *     'SomeClass' => 'Path\To\SomeClass'
     *
     * @returns void
     */
    protected function registerAliases()
    {
        if (!isset($this->aliases)) {
            return;
        }

        foreach ($this->aliases as $alias => $abstract) {
            AliasLoader::getInstance()->alias($alias, $abstract);
        }
    }

    /**
     * Registers the defined repository interfaces and binds them to an implementation.
     *
     * Format of the array should be:
     *
     *     'Repository' => 'RepositoryImplementation'
     *
     * @return void
     */
    protected function registerRepositories()
    {
        if (!isset($this->repositories)) {
            return;
        }

        foreach ($this->repositories as $interface => $repository) {
            $this->app->singleton($interface, $repository);
        }
    }

    /**
     * Register all files for the module.
     */
    protected function bootFiles()
    {
        foreach ($this->files as $file) {
            require $file;
        }
    }
}
