<?php

namespace alessio\puffin\data;

interface Reader {

    public function fetch_all(array|string $select, string $condition, Range $range): array;

}