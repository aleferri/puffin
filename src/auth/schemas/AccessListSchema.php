<?php

namespace puffin\auth\schemas;

use puffin\data\Property;
use puffin\data;

/**
 * Description of AccessListSchema
 *
 * @author Alessio
 */
class AccessListSchema implements \puffin\data\Schema {

    /**
     * @var array<\puffin\data\Property> $properties
     */
    private $properties;
    
    /**
     * @var string $name
     */
    private $name;

    public function __construct(string $name = 'sec_access_lists') {
    	$this->name = $name;
        $this->properties = [
            data\progressive ( 'rule_id' ),
            data\text ( 'match', 255 ),
            data\text ( 'users', 255 ),
            data\text ( 'grants', 255 ),
            data\flag ( 'permission', false )
        ];
    }

    public function clone(string $new_name): \puffin\data\Schema {
        return new self( $new_name );
    }

    public function getIterator(): \Traversable {
        return new \ArrayIterator($this->properties);
    }

    public function indexes(): array {
        return [ "rule_id" ];
    }

    public function name(): string {
        return $this->name;
    }

    public function progressive_key(): string {
        return "rule_id";
    }

    public function properties(): array {
        return $this->properties;
    }

    public function property(string $name): ?Property {
        foreach ( $this->properties as $prop ) {
            if ( $prop->name () == $name ) {
                return $prop;
            }
        }
        return null;
    }

}
