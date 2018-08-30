<?php
  require 'DatabaseTable.php';
  require 'functions.php';

  class Test extends PHPUnit_Framework_TestCase{

  	private $commentsTable;
  	private $articlesTable;
  	private $categoriesTable;
  	private $usersTable;
  	private $subscriptionsTable;
    private $pdo;
    private $schema;

    public function setUp(){
      $this->pdo = new PDO('mysql:dbname=WebAssignment2;host=192.168.56.2', 'student', 'student');
      $this->schema = 'WebAssignment2.';

      $this->commentsTable = new DatabaseTable($this->pdo, $this->schema . 'comments');
    	$this->articlesTable = new DatabaseTable($this->pdo, $this->schema . 'articles');
    	$this->categoriesTable = new DatabaseTable($this->pdo, $this->schema . 'categories');
    	$this->usersTable = new DatabaseTable($this->pdo, $this->schema . 'user');
    	$this->subscriptionsTable = new DatabaseTable($this->pdo, $this->schema . 'subscriptions');
    }

    public function testInsertArticle() {
      $arr = [
        'title' => 'Test article',
        'author' => 'Test Author',
        'date' => '2016-11-04',
        'content' => 'A test A test A test A test',
        'category' => 'Fashion'
      ];

      $stmt = $this->articlesTable->insert($arr);
      $this->assertTrue($stmt);
    }

    public function testInsertCategory() {
      $arr = [
        'name' => 'Test category',
      ];

      $stmt = $this->categoriesTable->insert($arr);
      $this->assertTrue($stmt);
    }

    public function testInsertComment() {
      $arr = [
        'author' => 'Test comment',
        'content' => 'Test comment',
        'article_id' => 'A test A test A test A test'
      ];

      $stmt = $this->commentsTable->insert($arr);
      $this->assertTrue($stmt);
    }

    public function testInsertAdmin() {
      $arr = [
        'username' => 'Test Admin',
        'password' => 'Test Password',
      ];

      $stmt = $this->usersTable->insert($arr);
      $this->assertTrue($stmt);
    }

    public function testInsertSub() {
      $arr = [
        'email' => 'test@email.email.com',
      ];

      $stmt = $this->subscriptionsTable->insert($arr);
      $this->assertTrue($stmt);
    }

    public function testUpdateArticle() {
      $arr = [
        'title' => 'Tested article',
        'author' => 'Tested Author',
        'date' => '2016-11-11',
        'content' => 'A tested A tested A test A test',
        'category' => 'Coding'
      ];

      $stmt = $this->articlesTable->update($arr, '15');
      $this->assertTrue($stmt);
    }

    public function testUpdateCategory() {
      $arr = [
        'name' => 'Tested category',
      ];

      $stmt = $this->categoriesTable->update($arr, '19');
      $this->assertTrue($stmt);
    }

    public function testDeleteArticle() {
      $stmt = $this->articlesTable->delete('title', 'Tested article');
      $this->assertTrue($stmt);
    }

    public function testDeleteCategory() {
      $stmt = $this->categoriesTable->delete('name', 'Tested category');
      $this->assertTrue($stmt);
    }

    public function testDeleteComment() {
      $stmt = $this->commentsTable->delete('author', 'Test comment');
      $this->assertTrue($stmt);
    }

    public function testDeleteAdmin() {
      $stmt = $this->usersTable->delete('username', 'Test Admin');
      $this->assertTrue($stmt);
    }

    public function testDeleteSub() {
      $stmt = $this->subscriptionsTable->delete('email', 'test@email.email.com');
      $this->assertTrue($stmt);
    }

  }
?>
