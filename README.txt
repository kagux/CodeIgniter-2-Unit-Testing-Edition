This CodeIgniter 2.03 UnitTesting Edition.

INTEGRATED LIBRARIES
1. Doctrine 2
     By default, doctrine is autoloaded.
     console :  framework\application\doctrine.php
     class loading config : framework\application\libraries\Doctrine.php
     Entities:  \framework\application\models\entities, 'entities' namespace.
     Repositories: \framework\application\models\repositories, 'repositories' namespace.
     In 'testing' environment doctrine uses pdo_sqlite driver to run in-memory database.
     In other environments it is configured to use pdo_mysql driver.
2. Twig
    has its own twig.php config file  to set views and cache folders

CUSTOM CONTROLLER CLASS MY_Controller
1. loads Twig library into $this->view
2. _setView(Twig $view) function to mock view class
3. loadModel($modelName) function to load model into $this->model
4. _getModel(), _setModel(MY_Model $model) to mock model
5. redirectToPreviousPage() function
6. isLocalIPRequest() function
7. index function can have arguments

CUSTOM MODEL CLASS MY_Model
1. $this->entityManager gives access to doctrine 2 EntityManager
2. isObjectFound($object) function for syntactic sugar to check whether it is null or not (doctrine 2 returns null when entity could not be found in DB)


AUTOLOADING CUSTOM CLASSES
Sometimes we need to load a class that neither belongs to entities nor libraries.
Place these classes in framework\application\core\classes

UNIT TESTING
1. Integrated CUnit 3rd party module
2. Integrated Hamcrest library http://code.google.com/p/hamcrest/
3. Integrated Mockery library https://github.com/padraic/mockery

Sample tests are included.
Tests are located in framework\tests. Its obligatory for test files to have 'Test' postfix in their name to be executed.



