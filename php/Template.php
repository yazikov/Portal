<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 9/20/14
 * Time: 6:59 PM
 */

class Template {
    private $category;
    private $page_count;
    private $page_name;
    private $active_page;
    private $page_generate;
    private $texts;
    private $user;

    function __construct($user, $active_page, $category, $page_count, $page_name, $texts)
    {
        $this->user = $user;
        $this->active_page = $active_page;
        $this->category = $category;
        $this->page_count = $page_count;
        $this->page_name = $page_name;
        $this->page_generate = $page_name.'?category='.$category.'&page=';
        $this->texts = $texts;
    }


    public function buildPaging() {
        if ($this->page_count > 1) {
            print '<ul class="pagination pag">';
            if ($this->page_count < 8) {
                for ($i = 1; $i <= $this->page_count; $i++) {
                    $this->printPage($i);
                }
            } else {
                if ($this->active_page < 5) {
                    for ($i = 1; $i < 5; $i++) {
                        $this->printPage($i);
                    }
                    if ($this->active_page == 4) {
                        $this->printPage($this->active_page + 1);
                    }
                    $this->printHellip();
                    $this->printPage($this->page_count - 1);
                    $this->printPage($this->page_count);
                } else if($this->active_page > $this->page_count - 4) {
                    $this->printPage(1);
                    $this->printPage(2);
                    $this->printHellip();
                    if ($this->active_page == $this->page_count - 4) {
                        $this->printPage($this->page_count - 5);
                    }
                    for ($i = $this->page_count - 3; $i <= $this->page_count; $i++) {
                        $this->printPage($i);
                    }
                } else {
                    $this->printPage(1);
                    $this->printPage(2);
                    $this->printHellip();
                    $this->printPage($this->active_page - 1);
                    $this->printPage($this->active_page);
                    $this->printPage($this->active_page + 1);
                    $this->printHellip();
                    $this->printPage($this->page_count - 1);
                    $this->printPage($this->page_count);
                }
            }
            print '</ul>';
        }
    }

    public function buildMenu() {
        print '<ul class="menu">';
        print '<li><a href="/">ГЛАВНАЯ</a></li>';
        print '<li><a href="#">КАТАЛОГ</a></li>';
        print '<li><a href="/texts.php?category=1">КРАСОТА</a></li>';
        print '<li><a href="/texts.php?category=3">СПОРТ</a></li>';
        print '<li><a href="/texts.php?category=2">ЗДОРОВЬЕ</a></li>';
        print '<li><a href="/texts.php?category=4">СОВЕТЫ</a></li>';
        print '<li><a href="#">ФОРУМ</a></li>';
        print '</ul>';
    }

    public function buildAdvice() {
        print '<div class="content_box">';
        print '<h4>Совет</h4>';
        print '<div id="advice">';
//        print $this->advice->getText();
        print '</div>';
        print '<div id="btnAdviceNext" class="button_login"><button type="button" class="btn btn-default">Следующий</button></div>';
        print '</div>';
    }

    public function buildTextList() {
        foreach ($this->texts as $text) {
            $this->printText($text);
        }
    }

    public function buildLoginForm() {
        print '<div class="content_box">';
        if (isset($this->user)) {
            print '<h3>'.$this->user->getFio().'</h3>';
        } else {
            print '<input type="text" class="form-control form-control-pad" placeholder="Логин">';
            print '<input type="text" class="form-control form-control-pad" placeholder="Пароль">';
            print '<div class="button_login">';
            print '<div class="btn-group">';
            print '<button type="button" class="btn btn-default">Войти</button>';
            print '<button type="button" class="btn btn-default" data-toggle="modal" data-target="#registration">Регистрация</button>';
            print '<div id="registration" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
            print '<div class="modal-dialog">';
            print '<div class="modal-content">';
            print '<div class="modal-header">';
            print '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
            print '<h4 class="modal-title" id="myModalLabel">Регистрация</h4>';
            print '</div>';
            print '<div class="modal-body">';
            print '<form class="form-horizontal" role="form">';
            print '<div class="form-group"><label for="inputLogin" class="col-sm-5 control-label">Логин</label><div class="col-sm-7"><input type="text" class="form-control" id="inputLogin" placeholder="Логин"></div></div>';
            print '<div class="form-group"><label for="inputPassword" class="col-sm-5 control-label">Пароль</label><div class="col-sm-7"><input type="password" class="form-control" id="inputPassword" placeholder="Пароль"></div></div>';
            print '<div class="form-group"><label for="inputPassword2" class="col-sm-5 control-label">Подтвердите пароль</label><div class="col-sm-7"><input type="password" class="form-control" id="inputPassword2" placeholder="Подтвердите пароль"></div></div>';
            print '<div class="form-group"><label for="inputFIO" class="col-sm-5 control-label">ФИО</label><div class="col-sm-7"><input type="text" class="form-control" id="inputFIO" placeholder="ФИО"></div></div>';
            print '<div class="form-group"><label for="inputBirthday" class="col-sm-5 control-label">Дата рождения</label><div class="col-sm-7"><input type="date" class="form-control" id="inputBirthday" placeholder="Дата рождения"></div></div>';
            print '<div class="form-group"><label for="inputSex" class="col-sm-5 control-label">Пол</label><div class="col-sm-7"><select id="inputSex" class="form-control"><option>Мужской</option><option>Женский</option></select></div></div>';
            print '<div class="form-group"><label for="inputEmail" class="col-sm-5 control-label">Адрес электронной почты</label><div class="col-sm-7"><input type="email" class="form-control" id="inputEmail" placeholder="Адрес электронной почты"></div></div>';
            print '<div class="form-group"><label for="inputWork" class="col-sm-5 control-label">Место работы</label><div class="col-sm-7"><input type="text" class="form-control" id="inputWork" placeholder="Место работы"></div></div>';
            print '<div class="form-group"><label for="inputAbout" class="col-sm-5 control-label">О себе</label><div class="col-sm-7"><textarea id="inputAbout" class="form-control" rows="3"></textarea></div></div>';
            print '<div class="form-group"><div class="col-sm-offset-2 col-sm-10"><button id="btnSaveUser" type="button" class="btn btn-default">Зарегистрироваться</button><button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button></div></div>';
            print '</form>';
            print '</div>';
            print '</div>';
            print '</div>';
            print '</div>';
            print '</div>';
            print '</div>';
        }
        print '</div>';
    }

    private function printText($text) {
        print '<div class="content_box">';
        print '<h3>'.$text->getTitle().'</h3>';
        print $text->getShortText();
        print '<div class="button_pos"><button type="button" class="btn btn-default">Подробнее</button></div>';
        print '</div>';
    }

    private function printPage($page_number) {
        if ($page_number == $this->active_page) {
            print '<li class="active"><a href="'.$this->page_generate.$page_number.'">'.$page_number.'</a></li>';
        } else {
            print '<li><a href="'.$this->page_generate.$page_number.'">'.$page_number.'</a></li>';
        }
    }

    private function printHellip() {
        print '<li class="disabled"><a href="#">&hellip;</a></li>';
    }
} 