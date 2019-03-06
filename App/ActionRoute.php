<?php
/**
 * Created by PhpStorm.
 * User: shakidevcom
 * Date: 3/6/19
 * Time: 1:48 PM
 */

namespace App;

use App\Models\Models;
use App\Traits\collect;

/**
 * Маршрут и контроллер
 * Class ActionRoute
 * @package App
 */
class ActionRoute
{

    use collect;
    protected $request;
    protected $models;
    private $action;
    private $modules = null;

    /**
     * Исходя от ссылки используем нужный метод, немного рушится принцип открытости и закрытости, для быстрой реализации маршрутов÷ был реализован, без генерации линков
     * ActionRoute constructor.
     * @param Request $r
     */
    public function __construct(Request $r)
    {
        $this->request = $r;
        $this->models = new Models();
        $this->action = explode('/', $r->route);
        if (!empty($this->action[3])) {
            $this->modules = $this->action[2];
            $this->action = $this->action[3];
            $this->route();
        }
    }

    public function route()
    {
        $action = $this->modules . ucfirst($this->action);
        if (method_exists($this, $action))
            $this->$action();
    }

    public function main()
    {
        $model = new Models();
        if (isset($this->request->request['filter'])) {
            $model->where('name', 'like', "%{$this->request->request['filter']}%")->orWhere('phone', 'like', "%{$this->request->request['filter']}%");
        }
        $contacts = $this->groupBy($model->table("phones")->leftJoin("contacts", "id", "contact_id")->get(), "name");
        return Template::view('main.tpl')->with(["contacts" => $contacts])->render();
    }


    public function contactCreate()
    {
        if (validate_phone_number($this->request->request['phone']) == true) {
            $model = new Models();
            $contact = $model->table('contacts')->where('name', $this->request->request['name'])->first();
            if (empty($contact)) {
                $contact = $model->table("contacts")->create([
                    'name' => $this->request->request['name']
                ]);
            } else {
                $contact = $contact->id;
            }
            $model->table("phones")->create([
                'phone' => $this->request->request['phone'],
                'contact_id' => $contact
            ]);
            return $this->request->redirect("/");
        } else {
            return $this->request->withError("Неправильный формат номера");
        }
    }


    public function phoneEdit()
    {
        if ($phone = $this->models->table("phones")->find($this->request->request['id'])->first()) {
            return Template::view('phone-edit.tpl')->with(["phone" => $phone])->render();
        }
    }

    public function contactEdit()
    {
        if ($contact = $this->models->table("contacts")->find($this->request->request['id'])->first()) {
            return Template::view('contact-edit.tpl')->with(["contact" => $contact])->render();
        }
    }

    public function phoneUpdate()
    {
        if (validate_phone_number($this->request->request['phone']) == true) {
            $this->models->table('phones')->where('id', $this->request->request['id'])->update([
                'phone' => $this->request->request['phone']
            ]);
            return $this->request->redirect("/");
        } else {
            return $this->request->withError("Неправильный формат номера");
        }
    }

    public function contactUpdate()
    {
        $this->models->table('contacts')->where('id', $this->request->request['id'])->update([
            'name' => $this->request->request['name']
        ]);
        return $this->request->redirect("/");
    }


    public function phoneDestroy()
    {
        $this->models->table('phones')->find($this->request->request['id'])->delete();
    }

    public function contactDestroy()
    {
        $this->models->table('contacts')->find($this->request->request['id'])->delete();

    }


}