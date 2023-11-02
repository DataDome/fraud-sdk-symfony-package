<?php

namespace DataDome\FraudSdkSymfony\Models;

class RegistrationEvent extends DataDomeEvent
{
    public User $user;
    public Session $session;

    public function __construct(string $account, StatusType $status, Session $session, User $user)
    {
        parent::__construct(ActionType::Registration, $status, $account);

        $this->session = $session;
        $this->user = $user;
    }
}
