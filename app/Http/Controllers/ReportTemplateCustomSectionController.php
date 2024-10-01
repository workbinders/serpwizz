<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomSectionUpdateRequest;
use App\Http\Requests\ReportTemplateCustomSectionRequest;
use App\Http\Resources\ReportTemplateCustomSectionResourceCollection;
use App\Models\ReportTemplateCustomSection;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportTemplateCustomSectionController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $data = User::with('customSection')->find($request->user()->id);
            $response = new ReportTemplateCustomSectionResourceCollection($data->customSection);
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
    public function store(ReportTemplateCustomSectionRequest $request)
    {
        try {
            $user = Auth::user();
            $input = $request->all();
            $input['user_id'] = $user->id;
            $create = ReportTemplateCustomSection::create($input);
            if ($create) {
                $message = __('message.report_template_custom_section_success');
                return $this->sendResponse($message);
            } else {
                $message = __('message.report_template_custom_section_failed');
                return $this->sendError($message, [], []);
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
    public function update(CustomSectionUpdateRequest $request, string $id)
    {
        try {
            $input = $request->all();
            $input['user_id'] = Auth::user()->id;
            $model = ReportTemplateCustomSection::find($id);
            if (!$model) {
                $message = __('message.report_template_custom_section_id_failed_to_found');
                return $this->sendError($message);
            }
            $model->update($input);
            $message = __('message.report_template_custom_section_update_success');
            return $this->sendResponse($message);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $model = ReportTemplateCustomSection::find($id);
            if (!$model) {
                $message = __('message.report_template_custom_section_id_failed_to_found');
                return $this->sendError($message);
            }
            $model->delete();
            $message = __('message.report_template_custom_section_delete_success');
            return $this->sendResponse($message);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }
}
