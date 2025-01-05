<?php

namespace MikeyDevelops\Econt;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Shell extends \Psy\Shell
{
    /**
     * The autoload aliases.
     * Automatic classes will be added to this array from composer's autoload_classmap.php
     *
     * @var array
     */
    protected array $aliases = [
        'HttpClient' => \MikeyDevelops\Econt\Http\Client::class,
    ];

    /**
     * Runs PsySH.
     *
     * @param InputInterface|null  $input  An Input instance
     * @param OutputInterface|null $output An Output instance
     *
     * @return int 0 if everything went fine, or an error code
     */
    public function run(?InputInterface $input = null, ?OutputInterface $output = null): int
    {
        $this->autoloadAliases();

        spl_autoload_register([$this, 'alias']);

        try {
            return parent::run($input, $output);
        } finally {
            spl_autoload_unregister([$this, 'alias']);
        }
    }

    /**
     * Autoload aliased class.
     *
     * @param  string  $class
     * @return void
     */
    public function alias($alias)
    {
        if (strpos($alias, '\\') !== false || ! isset($this->aliases[$alias])) {
            return;
        }

        $class = $this->aliases[$alias];

        $this->writeStdout("Automatically aliasing [$alias] to [$class].\n");

        class_alias($class, $alias);
    }

    /**
     * Automatically load aliases from composer.json psr-4 namespaces and autoload_classmap.php
     *
     * @return static
     */
    protected function autoloadAliases(): self
    {
        $composerJson = dirname(__DIR__) . '/composer.json';

        if (! file_exists($composerJson)) {
            $this->writeStdout("Failed to load composer.json from [$composerJson]. File missing.");

            return $this;
        }

        $composer = json_decode(file_get_contents($composerJson), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->writeStdout("Failed to load composer.json from [$composerJson]. Json decode error. " . json_last_error_msg());

            return $this;
        }

        $classmap = dirname(__DIR__) . '/vendor/composer/autoload_classmap.php';

        if (! file_exists($composerJson)) {
            $this->writeStdout("Failed to load autoload_classmap.php from [$classmap]. File missing. Run composer dump-autoload.");

            return $this;
        }

        // get all classes and only autoload those in base composer.json
        $aliases = array_filter(
            require $classmap,
            function ($namespace) use ($composer) {
                foreach ($composer['autoload']['psr-4'] ?? [] as $baseNamespace => $_) {
                    if (substr($namespace, 0, strlen($baseNamespace)) == $baseNamespace) {
                        return true;
                    }
                }

                return false;
            },
            ARRAY_FILTER_USE_KEY,
        );

        foreach ($aliases as $class => $path) {
            $alias = basename(str_replace('\\', '/', $class));

            unset($aliases[$class]);

            if (! isset($aliases[$alias])) {
                $aliases[$alias] = $class;
            }
        }

        $this->aliases = array_merge(array_reverse($aliases), $this->aliases);

        // for debugging the array.
        ksort($this->aliases);

        return $this;
    }
}
