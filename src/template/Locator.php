<?php

declare(strict_types=1);
/**
 * @author Alessio Ferri
 * @copyright Alessio Ferri
 * @license Apache-2.0
 */

namespace puffin\template;

class Locator {

    private $base;

    public function __construct(string $base) {
        $this->base = $base;
    }

    public function template(string $name): string {
        return $this->base . '/' . $name;
    }

}
