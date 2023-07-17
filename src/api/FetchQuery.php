<?php

namespace puffin\api;

interface FetchQuery {

    public function fetch_fields(): array;

    public function query_fields(): array;

    public function condition_on(string $field, bool $alias = true): array;
}
