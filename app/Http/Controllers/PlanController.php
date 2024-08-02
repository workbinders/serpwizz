<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlanResourceCollection;
use App\Models\Plan;
use App\Traits\ApiResponse;

class PlanController extends Controller
{
    use ApiResponse;

    //Plans Get
    public function index()
    {
        try {
            $plans = Plan::with('features')->orderBy('ordering')->get();
            if ($plans) {
                $response = new PlanResourceCollection($plans);
                return $this->sendResponse('', $response);
            } else {
                $message = __('message.is_empty');
                return $this->sendError($message);
            }
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }
}
