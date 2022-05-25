<?php

namespace app\Controllers;

use app\Core\Controller;
use app\Models\Main;

class MainController extends Controller {

    private function validation($request) {
        $errors = [];

        if (iconv_strlen($request['first_name']) < 2 || iconv_strlen($request['first_name']) > 150 || preg_match('/[^а-яА-ЯЁёa-zA-Z\-]+/u', $request['first_name'])) {
            $errors[] = [
                'type' => 'danger',
                'message' => '"Имя" - значение обязательно для заполнения,  должно быть больше 2ух символов, может содержать буквы и тире, максимальная длина 150 символов'
            ];
        }

        if (iconv_strlen($request['last_name']) < 2 || iconv_strlen($request['last_name']) > 150 || preg_match('/[^а-яА-ЯЁёa-zA-Z\-]+/u', $request['last_name'])) {
            $errors[] = [
                'type' => 'danger',
                'message' => '"Фамилия" - значение  обязательно для заполнения, должно быть больше 2ух символов, может содержать буквы и тире, максимальная длина 150 символов'
            ];
        }

        if (iconv_strlen($request['phone']) < 10 || preg_match('/[^\d]+/u', $request['phone'])) {
            $errors[] = [
                'type' => 'danger',
                'message' => '"Мобильный телефон" - значение обязательно для заполнения, должно быть больше или равно 10 символам, должно состоять только из цифр'
            ];
        }

        if (iconv_strlen($request['comments']) > 200) {
            $errors[] = [
                'type' => 'danger',
                'message' => '"Комментарий" -должно быть не более 200 символов'
            ];
        }
        
        return $errors;
    }

    public function indexAction() {
        $main = new Main;
        $items = $main->getAll();
        $this->view->render('index', $items);
    }

    public function createAction() {
        $this->view->render('create');
    }
    
    public function addAction() {
        $errors = $this->validation($_POST);

        if (!empty($errors)) {
            $this->view->render('create', $_POST, $errors);
        } else {
            $main = new Main;
            $pdo = $main->addItem($_POST);
            $this->view->redirect('/');
        }
    }
}