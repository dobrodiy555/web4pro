<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
    <link rel="stylesheet" href="/resources/demos/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

  <style>
    h1,
    h3 {
      margin: 10px;
      text-align: center;
    }

    body {
      margin: 10px;
    }

    #description_input {
      width: 370px;
    }

     .frmSearch {
        border: 1px solid #a8d4b1;
        background-color: #c6f7d0;
        margin: 2px 0px;
        padding: 10px;
        border-radius: 4px;
    }

    #autocomplete_search {
        padding: 5px;
        width: 550px;
        border: #a8d4b1 1px solid;
        border-radius: 4px;
    }

    #autocomplete_button {
        position: absolute;  /* теперь он будет как бы отдельным слоем относительно всей страницы */
        left: 578px;  /* выталкиваем налево на 473 рх */
        top: 127px; /* выталкиваем сверху на 131 рх */

    }

    #description_form {
        display: inline;
    }

    #date_form {
        display: inline;
        margin-left: 55px;
    }

  </style>
</head>

<body>

  <h1>AJAX + JQuery</h1>
  <h3>Bootstrap table</h3>

  <!--  форма автозаполнения по title-->
  <div class="frmSearch" id="frmSearch">
      <form id="autocomplete_form">
      <input type="text" id="autocomplete_search" placeholder="Title autocomplete" />
      <div id="suggestion_box"></div>
      <input type="submit" id="autocomplete_button" value="Показать записи">
      </form>
  </div>
  <br>

  <!-- дропдаун сортировки (справа) -->
      <select id="sorting_select" style="float:right;">
          <option value="asc">Сортировка по возрастанию</option>
          <option value="desc">Сортировка по убыванию</option>
      </select>

   <!-- форма поиска по description -->
  <form id="description_form">
      <label for="description">Description: </label>
      <input type="text" id="description_input">
      <input type="submit" id="description_button" value="Показать записи">
  </form>

  <!-- форма поиска по датам -->
  <form id="date_form">
      <input type="text" id="from_date" placeholder="Date from" />
      <input type="text" id="to_date" placeholder="Date to" />
      <input type="submit" id="date_button" value="Показать записи">
  </form>

  <br><br>

<!--  таблица бутстрап -->
  <table class="table" id="responds">
    <thead>
      <tr class="table-primary">
        <th>Post Id</th>
        <th>Title</th>
        <th>Description</th>
        <th>Author (Full name)</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
<!--сюда будут вставляться записи из бд-->
    </tbody>
  </table>

  <!-- кнопка для подгрузки еще 30 записей снизу таблицы -->
  <form id='loadform' action='' method='get'>
    <input id="load" name="load" type="submit" value="Load more">
  </form>

  <script>
   // вызов ф-ции отображения первых 30 записей
      $(document).ready(function () {
        $.ajax({
          url: 'display_records.php',
          dataType: "html",
          success: function(response) {
          // alert("success display f-n");
          $("#responds").append(response);
        },
          error: function() {
          alert("error");
        }
        });
      });

   // вызов ф-ции подргузки еще 30 записей loadmore
   var page = 1; // для пагинации
    $("#loadform").submit(function(e) {  // при нажатии на кнопку loadmore
      e.preventDefault();
      page++;  // при каждом вызове ф-ции как будто след страница
      var myData1 = "load=" + $("#load").val();
      var myData2 = "page=" + page;
      var myData = myData1 + '&' + myData2; // отправим серверу как GET переменные
      // alert("handler for loadmore submit called");
      // alert(myData); // for testing purposes

      $.ajax({
        type: "GET",
        url: 'loadmore.php',
        dataType: "html", // what we receive from server
        data: myData, // what we send to server (GET variable)
        success: function(response) {
          // alert("success loadmore f-n");
          $("#responds").append(response); // прикрепляем ответ сервера к таблице
        },
        error: function() {
          alert("error");
        }
      });
    });

    // вызываем ф-цию поиска по description
    $("#description_form").submit(function(e) {
        e.preventDefault();
        var myData = "description=" + $("#description_input").val();
        // alert("handler for description submit called");
        // alert(myData);
        $(".from_display").hide();  // скрываем все данные вызванные ранее
        $(".from_loadmore").hide();
        $(".from_autocomplete").hide();
        $(".from_date").hide();
        $(".from_description").hide();

              $.ajax({
                  type: "GET",
                  url: 'find_by_description.php',
                  dataType: "html", // what we receive from server
                  data: myData, // what we send to server (GET variable)
                  success: function(response) {
                      // alert("success find description f-n");
                      $("#responds").append(response);
                  },
                  error: function() {
                      alert("error");
                  }
              });
          });

    // вызываем ф-цию поиска по датам
    $("#date_form").submit(function(e) {
        e.preventDefault();
        var myData1 = "from_date=" + $("#from_date").val();
        var myData2 = "to_date=" + $("#to_date").val();
        var myData = myData1 + "&" + myData2;
        // alert("handler for description submit called");
        // alert(myData);
        $(".from_display").hide();
        $(".from_loadmore").hide();
        $(".from_autocomplete").hide();
        $(".from_description").hide();
        $(".from_date").hide();

              $.ajax({
                  type: "GET",
                  url: 'find_by_date.php',
                  dataType: "html", // what we receive from server
                  data: myData, // what we send to server (GET variable)
                  success: function(response) {
                      // alert("success find date f-n");
                      $("#responds").append(response);
                  },
                  error: function() {
                      alert("error");
                  }
              });
          });

