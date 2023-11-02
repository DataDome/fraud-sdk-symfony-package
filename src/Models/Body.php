<?php

namespace DataDome\FraudSdkSymfony\Models;

use Symfony\Component\HttpFoundation\Request;

abstract class Body
{
    /**
     * @var string User account (mail address, username, alias, login, ...).
     */
    public string $account;
    public Module $module;
    public Header $header;
    public string $event;
    public string $status;

    public function __construct(Request $request, DataDomeEvent $dataDomeEvent) {
        $this->account = $dataDomeEvent->account;
        $this->event = $dataDomeEvent->actionType->jsonSerialize();
        $this->header = new Header($request);
        $this->module = new Module();
    }
}
