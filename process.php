<?php

$username = $_POST['login'] ?? null;
$password = $_POST['password'] ?? null;
$password = '123456';
$hash = password_hash($password, PASSWORD_BCRYPT);

$hash = '$2y$10$Vb.pry5vRGNrm6Y79UfBsun/RbXq2.XEGCOMpozrDwg.MNpfxvWHK';
$password = '123456';

if(password_verify($password, $hash))
    echo 'Пароль правильный.';
else
    echo 'Пароль неправильный.';

var_dump($hash);
// string(60) "$2y$10$Vb.pry5vRGNrm6Y79UfBsun/RbXq2.XEGCOMpozrDwg.MNpfxvWHK"

//Функция existsUser($login) проверяет - существует ли пользователь с заданным логином?
function existsUser($login)
{
    if (isset(getUsersList()[$login])) {
        return true;
    }
    return false;
}

//Функция checkPassword($login, $password) пусть возвращает true тогда, когда существует пользователь с указанным логином и введенный им пароль прошел проверку.
function checkPassword($login, $password)
{
    if (existsUser($login)) {
        $hash = getUsersList()[$login]['hash'];
        if (password_verify($password, $hash)) {
            return true;
        }
        return false;
    }
}
//функциz getCurrentUser() возвращает либо имя вошедшего на сайт пользователя, либо null().
//Т.е. если в сессии есть логин и он существует в нашем массиве, то вернем имя пользователя соответствующего этому логину, иначе null.
    function getCurrentUser()
    {
        if (!empty($_SESSION['user']) && existsUser($_SESSION['user'])) {
            return getUsersList()[$_SESSION['user']]['name'];
        }
        return null;
    }

//Функция доступа к файлу логов
    function getLogFile()
    {
        return file(__DIR__ . '/logs/imageUpload.log', FILE_IGNORE_NEW_LINES);

    }

//Пара тестов для функции existsUser()
    assert(existsUser('admin') === true);
    assert(existsUser('user') === true);

   


// зададим книгу паролей
$users = [
     'admin' => ['id' => '1', 'password' => '132432'],
];


if (null !== $username || null !== $password) {

    // Если пароль из базы совпадает с паролем из формы
    if ($password === $users['admin']['password']) {
    
         // Стартуем сессию:
        session_start(); 
        
   	 // Пишем в сессию информацию о том, что мы авторизовались:
        $_SESSION['auth'] = true; 
        
        // Пишем в сессию логин и id пользователя
        $_SESSION['id'] = $users['admin']['id']; 
        $_SESSION['login'] = $username; 

    }
}

    
$auth = $_SESSION['auth'] ?? null;

// если авторизованы
if ($auth) {
?>
// контент для администратора
    <a href="index.php">Вернуться на главную</a>

<?php }