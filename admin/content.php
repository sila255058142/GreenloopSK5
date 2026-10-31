<?php 
 require __DIR__ . '/../controller/admin_content.php';
    head('จัดการเนื้อหา');
    if(!empty($_GET['edit'])){

        $id = $_GET['edit'];

        $select = $db->query("SELECT * FROM contents WHERE id = $id");
        $row = $select->fetch_assoc();
        
    ?> 
    
    <form action="" method="post" class="card card-body mb-4">
    <h5><?= $row['id'] ? 'แก้ไขเนื้อหา' : 'เพิ่มเนื้อหา'?></h5>
        <input type="hidden" name="id" value="<?= $row['id']?>">
    <label for="" class="form-label">หัวข้อ</label>
        <input class="form-control" name="title" type="text" name="id" value="<?= e($row['title'])?>" required minlength="3">
    <label for="" class="form-label mt-2">เนื้อหา</label>
    <textarea class="form-control" name="body" row="3" required><?= e($row['body'])?></textarea>
    <div class="row">
        <div class="col-md-6">
            <label for="" class="form-label mt-2">เริ่มแสดงผล</label>
                <input type="datetime-local" name="start_at" value="<?= e($local($row['start_at']))?>" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="" class="form-label mt-2">สิ้นสุดการแสดงผล (ไม่มีกำหนด = ว่าง)</label>
                <input type="datetime-local" name="end_at" value="<?= e($local($row['end_at']))?>" class="form-control">
        </div>
        <input type="hidden" name ="Id" value="<?= $id ?>">
    </div>
    <div class="mt-3">
        <button name="editId" class="btn btn-success">บันทึก</button>
        <a href="contents.php" class="btn btn-outline-secondary">ล้างฟอร์ม</a>
    </div>
</form>
    <form method="get" class="d-flex flex-wrap gap-2 mb-3 d-print-none">
    <input class="form-control w-auto" name="q" value=" <?= isset($_GET['q']) ? e(trim($_GET['q'])) : '' ?>" placeholder="ค้นหา...">
        <button class="btn btn-success">ค้นหา</button>
    </form>

    <?php


    }else{
      
?>
<form action="" method="post" class="card card-body mb-4">
    <h5><?= $edit['id'] ? 'แก้ไขเนื้อหา' : 'เพิ่มเนื้อหา'?></h5>
        <input type="hidden" name="id" value="<?= $edit['id']?>">
    <label for="" class="form-label">หัวข้อ</label>
        <input class="form-control" name="title" type="text" name="id" value="<?= e($edit['title'])?>" required minlength="3">
    <label for="" class="form-label mt-2">เนื้อหา</label>
    <textarea class="form-control" name="body" row="3" required><?= e($edit['body'])?></textarea>
    <div class="row">
        <div class="col-md-6">
            <label for="" class="form-label mt-2">เริ่มแสดงผล</label>
                <input type="datetime-local" name="start_at" value="<?= e($edit['start_at'])?>" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="" class="form-label mt-2">สิ้นสุดการแสดงผล (ไม่มีกำหนด = ว่าง)</label>
                <input type="datetime-local" name="end_at" value="<?= e($edit['end_at'])?>" class="form-control" required>
        </div>
    </div>
    <div class="mt-3">
        <button class="btn btn-success">บันทึก</button>
        <a href="contents.php" class="btn btn-outline-secondary">ล้างฟอร์ม</a>
    </div>
</form>
    <?php }     ?>

 <div class="table-responsive"> 
        <table id ="ContentTable" class="table table-striped bg-white align-middle">
            <thead>
                <tr>
                    <th>หัวข้อ</th>
                    <th>เริ่มแสดง</th>
                    <th>สิ้นสุด</th>
                    <th>สถานะ</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $r): ?>
                    <tr>
                        <td><?= e($r['title']) ?></td>
                        <td><?= ($r['start_at'] ? date('d/m/Y H:i' ,strtotime($r['start_at'])) : '-')?></td>
                        <td><?= ($r['end_at'] ? date('d/m/Y H:i',strtotime($r['end_at'])) : '-')?></td>
                        <td><?= $r['Live']?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="id" value="<?= $r['id']?>">
                                    <a type="button" href="admin/content.php?edit=<?= $r['id']?>" name="edit" class="btn btn-sm btn-outline-success">แก้ไข</a>
                                    <button class="btn btn-sm btn-outline-danger" name="delete" onclick="return confirm('ลบเนื้อหาหน้านี้?')">ลบ</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script>
    $(document).ready(function () {
        const table = $('#ContentTable').DataTable();
    });
    </script>
    <?php foot() ?>