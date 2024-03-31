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

use puffin\template\Renderable;

/**
 *
 * @author Alessio
 */
interface Layout {

    /**
     * Put the component after components with equal priority, mantaining the chronological order of addition
     */
    public const AFTER_SAME_PRIORITY = 0;

    /**
     * Put the component before components with equal priority
     */
    public const BEFORE_SAME_PRIORITY = 1;

    /**
     * Append component to the specified slot
     * @param string $slot
     * @param Renderable $renderable
     * @return Layout $this
     */
    public function append_to(string $slot, Renderable $renderable): Layout;

    /**
     *
     * @param string $slot
     * @param Renderable $renderable
     * @param int $priority
     * @param int $options
     * @return Layout
     */
    public function insert_to(string $slot, Renderable $renderable, int $priority = 100, int $options = 0): Layout;

    /**
     *
     * @param string $slog
     * @return Layout
     */
    public function reset_slot(string $slog = '*'): Layout;

    /**
     * Create a slot with a layout
     * @param string $slot
     * @param Layout $layout
     * @return Layout
     */
    public function layout_slot(string $slot, Layout $layout): Layout;

    /**
     * Query all components within a slot
     * @param string $slot
     * @return array list of components
     */
    public function query(string $slot = '*'): array;

    /**
     * All slots and their component
     * @return array
     */
    public function slots(): array;

}
