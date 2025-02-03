<?php
namespace App\Services;

use App\Http\Repositories\UserRepository;
use App\Models\ImprovementRequest;
use App\Models\User;
use App\Notifications\ImprovementRequestNotification;
use Illuminate\Support\Facades\Log;

class ImprovementRequestsService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function sendNotification(ImprovementRequest $improvementRequest): void
    {
        try {
            $user = $this->userRepository->getById($improvementRequest->user_id);

            if (!$user) {
                Log::warning("User not found for order ID: {$improvementRequest->id}");
                return;
            }

            $this->notifyUser($user, $improvementRequest);

            Log::info("Order notification sent successfully for order ID: {$improvementRequest->id}");
        } catch (\Throwable $e) {
            Log::error("Failed to send order notification", [
                'order_id' => $improvementRequest->id ?? null,
                'message'  => $e->getMessage(),
                'trace'    => $e->getTraceAsString(),
            ]);
        }
    }

    private function notifyUser(User $user, ImprovementRequest $improvementRequest): void
    {
        $user->notify(new ImprovementRequestNotification($improvementRequest));
    }
}
