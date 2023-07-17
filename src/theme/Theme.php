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

/**
 * Description of Theme
 *
 * @author Alessio
 */
interface Theme {

    /**
     * Theme name
     * @return string
     */
    public function name(): string;

    /**
     * Theme versione
     * @return array
     */
    public function version(): array;

    /**
     * Theme root folder
     * @return string
     */
    public function root_folder(): string;

    /**
     * Renderable page
     * @param string $name
     * @param array $args
     * @return Page page to use
     */
    public function page(string $name, array $args): Page;

    /**
     * Renderable fragment
     * @param string $name
     * @param array $args
     * @return Fragment
     */
    public function fragment(string $name, array $args): Fragment;

}