// autocomplete widget, ajax не нужен так как виджет сам отправит запрос на сервер через $_GET['term']
   $(function() {
       $("#autocomplete_search").autocomplete({
           source: 'find_title_autocomplete.php',
           minLength: 3, // отобразит результаты при введенных трех буквах
           select: function (event, ui) {
            $("#autocomplete_search").val(ui.item.value);  // нужно присвоить полю значение иначе не будет работать след. ф-ция
           }
       });
   });

    // загрузить записи по выбранному title из autocomplete
    $("#autocomplete_form").submit(function(e) {
        e.preventDefault();
        var myData = "title=" + $("#autocomplete_search").val();
        // alert("handler for display after autocompl called");
        // alert(myData);
        $(".from_display").hide();
        $(".from_description").hide();
        $(".from_loadmore").hide();
        $(".from_date").hide();
        $(".from_autocomplete").hide();

        $.ajax({
            type: "GET",
            url: 'display_after_autocomplete.php',
            dataType: "html",
            data: myData,
            success: function(response) {
                // alert("success display after autocompl f-n");
                $("#responds").append(response);
            },
            error: function() {
                alert("error");
            }
        });
    });

   // функция сортировки отображенных записей по post id
   $("#sorting_select").change(function sortTable() { // когда меняем значение дропдауна сортировки
       var sorting_type, table, rows, switching, i, x, y, shouldSwitch;
       sorting_type = $(this).val(); // считываем value из select option: asc или desc
       table = document.getElementById("responds"); // считываем данные таблицы
       switching = true;
       while (switching) {
           switching = false;
           rows = table.rows; // строки таблицы
           for (i = 1; i < (rows.length - 1); i++) { // заголовки табл не нужны
               shouldSwitch = false;
               x = rows[i].getElementsByTagName("td")[0]; // считываем строку первого столбца (Post ID)
               y = rows[i+1].getElementsByTagName("td")[0]; // след строка первого столбца для сравнения с первой
               if (sorting_type == 'desc') {
                   if (Number(x.innerHTML) < Number(y.innerHTML)) { // сравниваем строки
                       shouldSwitch = true; // нужно менять местами
                       break;
                   }
               } else { // если asc
                   if (Number(x.innerHTML) > Number(y.innerHTML)) {
                       shouldSwitch = true;
                       break;
                   }
               }
           }
           if (shouldSwitch) {
               rows[i].parentNode.insertBefore(rows[i+1], rows[i]); // меняем строки местами
               switching = true; // продолжай выполнять цикл
           }
       }
   });

  </script>

</body>
</html>


