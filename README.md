##Простейший новостной сайт с авторизацией и оповещением пользователей о событиях.##

Использовал миграции и фикстуры, тесты не использовались.

Роль        Пользователь      Пароль
admin       root              root
manager     manager           manager
user        user              user

##Разработка архитектуры модуля уведомлений (на основе системы событий Yii2).##

###Схема базы.###

Необходима одна таблица:

`CREATE TABLE `NotifyTemplate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modelName` char(255) NOT NULL,
  `eventName` char(255) NOT NULL,
  `notificatorName` char(255) NOT NULL,
  `template` text NOT NULL,
  PRIMARY KEY (`id`)
)`

###Мета код###

Тут мета код и его UML диаграмма https://docs.google.com/drawings/d/1VIc9Ymox7HQgyV-BU2ESGCwROQv7Ei2RuaxFjhxn6xo/edit?usp=sharing 


`
interface NotificatorInterface
{
    public function notify(string $message, User $user);
}

class EmailNotificator implements NotificatorInterface {}

class BrowserNotificator implements NotificatorInterface {}

class XxxNotificator implements NotificatorInterface {}

class User extends \yii\db\ActiveRecord {
    public function notify(string $message, NotificatorInterface $notificator = null)
}

class UserAdminController extends \yii\web\Controller {
    public function actionNotify($userId);
}

class RoleController extends \yii\web\Controller {
    public function actionNotify($roleId);
}

class NotifyBefavior extends \yii\base\Behavior {
    public $db_criteria;
}

class NotifyTemplate extends \yii\db\ActiveRecord {
    public $id;
    public $modelName;
    public $eventName;
    public $notificatorName;
    public $template;

    public function render(array $params = null);
}

class NotifyTemplateController extends \yii\web\Controller {}

`

###Описание работы###

NotifyBehavior поведение может крепиться к любому классу реализующему события ActiveRecord::EVENT_AFTER_INSERT, ActiveRecord::EVENT_AFTER_UPDATE, ActiveRecord::EVENT_AFTER_DELETE, или наследнику ActiveRecord. Оно слушает эти события и при их возникновении ищет соответствующий NotifyTemplate по полям modelName, где содержиться имя модели к которому прикреплено событие и eventName - имя возникщего события. Далее оно выбирает модели пользователей(User) по некоторым db_criteria которые были указаны при прикреплении этого поведения. Рендерит шаблон передавая ему модель this и модель каждого конкретного выбранного пользователя. Результат получает в формате строки. Создаёт конкретный нотификатор - экземпляр класса реализующего NotificatorInterface на основании NotifyTemplate::$notificatorName. Передаёт результат рендеринга и конкретный нотификатор в метод User::notify() конкретного пользователя (DI проиходит тут) для которого был отрендерин результат. Метод User::notify() вызывает метод NotificatorInterface::notify() передавая ему полученное сообщение и экземпляр класса this. Далее в методе NotificatorInterface::notify() конкретного нотификатора происходит отправка полученного сообщения заданным алгоритмом.

Дожен быть реализован CRUD для NotifyTemplate, что бы можно было настраивать шаблоны сообщений в привязке к конкретным моделям, событиям и нотификаторам или без таковых.

Для уведомления конкретного пользователя по желанию админа должен быть реализован например actionNotify в UserAdminController, который по get запросу будет выдавать форму с полями, текст сообщения и способ уведомления. По post запросу будет создавать конкретный нотификатор на основании выбранного способа уведомления передавать его с полученным текстом сообщения в метод User::notify() конкретного экземпляра класса User.

Для уведомления группы пользователей необходимо реализовать метод actionNotify в некотором RoleController (CRUD ролей), который будет выбирать всех пользователей конкретной роли и передавать им в метод User::notify() текст сообщения и конкретный нотификатор созданный на основании выбранного способа уведомления. (По аналогии с уведомлением конкретного пользователя.)

Предположим, что NotifyTemplate::$notificatorName не был задан при возникновении некоторого события или способа уведомления не был указан при уведомлении пользователя или роли. Тогда метод User::notify() конкретного пользователя должен создать нотификатор по умолчанию заданный например в настройках профиля пользователя или хардкодом.
