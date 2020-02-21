<form>
  <div class="form-group row">
    <label class="col-sm-3" for="segmentation_name">Tahun dan Bulan</label>
    <div class="col-sm-9">
      <input type="text" class="form-control form-control-sm" id="segmentation_name" placeholder="Misal diisi dengan 2020-01">
    </div>
  </div>
  <?php $arr = array('Sentra Bisnis','Retail','H2H','Minimarket','Top 600','Top 500','Travel','Ekspedisi','Top 15 H2H');
  foreach ($arr as $poin) {?>
  <div class="form-group row">
    <label class="col-sm-3" for="potensi"><?php echo $poin?></label>
    <div class="col-sm-9">
      <input type="hidden" class="form-control form-control-sm" name="poin[]" value="<?php echo $poin?>">
      <input type="text" class="form-control form-control-sm" name="target[]">
    </div>
  </div>
  <?php }?>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
    <button type="button" class="btn btn-primary">Simpan</button>
  </div>
 </form>
