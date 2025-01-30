<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ปรับตัว </title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=K2D:wght@300;400;500;600;700&display=swap">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs4.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs4.min.js"></script>
  <link rel="stylesheet" href="styles.css">
</head>
<script>
  window.onload = function() {
    loadData();
  }

  function loadData() {
    fetchDataTitle();
    fetchDataReasons();
    fetchDataTb1();
    fetchDatacourse_name();
    fetchDataDegree_name();
    fetchDataagency();
    fetchDatafirst_open();
    fetchDataLast_update_course();
    fetchDataclosing_course();
    loadCheck();
    fetchDatatopic8();
  }

  function fetchDataTitle(formId) {
    console.log("fetchDataTitle");
    $.ajax({
      url: 'fetch_data.php', // URL ของ PHP ที่จะดึงข้อมูล
      type: 'GET', // การส่งข้อมูลแบบ GET
      dataType: 'json', // กำหนดให้รับข้อมูลในรูปแบบ JSON
      data: {
        action: 'getform', // ส่งค่า action ไปด้วย
        formId: formId ?? 1 // ส่ง formId ไปด้วย
      },
      success: function(data) {
        if (data.response === 'success') {
          console.log("fetchDataTitle", data.data);
          const fetchedDataArray = data.data; // array of objects ที่ได้รับ
          const tbody = $('#fetchDataTitle'); // อ้างอิง <tbody>
          tbody.empty(); // ล้างข้อมูลเดิมในตาราง

          // ตรวจสอบข้อมูลและแสดงผล
          if (fetchedDataArray.length > 0 && fetchedDataArray[0].texts !== '') {
            fetchedDataArray.forEach((item) => {
              const row = `
              <tr>
                <td>${item.texts}</td> <!-- แสดง texts -->
                <td>
                  <button id="edittitle" class="btn btn-warning edit-btn" data-form-id="${item.sid}">แก้ไข</button>
                  <button class="btn btn-danger delete-btn" onclick="ondelete(${item.sid})">ลบ</button>
                </td>
              </tr>`;
              tbody.append(row); // เพิ่มแถวใหม่ใน <tbody>
            });
          } else {
            tbody.append('<tr><td colspan="2" class="text-center">ไม่มีข้อมูล</td></tr>');
          }
        } else {
          console.error('ไม่พบข้อมูลในฐานข้อมูล:', data);
        }
      },
      error: function(xhr, status, error) {
        console.error('เกิดข้อผิดพลาดในการดึงข้อมูล:', error);
      }
    });
  }


  function fetchDataReasons(formId) {
    // //console.log(formId)
    $.ajax({
      url: 'fetch_data.php', // URL ของ PHP ที่จะดึงข้อมูล
      type: 'GET', // การส่งข้อมูลแบบ GET
      dataType: 'json', // กำหนดให้รับข้อมูลในรูปแบบ JSON
      data: {
        action: 'getform', // ส่งค่า action ไปด้วย
        formId: formId ?? 2 // ส่ง formId ไปด้วย
      },
      success: function(data) {
        if (data.response === 'success') {

          const fetchedDataArray = data.data; // ข้อมูลที่ดึงมา
          // //console.log("ข้อมูลทั้งหมดที่ดึงมา:", fetchedDataArray);
          const tbody = $('#fetchDataReasons'); // อ้างอิง <tbody>
          tbody.empty();
          if (fetchedDataArray.length > 0 && fetchedDataArray[0].texts !== '') {
            fetchedDataArray.forEach((item) => {
              // //console.log("ข้อมูล:", item);
              const row = `
              <tr> <!-- เก็บ id เป็น data attribute -->
                <td>${item.texts}</td> <!-- สมมุติ item มี title -->
                <td>
                    <button id="editreasons" class="btn btn-warning edit-btn" data-form-id="${item.sid}">แก้ไข</button>
                  <button class="btn btn-danger delete-btn" onclick="ondelete(${item.sid})">ลบ</button>
                </td>
              </tr>`;
              tbody.append(row); // เพิ่มแถวใหม่ใน <tbody>
            });
          } else {
            tbody.append('<tr><td colspan="2" class="text-center">ไม่มีข้อมูล</td></tr>');
          }
        } else {
          console.error('ไม่พบข้อมูลในฐานข้อมูล:', data);
        }
      },
      error: function(xhr, status, error) {
        console.error('เกิดข้อผิดพลาดในการดึงข้อมูล:', error);
      }
    });
  }



  function fetchDataTb1() {
    const action = "table1";

    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'fetchtable.php?action=' + action, true);

    xhr.onreadystatechange = function() {
      if (xhr.readyState == 4) {
        if (xhr.status == 200) {
          try {
            var tb1 = JSON.parse(xhr.responseText);
            displayDataTb1(tb1);
            console.log("tb1", tb1.data[0].texts);
          } catch (e) {
            console.error('Error parsing JSON:', e);
          }
        } else {
          console.error('Failed to fetch data:', xhr.status);
        }
      }
    };

    xhr.send();
  }

  function displayDataTb1(tb1) {
    const tableBody = document.getElementById('displayDataTb1');
    if (!tableBody) {
      console.error("Element with ID 'displayDataTb1' not found in the DOM");
      return;
    }
    // console.log("res", Array.isArray(tb1.data))
    let output = '';
    if (tb1.data[0].texts !== '' && tb1.data[1].texts !== '' && tb1.data[2].texts !== '') {
      // tb1.data.forEach((item, index) => {
      // //console.log("item", item)
      output += `
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2 px-4">1</td>
                        <td class="py-2 px-4">${tb1.data[0].texts ?? ''}</td>
                        <td class="py-2 px-4">${tb1.data[1].texts ??''}</td>
                        <td class="py-2 px-4">${tb1.data[2].texts ??''}</td>
                        <td class="py-2 px-4">
                            <button class="btn btn-warning" onclick="edittable1()">แก้ไข</button>
                        </td>
                        <td class="py-2 px-4">
                            <button class="action-btn delete-btn btn btn-danger" onclick="deletetable1()">ลบ</button>
                        </td>
                    </tr>
                `;


    } else {

      output = `
            <tr>
                <td colspan="6" class="text-center py-4 text-gray-500">ไม่พบข้อมูล</td>
            </tr>
        `;
    }

    // อัปเดตเนื้อหาของตาราง
    tableBody.innerHTML = output;
  }


  function sanitizeHTML(str) {
    const temp = document.createElement('div');
    temp.textContent = str;
    return temp.innerHTML;
  }


  function fetchDatacourse_name(formId) {
    // //console.log(formId)
    $.ajax({
      url: 'fetch_data.php', // URL ของ PHP ที่จะดึงข้อมูล
      type: 'GET', // การส่งข้อมูลแบบ GET
      dataType: 'json', // กำหนดให้รับข้อมูลในรูปแบบ JSON
      data: {
        action: 'getform', // ส่งค่า action ไปด้วย
        formId: formId ?? 6 // ส่ง formId ไปด้วย
      },
      success: function(data) {
        if (data.response === 'success') {

          const fetchedDataArray = data.data; // ข้อมูลที่ดึงมา
          // //console.log("ข้อมูลทั้งหมดที่ดึงมา:", fetchedDataArray);
          const tbody = $('#fetchDatacourse_name'); // อ้างอิง <tbody>
          tbody.empty();
          if (fetchedDataArray.length > 0 && fetchedDataArray[0].texts !== '') {
            fetchedDataArray.forEach((item) => {
              // //console.log("ข้อมูล:", item);
              const row = `
              <tr> <!-- เก็บ id เป็น data attribute -->
                <td>${item.texts}</td> <!-- สมมุติ item มี title -->
                <td>
                    <button id="editcourse_name" class="btn btn-warning edit-btn" data-form-id="${item.sid}">แก้ไข</button>
                  <button class="btn btn-danger delete-btn" onclick="ondelete(${item.sid})">ลบ</button>
                </td>
              </tr>`;
              tbody.append(row); // เพิ่มแถวใหม่ใน <tbody>
            });
          } else {
            tbody.append('<tr><td colspan="2" class="text-center">ไม่มีข้อมูล</td></tr>');
          }
        } else {
          console.error('ไม่พบข้อมูลในฐานข้อมูล:', data);
        }
      },
      error: function(xhr, status, error) {
        console.error('เกิดข้อผิดพลาดในการดึงข้อมูล:', error);
      }
    });
  }

  function fetchDataDegree_name(formId) {
    // //console.log(formId)
    $.ajax({
      url: 'fetch_data.php', // URL ของ PHP ที่จะดึงข้อมูล
      type: 'GET', // การส่งข้อมูลแบบ GET
      dataType: 'json', // กำหนดให้รับข้อมูลในรูปแบบ JSON
      data: {
        action: 'getform', // ส่งค่า action ไปด้วย
        formId: formId ?? 7 // ส่ง formId ไปด้วย
      },
      success: function(data) {
        if (data.response === 'success') {

          const fetchedDataArray = data.data; // ข้อมูลที่ดึงมา
          // //console.log("ข้อมูลทั้งหมดที่ดึงมา:", fetchedDataArray);
          const tbody = $('#fetchDataDegree_name'); // อ้างอิง <tbody>
          tbody.empty();
          if (fetchedDataArray.length > 0 && fetchedDataArray[0].texts !== '') {
            fetchedDataArray.forEach((item) => {
              // //console.log("ข้อมูล:", item);
              const row = `
              <tr> <!-- เก็บ id เป็น data attribute -->
                <td>${item.texts}</td> <!-- สมมุติ item มี title -->
                <td>
                    <button id="editDegree_name" class="btn btn-warning edit-btn" data-form-id="${item.sid}">แก้ไข</button>
                  <button class="btn btn-danger delete-btn" onclick="ondelete(${item.sid})">ลบ</button>
                </td>
              </tr>`;
              tbody.append(row); // เพิ่มแถวใหม่ใน <tbody>
            });
          } else {
            tbody.append('<tr><td colspan="2" class="text-center">ไม่มีข้อมูล</td></tr>');
          }
        } else {
          console.error('ไม่พบข้อมูลในฐานข้อมูล:', data);
        }
      },
      error: function(xhr, status, error) {
        console.error('เกิดข้อผิดพลาดในการดึงข้อมูล:', error);
      }
    });
  }

  function fetchDataagency(formId) {
    // //console.log(formId)
    $.ajax({
      url: 'fetch_data.php', // URL ของ PHP ที่จะดึงข้อมูล
      type: 'GET', // การส่งข้อมูลแบบ GET
      dataType: 'json', // กำหนดให้รับข้อมูลในรูปแบบ JSON
      data: {
        action: 'getform', // ส่งค่า action ไปด้วย
        formId: formId ?? 8 // ส่ง formId ไปด้วย
      },
      success: function(data) {
        if (data.response === 'success') {

          const fetchedDataArray = data.data; // ข้อมูลที่ดึงมา
          // //console.log("ข้อมูลทั้งหมดที่ดึงมา:", fetchedDataArray);
          const tbody = $('#fetchDataagency'); // อ้างอิง <tbody>
          tbody.empty();
          if (fetchedDataArray.length > 0 && fetchedDataArray[0].texts !== '') {
            fetchedDataArray.forEach((item) => {
              // //console.log("ข้อมูล:", item);
              const row = `
              <tr> <!-- เก็บ id เป็น data attribute -->
                <td>${item.texts}</td> <!-- สมมุติ item มี title -->
                <td>
                    <button id="editagency" class="btn btn-warning edit-btn" data-form-id="${item.sid}">แก้ไข</button>
                  <button class="btn btn-danger delete-btn" onclick="ondelete(${item.sid})">ลบ</button>
                </td>
              </tr>`;
              tbody.append(row); // เพิ่มแถวใหม่ใน <tbody>
            });
          } else {
            tbody.append('<tr><td colspan="2" class="text-center">ไม่มีข้อมูล</td></tr>');
          }
        } else {
          console.error('ไม่พบข้อมูลในฐานข้อมูล:', data);
        }
      },
      error: function(xhr, status, error) {
        console.error('เกิดข้อผิดพลาดในการดึงข้อมูล:', error);
      }
    });
  }

  function fetchDatafirst_open(formId) {
    // //console.log(formId)
    $.ajax({
      url: 'fetch_data.php', // URL ของ PHP ที่จะดึงข้อมูล
      type: 'GET', // การส่งข้อมูลแบบ GET
      dataType: 'json', // กำหนดให้รับข้อมูลในรูปแบบ JSON
      data: {
        action: 'getform', // ส่งค่า action ไปด้วย
        formId: formId ?? 9 // ส่ง formId ไปด้วย
      },
      success: function(data) {
        if (data.response === 'success') {

          const fetchedDataArray = data.data; // ข้อมูลที่ดึงมา
          // //console.log("ข้อมูลทั้งหมดที่ดึงมา:", fetchedDataArray);
          const tbody = $('#fetchDatafirst_open'); // อ้างอิง <tbody>
          tbody.empty();
          if (fetchedDataArray.length > 0 && fetchedDataArray[0].texts !== '') {
            fetchedDataArray.forEach((item) => {
              // //console.log("ข้อมูล:", item);
              const row = `
              <tr> <!-- เก็บ id เป็น data attribute -->
                <td>${item.texts}</td> <!-- สมมุติ item มี title -->
                <td>
                    <button id="editfirst_open" class="btn btn-warning edit-btn" data-form-id="${item.sid}">แก้ไข</button>
                  <button class="btn btn-danger delete-btn" onclick="ondelete(${item.sid})">ลบ</button>
                </td>
              </tr>`;
              tbody.append(row); // เพิ่มแถวใหม่ใน <tbody>
            });
          } else {
            tbody.append('<tr><td colspan="2" class="text-center">ไม่มีข้อมูล</td></tr>');
          }
        } else {
          console.error('ไม่พบข้อมูลในฐานข้อมูล:', data);
        }
      },
      error: function(xhr, status, error) {
        console.error('เกิดข้อผิดพลาดในการดึงข้อมูล:', error);
      }
    });
  }

  function fetchDataLast_update_course(formId) {
    // //console.log(formId)
    $.ajax({
      url: 'fetch_data.php', // URL ของ PHP ที่จะดึงข้อมูล
      type: 'GET', // การส่งข้อมูลแบบ GET
      dataType: 'json', // กำหนดให้รับข้อมูลในรูปแบบ JSON
      data: {
        action: 'getform', // ส่งค่า action ไปด้วย
        formId: formId ?? 10 // ส่ง formId ไปด้วย
      },
      success: function(data) {
        if (data.response === 'success') {

          const fetchedDataArray = data.data; // ข้อมูลที่ดึงมา
          // //console.log("ข้อมูลทั้งหมดที่ดึงมา:", fetchedDataArray);
          const tbody = $('#fetchDataLast_update_course'); // อ้างอิง <tbody>
          tbody.empty();
          if (fetchedDataArray.length > 0 && fetchedDataArray[0].texts !== '') {
            fetchedDataArray.forEach((item) => {
              // //console.log("ข้อมูล:", item);
              const row = `
              <tr> <!-- เก็บ id เป็น data attribute -->
                <td>${item.texts}</td> <!-- สมมุติ item มี title -->
                <td>
                    <button id="editLast_update_course" class="btn btn-warning edit-btn" data-form-id="${item.sid}">แก้ไข</button>
                  <button class="btn btn-danger delete-btn" onclick="ondelete(${item.sid})">ลบ</button>
                </td>
              </tr>`;
              tbody.append(row); // เพิ่มแถวใหม่ใน <tbody>
            });
          } else {
            tbody.append('<tr><td colspan="2" class="text-center">ไม่มีข้อมูล</td></tr>');
          }
        } else {
          console.error('ไม่พบข้อมูลในฐานข้อมูล:', data);
        }
      },
      error: function(xhr, status, error) {
        console.error('เกิดข้อผิดพลาดในการดึงข้อมูล:', error);
      }
    });
  }

  function fetchDataclosing_course(formId) {
    // //console.log(formId)
    $.ajax({
      url: 'fetch_data.php', // URL ของ PHP ที่จะดึงข้อมูล
      type: 'GET', // การส่งข้อมูลแบบ GET
      dataType: 'json', // กำหนดให้รับข้อมูลในรูปแบบ JSON
      data: {
        action: 'getform', // ส่งค่า action ไปด้วย
        formId: formId ?? 11 // ส่ง formId ไปด้วย
      },
      success: function(data) {
        if (data.response === 'success') {

          const fetchedDataArray = data.data; // ข้อมูลที่ดึงมา
          // //console.log("ข้อมูลทั้งหมดที่ดึงมา:", fetchedDataArray);
          const tbody = $('#fetchDataclosing_course'); // อ้างอิง <tbody>
          tbody.empty();
          if (fetchedDataArray.length > 0 && fetchedDataArray[0].texts !== '') {
            fetchedDataArray.forEach((item) => {
              // //console.log("ข้อมูล:", item);
              const row = `
              <tr> <!-- เก็บ id เป็น data attribute -->
                <td>${item.texts}</td> <!-- สมมุติ item มี title -->
                <td>
                    <button id="editclosing_course" class="btn btn-warning edit-btn" data-form-id="${item.sid}">แก้ไข</button>
                  <button class="btn btn-danger delete-btn" onclick="ondelete(${item.sid})">ลบ</button>
                </td>
              </tr>`;
              tbody.append(row); // เพิ่มแถวใหม่ใน <tbody>
            });
          } else {
            tbody.append('<tr><td colspan="2" class="text-center">ไม่มีข้อมูล</td></tr>');
          }
        } else {
          console.error('ไม่พบข้อมูลในฐานข้อมูล:', data);
        }
      },
      error: function(xhr, status, error) {
        console.error('เกิดข้อผิดพลาดในการดึงข้อมูล:', error);
      }
    });
  }
  <?php
  // เชื่อมต่อฐานข้อมูล
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "papreg5"; // เปลี่ยนเป็นชื่อฐานข้อมูลของคุณ

  // สร้างการเชื่อมต่อ
  $conn = new mysqli($servername, $username, $password, $dbname);

  // ตรวจสอบการเชื่อมต่อ
  if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
  }

  // ดึงข้อมูลจากฐานข้อมูล
  $sql = "SELECT * FROM 7checkbox WHERE cid = 1";
  $result = $conn->query($sql);

  // เช็คว่ามีข้อมูลหรือไม่
  if ($result->num_rows > 0) {
    // ดึงข้อมูล
    $row = $result->fetch_assoc();

    // ใช้ loop เพื่อเก็บค่าของแต่ละคอลัมน์ col1, col2, ..., col13
    for ($i = 1; $i <= 13; $i++) {
      ${"col$i"} = $row["col$i"];
    }
  } else {
    echo "ไม่พบข้อมูล";
  }

  // ปิดการเชื่อมต่อฐานข้อมูล
  $conn->close();
  ?>

  function loadCheck() {
    // ฝังค่าจาก PHP ลงใน JavaScript
    var col1 = <?php echo $col1; ?>;
    var col2 = <?php echo $col2; ?>;
    var col3 = <?php echo $col3; ?>;
    var col4 = <?php echo $col4; ?>;
    var col5 = <?php echo $col5; ?>;
    var col6 = <?php echo $col6; ?>;
    var col7 = <?php echo $col7; ?>;
    var col8 = <?php echo $col8; ?>;
    var col9 = <?php echo $col9; ?>;
    var col10 = <?php echo $col10; ?>;
    var col11 = <?php echo $col11; ?>;
    var col12 = <?php echo $col12; ?>;
    var col13 = <?php echo $col13; ?>;

    // ตั้งค่าการเช็คสำหรับแต่ละ checkbox ตามค่าที่ดึงมา
    $('#col1').prop('checked', col1 == 1);
    $('#col2').prop('checked', col2 == 1);
    $('#col3').prop('checked', col3 == 1);
    $('#col4').prop('checked', col4 == 1);
    $('#col5').prop('checked', col5 == 1);
    $('#col6').prop('checked', col6 == 1);
    $('#col7').prop('checked', col7 == 1);
    $('#col8').prop('checked', col8 == 1);
    $('#col9').prop('checked', col9 == 1);
    $('#col10').prop('checked', col10 == 1);
    $('#col11').prop('checked', col11 == 1);
    $('#col12').prop('checked', col12 == 1);
    $('#col13').prop('checked', col13 == 1);
  }


  function fetchDatatopic8() {
    $.ajax({
      url: 'fetchtopic8.php', // URL ของ PHP ที่จะดึงข้อมูล
      type: 'GET', // ใช้วิธีการ GET
      dataType: 'json', // รับข้อมูลเป็น JSON
      success: function(data) {
        if (data.response === 'success') {
          console.log("topic 8", data);
          const tbody = $('#fetchDatatopic8'); // อ้างอิง <tbody>
          tbody.empty(); // ล้างข้อมูลเดิมออก

          if (data.data.length > 0) {
            data.data.forEach((item, index) => {
              let row = `
                <tr> 
                  <td>${index + 1}</td>  
                  <td>${item.type}</td> 
                  <td>${item.admission_plan}</td> 
                  <td>${item.year1}</td>   
                  <td>${item.year2}</td>   
                  <td>${item.year3}</td>   
                  <td>${item.year4}</td>   
                  <td>${item.year5}</td>
                  <td>
                    <button id="editclosing_course" class="btn btn-warning" onclick="edittopic8(${item.id})">แก้ไข</button>
                  </td>
                  <td >
                    <button class="btn btn-danger delete-btn" onclick="deletetopic8(${item.id})">ลบ</button>
                  </td>
                </tr>`;
              tbody.append(row); // เพิ่มข้อมูลเข้าไปใน <tbody>
            });
          } else {
            tbody.append('<tr><td colspan="10" class="text-center">ไม่มีข้อมูล</td></tr>');
          }
        }
      },
      error: function(xhr, status, error) {
        console.error('เกิดข้อผิดพลาดในการดึงข้อมูล:', xhr, status, error);
      }
    });
  }
