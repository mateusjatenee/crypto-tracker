<?php

use App\Models\Team;

function team(): ?Team
{
    return auth()->user()?->currentTeam;
}
