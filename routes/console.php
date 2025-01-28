<?php

use App\Services\ProjectDueReminderService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('send-project-due-reminder-mail', function (ProjectDueReminderService $dueReminderService) {
    $dueReminderService->sendProjectDueReminderMails();
})->daily();;
