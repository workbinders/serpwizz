<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Http\Resources\ReportTemplateResource;
use App\Models\ReportTemplate;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ReportTemplateController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $data = User::with('report')->find($request->user()->id);
            $response = new ReportTemplateResource($data);
            return $this->sendResponse('', $response);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReportRequest $request)
    {
        try {
            $user = Auth::user();
            if ($user) {
                $input = $request->all();
                $input[ReportTemplate::USER_ID] = $user->id;
                if ($request->company_logo) {
                    $slug = Str::slug($request->company_name);
                    $input['company_logo'] = $request->company_logo->storeAs("image/company_logo", $slug . ".jpg");
                }
                $createReport = ReportTemplate::query()->updateOrCreate(
                    [
                        'user_id' => $input['user_id'],
                    ],
                    [
                        'company_logo' => $input['company_logo'] ?? null,
                        'report_header_text' => $input['report_header_text'] ?? null,
                        'company_name' => $input['company_name'],
                        'company_email' => $input['company_email'] ?? null,
                        'company_website' => $input['company_website'] ?? null,
                        'company_phone' => $input['company_phone'] ?? null,
                        'company_address' => $input['company_address'],
                        'custom_title_status' => $input['custom_title_status'] ?? null,
                        'custom_title' => $input['custom_title'] ?? null,
                    ],
                );
                if ($createReport) {
                    $message = __('message.report_create_success');
                    return $this->sendResponse($message);
                }
            }
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
