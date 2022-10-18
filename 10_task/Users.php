<?php

class User
{
  public $email = '';
  public $surname = '';
  public $name = '';

  function set_email($email)
  {
    $this->email = $email;
  }

  function set_surname($surname)
  {
    $this->surname = $surname;
  }

  function set_name($name)
  {
    $this->name = $name;
  }

  function save_data_in_csv_file($filename) // сохранить данные в указанном файле
  {
    $file = fopen($filename, 'a') or die("Unable to open file!");
    $arr = [$this->email, $this->surname, $this->name];
    fputcsv($file, $arr); // сохранит array в виде строки csv
    fclose($file);
  }

  function find_by_email($email, $filename)
  {
    $array_with_email = [];
    $file = fopen($filename, 'r');
    while (($line = fgetcsv($file)) !== false) { // парсим все строки до конца файла
      if (in_array($email, $line)) {
        $array_with_email[] = $line;
      }
    }
    fclose($file);
    return $array_with_email; // массив с данными об этом человеке
  }

  function delete_record() // удаляет запись созданного ранее обьекта класса
  {
    $file = fopen('file.csv', 'r');
    $temp_file = fopen('file_temp.csv', 'w');
    $email = $this->email; // email как у обьекта класса
    while (($line = fgetcsv($file)) !== false) {
      if (!in_array($email, $line)) {
        fputcsv($temp_file, $line); // перезапишет данные во временный файл без человека которого нужно удалить
      }
    }
    fclose($file);
    fclose($temp_file);
    rename('file_temp.csv', 'file.csv'); // сделает временный файл постоянным
  }

  static function show_all_records($filename)  // отобразить все данные csv из нужного файла; статическая т.е. для ее вызова не обязательно создавать обьект класса
  {
    $data = file_get_contents($filename);
    echo $data;
  }
}

// тестируем

$obj_user1 = new User();
$obj_user1->set_email('andmih666@gmail.com');
$obj_user1->set_name('Andrii');
$obj_user1->set_surname('Miheev');
$obj_user1->save_data_in_csv_file('file.csv');

$obj_user2 = new User();
$obj_user2->set_email('petrpetr@gmail.com');
$obj_user2->set_name('Petro');
$obj_user2->set_surname('Petrow');
$obj_user2->save_data_in_csv_file('file.csv');

$obj_user3 = new User();
$obj_user3->set_email('ivanivan@mail.ru');
$obj_user3->set_name('Ivan');
$obj_user3->set_surname('Ivanow');
$obj_user3->save_data_in_csv_file('file.csv');

print_r($obj_user3->find_by_email('ivanivan@mail.ru', 'file.csv'));
$obj_user2->delete_record();
User::show_all_records('file.csv');
