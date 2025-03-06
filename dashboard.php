<?php $page = "dashboard";
require_once "./includes/header.php";
$search = isset($_GET['search']) ? $_GET['search'] : "";
$wheels = query("SELECT * FROM wheels WHERE name LIKE '%$search%'ORDER BY datetime DESC");
$wheel_items = query("SELECT * FROM wheel_members");
$items = [];
foreach ($wheel_items as $item) {
  $items[$item->wheel_id][] = $item;
}
?>
<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid pt-4">
      <div class="row justify-content-center">
        <div class="col-md-4">
          <div class="row justify-content-center">
            <div class="col-md-12">
            <h3 class="text-center">Manage winners</h3>
              <form class="mb-4">
                <input type="search" name="search" class="form-control" placeholder="Search by wheel name" value="<?php echo $search ?>">
              </form>
            </div>
            <?php foreach ($wheels as $wheel): ?>
              <div class="col-md-6">
                <div class="small-box <?php echo $wheel->winner ? 'bg-primary' : 'bg-gray' ?>" color-for="<?php echo $wheel->id ?>">
                  <div class="inner">
                    <h5><?php echo $wheel->name; ?></h5>
                    <small class="text-center d-block w-100 mb-2">winner</small>
                    <h6 class="text-center" winner-for="<?php echo $wheel->id ?>"><?php echo $wheel->winner ? $wheel->winner : 'Auto' ?></h6>
                  </div>
                  <select class="w-100 text-center py-2 select-winner" data-id="<?php echo $wheel->id ?>">
                    <option value="">Auto</option>
                    <?php foreach ((!empty($items[$wheel->id]) ? $items[$wheel->id] : []) as $option) : ?>
                      <option value="<?php echo $option->name; ?>" <?php echo $option->name == $wheel->winner ? 'selected' : ''; ?>><?php echo $option->name; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            <?php endforeach; ?>
            <?php if (empty($wheels)): ?>
              <div class="col-md-12">
                <h6 class="text-center">No wheels found</h6>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    $('.select-winner').change(function(event) {
      let formdata = new FormData();
      let id = event.target.getAttribute('data-id');
      let value = event.target.value;
      formdata.append('id', id);
      formdata.append('winner', value);
      $.ajax({
        url: 'script/winner.php',
        method: 'post',
        data: formdata,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: (response) => {
          toastr.info('Winner selected successfully');
          $(`[winner-for="${id}"]`).html(value == "" ? 'Auto' : value);
          $(`[color-for="${id}"]`).addClass(value == "" ? 'bg-gray' : 'bg-primary').removeClass(value != "" ? 'bg-gray' : 'bg-primary');
        },
        error: (error) => {
          toastr.error(error.statusText);
        }
      });
    });
  });
</script>
<?php require_once "./includes/footer.php"; ?>