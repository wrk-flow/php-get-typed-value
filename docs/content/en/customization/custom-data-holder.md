---
title: Custom data holder
subtitle: 'Provide data access to a custom data format 🚀'
category: Customization
position: 11
---

1. Create an object in DataHolders namespace
2. Extend `\Wrkflow\GetValue\DataHolders`
3. Implement `getValue(string|array $key): mixed` that should return required value (make it nullable).
4. Implement `public function get(): array` that should return whole data when you need it.

```php
<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\DataHolders;

class ArrayData extends AbstractData
{
    public function __construct(private readonly array $flatArray)
    {
    }

    public function getValue(string|array $key): mixed
    {
        return $this->flatArray[implode('.', $key)] ?? null;
    }

    public function get(): array
    {
        return $this->flatArray;
    }
}

```
