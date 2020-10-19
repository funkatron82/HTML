<?php
use \CEC\HTML\Html;

include_once 'vendor' . DIRECTORY_SEPARATOR . 'LoremIpsum.php';
spl_autoload_register(function ($class) {
    if (false === strpos($class, "CEC\\HTML")) {
        return;
    }

    $class = str_replace("CEC\\HTML", '', $class);
    $class = ltrim($class, "\\");

    $class      = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $classpath  = dirname(__FILE__) .  DIRECTORY_SEPARATOR . 'src' .  DIRECTORY_SEPARATOR . $class . '.php';

    if (file_exists($classpath)) {
        include_once $classpath;
    }
});

$div = Html::createElement('div');
$lorem = new joshtronic\LoremIpsum();

for ($i =0; $i<10; $i++) {
    $temp = Html::createElement('article')->setAttribute('class', 'stuff');
    $head = Html::createElement('h1');
    $head->append(Html::createText($lorem->words(5)));
    $temp->append($head);
    $temp->append(Html::createElement('input'));
    $para = Html::createElement('p');
    $para->append(Html::createText($lorem->paragraphs(1)));
    $temp->append($para);
    $div->append($temp);
}

echo($div->render());
