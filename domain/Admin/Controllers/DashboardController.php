<?php

namespace Domain\Admin\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        $ordersWaitingForReview = OrderService::adminIndex(orderStatusType: OrderStatusType::REVIEW_TECHNICAL_DRAWING, perPage: 3);
        $ordersWaitingForShipment = OrderService::adminIndex(orderStatusType: OrderStatusType::IN_PROCESS, perPage: 3);

        return Inertia::render('Admin/Dashboard', [
            'ordersWaitingForReview' => $ordersWaitingForReview,
            'ordersWaitingForShipment' => $ordersWaitingForShipment,
        ]);
    }
}
