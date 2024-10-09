<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Traits\ApiResponse;
use App\Traits\Tools;
use App\Http\Requests\LeadRequest;
use App\Http\Resources\LeadCollection;
use App\Http\Resources\LeadListCollection;

class LeadsController extends Controller
{
    use ApiResponse, Tools;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $leads = Lead::where('user_id', request()->user()->id)->orderBy('id', 'desc')->paginate(20);
            return $this->sendResponse('', [
                'leads' => new LeadListCollection($leads)
            ]);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LeadRequest $request)
    {
        try {
            $lead = Lead::create([
                ...$request->validated(),
                'website' => $this->getHost($request->website),
                'user_id' => $request->user()->id
            ]);

            return $this->sendResponse("Lead stored successfully.", [
                'lead' => $lead
            ]);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        try {
            return $this->sendResponse("", [
                'lead' => $lead
            ]);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(LeadRequest $request, Lead $lead)
    {
        try {
            $lead->update([...$request->validated(), 'website' => $this->getHost($request->website),]);
            return $this->sendResponse("Lead updated successfully.", [
                'lead' => $lead->refresh()
            ]);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        try {
            $lead->delete();
            return $this->sendResponse("Lead deleted successfully.");
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), $th->getFile(), $th);
        }
    }
}
