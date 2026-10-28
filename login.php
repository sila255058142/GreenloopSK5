<?php 
require 'init.php';

head('เข้าสู่ระบบ');
?>
<div class="container p-4">
    <form action="controller/login.php" class="card card-body mx-auto" style="max-width:520px" method="post">
        <label for="" class="form-label mt-2">อีเมล</label>
        <input type="email" class="form-control" name="email" value="" required>
        <label for="" class="form-label mt-2">รหัสผ่าน</label>
        <input type="password" class="form-control" name="password" value="" required>
        <button class="btn btn-success mt-3" type="submit">
            เข้าสู่ระบบ
        </button>
        <div class="d-flex justify-content-between mt-3">
            <a href="forget.php" class="">ลืมรหัสผ่าน</a>
            <a href="register.php" class="">สมัครสมาชิก</a>
        </div>
    </form>
</div>
<?php  foot()?>