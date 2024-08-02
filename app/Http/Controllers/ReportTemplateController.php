<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Models\ReportTemplate;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ReportTemplateController extends Controller
{
    use ApiResponse;
    public function create(ReportRequest $request)
    {
        try {
            $user = Auth::user();
            if ($user) {
                $input = $request->all();
                $input[ReportTemplate::USER_ID] = $user->id;
                if ($request->company_logo) {
                    $$request->file('company_logo')->store('images/company_logo');
                    $slug = Str::slug($request->company_name);
                    $input['company_logo'] = $request->company_logo->move("image/company_logo/", $slug . ".jpg");
                }
                $createReport = ReportTemplate::create($input);
                if ($createReport) {
                    $message = __('message.report_create_success');
                    return $this->sendResponse($message);
                }
            }
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }
}
