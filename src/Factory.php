<?php

/*
 * This file is part of the icecho/easyip.
 *
 * (c) icecho <iymiym@icloud.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Icecho\EasyIp;

use Icecho\EasyIp\Exception\InvalidArgumentException;

class Factory
{
    protected $config;

    /**
     * Factory constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     */
    public function make($name, $arguments)
    {
        $class = static::formatClassName($this->config['provider']);

        if (!class_exists($class)) {
            throw new InvalidArgumentException('Class is not exist!');
        }

        return call_user_func([new $class($this->config), $name], ...$arguments);
    }

    /**
     * @param string $provider
     *
     * @return string
     */
    public static function formatClassName(string $provider)
    {
        $provider = ucfirst($provider);

        return __NAMESPACE__."\\Providers\\{$provider}\\{$provider}";
    }
}
