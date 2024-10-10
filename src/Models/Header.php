<?php

namespace DataDome\FraudSdkSymfony\Models;

use Symfony\Component\HttpFoundation\Request;

/**
 * Names of the form fields in the Header object to be sent to the API.
 */
class Header
{
    /**
     * @var string|null The full list of headers in the user's request.
     */
    public ?string $headersList;
    /**
     * @var string|null The IP address from which the user is viewing the request.
     */
    public ?string $addr;
    /**
     * @var string|null Request content-type.
     */
    public ?string $contentType;
    /**
     * @var string|null The Host request-header field specifies the Internet host.
     */
    public ?string $host;
    /**
     * @var int|null IP port of the TCP/IP connection originating the request (from the final client).
     */
    public ?int $port;
    public ?string $xRealIp;
    /**
     * @var string|null HTTP extension header field that allows is used to disclose information about the
     * client that initiated the request and subsequent proxies in a chain of proxies.
     */
    public ?string $xForwardedForIp;
    /**
     * @var string|null The Accept-Encoding request-header field. Is similar to Accept, but restricts the
     * content-codings that are acceptable in the response.
     */
    public ?string $acceptEncoding;
    /**
     * @var string|null The Accept-Language request-header field. Is similar to Accept, but restricts the
     * set of natural languages that are preferred as a response to the request.
     */
    public ?string $acceptLanguage;
    /**
     * @var string|null The Accept request-header field. Can be used to specify certain media types which are
     * acceptable for the response.
     */
    public ?string $accept;
    /**
     * @var string|null HTTP method (GET/POST/OPTION).
     */
    public ?string $method;
    /**
     * @var string|null This is a scheme part of the Request-URI (HTTP or HTTPS).
     */
    public ?string $protocol;
    /**
     * @var string|mixed|null The virtualhost.
     */
    public ?string $serverHostname;
    /**
     * @var string|null The Referer request-header field allows that the client to specify.
     */
    public ?string $referer;
    /**
     * @var string|null The User-Agent request-header field, containing information about the user agent.
     */
    public ?string $userAgent;
    public ?string $from;
    /**
     * @var string|null This is a path and query part of the Request-URI.
     */
    public ?string $request;
    /**
     * @var string|null The Origin request header indicates where a fetch originates from. It doesn't include
     * any path information, but only the server name. It is sent with CORS requests, as well
     * as with POST requests. It is similar to the Referer header, but, unlike this header,
     * it doesn't disclose the whole path.
     */
    public ?string $origin;
    /**
     * @var string|null The Accept-Charset request-header field. Can be used to indicate what character sets
     * are acceptable for the response.
     */
    public ?string $acceptCharset;
    /**
     * @var string|null The Connection general header controls whether or not the network connection stays
     * open after the current transaction finishes. If the value sent is keep-alive, the
     * connection is persistent and not closed, allowing for subsequent requests to the same
     * server to be done.
     */
    public ?string $connection;
    /**
     * @var string|null Custom client identifier.
     */
    public ?string $clientId;

    public function __construct(Request $request)
    {
        $this->headersList = implode(',', $request->headers?->keys() ?? []);

        $this->accept = $request->headers?->get('Accept');
        $this->acceptCharset = $request->headers?->get('Accept-Charset');
        $this->acceptEncoding = $request->headers?->get('Accept-Encoding');
        $this->acceptLanguage = $request->headers?->get('Accept-Language');
        $this->xRealIp = $request->headers?->get('X-Real-IP');
        $this->xForwardedForIp = $request->headers?->get('X-Forwarded-For');
        $this->referer = $request->headers?->get('Referer');
        $this->userAgent = $request->headers?->get('User-Agent');
        $this->from = $request->headers?->get('From');
        $this->origin = $request->headers?->get('Origin');
        $this->connection = $request->headers?->get('Connection');

        $this->contentType = $request->getContentTypeFormat();
        $this->method = $request->getMethod();
        $this->addr = $request->getClientIp();
        $this->port = $request->getPort();
        $this->protocol = $request->getProtocolVersion();
        $this->request = $request->getRequestUri();
        $this->host = $request->getHost();
        $this->serverHostname = $_SERVER['SERVER_NAME'] ?? '';

        $clientIdHeader = $request->headers?->get('x-datadome-clientid');
        $dataDomeCookie = $request->cookies?->get('datadome');
        $this->clientId = $clientIdHeader ?? $dataDomeCookie;

        // Header truncation as required by DataDome: https://docs.datadome.co/reference/validate-request#size-limits-for-payload-fields
        foreach ($this as $propertyName => $propertyValue) {
            if (is_string($propertyValue)) {
                $maxLength = ApiLimits::GetLimit($propertyName);

                if ((strlen($propertyValue) > $maxLength) && ($maxLength != -1)) {
                    if ($propertyName == 'xForwardedForIp') {
                        $this->$propertyName = substr($propertyValue, -$maxLength);
                    } else {
                        $this->$propertyName = substr($propertyValue, 0, $maxLength);
                    }
                }
            }
        }
    }
}
