<?php

/*
 * Copyright 2020 Alessio.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace puffin\data;

/**
 * Create a progressive index property (necessary primary)
 * @param string $name name of the property
 * @return Property created
 */
function progressive(string $name): Property {
    $type_name = new PropertyTag ( 'type', 'int64' );
    $writeable = new PropertyTag ( 'write', false );
    $primary = new PropertyTag ( 'primary', true );
    return new BasicProperty ( $name, [ $type_name, $writeable, $primary ] );
}

/**
 * Create a text based property
 * @param string $name name of the property
 * @param int $len length of the text
 * @param string $default default value
 * @return Property created
 */
function text(string $name, int $len, string $default = ''): Property {
    $type_name = new PropertyTag ( 'type', "varchar({$len})" );
    $writeable = new PropertyTag ( 'write', true );
    $init = new PropertyTag ( 'init', $default );
    return new BasicProperty ( $name, [ $type_name, $writeable, $init ] );
}

/**
 * Create a flag based property
 * @param string $name name of the property
 * @param bool $default default value
 * @return Property created
 */
function flag(string $name, bool $default = false): Property {
    $type_name = new PropertyTag ( 'type', "bool" );
    $writeable = new PropertyTag ( 'write', true );
    $init = new PropertyTag ( 'init', $default );
    return new BasicProperty ( $name, [ $type_name, $writeable, $init ] );
}

/**
 * Create an email property
 * @param string $name name of the property
 * @param string $default default value
 * @return Property created
 */
function email(string $name, string $default = ''): Property {
    $type_name = new PropertyTag ( 'type', "email" );
    $writeable = new PropertyTag ( 'write', true );
    $init = new PropertyTag ( 'init', $default );
    return new BasicProperty ( $name, [ $type_name, $writeable, $init ] );
}
