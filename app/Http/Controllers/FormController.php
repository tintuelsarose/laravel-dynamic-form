<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forms;
use App\Models\FormAttributes;
use App\Models\FormData;
use App\Models\FieldAttributes;
use DB;
use App\Jobs\SendNotificationEmail;

class FormController extends Controller
{
    //Manage Form
    public function index()
    {
        $data = Forms::where(['active' => 1])->paginate(50);

        return view('forms.list-form', compact('data'));
    }

    //Load Resources
    public function create()
    {

        //return view('forms.list-form');
    }

    //Store Form Name
    public function saveFormName(Request $request)
    {
        $data = [
            'form_name' => $request->form_name
        ];
        DB::beginTransaction();

        try {
            $formData = Forms::create($data);
            DB::commit();

            return redirect()->route('form.add-attributes', ['id' => $formData->id]);
        } catch (\Exception $e) {
            DB::rollback();

            redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function addFormAttributes($idForm)
    {
        $formData = Forms::find($idForm);

        return view('forms.list-created-form', compact('formData'));
    }

    //Store Form Attributes
    public function saveFormAttributes(Request $request)
    {
        $data = [
            'name' => $request->name,
            'label' => $request->label,
            'type' => $request->type,
            'id_forms' => $request->id_form
        ];

        DB::beginTransaction();

        try {

            $formAttribute = FormAttributes::create($data);
            if ($request->type == 'select') {
                $options = [];

                foreach ($request->option_value as $key => $value) {
                    $options[] = [
                        'label' => $value,
                        'value' => $request->option_name[$key] ?? null,
                        'id_form_attributes' => $formAttribute->id
                    ];
                }
                if (!empty($options)) {
                    FieldAttributes::insert($options);
                }
            }
            DB::commit();

            return redirect()->back()->with('success', 'Attribute Added Successfully.');
        } catch (\Exception $e) {
            DB::rollback();

            redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    
    public function showForm($idForm)
    {
        $data = Forms::with('getFormAttributes')->find($idForm);
        $formAttributes = $data->getFormAttributes()->get();

        return view('forms.show-form', compact('data', 'formAttributes'));
    }

    public function testQueue(Request $request)
    {
        $emailDetails = [
            'email' => 'test@test.com',
        ];
        dispatch(new SendNotificationEmail($emailDetails));
    }

    public function submitForm(Request $request)
    {
        $formAttribute = FormAttributes::where('id_forms', $request->id_form)->get();
        foreach ($formAttribute as $attribute) {
            if ($attribute->name == 'email') {
                $email = $request->{$attribute->name};
            }
            $data[] = [
                'id_forms' => $request->id_form,
                'id_field_attributes' => $attribute->id,
                'field_value' => $request->{$attribute->name}
            ];
        }

        DB::beginTransaction();

        try {
            FormData::insert($data);

            DB::commit();
            $this->sendEmailNotification($email);
            \Session::flash('message', "Form Submitted Successfully");
            return redirect()->to("/");
            // return redirect()->back()->with('success', 'Form Submitted Successfully.');
        } catch (\Exception $e) {
            DB::rollback();

            // redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    private function sendEmailNotification($email)
    {
        $emailDetails = [
            'email' => $email ?? 'test@test.com',
        ];
        dispatch(new SendNotificationEmail($emailDetails));
    }

    public function editFormAttributes($id)
    {
        $formAttributes = FormAttributes::join('forms', 'forms.id', 'form_attributes.id_forms')
            ->where('form_attributes.id', $id)
            ->select('form_attributes.*', 'forms.form_name')
            ->first();
        return view('forms.edit-form-attributes', compact('formAttributes'));
    }

    public function updateAttributes(Request $request)
    {
        $existingFieldAttributes = FieldAttributes::where('id_form_attributes', $request->id_form_attribute)->get();
        
        $data = [
            'name' => $request->name,
            'label' => $request->label,
            'type' => $request->type
        ];

        DB::beginTransaction();

        try {
            FormAttributes::where(['id_forms' => $request->id_form, 'id' => $request->id_form_attribute])->update($data);
            if ($request->type == 'select') {
                $options = [];
                foreach ($request->option_value as $key => $value) {
                    if ($key != null && $value != null) {
                        $options = [
                            'label' => $value,
                            'value' => $request->option_name[$key] ?? null,
                            'id_form_attributes' => $request->id_form_attribute
                        ];

                    }
                    if (!empty($options)) {
                        if(FieldAttributes::find($key)) {
                            FieldAttributes::where(['id' => $key, 'id_form_attributes' => $request->id_form_attribute])->update($options);
                        } else {
                            FieldAttributes::create($options);
                        }
                    }
                }
            } else {
                if ($existingFieldAttributes->isNotEmpty()) {
                    foreach($existingFieldAttributes as $key => $fieldValue) {
                        FieldAttributes::where(['id' => $fieldValue->id, 'id_form_attributes' => $fieldValue->id_form_attributes])->delete();
                    }
                }
            }
            DB::commit();

            \Session::flash('message', "Attributes updated Successfully");
            return redirect()->to("/form/$request->id_form/add-attributes");
        } catch (\Exception $e) {
            DB::rollback();

            \Session::flash('message', "Something went wrong!");
            return redirect()->to("/form/$request->id_form/add-attributes");
        }
    }

    public function deleteAttributes(Request $request)
    {
        $idForm = FormAttributes::find($request->id)->id_forms;
        
        DB::beginTransaction();
        try {
            FormAttributes::where(['id_forms' => $idForm, 'id' => $request->id])->delete();

            FieldAttributes::where('id_form_attributes', $request->get('id'))->delete();
            DB::commit();

            \Session::flash('message', "Attributes deleted Successfully");
            return redirect()->to("/form/$idForm/add-attributes");

        } catch (\Exception $e) {
            DB::rollback();

            \Session::flash('message', "Something went wrong!");
            return redirect()->to("/form/$request->id_form/add-attributes");
        }
    }
}
