<?php namespace Uit\Content\Components;

use Cms\Classes\ComponentBase;
use RainLab\User\Models\User;
use Uit\Userextend\Models\UserFields;
use Flash;
use Mail;

class ResetPassword extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'ResetPassword Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        if(get('code')){
            $userField = UserFields::where('code', get('code'))->first();
            if(is_null($userField)){
                Flash::error('Не верный код для потверждения!');
                return redirect()->to('auth');
            }
            $user = User::find($userField->user_id);
            $user->password = $userField->new_password;
            $user->password_confirmation = $userField->new_password;
            $user->save();
            $userField->delete();
            Flash::success('Ваш пароль сменен! Используйте новый пароль');
            return redirect()->to('auth');
        }
    }

    public function onResetPassword()
    {
        $email = post('email');
        $user = User::findByEmail($email);
        if(is_null($user)){
            Flash::error('Пользователь с таким E-mail не найден');
        }
        $password = str_random(8);
        $code = str_random(30);
        $oldUserField = UserFields::where('user_id', $user->id)->first();
        if(!is_null($oldUserField)){
            $oldUserField->delete();
        }
        $userField = new UserFields();
        $userField->new_password = $password;
        $userField->code = $code;
        $userField->user_id = $user->id;
        $userField->save();
        $params = [
            'password' => $password,
            'user' => $user,
            'link' => url('reset').'?code='.$code
        ];

        Mail::sendTo($user, 'uit.content::mail.reset', $params);

        Flash::success('Мы отправили вам пароль, с потверждением! Пожалуйста проверьте почту!');

        return;


    }
}
