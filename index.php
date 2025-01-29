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
          <button id="savecourse_name" data-form-id="2" class="btn btn-success mt-2">บันทึก</button>
        </div>
        <div class="card-body bg-white shadow-md rounded-lg">
          <table class='w-full table-auto bg-gray-100 rounded-lg overflow-hidden'>
            <thead class='bg-gray-200 text-gray-600'>
              <tr>
                <th class='py-2 px-4 border-b font-k2d'>ชื่อหลักสูตร</th>
                <th class='py-2 px-4 border-b font-k2d'>การกระทำ</th>
              </tr>
            </thead>
            <tbody id="">
            </tbody>
          </table>
        </div>


        <div class="card-body">
          <label for="Degree_name">2.ชื่อปริญญา</label>
          <textarea id="Degree_name" class="form-control"></textarea>
          <button id="saverDegree_name" data-form-id="2" class="btn btn-success mt-2">บันทึก</button>
        </div>
        <div class="card-body bg-white shadow-md rounded-lg">
          <table class='w-full table-auto bg-gray-100 rounded-lg overflow-hidden'>
            <thead class='bg-gray-200 text-gray-600'>
              <tr>
                <th class='py-2 px-4 border-b font-k2d'>ชื่อปริญญา</th>
                <th class='py-2 px-4 border-b font-k2d'>การกระทำ</th>
              </tr>
            </thead>
            <tbody id="">
            </tbody>
          </table>
        </div>



        <div class="card-body">
          <label for="agency">3.หน่วยงานที่รับผิดชอบ</label>
          <textarea id="agency" class="form-control"></textarea>
          <button id="saveagency" data-form-id="2" class="btn btn-success mt-2">บันทึก</button>
        </div>
        <div class="card-body bg-white shadow-md rounded-lg">
          <table class='w-full table-auto bg-gray-100 rounded-lg overflow-hidden'>
            <thead class='bg-gray-200 text-gray-600'>
              <tr>
                <th class='py-2 px-4 border-b font-k2d'>หน่วยงานที่รับผิดชอบ</th>
                <th class='py-2 px-4 border-b font-k2d'>การกระทำ</th>
              </tr>
            </thead>
            <tbody id="">
            </tbody>
          </table>
        </div>



        <div class="card-body">
          <label for="first_open">4.หลักสูตรขออนุมัติเปิดครั้งแรก</label>
          <textarea id="first_open" class="form-control"></textarea>
          <button id="savefirst_open" data-form-id="2" class="btn btn-success mt-2">บันทึก</button>
        </div>
        <div class="card-body bg-white shadow-md rounded-lg">
          <table class='w-full table-auto bg-gray-100 rounded-lg overflow-hidden'>
            <thead class='bg-gray-200 text-gray-600'>
              <tr>
                <th class='py-2 px-4 border-b font-k2d'>หลักสูตรขออนุมัติเปิดครั้งแรก</th>
                <th class='py-2 px-4 border-b font-k2d'>การกระทำ</th>
              </tr>
            </thead>
            <tbody id="">
            </tbody>
          </table>
        </div>



        <div class="card-body">
          <label for="Last_update_course">5.หลักสูตรปรับปรุงครั้งสุดท้าย</label>
          <textarea id="Last_update_course" class="form-control"></textarea>
          <button id="saveLast_update_course" data-form-id="2" class="btn btn-success mt-2">บันทึก</button>
        </div>
        <div class="card-body bg-white shadow-md rounded-lg">
          <table class='w-full table-auto bg-gray-100 rounded-lg overflow-hidden'>
            <thead class='bg-gray-200 text-gray-600'>
              <tr>
                <th class='py-2 px-4 border-b font-k2d'>หลักสูตรปรับปรุงครั้งสุดท้าย</th>
                <th class='py-2 px-4 border-b font-k2d'>การกระทำ</th>
              </tr>
            </thead>
            <tbody id="">
            </tbody>
          </table>
        </div>



        <div class="card-body">
          <label for="closing_course">6.ปิดหลักสูตร</label>
          <textarea id="closing_course" class="form-control"></textarea>
          <button id="saveclosing_course" data-form-id="2" class="btn btn-success mt-2">บันทึก</button>
        </div>
        <div class="card-body bg-white shadow-md rounded-lg">
          <table class='w-full table-auto bg-gray-100 rounded-lg overflow-hidden'>
            <thead class='bg-gray-200 text-gray-600'>
              <tr>
                <th class='py-2 px-4 border-b font-k2d'>ปิดหลักสูตร</th>
                <th class='py-2 px-4 border-b font-k2d'>การกระทำ</th>
              </tr>
            </thead>
            <tbody id="">
            </tbody>
          </table>
        </div>

        <div class="section mt-4 form-check">
          <label for="improv_info4">7. เหตุผลในการปิดหลักสูตร </label>
          <div class="form-check">
            <input class="form-check-input" type="checkbox">
            <label class="form-check-label" for="flexCheckDefault">
              หลักสูตรไม่สอดคล้องกับความต้องการของสังคม/ตลาดแรงงานของประเทศหรือต่างประเทศ
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox">
            <label class="form-check-label" for="flexCheckDefault">
              ไม่มีผู้สมัครเข้าเรียน ติดต่อกันเกิน 3 ปีการศึกษา ตั้งแต่ปีการศึกษา...................
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox">
            <label class="form-check-label" for="flexCheckDefault">
              ไม่มีการจัดการเรียนการสอน ติดต่อกันเกิน 3 ปีการศึกษา ตั้งแต่ปีการศึกษา......
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox">
            <label class="form-check-label" for="flexCheckDefault">
              ไม่ได้เปิดรับนิสิตมาแล้วไม่น้อยกว่า 3 ปีการศึกษา
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox">
            <label class="form-check-label" for="flexCheckDefault">
              มีหลักสูตรสาขาใหม่ทดแทน
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox">
            <label class="form-check-label" for="flexCheckDefault">
              ศักยภาพและความพร้อมยังไม่สอดคล้องกับเกณฑ์มาตรฐานหลักสูตรระดับอุดมศึกษา พ.ศ. 2558
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox">
            <label class="form-check-label" for="flexCheckDefault">
              จำนวนอาจารย์ผู้รับผิดชอบหลักสูตร/อาจารย์ประจำหลักสูตรไม่เป็นไปตามเกณฑ์มาตรฐานหลักสูตร พ.ศ. 2558
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox">
            <label class="form-check-label" for="flexCheckDefault">
              ผลงานทางวิชาการของอาจารย์ผู้รับผิดชอบหลักสูตรไม่เป็นไปตามเกณฑ์มาตรฐานหลักสูตร พ.ศ. 2558
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox">
            <label class="form-check-label" for="flexCheckDefault">
              ผลงานทางวิชาการของอาจารย์ประจำหลักสูตรไม่เป็นไปตามเกณฑ์มาตรฐานหลักสูตร พ.ศ. 2558
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox">
            <label class="form-check-label" for="flexCheckDefault">
              คุณวุฒิของอาจารย์ผู้รับผิดชอบหลักสูตรไม่ตรงหรือสัมพันธ์กับสาขาที่เปิดสอน
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox">
            <label class="form-check-label" for="flexCheckDefault">
              คุณวุฒิของอาจารย์ประจำหลักสูตรไม่ตรงหรือสัมพันธ์กับสาขาที่เปิดสอน
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox">
            <label class="form-check-label" for="flexCheckDefault">
              ทรัพยากรการจัดการเรียนการสอนมีไม่เพียงพอ
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox">
            <label class="form-check-label" for="flexCheckDefault">
              อื่นๆ (ระบุ) ตั้งแต่เริ่มเปิดหลักสูตรปี พ.ศ. 2563 จนถึงปัจจุบัน จำนวนนิสิตสมัครเข้าศึกษาในหลักสูตรน้อยไม่ถึงจุดคุ้มทุนที่หลักสูตรกำหนด คือ ปีการศึกษาละ 10 คน
            </label>
          </div>
        </div>

        <div class="card-body">
          <label for="reasons">8.ผลการรับนิสิต/การสำเร็จการศึกษาย้อนหลัง 5 ปี</label>
          <br>
          <label for="reasons">การรับนิสิต(จำนวนคน)</label>
          <input type="text" class="form-control mb-3"></input>

          <div class="form-row">
            <div class="col">
              <label for="reasons">ปี 2563</label>
              <input type="text" class="form-control mb-3"></input>
            </div>
            <div class="col">
              <label for="reasons">ปี 2564</label>
              <input type="text" class="form-control mb-3"></input>
            </div>
            <div class="col">
              <label for="reasons">ปี 2565</label>
              <input type="text" class="form-control mb-3"></input>
            </div>
            <div class="col">
              <label for="reasons">ปี 2566</label>
              <input type="text" class="form-control mb-3"></input>
            </div>
            <div class="col">
              <label for="reasons">ปี 2567</label>
              <input type="text" class="form-control mb-3"></input>
            </div>
          </div>

          <label for="reasons">การสำเร็จการศึกษา(จำนวนคน)</label>
          <input type="text" class="form-control mb-3"></input>

          <div class="form-row">
            <div class="col">
              <label for="reasons">ปี 2563</label>
              <input type="text" class="form-control mb-3"></input>
            </div>
            <div class="col">
              <label for="reasons">ปี 2564</label>
              <input type="text" class="form-control mb-3"></input>
            </div>
            <div class="col">
              <label for="reasons">ปี 2565</label>
              <input type="text" class="form-control mb-3"></input>
            </div>
            <div class="col">
              <label for="reasons">ปี 2566</label>
              <input type="text" class="form-control mb-3"></input>
            </div>
            <div class="col">
              <label for="reasons">ปี 2567</label>
              <input type="text" class="form-control mb-3"></input>
            </div>
          </div>
          <button id="" class="btn btn-success mt-2">บันทึก</button>
        </div>
        <div class="card-body bg-white shadow-md rounded-lg">
          <table class='w-full table-auto bg-gray-100 rounded-lg overflow-hidden'>
            <thead class='bg-gray-200 text-gray-600'>
              <tr>
                <th class='py-2 px-4 border-b font-k2d'>ปิดหลักสูตร</th>
                <th class='py-2 px-4 border-b font-k2d'>การกระทำ</th>
              </tr>
            </thead>
            <tbody id="">
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
              <!-- Year 1 -->
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
              <!-- Year 2 -->
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
    console.log(formId);

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
</script>

</html>