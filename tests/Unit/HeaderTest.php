<?php

namespace DataDome\FraudSdkSymfony\Tests\Unit;

use DataDome\FraudSdkSymfony\Models\Header;
use DataDome\FraudSdkSymfony\Tests\Unit\Mocks\MockRequest;
use PHPUnit\Framework\TestCase;

class HeaderTest extends TestCase
{
    public function testConstructor()
    {
        $requestMock = MockRequest::getValidMockRequest();

        $header = new Header($requestMock);

        $this->assertSame("accept,accept-charset,accept-encoding,accept-language,x-real-ip,x-forwarded-for,referer,user-agent,from,origin,connection,content-type", $header->headersList);
        $this->assertSame("application/json", $header->accept);
        $this->assertSame("utf-8", $header->acceptCharset);
        $this->assertSame("gzip", $header->acceptEncoding);
        $this->assertSame("en-US", $header->acceptLanguage);
        $this->assertSame("127.0.0.1", $header->xRealIp);
        $this->assertSame("127.0.0.1", $header->xForwardedForIp);
        $this->assertSame("http://example.com", $header->referer);
        $this->assertSame("PHPUnit User Agent", $header->userAgent);
        $this->assertSame("info@example.com", $header->from);
        $this->assertSame("http://example.com", $header->origin);
        $this->assertSame("keep-alive", $header->connection);
        $this->assertSame("json", $header->contentType);
        $this->assertSame("POST", $header->method);
        $this->assertSame("127.0.0.1", $header->addr);
        $this->assertSame(80, $header->port);
        $this->assertSame("HTTP/1.1", $header->protocol);
        $this->assertSame("/example", $header->request);
        $this->assertSame("localhost", $header->host);
        $this->assertSame("serverName", $header->serverHostname);
        $this->isNull($header->clientId);
    }
    
    public function testHeaderTruncation()
    {
        $requestMock = MockRequest::getValidMockRequest();
        $requestMock->headers->set("Accept", "o4c5pn5h589et3skiv44awph866ltdz5l9ns879q09z0v6ftjevnmor9futsms9mm08fj3o6o2t7hb6dk2lld6l74ilkk3ldsmuczizfcidi4i6lgnn0zb304gxx39szmbgx2t3go5cituo3jtyo426u9cpiebglfcbb5dp4hhqdc9ivjrx3f6f0bvex0bm3nxexlqb7ge7n7a0ciltq2kkg3bbpffjwk7yey2ggvvbb52nvxuiwqu3z7qti4rvwe8idsere12t8ro55b9fmenk0kkkw78ltyimpdl3ghr2pua69dox43gy4hzpfbn2tssso6sfkiutb9dczm0i8ffejztadh7l8vx5ipr7fz8oe7nelf6rh6kgw4swfs34ky3waoqv4am2sm26pynlyjttk8d4pv7debg30vs9p0oqdau5032on3fc2bxc5ax4eb90cx80gknjgrahbm6h4fi8ijj2798jc1ysm81eb507yvaeqmm4tuzn8bgnci608o4c5pn5h589et3skiv44awph866ltdz5l9ns879q09z0v6ftjevnmor9futsms9mm08fj3o6o2t7hb6dk2lld6l74ilkk3ldsmuczizfcidi4i6lgnn0zb304gxx39szmbgx2t3go5cituo3jtyo426u9cpiebglfcbb5dp4hhqdc9ivjrx3f6f0bvex0bm3nxexlqb7ge7n7a0ciltq2kkg3bbpffjwk7yey2ggvvbb52nvxuiwqu3z7qti4rvwe8idsere12t8ro55b9fmenk0kkkw78ltyimpdl3ghr2pua69dox43gy4hzpfbn2tssso6sfkiutb9dczm0i8ffejztadh7l8vx5ipr7fz8oe7nelf6rh6kgw4swfs34ky3waoqv4am2sm26pynlyjttk8d4pv7debg30vs9p0oqdau5032on3fc2bxc5ax4eb90cx80gknjgrahbm6h4fi8ijj2798jc1ysm81eb507yvaeqmm4tuzn8bgnci608");

        $header = new Header($requestMock);

        $this->assertSame("o4c5pn5h589et3skiv44awph866ltdz5l9ns879q09z0v6ftjevnmor9futsms9mm08fj3o6o2t7hb6dk2lld6l74ilkk3ldsmuczizfcidi4i6lgnn0zb304gxx39szmbgx2t3go5cituo3jtyo426u9cpiebglfcbb5dp4hhqdc9ivjrx3f6f0bvex0bm3nxexlqb7ge7n7a0ciltq2kkg3bbpffjwk7yey2ggvvbb52nvxuiwqu3z7qti4rvwe8idsere12t8ro55b9fmenk0kkkw78ltyimpdl3ghr2pua69dox43gy4hzpfbn2tssso6sfkiutb9dczm0i8ffejztadh7l8vx5ipr7fz8oe7nelf6rh6kgw4swfs34ky3waoqv4am2sm26pynlyjttk8d4pv7debg30vs9p0oqdau5032on3fc2bxc5ax4eb90cx80gknjgrahbm6h4fi8ijj2798jc1ysm81eb507yvaeqmm4tuzn8bgnci608", $header->accept);
    }
}
