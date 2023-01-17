<?php

namespace App\Http\Controllers\Api;

use App\Models\Plant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
	public function getUserPlants(Request $request)
	{
		$userPlants = Plant::whereHas(
			'userPlants',
			function ($q) {
				$authUser = Auth::user();
				$q->where('user_id', $authUser->id);
			}
		)->get();

		return response()->json(['data' => $userPlants]);
	}
}