</script>

<body>
  <div class="container mt-5">
    <h1>ปิดหลักสูตร</h1>

    <!-- ชื่อเรื่อง -->
    <div class="card mt-5">
      <label class="card-header" for="title">ชื่อเรื่อง</label>
      <div class="card-body">
        <textarea id="title" class="form-control"></textarea>
        <button id="savetitle" data-form-id="1" class="btn btn-success mt-2">บันทึก</button>
      </div>
      <div class="card-body bg-white shadow-md rounded-lg">
        <table class='w-full table-auto bg-gray-100 rounded-lg overflow-hidden'>
          <thead class='bg-gray-200 text-gray-600'>
            <tr>
              <th class='py-2 px-4 border-b font-k2d'>หัวข้อ</th>
              <th class='py-2 px-4 border-b font-k2d'>การกระทำ</th>
            </tr>
          </thead>
          <tbody id="fetchDataTitle">
            <!--  -->
          </tbody>
        </table>
      </div>
      <div class="card-footer">
      </div>
    </div>

    <!-- หลักการและเหตุผล -->
    <div class="form-group">
      <div class="card mt-5">
        <label class="card-header" for="reasons">หลักการและเหตุผล</label>
        <div class="card-body">
          <textarea id="reasons" class="form-control"></textarea>
          <button id="savereasons" data-form-id="2" class="btn btn-success mt-2">บันทึก</button>
        </div>
        <div class="card-body bg-white shadow-md rounded-lg">
          <table class='w-full table-auto bg-gray-100 rounded-lg overflow-hidden'>
            <thead class='bg-gray-200 text-gray-600'>
              <tr>
                <th class='py-2 px-4 border-b font-k2d'>หัวข้อ</th>
                <th class='py-2 px-4 border-b font-k2d'>การกระทำ</th>
              </tr>
            </thead>
            <tbody id="fetchDataReasons">
            </tbody>
          </table>
        </div>
        <div class="card-footer">
        </div>
      </div>
    </div>

    <!-- สาระการปิดหลักสูตร -->
    <div class="form-group">
      <div class="card mt-5">
        <label class="card-header">สาระการปิดหลักสูตร</label>
        <div class="card-body">
          <!-- Textarea ทั้ง 3 ส่วน -->
          <div class="section">
            <label for="origin_info">ข้อมูลเดิม</label>
            <textarea id="origin_info" class="form-control mt-2"></textarea>
          </div>

          <div class="section mt-4">
            <label for="new_info">ข้อมูลใหม่</label>
            <textarea id="new_info" class="form-control mt-2"></textarea>
          </div>

          <div class="section mt-4">
            <label for="Closing_content">สาระการปิดหลักสูตร</label>
            <textarea id="Closing_content" class="form-control mt-2"></textarea>
          </div>

          <!-- ปุ่มบันทึก -->
          <button id="Tablesave1" class="btn btn-success mt-4">บันทึกทั้งหมด</button>
        </div>

        <!-- แสดงข้อมูลในตาราง -->
        <div class="card-body bg-white shadow-md rounded-lg mt-4">
          <table class='w-full table-auto bg-gray-100 rounded-lg overflow-hidden'>
            <thead class='bg-gray-200 text-gray-600'>
              <tr>
                <th id="" class='py-2 px-4 border-b font-k2d'>ที่</th>
                <th class='py-2 px-4 border-b font-k2d'>ข้อมูลเดิม</th>
                <th class='py-2 px-4 border-b font-k2d'>ข้อมูลใหม่</th>
                <th class='py-2 px-4 border-b font-k2d'>สาระการปิดหลักสูตร</th>
                <th class='py-2 px-4 border-b font-k2d'>แก้ไข</th>
                <th class='py-2 px-4 border-b font-k2d'>ลบ</th>
              </tr>
            </thead>
            <tbody id="displayDataTb1">
              <!--  -->
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- แบบฟอร์มการปิดหลักสูตร มหาวิทยาลัยมหาสารคาม -->
    <div class="form-group">
      <div class="card mt-5">
        <label class="card-header" for="course_name">แบบฟอร์มการปิดหลักสูตร</label>
        <div class="card-body">
          <label for="course_name">1.ชื่อหลักสูตร</label>
          <textarea id="course_name" class="form-control"></textarea>
          <button id="savecourse_name" data-form-id="6" class="btn btn-success mt-2">บันทึก</button>
        </div>
        <div class="card-body bg-white shadow-md rounded-lg">
          <table class='w-full table-auto bg-gray-100 rounded-lg overflow-hidden'>
            <thead class='bg-gray-200 text-gray-600'>
              <tr>
                <th class='py-2 px-4 border-b font-k2d'>ชื่อหลักสูตร</th>
                <th class='py-2 px-4 border-b font-k2d'>การกระทำ</th>
              </tr>
            </thead>
            <tbody id="fetchDatacourse_name">
            </tbody>
          </table>
        </div>
        <div class="card-body">
          <label for="Degree_name">2.ชื่อปริญญา</label>
          <textarea id="Degree_name" class="form-control"></textarea>
          <button id="saveDegree_name" data-form-id="7" class="btn btn-success mt-2">บันทึก</button>
        </div>
        <div class="card-body bg-white shadow-md rounded-lg">
          <table class='w-full table-auto bg-gray-100 rounded-lg overflow-hidden'>
            <thead class='bg-gray-200 text-gray-600'>
              <tr>
                <th class='py-2 px-4 border-b font-k2d'>ชื่อปริญญา</th>
                <th class='py-2 px-4 border-b font-k2d'>การกระทำ</th>
              </tr>
            </thead>
            <tbody id="fetchDataDegree_name">
            </tbody>
          </table>
        </div>
        <div class="card-body">
          <label for="agency">3.หน่วยงานที่รับผิดชอบ</label>
          <textarea id="agency" class="form-control"></textarea>
          <button id="saveagency" data-form-id="8" class="btn btn-success mt-2">บันทึก</button>
        </div>
        <div class="card-body bg-white shadow-md rounded-lg">
          <table class='w-full table-auto bg-gray-100 rounded-lg overflow-hidden'>
            <thead class='bg-gray-200 text-gray-600'>
              <tr>
                <th class='py-2 px-4 border-b font-k2d'>หน่วยงานที่รับผิดชอบ</th>
                <th class='py-2 px-4 border-b font-k2d'>การกระทำ</th>
              </tr>
            </thead>
            <tbody id="fetchDataagency">
            </tbody>
          </table>
        </div>
        <div class="card-body">
          <label for="first_open">4.หลักสูตรขออนุมัติเปิดครั้งแรก</label>
          <textarea id="first_open" class="form-control"></textarea>
          <button id="savefirst_open" data-form-id="9" class="btn btn-success mt-2">บันทึก</button>
        </div>
        <div class="card-body bg-white shadow-md rounded-lg">
          <table class='w-full table-auto bg-gray-100 rounded-lg overflow-hidden'>
            <thead class='bg-gray-200 text-gray-600'>
              <tr>
                <th class='py-2 px-4 border-b font-k2d'>หลักสูตรขออนุมัติเปิดครั้งแรก</th>
                <th class='py-2 px-4 border-b font-k2d'>การกระทำ</th>
              </tr>
            </thead>
            <tbody id="fetchDatafirst_open">
            </tbody>
          </table>
        </div>
        <div class="card-body">
          <label for="Last_update_course">5.หลักสูตรปรับปรุงครั้งสุดท้าย</label>
          <textarea id="Last_update_course" class="form-control"></textarea>
          <button id="saveLast_update_course" data-form-id="10" class="btn btn-success mt-2">บันทึก</button>
        </div>
        <div class="card-body bg-white shadow-md rounded-lg">
          <table class='w-full table-auto bg-gray-100 rounded-lg overflow-hidden'>
            <thead class='bg-gray-200 text-gray-600'>
              <tr>
                <th class='py-2 px-4 border-b font-k2d'>หลักสูตรปรับปรุงครั้งสุดท้าย</th>
                <th class='py-2 px-4 border-b font-k2d'>การกระทำ</th>
              </tr>
            </thead>
            <tbody id="fetchDataLast_update_course">
            </tbody>
          </table>
        </div>
        <div class="card-body">
          <label for="closing_course">6.ปิดหลักสูตร</label>
          <textarea id="closing_course" class="form-control"></textarea>
          <button id="saveclosing_course" data-form-id="11" class="btn btn-success mt-2">บันทึก</button>
        </div>
        <div class="card-body bg-white shadow-md rounded-lg">
          <table class='w-full table-auto bg-gray-100 rounded-lg overflow-hidden'>
            <thead class='bg-gray-200 text-gray-600'>
              <tr>
                <th class='py-2 px-4 border-b font-k2d'>ปิดหลักสูตร</th>
                <th class='py-2 px-4 border-b font-k2d'>การกระทำ</th>
              </tr>
            </thead>
            <tbody id="fetchDataclosing_course">
            </tbody>
          </table>
        </div>

        <div class="section mt-4 form-check">
          <label for="improv_info4">7. เหตุผลในการปิดหลักสูตร </label>

          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="col1" value="1"
              <?= isset($course['col1']) && $course['col1'] == 1 ? 'checked' : ''; ?>>
            <label class="form-check-label">
              หลักสูตรไม่สอดคล้องกับความต้องการของสังคม/ตลาดแรงงานของประเทศหรือต่างประเทศ
            </label>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="col2" value="1"
              <?= isset($course['col2']) && $course['col2'] == 1 ? 'checked' : ''; ?>>
            <label class="form-check-label">
              ไม่มีผู้สมัครเข้าเรียน ติดต่อกันเกิน 3 ปีการศึกษา ตั้งแต่ปีการศึกษา...................
            </label>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="col3" value="1"
              <?= isset($course['col3']) && $course['col3'] == 1 ? 'checked' : ''; ?>>
            <label class="form-check-label">
              ไม่มีการจัดการเรียนการสอน ติดต่อกันเกิน 3 ปีการศึกษา ตั้งแต่ปีการศึกษา......
            </label>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="col4" value="1"
              <?= isset($course['col4']) && $course['col4'] == 1 ? 'checked' : ''; ?>>
            <label class="form-check-label">
              ไม่ได้เปิดรับนิสิตมาแล้วไม่น้อยกว่า 3 ปีการศึกษา
            </label>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="col5" value="1"
              <?= isset($course['col5']) && $course['col5'] == 1 ? 'checked' : ''; ?>>
            <label class="form-check-label">
              มีหลักสูตรสาขาใหม่ทดแทน
            </label>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="col6" value="1"
              <?= isset($course['col6']) && $course['col6'] == 1 ? 'checked' : ''; ?>>
            <label class="form-check-label">
              ศักยภาพและความพร้อมยังไม่สอดคล้องกับเกณฑ์มาตรฐานหลักสูตรระดับอุดมศึกษา พ.ศ. 2558
            </label>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="col7" value="1"
              <?= isset($course['col7']) && $course['col7'] == 1 ? 'checked' : ''; ?>>
            <label class="form-check-label">
              จำนวนอาจารย์ผู้รับผิดชอบหลักสูตร/อาจารย์ประจำหลักสูตรไม่เป็นไปตามเกณฑ์มาตรฐานหลักสูตร พ.ศ. 2558
            </label>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="col8" value="1"
              <?= isset($course['col8']) && $course['col8'] == 1 ? 'checked' : ''; ?>>
            <label class="form-check-label">
              ผลงานทางวิชาการของอาจารย์ผู้รับผิดชอบหลักสูตรไม่เป็นไปตามเกณฑ์มาตรฐานหลักสูตร พ.ศ. 2558
            </label>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="col9" value="1"
              <?= isset($course['col9']) && $course['col9'] == 1 ? 'checked' : ''; ?>>
            <label class="form-check-label">
              ผลงานทางวิชาการของอาจารย์ประจำหลักสูตรไม่เป็นไปตามเกณฑ์มาตรฐานหลักสูตร พ.ศ. 2558
            </label>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="col10" value="1"
              <?= isset($course['col10']) && $course['col10'] == 1 ? 'checked' : ''; ?>>
            <label class="form-check-label">
              คุณวุฒิของอาจารย์ผู้รับผิดชอบหลักสูตรไม่ตรงหรือสัมพันธ์กับสาขาที่เปิดสอน
            </label>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="col11" value="1"
              <?= isset($course['col11']) && $course['col11'] == 1 ? 'checked' : ''; ?>>
            <label class="form-check-label">
              คุณวุฒิของอาจารย์ประจำหลักสูตรไม่ตรงหรือสัมพันธ์กับสาขาที่เปิดสอน
            </label>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="col12" value="1"
              <?= isset($course['col12']) && $course['col12'] == 1 ? 'checked' : ''; ?>>
            <label class="form-check-label">
              ทรัพยากรการจัดการเรียนการสอนมีไม่เพียงพอ
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="col13" value="1"
              <?= isset($course['col13']) && $course['col13'] == 1 ? 'checked' : ''; ?>>
            <label class="form-check-label">
              อื่นๆ (ระบุ) ตั้งแต่เริ่มเปิดหลักสูตรปี พ.ศ. 2563 จนถึงปัจจุบัน จำนวนนิสิตสมัครเข้าศึกษาในหลักสูตรน้อยไม่ถึงจุดคุ้มทุนที่หลักสูตรกำหนด คือ ปีการศึกษาละ 10 คน
            </label>
          </div>
          <button class="btn btn-success mt-2" onclick="saveCheck()">บันทึก</button>
        </div>

        <div class="card-body">
          <label for="reasons">8.ผลการรับนิสิต/การสำเร็จการศึกษาย้อนหลัง 5 ปี</label>
          <br>
          <label for="type">ประเภท </label>
          <input type="text" class="form-control mb-3" id="type" placeholder="-"></input>
          <label for="people">การรับนิสิต(จำนวนคน)</label>
          <input type="text" class="form-control mb-3" id="people" placeholder="-"></input>
          <div class="form-row">
            <div class="col">
              <label for="year_2563">ปี 2563</label>
              <input type="text" class="form-control mb-3" id="2563" placeholder="-"></input>
            </div>
            <div class="col">
              <label for="year_2564">ปี 2564</label>
              <input type="text" class="form-control mb-3" id="2564" placeholder="-"></input>
            </div>
            <div class="col">
              <label for="year_2565">ปี 2565</label>
              <input type="text" class="form-control mb-3" id="2565" placeholder="-"></input>
            </div>
            <div class="col">
              <label for="year_2566">ปี 2566</label>
              <input type="text" class="form-control mb-3" id="2566" placeholder="-"></input>
            </div>
            <div class="col">
              <label for="year_2567">ปี 2567</label>
              <input type="text" class="form-control mb-3" id="2567" placeholder="-"></input>
            </div>
          </div>
          <button class="btn btn-success mt-2" onclick="saveTopic8()">บันทึก</button>
        </div>

        <div class="card-body bg-white shadow-md rounded-lg">
          <table class='w-full table-auto bg-gray-100 rounded-lg overflow-hidden'>
            <thead class='bg-gray-200 text-gray-600'>
              <tr>
                <th rowspan="2" class='py-2 px-4 border-b font-k2d'>ที่</th>
                <th rowspan="2" class='py-2 px-4 border-b font-k2d'>ประเภท</th>
                <th rowspan="2" class='py-2 px-4 border-b font-k2d'>แผนการรับนิสิต</th>
                <th colspan="5" class='py-2 px-4 border-b font-k2d'>จำนวนนิสิตในแต่ละปีการศึกษา (คน)</th>
                <th rowspan="2" class='py-2 px-4 border-b font-k2d'>แก้ไข</th>
                <th rowspan="2" class='py-2 px-4 border-b font-k2d'>ลบ</th>
              <tr>
                <th class='py-2 px-4 border-b font-k2d'>2563</th>
                <th class='py-2 px-4 border-b font-k2d'>2564</th>
                <th class='py-2 px-4 border-b font-k2d'>2565</th>
                <th class='py-2 px-4 border-b font-k2d'>2566</th>
                <th class='py-2 px-4 border-b font-k2d'>2567</th>
              </tr>

              </tr>
            </thead>
            <tbody id="fetchDatatopic8">
            </tbody>
          </table>
        </div>
        <div class="section mt-4 form-check">
          <label for="improv_info4">9.หน่วยงานต้นสังกัด มีแผนดำเนินการหลังปิดหลักสูตร ดังนี้</label><br>
          <label>9.1 รายวิชาของหลักสูตรที่ขอปิด ประสงค์ให้</label>
          <div class="form-check">
            <input class="form-check-input" type="checkbox">
            <label class="form-check-label" for="flexCheckDefault">
              <b>ปิดรายวิชาในหลักสูตรทั้งหมด</b> (ทั้งนี้ต้องไม่มีผลกระทบกับการเรียนการสอนในหลักสูตรอื่น ๆ ของมหาวิทยาลัย)
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox">
            <label class="form-check-label" for="flexCheckDefault">
              <b>ขอคงรายวิชาในหลักสูตรไว้</b> เนื่องจาก (ระบุเหตุผลของการขอคงชื่อหลักสูตร/สาขาวิชาที่ขอใช้รายวิชาของหลักสูตรที่ขอปิด)
            </label>
          </div>

          <label class="mt-3">9.2จำนวนนิสิตคงค้างแยกตามชั้นปี (โปรดแยกระบบ/แผนการศึกษา ถ้ามี)</label>
          <div class="form-check">
            <input class="form-check-input" name="1" type="checkbox" id="noStudents">
            <label class="form-check-label" for="noStudents">
              <b>ไม่มีนิสิตคงค้าง</b>
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" name="2" type="checkbox" id="hasStudents">
            <label class="form-check-label" for="hasStudents">
              มีนิสิตคงค้าง รายละเอียดดังนี้
            </label>
          </div>
          <div id="studentDetails" style="display: none;">
            <label for="" class="mt-2">จำนวนนิสิต</label>
            <input class="form-control "></input>
            <div class="container my-4">
              <h4 class="text-center">จำนวนนิสิต</h4>
              <div class="row  text-center">
                <div class="col-2 ">ชั้นปีที่</div>
                <div class="col-5 ">ระบบในเวลาราชการ</div>
                <div class="col-5 ">ระบบนอกเวลาราชการ</div>
              </div>
              <div class="row  text-center">
                <div class="col-2 "></div>
                <div class="col-2 ">แผน ก 1</div>
                <div class="col-3 ">แผน ก 2</div>
                <div class="col-2 ">แผน ก 1</div>
                <div class="col-3 ">แผน ก 2</div>
              </div>
              <!-- Rows for each year -->

              <div class="row border-bottom text-center">
                <div class="col-2 ">1</div>
                <div class="col-2 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
                <div class="col-3 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
                <div class="col-2 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
                <div class="col-3 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
              </div>

              <div class="row border-bottom text-center">
                <div class="col-2 ">2</div>
                <div class="col-2 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
                <div class="col-3 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
                <div class="col-2 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
                <div class="col-3 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
              </div>
              <!--  -->
              <div class="row border-bottom text-center">
                <div class="col-2 ">3</div>
                <div class="col-2 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
                <div class="col-3 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
                <div class="col-2 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
                <div class="col-3 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
              </div>
              <!--  -->
              <div class="row border-bottom text-center">
                <div class="col-2 ">4</div>
                <div class="col-2 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
                <div class="col-3 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
                <div class="col-2 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
                <div class="col-3 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
              </div>
              <!--  -->
              <div class="row border-bottom text-center">
                <div class="col-2 ">5</div>
                <div class="col-2 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
                <div class="col-3 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
                <div class="col-2 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
                <div class="col-3 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
              </div>
              <!--  -->
              <div class="row border-bottom text-center">
                <div class="col-2 ">6</div>
                <div class="col-2 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
                <div class="col-3 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
                <div class="col-2 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
                <div class="col-3 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
              </div>
              <!--  -->
              <div class="row border-bottom text-center">
                <div class="col-2 ">7</div>
                <div class="col-2 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
                <div class="col-3 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
                <div class="col-2 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
                <div class="col-3 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
              </div>
              <!--  -->
              <div class="row border-bottom text-center">
                <div class="col-2 ">8</div>
                <div class="col-2 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
                <div class="col-3 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
                <div class="col-2 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
                <div class="col-3 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
              </div>
              <!--  -->
              <div class="row border-bottom text-center">
                <div class="col-2 ">9</div>
                <div class="col-2 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
                <div class="col-3 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
                <div class="col-2 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
                <div class="col-3 ">
                  <input type="text" class="form-control" placeholder="-" />
                </div>
              </div>
              <button id="savereasons" class="btn btn-success mt-2">บันทึก</button>

            </div>

            <label for="">รายชื่อ</label>
            <div class="row text-center">
              <div class="col-3">รหัสนิสิต</div>
              <div class="col-3">ชื่อ-สกุล</div>
              <div class="col-3">ชั้นปีที่</div>
            </div>
            <div class="row mb-2">
              <input type="text" class="form-control col-3 mr-2" placeholder="-" />
              <input type="text" class="form-control col-3 mr-2" placeholder="-" />
              <input type="text" class="form-control col-3" placeholder="-" />
            </div>
            <div class="row text-center">
              <div class="col-3">จำนวนหน่วยกิตที่เหลือ</div>
              <div class="col-3">ปีที่คาดว่าจะสำเร็จการศึกษา</div>
              <div class="col-3">รายชื่ออาจารย์ที่ปรึกษาวิทยานิพนธ์</div>
            </div>
            <div class="row mb-2">
              <input type="text" class="form-control col-3 mr-2" placeholder="-" />
              <input type="text" class="form-control col-3 mr-2" placeholder="-" />
              <input type="text" class="form-control col-3" placeholder="-" />
            </div>
            <button id="" class="btn btn-success mt-2">บันทึก</button>

            <div class="card-body">
              <label for="Guidelines">แนวทางการดำเนินการกับนิสิตที่คงค้าง</label>
              <textarea id="Guidelines" class="form-control"></textarea>
              <button id="saveGuidelines" data-form-id="2" class="btn btn-success mt-2">บันทึก</button>
            </div>
            <div class="card-body bg-white shadow-md rounded-lg">
              <table class='w-full table-auto bg-gray-100 rounded-lg overflow-hidden'>
                <thead class='bg-gray-200 text-gray-600'>
                  <tr>
                    <th class='py-2 px-4 border-b font-k2d'>แนวทางการดำเนินการกับนิสิตที่คงค้าง</th>
                    <th class='py-2 px-4 border-b font-k2d'>การกระทำ</th>
                  </tr>
                </thead>
                <tbody id="">
                </tbody>
              </table>
            </div>
          </div>

          <script>
            $(document).ready(function() {
              $('#hasStudents').change(function() {
                if ($(this).is(':checked')) {
                  $('#studentDetails').show();
                } else {
                  $('#studentDetails').hide();
                }
              });
              $('#noStudents').change(function() {
                if ($(this).is(':checked')) {
                  $('#studentDetails').hide();
                }
              });
            });
          </script>
          </script>
          <label for="">9.3 การจัดสรรอัตรากำลังใหม่ หลังจากปิดหลักสูตรแล้ว</label>
          <div class="card-body">
            <label for="Teacher">อาจารย์ผู้รับผิดชอบหลักสูตร/อาจารย์ประจำหลักสูตรที่ขอปิด*</label>
            <textarea id="Teacher" class="form-control"></textarea>
          </div>
          <div class="card-body">
            <label for="teaching_load">ภาระงานสอนในปัจจุบัน/อาจารย์ประจำหลักสูตรอื่น (ระบุชื่อหลักสูตร)</label>
            <textarea id="teaching_load" class="form-control"></textarea>
          </div>
          <button id="saveTable" data-form-id="2" class="btn btn-success mt-2">บันทึก</button>
          <div class="card-body bg-white shadow-md rounded-lg">
            <table class='w-full table-auto bg-gray-100 rounded-lg overflow-hidden'>
              <thead class='bg-gray-200 text-gray-600'>
                <tr>
                  <th class='py-2 px-4 border-b font-k2d'>อาจารย์ผู้รับผิดชอบหลักสูตร/อาจารย์ประจำหลักสูตรที่ขอปิด*</th>
                  <th class='py-2 px-4 border-b font-k2d'>ภาระงานสอนในปัจจุบัน/อาจารย์ประจำหลักสูตรอื่น (ระบุชื่อหลักสูตร)</th>
                  <th class='py-2 px-4 border-b font-k2d'>การกระทำ</th>
                </tr>
              </thead>
              <tbody id="fetchDataReasons">
              </tbody>
            </table>
          </div>

          <div class="card-body">
            <label for="other">9.4 อื่นๆ (ระบุ)</label>
            <textarea id="other" class="form-control"></textarea>
            <button id="saveother" data-form-id="2" class="btn btn-success mt-2">บันทึก</button>
          </div>
          <div class="card-body bg-white shadow-md rounded-lg">
            <table class='w-full table-auto bg-gray-100 rounded-lg overflow-hidden'>
              <thead class='bg-gray-200 text-gray-600'>
                <tr>
                  <th class='py-2 px-4 border-b font-k2d'>อื่นๆ (ระบุ)</th>
                  <th class='py-2 px-4 border-b font-k2d'>การกระทำ</th>
                </tr>
              </thead>
              <tbody id="">
              </tbody>
            </table>
          </div>

          <div class="card-body">
            <label for="approval_result">10.ผลการอนุมัติปิดหลักสูตร</label>
            <textarea id="approval_result" class="form-control"></textarea>
            <button id="saveapproval_result" data-form-id="2" class="btn btn-success mt-2">บันทึก</button>
          </div>
          <div class="card-body bg-white shadow-md rounded-lg">
            <table class='w-full table-auto bg-gray-100 rounded-lg overflow-hidden'>
              <thead class='bg-gray-200 text-gray-600'>
                <tr>
                  <th class='py-2 px-4 border-b font-k2d'>ผลการอนุมัติปิดหลักสูตร</th>
                  <th class='py-2 px-4 border-b font-k2d'>การกระทำ</th>
                </tr>
              </thead>
              <tbody id="">
              </tbody>
            </table>
          </div>
          <div class="card-body">
            <label for="propos_issue">ประเด็นที่เสนอ</label>
            <textarea id="propos_issue" class="form-control"></textarea>
            <button id="savepropos_issue" data-form-id="2" class="btn btn-success mt-2">บันทึก</button>
          </div>
          <div class="card-body bg-white shadow-md rounded-lg">
            <table class='w-full table-auto bg-gray-100 rounded-lg overflow-hidden'>
              <thead class='bg-gray-200 text-gray-600'>
                <tr>
                  <th class='py-2 px-4 border-b font-k2d'>ประเด็นที่เสนอ</th>
                  <th class='py-2 px-4 border-b font-k2d'>การกระทำ</th>
                </tr>
              </thead>
              <tbody id="">
              </tbody>
            </table>
          </div>

          <div class="card-body">
            <label for="mati">มติ</label>
            <textarea id="mati" class="form-control"></textarea>
            <button id="savemati" data-form-id="2" class="btn btn-success mt-2">บันทึก</button>
          </div>
          <div class="card-body bg-white shadow-md rounded-lg">
            <table class='w-full table-auto bg-gray-100 rounded-lg overflow-hidden'>
              <thead class='bg-gray-200 text-gray-600'>
                <tr>
                  <th class='py-2 px-4 border-b font-k2d'>มติ</th>
                  <th class='py-2 px-4 border-b font-k2d'>การกระทำ</th>
                </tr>
              </thead>
              <tbody id="">
              </tbody>
            </table>
          </div>

        </div>
        <div class="card-footer">
        </div>
      </div>

    </div>

  </div>
  </div>
