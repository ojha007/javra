<?php


namespace App\Http\Responses;


use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SuccessResponse implements Responsable
{

    protected $data;
    protected $path;

    public function __construct($path = null, $data = null)
    {
        $this->data = $data;
        $this->path = $path;
    }

    public function toResponse($request)
    {
        if ($this->path) {
            if (view()->exists($this->path)) {
                return view($this->path)
                    ->with($this->data);
            }
            if (Route::has($this->path)) {
                return redirect()->route($this->path)
                    ->with($this->data);
            }
        }
        return redirect()
            ->back()
            ->with('success', 'Success.');
    }
}
