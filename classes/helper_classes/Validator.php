<?php
class Validator{
    private $di;

    private $database;
    private $errorHandler;

    private $data;


    protected $rules = [
        'required',
        'minlenght',
        'maxlenght',
        'unique',
        'uniqueUpdate',
        'email',
        'phone',
        'gender'
    ];

    protected $messages = [
        'required' => 'The :field field is required',
        'minlength' => 'The :field field must be a minimum of :satisfier characters',
        'maxlength' => 'The :field field must be a maximum of :satisfier characters',
        'email' => 'This is not a valid email address',
        'unique' => 'That :field is already taken',
        'uniqueUpdate' => 'That :field is already taken',
        'phone' => 'This is not a valid phone number',
        'gender' => 'This is not a valid gender'
    ];

    public function __construct($di){
        $this->di = $di;
        $this->database = $di->get('database');
        $this->errorHandler = $di->get('errorhandler');
    }

    public function check($items, $rules)
    {
        $this->data = $items;
        // Util::dd($items);
        foreach ($items as $item => $value) {
            if (in_array($item, array_keys($rules))) {
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
        // $item['field'] == 'phone_no' ? Util::dd( $item ) : 0;
        $field = $item['field'];
        foreach ($item['rules'] as $rule => $satisfier) {
            if (!call_user_func_array([$this, $rule], [$field, $item['value'], $satisfier])) {
                // error handling
                $this->errorHandler->addError(str_replace([':field', ':satisfier'], [$field, $satisfier], $this->messages[$rule]), $field);
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
    public function unique($field, $value, $satisfier) {
        if ( isset( $this->data['update'] ) && $this->data['update'] == true ) {
           return $this->uniqueUpdate($field, $value, $satisfier);
        }
        return !$this->database->exists($satisfier, [$field=>$value]);
    }
    public function uniqueUpdate($field, $value, $satisfier) {
        // echo " hello ";
        if ( $this->data[$field] ) {
            // Util::dd( $this->data );
            return !$this->database->existsUpdate($satisfier, [
                'id' => $this->data['id'],
                $field => $value
                ]);
        }
        // $this->unique($field, $value, $satisfier);
        // Util::dd([$field, $value, $satisfier]);
        // return 1;

    }
    public function email($field, $value, $satisfier) {
        Util::dd( ["hello", $field, $value, $satisfier] );
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
    public function gender($field, $value, $satisfier) {
        return $value == 'Male' || $value == 'Female';
    }
    public function phone($field, $value, $satisfier) {
        return strlen(preg_replace('/^[0-9]{10}/', '', $value)) == 10;
    }

    public function fails() {
        return $this->errorHandler->hasErrors();
    }

    public function errors() {
        return $this->errorHandler;
    }
}

?>