<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;

Route::view('/', 'welcome');
Route::view('docs', 'docs')->name('docs');

Route::get('dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('dashboard/sandbox-query', function (Request $request) {
    $endpoint = $request->query('endpoint');
    $params = $request->query('params', '');
    $simulateUnauthorized = filter_var($request->query('unauthorized', false), FILTER_VALIDATE_BOOLEAN);
    
    parse_str($params, $paramsArray);
    
    if (!$simulateUnauthorized) {
        Sanctum::actingAs(auth()->user());
    }
    
    $subRequest = Request::create($endpoint, 'GET', $paramsArray);
    $subRequest->headers->set('Accept', 'application/json');
    
    try {
        $response = app()->handle($subRequest);
        $body = json_decode($response->getContent(), true) ?: $response->getContent();
        
        return response()->json([
            'status' => $response->getStatusCode(),
            'body' => $body,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 500,
            'body' => ['error' => $e->getMessage()],
        ]);
    }
})->middleware(['auth', 'verified'])->name('dashboard.sandbox-query');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');
    
    // User Management
    Route::resource('users', App\Http\Controllers\Admin\UserManagementController::class);
    
    // Activity Logs
    Route::get('activities', [App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activities.index');
    Route::get('activities/{activity}', [App\Http\Controllers\Admin\ActivityLogController::class, 'show'])->name('activities.show');
});

// Logout Route
Route::post('/logout', function () {
    Illuminate\Support\Facades\Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->middleware('auth');

require __DIR__.'/auth.php';
