<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\Tests\Support;

use InvalidArgumentException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\Constraint\IsEqual;
use RuntimeException;
use function array_shift;
use function count;

final class ArrayWithConsecutive implements WithConsecutive
{
    private array $parameterGroups;

    /**
     * @param $parameterGroups array<int, array<*>>
     */
    public function __construct(array $parameterGroups)
    {
        $this->parameterGroups = $parameterGroups;
    }

    public function __invoke(): array
    {
        $result = [];
        $parametersCount = null;
        $groups = [];
        $values = [];

        if ([] === $this->parameterGroups) {
            throw new InvalidArgumentException('At least one parameter must be passed');
        }

        foreach ($this->parameterGroups as $index => $parameters) {
            // initial
            $parametersCount ??= count($parameters);

            // compare
            if ($parametersCount !== count($parameters)) {
                throw new RuntimeException('Parameters count max much in all groups');
            }

            // prepare parameters
            foreach ($parameters as $parameter) {
                if (!$parameter instanceof Constraint) {
                    $parameter = new IsEqual($parameter);
                }

                $groups[$index][] = $parameter;
            }
        }

        // collect values
        foreach ($groups as $parameters) {
            foreach ($parameters as $index => $parameter) {
                $values[$index][] = $parameter;
            }
        }

        // build callback
        for ($index = 0; $index < $parametersCount; ++$index) {
            $result[$index] = Assert::callback(static function ($value) use ($values, $index) {
                static $map = null;
                $map ??= $values[$index];

                $expectedArg = array_shift($map);
                if (null === $expectedArg) {
                    throw new RuntimeException('No more expected calls');
                }
                $expectedArg->evaluate($value);

                return true;
            });
        }

        return $result;
    }
}
