<?php

namespace puffin\data;

/**
 *
 * @author Alessio
 */
interface Link {

    public function keys_left(array $record): array;

    public function keys_right(array $record): array;

    public function name_left(): string;

    public function name_right(): string;

}
