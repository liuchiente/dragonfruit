<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HealthController extends Controller
{
    // Health check method
    public function checkHealth(Request $request)
    {
        $data = [
            'uptime' => time() - $_SERVER['REQUEST_TIME'], // Get the server uptime
            'message' => 'Ok',
            'date' => Carbon::now()->toDateTimeString(),
        ];

        try {
            return response()->json($data, 200);  // Return 200 OK status with data
        } catch (\Exception $e) {
            // If an error occurs, log the error and send a 503 service unavailable response
            $data['message'] = $e->getMessage();
            return response()->json($data, 503);
        }
    }
}
