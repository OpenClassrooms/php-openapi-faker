<?php

declare(strict_types=1);

namespace Vural\OpenAPIFaker;

use InvalidArgumentException;

use function in_array;
use function sprintf;

final class Options
{
    public const string STRATEGY_STATIC = 'static';

    public const string STRATEGY_DYNAMIC = 'dynamic';

    private int|null $minItems = null;

    private int|null $maxItems = null;

    private bool $alwaysFakeOptionals = false;

    private string $strategy = self::STRATEGY_DYNAMIC;

    private const array ALLOWED = [self::STRATEGY_STATIC, self::STRATEGY_DYNAMIC];

    public function setMinItems(int $minItems): self
    {
        $this->minItems = $minItems;

        return $this;
    }

    public function setMaxItems(int $maxItems): self
    {
        $this->maxItems = $maxItems;

        return $this;
    }

    public function setAlwaysFakeOptionals(bool $alwaysFakeOptionals): self
    {
        $this->alwaysFakeOptionals = $alwaysFakeOptionals;

        return $this;
    }

    /** @throws InvalidArgumentException */
    public function setStrategy(string $strategy): self
    {
        if (! in_array($strategy, self::ALLOWED, true)) {
            throw new InvalidArgumentException(sprintf('Unknown generation strategy: %s', $strategy));
        }

        $this->strategy = $strategy;

        return $this;
    }

    public function getMinItems(): int|null
    {
        return $this->minItems;
    }

    public function getMaxItems(): int|null
    {
        return $this->maxItems;
    }

    public function getAlwaysFakeOptionals(): bool
    {
        return $this->alwaysFakeOptionals;
    }

    public function getStrategy(): string
    {
        return $this->strategy;
    }
}
