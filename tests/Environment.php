<?php declare(strict_types=1);

namespace LitehexTests\Web3;

class Environment
{

    private string $path = __DIR__ . '/../';

    function load(string $path = ''): void
    {
        $dotenv = \Dotenv\Dotenv::createImmutable($path ?: $this->path);
        $dotenv->load();
    }

}