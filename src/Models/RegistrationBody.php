<?php

namespace DataDome\FraudSdkSymfony\Models;

use Symfony\Component\HttpFoundation\Request;

class RegistrationBody extends Body
{
    public Session $session;
    public User $user;

    public function __construct(Request $request, RegistrationEvent $dataDomeEvent)
    {
        $tempStatus = $dataDomeEvent->statusType;
        if ($tempStatus == StatusType::Undefined) {
            $tempStatus = StatusType::Succeeded;
        }

        $this->status = $tempStatus->jsonSerialize();
        $this->session = $dataDomeEvent->session;
        $this->user = $dataDomeEvent->user;

        parent::__construct($request, $dataDomeEvent);
    }
}
