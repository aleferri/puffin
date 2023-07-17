<?php

namespace puffin\ext;

use puffin\http\RouteCollection;

interface Plugin {

    public function name(): string;

    public function on_activate(): void;

    public function on_inactivate(): void;

    public function on_remove(): void;

    public function entities_classes(): array;

    public function routes(): RouteCollection;

    public function dump_routes(): string;

}