<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid;

use Generator;
use Reflection;
use ReflectionClass;

/**
 * @template TParam
 * @template TValue
 * @phpstan-require-implements Constraint<TParam, TValue>
 */
trait ConstraintTrait
{
    public string $name {
        get => $this->getName();
    }

    public int $weight {
        get => static::Weight;
    }

    /**
     * @var TParam
     */
    public mixed $parameter = null {
        set => $this->validateParameter($value);
    }

    /**
     * @var Processor<TValue>
     */
    protected(set) Processor $processor;

    /**
     * @param Processor<TValue> $processor
     */
    public function __construct(
        Processor $processor
    ) {
        $this->processor = $processor;
    }

    public static function getProcessorOutputTypes(): ?array
    {
        return static::OutputTypes;
    }

    protected function getName(): string {
        return new ReflectionClass($this)->getShortName();
    }

    /**
     * @param TParam $parameter
     * @return TParam
     */
    protected function validateParameter(
        mixed $parameter
    ): mixed {
        return $parameter;
    }


    public function prepareValue(
        mixed $value
    ): mixed {
        return $value;
    }

    public function alterValue(
        mixed $value
    ): mixed {
        return $value;
    }

    /**
     * @param TValue $value
     */
    public function validate(
        mixed $value
    ): Generator {
        yield null;
        return true;
    }
}
