<?php

namespace DataDome\FraudSdkSymfony\Models;

class LoginEvent extends DataDomeEvent
{
    public function __construct(string $account, StatusType $status = null)
    {
        if ($status === null) {
            $status = StatusType::Succeeded;
        }

        parent::__construct(ActionType::Login, $status, $account);
    }
}
