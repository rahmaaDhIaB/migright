<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(title="Migright Api", version="1.0")
 * @OA\Server(
 *     description="Migright Staging Server",
 *     url="https://migright.envast.tn/api/"
 * )
 * @OA\Server(
 *     description="Hr local Server",
 *     url="http://127.0.0.1:8000/api/"
 * )
 */
abstract class Controller
{
    /**
     * Partners may only act on decisions assigned to them; admins may act on any.
     */
    protected function authorizeDecisionAccess(\App\Models\PartnerDecision $partnerDecision): void
    {
        $user = auth('web')->user();

        if (!$user->is_admin && $partnerDecision->user_id !== $user->id) {
            abort(403);
        }
    }
}
