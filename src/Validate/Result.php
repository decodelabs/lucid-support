<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Validate;

use DecodeLabs\Lucid\Processor;

/**
 * @template TValue
 */
class Result
{
    /**
     * @var TValue|null
     */
    public protected(set) mixed $value = null;

    /**
     * @var Processor<TValue>
     */
    public protected(set) Processor $processor;

    /**
     * @var array<Error>
     */
    protected array $errors = [];

    /**
     * Init with processor
     *
     * @param Processor<TValue> $processor
     */
    public function __construct(
        Processor $processor
    ) {
        $this->processor = $processor;
    }


    /**
     * Get type name
     */
    public function getType(): string
    {
        return $this->processor->name;
    }


    /**
     * Is valid
     */
    public function isValid(): bool
    {
        return empty($this->errors);
    }

    /**
     * Add error
     *
     * @return $this
     */
    public function addError(
        Error $error
    ): static {
        $this->errors[$error->id] = $error;
        return $this;
    }

    /**
     * Get errors
     *
     * @return array<Error>
     */
    public function getErrors(): array
    {
        return array_values($this->errors);
    }

    /**
     * Has errors
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    /**
     * Count errors
     */
    public function countErrors(): int
    {
        return count($this->errors);
    }
}
