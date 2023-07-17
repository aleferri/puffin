<?php

namespace puffin\data;

/**
 *
 * @author Alessio
 */
interface Property {

    /**
     * Name of the property
     * @return string
     */
    public function name(): string;

    /**
     * Applied tags of the properties
     * @return array
     */
    public function tags(): array;

    /**
     * Return tag by name
     *
     * @param string $tag_name
     *
     * @return Tag|null
     */
    public function tag_by_name(string $tag_name): ?Tag;

}
