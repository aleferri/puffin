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

namespace puffin\http\body;

/**
 *
 * @author Alessio
 */
interface Encoder {

    /**
     * Encode any data
     * @param mixed $data
     * @param string|null $name name of the encoded
     * @return mixed
     */
    public function encode(mixed $data, ?string $name = null): mixed;

}
