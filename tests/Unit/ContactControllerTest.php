<?php

namespace Tests\Unit;

use App\Http\Controllers\ContactController;
use App\Http\Requests\ListRequest;
use App\Http\Requests\SaveRequest;
use App\Models\Contact;
use App\Services\ContactService;
use Illuminate\Http\JsonResponse;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ContactControllerTest extends TestCase
{   
    private MockObject $service;
    private ContactController $controller;

    public function setUp(): void {
        $this->service = $this->createMock(ContactService::class);
        $this->controller = new ContactController($this->service);
    }
   
    public function test_debe_llamar_el_metodo_list_del_servicio_y_devolver_un_json_response()
    {
        $this->service->method('list')->willReturn([]);
        $this->service->expects($this->once())->method('list')->with('test');
        $request = new ListRequest(['search' => 'test']);

        $response = $this->controller->list($request);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals([], $response->getData());
        $this->assertEquals(200, $response->getStatusCode());

    }

    public function test_debe_llamar_el_metodo_save_del_servicio_y_devovel_un_json_response()
    {
        $data = [
            'name'      => 'test',
            'lastname'  => 'test',
            'phones'    => ['test'],
            'addresses' => ['test']
        ];
        $contact = new Contact();
        $contact->name = 'test';
        $contact->lastname = 'test';
        $contact->phones = ['test'];
        $contact->addresses = ['test'];

        $this->service->method('save')->willReturn($contact);
        $this->service->expects($this->once())->method('save')->with($data);
        $request = new SaveRequest($data);

        $response = $this->controller->save($request);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals((object)$data, $response->getData());
        $this->assertEquals(201, $response->getStatusCode());
    }
}
