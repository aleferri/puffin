<?php

namespace alessio\puffin\data;

interface Query {

    public function bind_value(mixed $value): void;

}