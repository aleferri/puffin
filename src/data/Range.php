<?php

namespace alessio\puffin\data;

interface Range {

    public function apply(Query $query): Query;

}