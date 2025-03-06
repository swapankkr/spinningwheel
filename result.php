<?php $page="result"; require_once "./includes/header.php";
$results = query("SELECT W.id, W.name, COUNT(WM.id) as slices, result FROM wheels as W INNER JOIN wheel_members as WM ON WM.wheel_id = W.id WHERE result IS NOT NULL AND result != '' GROUP BY W.id");
?>
    <div class="content-wrapper bg-black">
      <section class="content">
        <div class="container-fluid pt-4">
          <?php foreach($results as $index => $result): ?>
          <div class="row">
            <div class="col-12">
              <div class="small-box" style="background-color: <?php echo color($index)?>;">
                <div class="inner">
                  <h5><?php echo $result->name;?></h5>
                  <span><?php echo $result->slices;?> Slices</span>
                  <h5><i><?php echo $result->result?></i></h5>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
          <?php if(empty($results)) :?>
            <div class="row">
            <div class="col-12">
              <div class="small-box bg-dark">
                <div class="inner">
                  <span>No results found</span>
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