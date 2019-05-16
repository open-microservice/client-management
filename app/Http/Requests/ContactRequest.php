<?php

namespace App\Http\Requests;

use App\Exceptions\FormPersistanceException;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class ContactRequest extends FormRequest implements Persistable
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function persist(Model $record = null)
    {
        try {
            DB::beginTransaction();
                if ($record) {
                    $contact = $this->updateRecord($record);
                } else {
                    $contact = $this->createRecord();
                }
            DB::commit();

            return $contact;
        } catch(\Exception $e) {
            throw new FormPersistanceException();
        }
    }

    private function updateRecord(Contact $contact)
    {
        $contact->update($this->all());

        return $contact;
    }

    private function createRecord()
    {
        return Contact::create($this->all());
    }
}
