<?php

namespace puffin\data;

class PropertyTag implements Tag {

    private $name;
    
    /**
     * @var mixed $value
     */
    private $value;

    /**
     * @param string $name name of the tag
     * @param mixed $value value of the tag
     */
    public function __construct(string $name, $value) {
        $this->name = $name;
        $this->value = $value;
    }

    public function name(): string {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function value() {
        return $this->value;
    }

    public function equals(Tag $b): bool {
        if ( $b->name () !== $this->name ) {
            return false;
        }
        if ( $b->value () !== $this->value ) {
            return false;
        }
        return true;
    }

}
