<?php

/*
 * Copyright 2023 Alessio.
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

namespace puffin\theme;

use puffin\template\Renderable;

/**
 *
 * @author Alessio
 */
interface Page extends Renderable {

    /**
     * List of all mount points
     * @return array
     */
    public function mount_points(): array;

    /**
     * Link script
     * @param array $script
     * @return void
     */
    public function link_script(array $script): void;

    /**
     *
     * @param string $name
     * @return void
     */
    public function drop_script(string $name): void;

    /**
     * Link a style
     * @param array $style
     * @return void
     */
    public function link_style(array $style): void;

    /**
     *
     * @param string $name
     * @return void
     */
    public function drop_style(string $name): void;

    /**
     * Set a meta
     * @param string $meta
     * @param array $content
     * @return void
     */
    public function set_meta(string $meta, array $content): void;

    /**
     * Get a meta
     * @param string $meta
     * @param array $content
     * @return array
     */
    public function get_meta(string $meta): array;

    /**
     * Set the title
     * @param string $title
     * @return void
     */
    public function set_title(string $title): void;

    /**
     * Get the title
     * @return string
     */
    public function get_title(): string;

}
