<?php

use App\Console\Commands\ExpireSupportTimeCommand;
use Illuminate\Support\Facades\Schedule;

Schedule::command(ExpireSupportTimeCommand::class)
    ->hourly();
