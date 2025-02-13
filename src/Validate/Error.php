<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Validate;

use DecodeLabs\Coercion;
use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\Constraint\Processor as ProcessorConstraint;
use DecodeLabs\Lucid\Processor;

class Error
{
    public string $id {
        get => md5($this->constraintKey . ':' . $this->messageTemplate);
    }

    protected(set) mixed $value;
    protected(set) string $messageTemplate;

    /**
     * @var array<string, mixed>
     */
    protected(set) array $parameters = [];

    /**
     * @var Constraint<mixed, mixed>
     */
    protected(set) Constraint $constraint;
    protected(set) string $constraintKey;

    /**
     * @param Constraint<mixed, mixed>|Processor<mixed> $constraint
     * @param array<string, mixed> $parameters
     */
    public function __construct(
        Constraint|Processor $constraint,
        mixed $value,
        string $messageTemplate,
        array $parameters = []
    ) {
        if ($constraint instanceof Processor) {
            $constraint = new ProcessorConstraint($constraint);
        }

        $this->constraint = $constraint;
        $this->value = $value;
        $this->messageTemplate = $messageTemplate;
        $this->parameters = $parameters;

        $this->constraintKey = lcfirst(
            $this->constraint->name
        );
    }

    public function getProcessorName(): string
    {
        return $this->constraint->processor->name;
    }

    public function getMessage(): string
    {
        $output = $this->messageTemplate;
        $parameters = $this->parameters;

        // Type
        if (false !== strstr($output, '%type%')) {
            $type = $this->getProcessorName();

            if (substr($type, -6) === 'Native') {
                $type = substr($type, 0, -6);
            }

            $parameters['type'] = $type;
        }

        // Param
        $key = $this->constraintKey;
        $parameters[$key] = $this->constraint->parameter;


        // Replace
        foreach ($parameters as $key => $param) {
            $output = str_replace(
                '%' . $key . '%',
                Coercion::forceString($param),
                $output
            );
        }

        return $output;
    }
}
