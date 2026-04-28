<?php

declare(strict_types=1);

namespace Vural\OpenAPIFaker\SchemaFaker;

use cebe\openapi\spec\Schema;
use Faker\Provider\Base;
use Vural\OpenAPIFaker\Options;

use function array_diff;
use function array_keys;
use function array_merge;
use function count;
use function in_array;

/** @internal */
final class ObjectFaker
{
    /** @return array<mixed> */
    public static function generate(Schema $schema, Options $options, bool $request = false): array
    {
        $useStaticStrategy = $options->getStrategy() === Options::STRATEGY_STATIC;

        if ($useStaticStrategy && $schema->example !== null) {
            return $schema->example;
        }

        $result = [];

        $requiredKeys         = $schema->required ?? [];
        $optionalKeys         = array_diff(array_keys($schema->properties), $requiredKeys);
        $selectedOptionalKeys = Base::randomElements($optionalKeys, Base::numberBetween(0, count($optionalKeys)));

        $allPropertyKeys = array_merge($requiredKeys, $selectedOptionalKeys);

        foreach ($schema->properties as $key => $property) {
            if (! $property instanceof Schema) {
                continue;
            }

            if (($request && $property->readOnly) || (! $request && $property->writeOnly)) {
                continue;
            }

            if (
                ! $useStaticStrategy
                && ! $options->getAlwaysFakeOptionals()
                && ! in_array($key, $allPropertyKeys, true)
            ) {
                continue;
            }

            $value = new SchemaFaker($property, $options)->generate();

            if (
                $useStaticStrategy
                && $property->nullable
                && ! $options->getAlwaysFakeOptionals()
            ) {
                continue;
            }

            $result[$key] = $value;
        }

        return $result;
    }
}
