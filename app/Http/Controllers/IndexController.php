<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        /** @var User|null $user */
        $user = Auth::user();
        $status = $request->query('status');
        $sort = $request->query('sort');
        $direction = $request->query('direction', 'asc');
        $search = $request->query('search');

        $tasks = $user
            ?$user->tasks()
                ->when($status, fn($query) => $query->where('status', $status))
                ->when($sort, fn($query) => $query->orderBy($sort, $direction))
                ->when($search, function($query) use ($search) {
                    $query->where(function($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                    });
                })
                ->get()
            : collect();

        return view('index', compact('tasks', 'status', 'sort', 'direction', 'search'));
    }
}
