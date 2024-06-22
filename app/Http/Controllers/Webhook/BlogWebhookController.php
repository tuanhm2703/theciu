<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogWebhookController extends Controller
{
    public function webhook() {
        return response()->json([
            'message' => 'success'
        ]);
    }
}
