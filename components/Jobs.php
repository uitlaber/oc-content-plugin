<?php namespace Uit\Content\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\Input;
use Uit\Content\Models\Job;
use Validator;
use ValidationException;
use Event;
use Uit\Form\Models\Request as RequestModel;
use System\Models\File;

class Jobs extends ComponentBase
{
    public $jobs;

    public function componentDetails()
    {
        return [
            'name'        => 'Jobs Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $this->jobs = $this->loadJobs();
    }

    public function loadJobs()
    {
        return Job::published()->get();
    }

    public function onRespondJob()
    {
        $data = post();

        $form = \Uit\Form\Models\Form::findOrFail($data['form']);

        $rules = [];
        $fields = [];

        foreach ($form->fields as $field) {
            $rules[$field['name']] = $field['rule'];
            $fields[$field['name']] = $field['label'];
        }

        $messages = [
            'resume.required' => 'Пожалуйста прикрепите резюме'
        ];
        $validation = Validator::make(Input::all(), $rules, $messages, $fields);

        if ($validation->fails()) {
            throw new ValidationException($validation);
        }
        $content = [];
        $content['form'] = $form->name;


        foreach ($form->fields as $field){
            if(isset($data[$field['name']])){
                $content[$field['name']] = [
                    'label' => $field['label'],
                    'value' => $data[$field['name']]
                ];
            }
        }

        $data['url'] = request()->url();
        $data['ip'] = request()->ip();
        $data['roistat'] =  (isset($_COOKIE['roistat_visit']))?$_COOKIE['roistat_visit']:'неизвестно';
        $request = new RequestModel();
        $request->ip = $data['ip'];
        $request->url = $data['url'];
        $request->roistat = $data['roistat'];
        $request->content = $content;
        $request->save();

//        var_dump($request);

        if (session()->has('files') && is_array(session('files'))) {
            $request = RequestModel::find($request->id);
            $files = array_slice(session('files'), -5);
            foreach ($files as $file){
                $file = File::find($file);
                $request->files()->save($file);
            }
            session()->forget('files');
        }
        Event::fire('uit.forms.afterSaveRecordModel', [$data,$request]);

        $file = new File;
        $file->data = Input::file('resume');
        $file->is_public = true;
        $file->save();

        $request->files()->save($file);

        $popup_id = str_random(6);
        $popup_content = $form->success_text ;
        return [
            'success' => 1,
            '#scripts' =>  $this->renderPartial('@_popup', compact('popup_content','popup_id') )

        ];

    }
}
