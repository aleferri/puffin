<?php

/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */

namespace puffin\theme;

/**
 *
 * @author Alessio
 */
interface Menu {

    /**
     * Add menu entry
     * @param MenuEntry $entry
     * @return array
     */
    public function add_entry(MenuEntry $entry): array;

    /**
     * Remove entry
     * @param MenuEntry $entry
     * @return array
     */
    public function remove_entry(MenuEntry $entry): array;

    /**
     * Query an entry by it's path
     * @param string $path
     * @return MenuEntry|null
     */
    public function query(string $path): ?MenuEntry;

    /**
     * Query all entries that follows the same path
     * @param string $path
     * @return array
     */
    public function query_all(string $path): array;

    /**
     * Render to array all the menu
     * @return array
     */
    public function to_array(): array;

}
