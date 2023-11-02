<?php

namespace DataDome\FraudSdkSymfony\Models;

abstract class DataDomeEvent
{
    public ActionType $actionType;
    public StatusType $statusType;
    public string $account;

    public function __construct(ActionType $actionType, StatusType $status, string $account)
    {
        $this->actionType = $actionType;
        $this->statusType = $status;
        $this->account = $account;
    }
}
