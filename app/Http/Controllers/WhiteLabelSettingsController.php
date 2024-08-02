<?php

namespace App\Http\Controllers;

use App\Http\Requests\WhiteLabelSettingsRequest;
use App\Models\WhiteLabelSettings;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WhiteLabelSettingsController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(WhiteLabelSettingsRequest $request)
    {
        try {
            $user = Auth::user();
            if ($user) {
                $input = $request->all();
                $input['user_id'] = $user->id;
                if ($request->header_big_logo) {
                    $big_logo = $request->file('header_big_logo')->getClientOriginalName();
                    $input['header_big_logo'] = $request->header_big_logo->move('image/header_big_logo', $big_logo . $user->slug . 'big' . '.jpg');
                }
                if ($request->header_small_logo) {
                    $small_logo = $request->file('header_small_logo')->getClientOriginalName();
                    $input['header_small_logo'] = $request->header_small_logo->move('image/header_small_logo', $small_logo . $user->slug . 'small' . '.jpg');
                }
                if ($request->favicon_icon) {
                    $favicon_icon = $request->file('favicon_icon')->getClientOriginalName();
                    $input['favicon_icon'] = $request->favicon_icon->move('image/favicon_icon', $favicon_icon . $user->slug);
                }
                $create = $create = WhiteLabelSettings::updateOrCreate(
                    [
                        'user_id' => $input['user_id'],
                    ],
                    [
                        'domain_name' => $input['domain_name'],
                        'audit_report_title' => $input['audit_report_title'],
                        'header_big_logo' => $input['header_big_logo'] ?? null,
                        'header_small_logo' => $input['header_small_logo'] ?? null,
                        'favicon_icon' => $input['favicon_icon'] ?? null,
                    ]
                );
                if ($create) {
                    $message = __('message.white_label_settings_success');
                    return   $this->sendResponse($message);
                } else {
                    $message = __('message.white_label_settings_failed');
                    return $this->sendError($message);
                }
            }
        } catch (\Throwable $th) {
            return  $this->sendError($th->getMessage(), $th->getFile(), $th);
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
