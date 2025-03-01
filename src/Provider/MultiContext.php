<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Provider;

use Closure;
use DecodeLabs\Lucid\Provider;
use DecodeLabs\Lucid\Sanitizer;
use DecodeLabs\Lucid\Validate\Result;

/**
 * @template TValue
 */
interface MultiContext extends Provider
{
    /**
     * @param array<string,mixed>|Closure|null $setup
     */
    public function cast(
        string $type,
        int|string $key,
        array|Closure|null $setup = null
    ): mixed;

    /**
     * @param array<string,mixed>|Closure|null $setup
     * @return Result<mixed>
     */
    public function validate(
        string $type,
        int|string $key,
        array|Closure|null $setup = null
    ): Result;

    /**
     * @param array<string,mixed>|Closure|null $setup
     */
    public function is(
        string $type,
        int|string $key,
        array|Closure|null $setup = null
    ): bool;

    public function sanitize(
        int|string $key
    ): Sanitizer;
}
