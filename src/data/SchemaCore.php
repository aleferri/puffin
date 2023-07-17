<?php

namespace puffin\data;

trait SchemaCore {

    /**
     * Property of name $name
     */
    public function property(string $name): ?Property {
        foreach( $this->properties() as $property ) {
            if ( $property->name() === $name ) {
                return $property;
            }
        }
        return null;
    }

    /**
     * List of indexes name
     */
    public function indexes(): array {
        $indexes = [];
        foreach( $this->properties() as $property ) {
            if ( $property->tag_by_name( Tag::INDEX_KEY ) !== null ) {
                $indexes[] = $property;
            }
        }
        return $indexes;
    }


}