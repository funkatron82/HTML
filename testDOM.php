<?php
spl_autoload_register(function ($class) {
    if (false === strpos($class, "CEC\\View")) {
        return;
    }

    $class = str_replace("CEC\\View", '', $class);
    $class = ltrim($class, "\\");

    $class      = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $classpath  = dirname(__FILE__) .  DIRECTORY_SEPARATOR . $class . '.php';

    if (file_exists($classpath)) {
        include_once $classpath;
    }
});


$div = new \CEC\HTML\Element('div');
for ($i = 0; $i <10; $i++) {
    $p = new \CEC\HTML\Element('p');
    $p->append(new \CEC\HTML\Text('Text  #' . $i));
    $div->append($p);
}
$div->append(new \CEC\HTML\Text('End'));
$div->prepend(new \CEC\HTML\Text('Start'));
$div->classList()->add('spoon', 'win', 'foo', 'bar')->remove('bar');
$text = new \CEC\HTML\Fields\Text();

foreach ($div->firstChild()->siblings() as $sibling) {
    //echo var_dump($sibling);
}
echo($text->render());

echo var_dump(class_implements($div));
echo var_dump(class_parents($div));
$options = ['win'=>'fun', 'lose'=>'notfun'];
['win' => $fun] = $options;
$expirationDate = (new DateTimeImmutable())
    ->modify('+14 days')
    ->setTime(0, 0, 0);
echo var_dump($expirationDate);
