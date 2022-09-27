<?php

class CsvCollectionExport extends CollectionExport
{
  public function printCsv($result)
  {
    $f = fopen('persons.csv', 'a');
    foreach ($result['data'] as $fields) {
      fputcsv($f, $fields);
    }
    fclose($f);

    // Fetching data from csv file row by row

    echo "<html><body><center><table>\n\n";
    $file = fopen('persons.csv', 'r');
    while (($data = fgetcsv($file)) !== false) {
      // HTML tag for placing in row format
      echo "<tr>";
      foreach ($data as $i) {
        echo "<td>" . htmlspecialchars($i)
          . "</td>";
      }
      echo "</tr> \n";
    }
  }
}
