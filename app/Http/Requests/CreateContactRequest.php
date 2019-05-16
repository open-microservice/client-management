<?php

namespace App\Http\Requests;

use App\Exceptions\FormPersistanceException;
use App\Models\Contact;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class CreateContactRequest extends FormRequest implements Persistable
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

    public function persist()
    {
        try {
            DB::beginTransaction();
            $contact = Contact::create($this->all());
            DB::commit();

            return $contact;
        } catch(\Exception $e) {
            throw new FormPersistanceException();
        }
    }
}
