<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FlespiController extends Controller
{
    public function handleData(Request $request)
    {
        $data = $request->all();

        // Check if tracker is moving
        if (isset($data['PositionSpeed']) && $data['PositionSpeed'] > 0) {
            // Process data for moving tracker
            Log::info('Tracker is moving:', $data);
        } else {
            // Skip processing for stationary tracker
            Log::info('Tracker is stationary:', $data);
        }

        return response()->json(['status' => 'success']);
    }
}
