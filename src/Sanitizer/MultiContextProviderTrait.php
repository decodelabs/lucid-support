<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Sanitizer;

use Closure;
use DecodeLabs\Exceptional;
use DecodeLabs\Lucid\Constraint\NotFoundException as ConstraintNotFoundException;
use DecodeLabs\Lucid\Sanitizer;
use DecodeLabs\Lucid\Validate\Result;
use Exception;

/**
 * @template TValue
 */
trait MultiContextProviderTrait
{
    public function make(
        string $key,
        string $type,
        array|Closure|null $setup = null
    ): mixed {
        return $this->sanitize($key)->as($type, $setup);
    }

    public function force(
        string $key,
        string $type,
        array|Closure|null $setup = null
    ): mixed {
        return $this->sanitize($key)->forceAs($type, $setup);
    }

    public function validate(
        string $key,
        string $type,
        array|Closure|null $setup = null
    ): Result {
        return $this->sanitize($key)->validate($type, $setup);
    }

    public function is(
        string $key,
        string $type,
        array|Closure|null $setup = null
    ): bool {
        try {
            return $this->validate($key, $type, $setup)->isValid();
        } catch (ConstraintNotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            return false;
        }
    }

    public function sanitize(string $key): Sanitizer
    {
        if (!class_exists(Sanitizer::class)) {
            throw Exceptional::ComponentUnavailable(
                'DecodeLabs/Lucid package is required for sanitisation'
            );
        }

        return new Sanitizer($this->getValue($key));
    }

    /**
     * @phpstan-return TValue|null
     */
    abstract protected function getValue(string $key): mixed;
}
