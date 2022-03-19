<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Contact;
use App\Models\Phone;
use Exception;
use Illuminate\Support\Facades\DB;

class ContactService {

    public function list(string $search):array {
        return Contact::
            where('name', 'like', "%{$search}%")
            ->orWhere('lastname', 'like', "%{$search}%")
            ->orWhereExists(function($query) use ($search) {
                $query
                ->select(DB::raw(1))
                ->from('phones')
                ->whereColumn('phones.contactId', 'contacts.id')
                ->where('phoneNumber', 'like', "%{$search}%");
            })
            ->get()
            ->map(
                function(Contact $contact) {
                    $contact->addresses = $contact->addresses()->get();
                    $contact->phones = $contact->phones()->get();
                    return $contact;
                }
            )
            ->toArray();
    }

    public function save(array $contactData): Contact{
        @[
            'name'      => $name,
            'lastname'  => $lastname,
            'phones'    => $phones,
            'addresses' => $addresses
        ] = $contactData;

        $contact = new Contact([
            'name'     => $name,
            'lastname' => $lastname
        ]);
        try{
            DB::beginTransaction();
            
            $contact->save();
    
            $contact->phones = $this->savePhones($contact->id, $phones);
            $contact->addresses = $this->saveAddresses($contact->id, $addresses);
            DB::commit();
            return $contact;
        }catch(Exception $e){
            DB::rollBack();
            throw new Exception('Error saving contacts');
        }
    }

    private function saveAddresses(int $contactId, array $addresses): array {
        $savedAddresses = [];
        foreach($addresses as $address){
            $addressModel = new Address([
                'address'   => $address,
                'contactId' => $contactId
            ]);
            $addressModel->save();
            $savedAddresses[] = $addressModel;
        }
        return $savedAddresses;
    }
    private function savePhones(int $contactId, array $phones): array {
        $savedPhones = [];
        foreach($phones as $phone){
            $phoneModel = new Phone([
                'phoneNumber' => $phone,
                'contactId'   => $contactId
            ]);
            $phoneModel->save();
            $savedPhones[] = $phoneModel;
        }
        return $savedPhones;
    }
}