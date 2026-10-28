<?php
require 'init.php';
head('สมัครสมาชิก');
?>
<div class="container p-4">
  <form method="post" action="controller/checkregister.php" class="card card-body mx-auto" style="max-width:520px" onsubmit="return checkPasswords()">
    <label class="form-label mt-2">ชื่อ-นามสกุล</label>
    <input class="form-control" type="text" name="name" required>
    <label class="form-label mt-2">อีเมล</label>
    <input class="form-control" type="email" name="email" id="email" required>

    <label class="form-label mt-2">เบอร์โทรศัพท์ (ตัวเลข 10 หลัก)</label>
    <input class="form-control" type="text" name="phone" maxlength="10" inputmode="numeric" pattern="0[0-9]{9}" title="ตัวเลข 10 หลัก ขึ้นต้นด้วย 0">

    <label class="form-label mt-2">รหัสผ่าน (อย่างน้อย 8 ตัวอักษร)</label>
    <input class="form-control" type="password" name="password" id="1" value="" required minlength="8">

    <label class="form-label mt-2">ยืนยันรหัสผ่าน</label>
    <input class="form-control" type="password" name="password2" id="2" value="" required>
    <label class="form-label mt-2">คำถามกันลืมรหัสผ่าน</label>
    <select class="form-select mt-2" id="" name="question" required>
      <option value="">เลือกคำถาม</option>
      <option value="สัตว์เลี้ยง">สัตว์เลี้ยงชื่ออะไร</option>
    </select>
    <label class="form-label mt-2">คำตอบ (ใช้ตั้งรหัสผ่านใหม่เมื่อลืม)</label>    
    <input class="form-control" type="text" name="answer" required>
    <button type="submit" name="submit" class="btn btn-success mt-3">สมัครสมาชิก</button>
  </form>
<script>
  function checkPasswords() {
    if (document.getElementById('1').value === document.getElementById('2').value) {
      return true;
    }
    alert('รหัสผ่านไม่ตรงกัน')
    return false;
  }
</script>
<?php  foot()?>