<?php

1) //Если пользователь нажал на кнопку Удалить, то производится удаление необходимых данных и производится редирект на текущую страницу для сбрасывания значений формы
if(isset($_POST['submit-del-result'])) {
            $query = "DELETE FROM `approach` WHERE `id_questionnaire`='{$_POST['id-questionnaire-result']}'";
            $this->mysqlResultToArr($query);

            $query = "DELETE FROM `questionnaire` WHERE `id_questionnaire`='{$_POST['id-questionnaire-result']}'";
            $this->mysqlResultToArr($query);

            header("Location:http://powerlift/?pag={$_GET['pag']}");
            die();
        }

2)
//Если пользователь авторизован, то производим редирект на главную страницу
if(isset($_COOKIE['user'])) {
  header('Location: http://trans/permission');
  die();
}

//Если пользователь нажал на кнопку Регистрации, то Обрабатываем введенные пользователем логин и пароль, добавляем данные пользователя в систему
list($email, $password) = $this->prepareVars([$_POST['email'], $_POST['password']]);

//Если пользователь нажал на кнопку Регистрации, то добавляем данные пользователя в систему
if(isset($_POST['registration'])) {
  $this->model->addUser($_POST['name'], $_POST['lastname'], $_POST['patronymic'], $email, $password, $_POST['subdivision_id'],
                        $_POST['position'], $_POST['mobile'], $_POST['mats'], $_POST['gats'], $_POST['dect']);
} 
//Если пользователь производит авторизацию, то отправляем введенные им данные на соответствущую проверку
elseif(isset($_POST['authorization'])) {
  $rememberMe = false;

  if(isset($_POST['remember_me'])) {
      $rememberMe = true;
  }

  $this->model->setCurrentUser($email, $password, $rememberMe);

  protected function prepareVars($arr) {
    foreach ($arr as $key=>$value) {
        $arr[$key] = htmlspecialchars(trim($value));
    }

    return $arr;
}

3)//При вызове метода проверяем существует ли в глобальном массиве POST данные с ключом 'del-permission'. В случае, если существует, то вызываем метод удаления разрешения из базы данных. Проверки на валидность ввода данных в бэкенд составляющей данного проекта не осуществляется в связи с проверкой ввода на фронтенд-части приложения. 
if(isset($_POST['del-permission'])) {
  $this->model->delPermission($_POST['id']);

  public function delPermission($permissionId):void {
    $query = "SELECT * FROM del_permission(:permission_id)";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute(array('permission_id' => $permissionId));
}

4)//Функция удаления тегов из массива POST по ключу
protected function postStripTags(...$arr)
{
    foreach ($arr as $key)
    {
        $_POST[$key] = strip_tags($_POST[$key]);
    }
}