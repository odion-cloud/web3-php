<?php declare(strict_types=1);

namespace Litehex\Web3\Formatters;

/**
 * This is part of the Litehex Web3 package.
 *
 * @link https://github.com/litehex/web3-php
 * @copyright Copyright (c) 2022 Litehex Ltd.
 *
 * @author Peter Lai <alk03073135@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
interface FormatterInterface
{

    /**
     * format
     *
     * @param mixed $value
     * @return mixed
     */
    public static function format(mixed $value): mixed;

}