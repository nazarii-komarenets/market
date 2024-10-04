<?php

namespace App\Http\Controllers;

use App\Http\Repositories\AdminRepository;
use App\Notifications\RequestNotification;
use App\Notifications\TelegramNotification;

class RequestNotificationController extends Controller
{
    protected AdminRepository $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function send(string $message): void
    {
        foreach ($this->getAdmins() as $admin) {
            $admin->notify(new RequestNotification($message));
        }
    }

    protected function getAdmins()
    {
        return $this->adminRepository->getAdminsWithTelegram();
    }
}
