<?php $page="active"; require_once "./includes/header.php";
$wheels_members = query("SELECT W.id, W.name, W.winner, WM.id as item_id, WM.name as item_name, WM.color FROM wheels as W INNER JOIN wheel_members as WM ON WM.wheel_id = W.id WHERE result IS NULL ORDER BY W.datetime DESC, W.id ASC");
$wheels = [];
$slices = [];
foreach($wheels_members as $wheel_member){
  $wheels[$wheel_member->id] = (object)['id' => $wheel_member->id, 'name' => $wheel_member->name, 'winner' => $wheel_member->winner ];
  $slices[$wheel_member->id][] = (object)['id' => $wheel_member->item_id, 'name' => $wheel_member->item_name, 'color' => $wheel_member->color];
}
$wheels = array_values($wheels);
?>
    <div class="content-wrapper bg-black">
      <section class="content">
        <div class="container-fluid pt-4">
          <?php foreach($wheels as $index => $wheel): ?>
          <div class="row">
            <div class="col-12">
              <div class="small-box" style="background-color: <?php echo color($index)?>ff;">
                <div class="inner">
                  <h5><?php echo $wheel->name;?></h5>
                  <span><?php echo count($slices[$wheel->id]);?> Slices</span>
                </div>
                <select class="small-box-footer w-100 d-block border-0 text-align select-winner" style="background-color: rgba(0,0,0,.7);" data-id="<?php echo $wheel->id;?>">
                  <option>Select Winner</option>
                  <?php foreach($slices[$wheel->id] as $slice): ?>
                  <option value="<?php echo $slice->id;?>" style="background-color: #fff; color: <?php echo $slice->color;?>; font-weight: bold;" <?php echo $wheel->winner== $slice->id ? 'selected' : '';?>><?php echo $slice->name ? $slice->name : '-- no slice name --';?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
          <?php if(empty($wheels)) :?>
            <div class="row">
            <div class="col-12">
              <div class="small-box bg-dark">
                <div class="inner">
                  <span>No wheels found</span>
                </div>
              </div>
            </div>
          </div>
          <?php endif; ?>
        </div>
      </section>
    </div>
  </div>
  <?php require_once "./includes/footer.php";?>
  <script>
    document.addEventListener('DOMContentLoaded', function(){
      $('.select-winner').change(function(event){
        let formdata = new FormData();
        formdata.append('id', event.target.getAttribute('data-id'));
        formdata.append('winner', event.target.value);
        $.ajax({
            url: 'script/winner.php',
            method: 'post',
            data: formdata,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: (response) => {
                toastr.info('Winner selected successfully');
            },
            error: (error) => {
                toastr.error(error.statusText);
            }
        });
      });
    });
  </script>