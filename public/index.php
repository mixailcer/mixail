<?php
// Начинаем рпботать с git
// Пробуем русские буквы UTF-8 а сейчас kkkkkkkkоолллл ggggппп jjjj ррр аааа
class View
{
    protected $pages=[];
    protected $title="2Контакты";
    protected $body="Содержимое страницы 1Контакты";
    
    public function addPage($page,$pageCallback)
    {
    	$this->pages[$page]=$pageCallback->bindTo($this,__CLASS__);
    }
    public function get()
    {
    	echo "<pre>";
    	var_dump($this->pages); exit();
    }
    public function render($page)
    {
    	$this->pages[$page]();
    	$content = <<<HTML
<!DOCTYPE html>
<html lang='ru'>
<head>
<title>{$this->title()}</title>
<meta charset='utf-8'>
</head>
<body>   
вввввввввввввв  	
<p>{$this->body()}</p>
</body>
</html>
HTML;
       echo $content;
    }
    public function title()
    {
    	return htmlspecialchars($this->title);
    }
    public function body()
    {
    	return nl2br(htmlspecialchars($this->body));
    }
}
$view=new View();

$view->addPage('about1',function()
    { 
        $this->title="О нас";
        $this->body="Страница о нас";
    });
//echo $view->get(); exit();
//echo "jjjjjjjjjj".$view->body(); exit("lllllllll");

//$view->get(); exit();
//echo $view->title(); exit();
$view->render("about1");

exit(" vvv ");





