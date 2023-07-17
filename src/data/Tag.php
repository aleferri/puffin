<?php

namespace puffin\data;

/**
 *
 * @author Alessio
 */
interface Tag {

    public const PRIMARY = "ID";
    public const INDEX_KEY = "INDEX";
    public const UNIQUE_KEY = "UNIQUE";

    /**
     * Name of the tag
     * @return string
     */
    public function name(): string;

    /**
     * Value of the tag
     * @return mixed
     */
    public function value();

    /**
     * Compare tag to other tag
     * @param Tag $b other tag to test
     * @return bool true if equals, false otherwise
     */
    public function equals(Tag $b): bool;

}
