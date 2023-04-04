<?php

namespace App\Http\Traits;

trait ApiResponse {

    protected function success($data, $status = 200) {
        return response(['success' => true, 'error' => (object)[], 'data' => $data], $status);
    }

    protected function error($error, $status = 403) {
        return response(['sucess' => false, 'error' => $error, 'data' => (object)[]], $status);
    }
}
