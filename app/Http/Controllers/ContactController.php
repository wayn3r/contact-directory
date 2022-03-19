<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListRequest;
use App\Http\Requests\SaveRequest;
use App\Services\ContactService;
use Exception;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    private ContactService $service;

    public function __construct(ContactService $service){
        $this->service = $service;
    }

    public function list(ListRequest $request): JsonResponse {
        return new JsonResponse($this->service->list($request->search ?? ''), 200);
    }

    public function save(SaveRequest $request): JsonResponse {

        try{
            $contact = $this->service->save([
                'name'      => $request->name,
                'lastname'  => $request->lastname ?? '',
                'phones'    => $request->phones,
                'addresses' => $request->addresses ?? []
            ]);
            return new JsonResponse($contact, 201);
        }catch(Exception $e){
            return new JsonResponse(['message' => $e->getMessage()], 500);
        }
    }
}
