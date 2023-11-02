<?php

namespace DataDome\FraudSdkSymfony\Models;

use Symfony\Component\HttpFoundation\Request;

class LoginBody extends Body
{
    public function __construct(Request $request, LoginEvent $dataDomeEvent, StatusType $defaultStatus)
    {
        $tempStatus = $dataDomeEvent->statusType;
        if ($tempStatus == StatusType::Undefined) {
            $tempStatus = $defaultStatus;
        }

        $this->status = $tempStatus->jsonSerialize();

        parent::__construct($request, $dataDomeEvent);
    }
}
