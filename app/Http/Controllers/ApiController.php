<?php

namespace App\Http\Controllers;

class ApiController {
    /**
     * Check connection
     *
     * @return Response
     */
    public function heartbeat() {
        return response()->json([], 204);
    }
}
