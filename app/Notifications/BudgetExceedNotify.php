<?php

namespace App\Notifications;

use App\Models\Budget;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class BudgetExceedNotify extends Notification
{
    use Queueable;

    protected $budget;

    public function __construct(Budget $budget)
    {
        $this->budget = $budget;
    }

    // Channels to send notification
    public function via($notifiable)
    {
        return ['mail', 'database']; // email + database notifications
    }

    // Email version
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Budget Exceeded Alert')
            ->line("Your budget for {$this->budget->category->name} in {$this->budget->month} {$this->budget->year} has been exceeded!")
            ->line("Planned: {$this->budget->planned_budget}, Spent: {$this->budget->spent_budget}");
    }

    // Database version (optional)
    public function toDatabase($notifiable)
    {
        return [
            'budget_id' => $this->budget->budget_id,
            'category' => $this->budget->category->name,
            'month' => $this->budget->month,
            'year' => $this->budget->year,
            'planned' => $this->budget->planned_budget,
            'spent' => $this->budget->spent_budget,
            'message' => 'Your budget has been exceeded!',
        ];
    }
}
