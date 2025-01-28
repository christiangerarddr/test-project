<?php

namespace App\Services;

use App\Mail\ProjectDueDateReminderMail;
use App\Models\Project;
use Illuminate\Support\Facades\Mail;

class ProjectDueReminderService
{
    /**
     * Create a new class instance.
     */
    public function sendProjectDueReminderMails(): void
    {
        $projects = Project::query()
            ->where('status', '!=', 'completed')
            ->where('due_date', '>=', now()->startOfDay())
            ->where('due_date', '<=', now()->endOfDay())
            ->get();

        // Loop through the projects and send an email
        foreach ($projects as $project) {
            Mail::to($project->team->owner->email)->send(new ProjectDueDateReminderMail($project));
        }
    }
}
