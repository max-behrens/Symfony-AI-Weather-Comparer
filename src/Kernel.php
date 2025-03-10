<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function getCacheDir(): string
    {
        return ($_ENV['CACHE_DIR'] ?? $this->getProjectDir().'/var/cache').'/'.$this->environment;
    }

    public function getLogDir(): string
    {
        return $_ENV['LOG_DIR'] ?? $this->getProjectDir().'/var/log';
    }
}