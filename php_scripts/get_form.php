<?php
// $conn = new PDO('mysql:host=localhost;dbname=ssc', 'root', 'p@$$word');


echo '  <div class="dutyForm" style="width: 10%;">
        <form>
            <div class="mb-3">
                <label for="date">Начало отпуска:</label>
                <input type="date" class="form-control datepicker"  name="date" id="start">
            </div>
            <div class="mb-3">
                <label for="date">Конец отпуска:</label>
                <input type="date" class="form-control datepicker"  name="date" id="end">
            </div>
            <button type="submit" class="btn btn-primary" onclick="set_duty()">Отправить</button>
          </form>
        </div>
          ';