<?php

declare(strict_types = 1);
/**
 * @author Alessio Ferri
 * @copyright Alessio Ferri
 * @license Apache-2.0
 */

namespace puffin\http;

use puffin\http\session\Cookies;

/**
 *
 * @author Alessio
 */
interface Response {

    /**
     * Return same response with different body
     * @param string $body new response body
     * @return Response same but with different body
     */
    public function with_body(string $body): Response;

    /**
     * Return same response with different status
     * @param int $http_code new http code
     * @return Response same but with different status
     */
    public function with_status(int $http_code): Response;

    /**
     * Return same response with different headers
     * @param array $headers new headers to replace the old ones
     * @return Response same but with different headers
     */
    public function with_headers(array $headers): Response;

    /**
     * Modify or add a single header in the request
     * @param string $header header name
     * @param string $value header value
     * @return Response same but with the header
     */
    public function with_header(string $header, string $value): Response;

    /**
     * Remove an header
     * @param string $header header to remove
     * @return Response same but without the header
     */
    public function without_header(string $header): Response;

    public function body(): string;

    public function status(): int;

    public function headers(): array;

    public function cookies(): Cookies;
}
