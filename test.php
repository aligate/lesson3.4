<?php
class Foo 
{
    public function bar() {
        echo 'foobar';
    }
}
 
class Decorator 
{
    protected $foo;
 
    function __construct(Foo $foo) {
       $this->foo = $foo;
    }
 
    function __call($method_name, $args) {
       echo 'Calling method ',$method_name,'<br />';
       return call_user_func_array(array($this->foo, $method_name), $args);
    }
}
 
$foo = new Decorator(new Foo());
print_r($foo);
$foo->bar();

?>