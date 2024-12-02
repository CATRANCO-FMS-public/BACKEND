<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Events\FlespiDataReceived;

class FlespiController extends Controller
{
    public function handleData(Request $request)
    {
        $data = $request->all();

        if (isset($data['PositionSpeed']) && $data['PositionSpeed'] > 0) {
            Log::info('Tracker is moving:', $data);
        } else {
            Log::info('Tracker is stationary:', $data);
        }

        // Broadcast the data to the frontend
        broadcast(new FlespiDataReceived($data));

        return response()->json(['status' => 'success']);
    }
}
