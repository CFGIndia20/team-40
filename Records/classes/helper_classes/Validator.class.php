<?php

class Validator{
    private $di;
    protected $rules = ['required', 'minlength', 'maxlength', 'unique', 'email', 'phone', 'unique_for_update', 'exists'];

    protected $messages = [
        'required' => 'This :field field is required',
        'minlength' => 'The :field field must be a minimum of :satisfier characters',
        'maxlength' => 'The :field field must be a maximum of :satisfier characters',
        'email' => 'This is not a valid email address',
        'unique' => 'That :field is already taken',
        'phone' => 'That is not a valid phone number',
        'unique_for_update' => 'This :field is already taken!',
        'exists' => 'This value does not exist'
    ];

    public function __construct(DependencyInjector $di){
        $this->di = $di;
    }

    public function check($items, $rules){
        foreach($items as $item => $value){
            if(in_array($item, array_keys($rules))){
                $this->validate([
                    'field' => $item,
                    'value' => $value,
                    'rules' => $rules[$item]
                ]);
            }
        }
        return $this;
    }

    public function validate($item){
        $field = $item['field'];
        foreach($item['rules'] as $rule => $satisfier){
            if(!call_user_func_array([$this, $rule], [$field, $item['value'], $satisfier])){
                //error handling
                $this->di->get('errorhandler')->addError(str_replace([':field', ':satisfier'], [$field, $satisfier], $this->messages[$rule]), $field);
            }
        }
    }

    public function required($field, $value, $satisfier){
        return !empty(trim($value));
    }

    public function minlength($field, $value, $satisfier){
        return mb_strlen($value) >= $satisfier;
    }

    public function maxlength($field, $value, $satisfier){
        return mb_strlen($value) <= $satisfier;
    }

    public function unique($field, $value, $satisfier){
        return !$this->di->get('database')->exists($satisfier, [$field=>$value]);
    }

    public function email($field, $value, $satisfier){
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public function phone($field, $value, $satisfier){
        return strlen(preg_replace("/^[0-9]{10}/", "", $value)) == 10;
    }

    public function unique_for_update($field, $value, $satisfier){
        $temp = explode("#", $satisfier);
        $table = $temp[0];
        $id = $temp[1];
        return !$this->di->get('database')->existsExceptCurrent($table, $id, [$field=>$value]);
    }

    public function fails(){
        return $this->di->get('errorhandler')->hasErrors();
    }

    public function errors(){
        return $this->di->get('errorhandler');
    }

    public function exists($field, $value, $satisfier){
        $temp = explode("|", $satisfier);
        $table_name = $temp[0];
        $column_name = $temp[1];
        return $this->di->get('database')->exists($table_name,[$column_name => $value]);
    }
}

?>