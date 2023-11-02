<?php

namespace DataDome\FraudSdkSymfony\Models;

class ApiLimits
{
    const UnlimitedFields = ["key", "apiconnectionstate", "authorizationlen", "cookieslen", "ip", "method", "moduleversion", "port", "postparamlen", "protocol", "requestmodulename", "timerequest"];
    const Limit16Fields = ["secchuaarch"];
    const Limit32Fields = ["secchuaplatform", "secfetchdest", "secfetchmode"];
    const Limit64Fields = ["contenttype", "secfetchsite"];
    const Limit128Fields = ["secchdevicememory", "secchuamobile", "secfetchuser", "acceptcharset", "acceptencoding", "cachecontrol", "clientid", "connection", "pragma", "secchua", "secchuamodel", "trueclientip", "xrealip", "xrequestedwith"];
    const Limit256Fields = ["acceptlanguage", "secchuafullversionlist", "via"];
    const Limit512Fields = ["accept", "headerslist", "host", "origin", "serverhostname", "servername", "xforwardedforip"];
    const Limit768Fields = ["useragent"];
    const Limit1024Fields = ["referer"];
    const Limit2048Fields = ["request"];

    static function GetLimit($key): int
    {
        $key = strtolower($key);

        if (in_array($key, ApiLimits::UnlimitedFields)) {
            return PHP_INT_MAX; // Unlimited
        } elseif (in_array($key, ApiLimits::Limit16Fields)) {
            return 16;
        } elseif (in_array($key, ApiLimits::Limit32Fields)) {
            return 32;
        } elseif (in_array($key, ApiLimits::Limit64Fields)) {
            return 64;
        } elseif (in_array($key, ApiLimits::Limit128Fields)) {
            return 128;
        } elseif (in_array($key, ApiLimits::Limit256Fields)) {
            return 256;
        } elseif (in_array($key, ApiLimits::Limit512Fields)) {
            return 512;
        } elseif (in_array($key, ApiLimits::Limit768Fields)) {
            return 768;
        } elseif (in_array($key, ApiLimits::Limit1024Fields)) {
            return 1024;
        } elseif (in_array($key, ApiLimits::Limit2048Fields)) {
            return 2048;
        } else {
            return -1; // Default
        }
    }
}
