<?
use Illuminate\Support\Facades\Route;
Route::get('/test', function () {
    return view('test');
});
Route::post('/test', function (\Illuminate\Http\Request $request) {
    // Chỉ đơn giản return dữ liệu để test
    return redirect('/');
});