</body>
<script>
  $('#title,#reasons,  #origin_info, #new_info, #Closing_content,#course_name,#Degree_name,#agency,#first_open,#Last_update_course,#closing_course,Guidelines,#Teacher,#teaching_load,#other,#approval_result,#propos_issue, #mati').summernote({
    height: 120,
  });

  function saveData(selector, formId) {
    var data = $(selector).summernote('code'); // Get the content
    console.log(data);

    // Check if content is empty or not
    if (data.trim() === "" || data.trim() === "<p><br></p>") {
      alert('เนื้อหาว่างเปล่า กรุณาเพิ่มข้อมูลก่อนบันทึก.');
      return; // Exit the function if content is empty
    }

    // var encodedData = btoa(unescape(encodeURIComponent(data))); // Encode in Base64

    $.ajax({
      type: 'POST',
      url: 'insert.php',
      dataType: 'json',
      data: {
        action: 'saveform',
        data: data,
        formId: formId // Send form ID to identify which form is being saved
      },
      success: function(response) {
        alert("บันทึกข้อมูลแล้ว"); // Handle success response
        //console.log(response)
        loadData();

      },
      error: function(xhr, status, error) {
        console.log('เกิดข้อผิดพลาดในการบันทึกข้อมูล.', status, error);
        alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล.', xhr, status, error);
      }
    });
  }
  // Attach click event handlers dynamically to buttons
  $('[id^="save"]').click(function() {
    console.log("click")
    var formId = $(this).data('form-id'); // Get form ID from the button's data attribute
    var relatedInputId = $(this).attr('id').replace('save', ''); // Extract the related input ID
    var selector = '#' + relatedInputId; // Create the selector dynamically

    saveData(selector, formId); // Call the save function with dynamic selector and form ID
  });

  // table 1
  $('#Tablesave1').on('click', function() {

    const origin_Info = $('#origin_info').val();
    const new_info = $('#new_info').val();
    const Closing_content = $('#Closing_content').val();

    console.log("table1")
    if (!origin_Info && !new_info && !Closing_content) {
      alert('กรุณากรอกข้อมูลให้ครบทุกช่อง');
      return;
    }
    $.ajax({
      url: 'insert.php',
      type: 'POST',
      dataType: 'json',
      data: {
        action: 'Allsave',
        origin_Info: origin_Info,
        new_info: new_info,
        Closing_content: Closing_content
      },
      success: function(response) {
        console.log("ผลลัพธ์จากเซิร์ฟเวอร์:", response);

        if (response.response === 'Data saved successfully!') {
          alert('บันทึกข้อมูลเรียบร้อยแล้ว');
          fetchDataTb1()
        } else {
          alert(`เกิดข้อผิดพลาด: ${result.message || 'ไม่ทราบสาเหตุ'}`);

        }
      }
    }, );

  });

  function saveCheck() {
    // ดึงค่าจาก Checkbox
    var checkboxData = {
      col1: $('#col1').is(':checked') ? 1 : 0,
      col2: $('#col2').is(':checked') ? 1 : 0,
      col3: $('#col3').is(':checked') ? 1 : 0,
      col4: $('#col4').is(':checked') ? 1 : 0,
      col5: $('#col5').is(':checked') ? 1 : 0,
      col6: $('#col6').is(':checked') ? 1 : 0,
      col7: $('#col7').is(':checked') ? 1 : 0,
      col8: $('#col8').is(':checked') ? 1 : 0,
      col9: $('#col9').is(':checked') ? 1 : 0,
      col10: $('#col10').is(':checked') ? 1 : 0,
      col11: $('#col11').is(':checked') ? 1 : 0,
      col12: $('#col12').is(':checked') ? 1 : 0,
      col13: $('#col13').is(':checked') ? 1 : 0
    };
    console.log(checkboxData)
    // ส่งข้อมูลผ่าน AJAX
    $.ajax({
      type: 'POST',
      url: 'saveCheck.php',
      dataType: 'json',
      data: checkboxData, // ส่งข้อมูล checkbox ไปที่ PHP
      success: function(response) {
        alert("บันทึกข้อมูลแล้ว");
      },
      error: function(xhr, status, error) {
        console.log('เกิดข้อผิดพลาดในการบันทึกข้อมูล.', status, error);
        alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล.');
      }
    });
  }
  let currentId = null;

  function saveTopic8() {
    if ($("#type").val().trim() === "") {
      alert("กรุณากรอกข้อมูลประเภท");
      return;
    }
    $.ajax({
      type: 'POST',
      url: 'insert.php',
      dataType: 'json',
      data: {
        id: currentId ?? null,
        action: 'saveTopic8',
        type: $("#type").val(),
        people: $("#people").val(),
        year1: $("#2563").val(),
        year2: $("#2564").val(),
        year3: $("#2565").val(),
        year4: $("#2566").val(),
        year5: $("#2567").val(),
      },
      success: function(response) {
        console.log("✅ Response from server:", response);
        alert("บันทึกข้อมูลเรียบร้อย");
        fetchDatatopic8();
        currentId = response.id
      },
      error: function(xhr, status, error) {
        console.log(xhr.responseText);
        alert("❌ เกิดข้อผิดพลาดในการบันทึกข้อมูล");
        console.log("❌ Error details:", xhr, status, error);
      }
    });
  }



  ////////////////////////  EDIT HEREE
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  $(document).on('click', '.edit-btn', function() {
    const Id = $(this).attr('id').replace('edit', '');
    //console.log("Editor ID:", Id);

    const formId = $(this).data('form-id'); // Get form ID from the button
    //console.log("Form ID:", formId);

    // Fetch data for the given form ID
    $.ajax({
      url: 'fetch_data.php', // Endpoint for fetching data
      type: 'GET',
      dataType: 'json',
      data: {
        formId: formId,
        action: 'getform' // Specify the action
      },
      success: function(response) {
        console.log(response)
        $('#' + Id).summernote('code', response.data[0].texts);
      },
      error: function(xhr, status, error) {
        console.error("Error details:", {
          xhr,
          status,
          error
        });
        alert(`เกิดข้อผิดพลาด: ${status} - ${error}`);
      }
    });
  });

  function edittable1() {
    const action = "table1";

    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'fetchtable.php?action=' + action, true);

    xhr.onreadystatechange = function() {
      if (xhr.readyState == 4) {
        if (xhr.status == 200) {
          try {
            var tb1 = JSON.parse(xhr.responseText);
            console.log("edit", tb1)
            $('#origin_info').summernote('code', tb1.data[0].texts || '');
            $('#new_info').summernote('code', tb1.data[1].texts || '');
            $('#Closing_content').summernote('code', tb1.data[2].texts || '');
          } catch (e) {
            console.error('Error parsing JSON:', e);
          }
        } else {
          console.error('Failed to fetch data:', xhr.status);
        }
      }
    };

    xhr.send();
  };

  function edittopic8(id) {
    $.ajax({
      url: 'fetchtopic8.php', // URL ของ PHP ที่จะดึงข้อมูล
      type: 'GET', // การส่งข้อมูลแบบ GET
      dataType: 'json',
      // กำหนดให้รับข้อมูลในรูปแบบ JSON
      success: function(data) {
        if (data.response === 'success') {
          console.log("topic 8", data.data[0].type);
          const item = data.data.find(d => d.id === id);
          if (item) {
            $("#type").val(item.type);
            $("#people").val(item.admission_plan);
            $("#2563").val(item.year1);
            $("#2564").val(item.year2);
            $("#2565").val(item.year3);
            $("#2566").val(item.year4);
            $("#2567").val(item.year5);
            currentId = id;
          } else {
            console.error('ไม่พบข้อมูลในฐานข้อมูล:', data);
          }
        } else {
          console.error('ไม่พบข้อมูลในฐานข้อมูล:', data);
        }
      },
      error: function(xhr, status, error) {
        console.error('เกิดข้อผิดพลาดในการดึงข้อมูล:', xhr, status, error);
      }
    });

  }



  ///////////////////////////// DELETE BELOW
  /////////////////////////////////////////////////////////////  
  function ondelete(formId) {
    if (confirm('คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?')) {
      $.ajax({
        type: 'POST',
        url: 'delete.php',
        dataType: 'json', // Expect JSON response
        data: {
          action: 'deleteform',
          formId: formId,
        },
        success: function(response) {
          if (response.status === 'success') {
            alert('ลบข้อมูลสำเร็จ');
            loadData();
          } else {
            alert('ลบข้อมูลไม่สำเร็จ: ' + response.message);
          }
        },
        error: function(xhr, status, error) {
          console.error('Error:', xhr.responseText); // Check server response
          alert(`เกิดข้อผิดพลาด: ${status} - ${error}`);
          loadData();
        }
      });

    }
  }


  function deletetable1() {
    if (confirm('คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?')) {
      $.ajax({
        type: 'POST',
        url: 'delete.php',
        dataType: 'json', // Expect JSON response
        data: {
          action: 'deletetable1',
        },
        success: function(response) {
          if (response.status === 'success') {
            alert('ลบข้อมูลสำเร็จ');
            loadData();
          } else {
            alert('ลบข้อมูลไม่สำเร็จ: ' + response.message);
            loadData();
          }
        },
        error: function(xhr, status, error) {
          console.error('Error:', xhr.responseText); // Check server response
          alert(`เกิดข้อผิดพลาด: ${status} - ${error}`);
          loadData();
        }
      });

    }
  }

  function deletetopic8(id) {
    if (confirm('คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?')) {
      $.ajax({
        type: 'POST',
        url: 'delete.php',
        dataType: 'json', // Expect JSON response
        data: {
          action: 'topic8',
          id: id
        },
        success: function(response) {
          if (response.status === 'success') {
            alert('ลบข้อมูลสำเร็จ');
            loadData();
          } else {
            alert('ลบข้อมูลไม่สำเร็จ: ' + response.message);
            loadData();
          }
        },
        error: function(xhr, status, error) {
          console.log('Error:', xhr, status, error); // Check server response
          // alert(`เกิดข้อผิดพลาด: ${status} - ${error}`);
          alert('ลบข้อมูลสำเร็จ');
          location.reload();
        }
      });

    }
  }
</script>

</html>