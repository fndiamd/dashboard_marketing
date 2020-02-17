<table width="100%">
<tbody>
<tr class="th">
<th>No</th>
<th>Segmentasi</th>
<th>Potensi</th>
<th>Periode</th>
<th>Pic</th>
<th>Aksi</th>
</tr>
<?php
$arr = array('Top 500 Q1 2020','Top 600 Q1 2020','Top 500 Q2 2020','Top 600 Q2 2020');
foreach ($arr as $r) {
?>
<tr>
<td><?php echo ++$c?></td>
<td><?php echo $r?></td>
<td align="right"><?php echo rand()?> Outlet</td>
<td>Januari - Maret 2020</td>
<td align="right">Febri</td>
<td align="center">
<button type="button" class="btn btn-outline-success btn-sm" onclick="followup_segmentation()">
<li class="ion-ios-paperplane active" data-pack="ios" style="display: inline-block;"></li>
Follow Up</button>
&nbsp;
<button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#myModal" onclick="openform_segmentation()">
<li class="ion-person-stalker active" data-pack="ios" style="display: inline-block;"></li>
Ubah
</button>
&nbsp;
<button type="button" class="btn btn-outline-warning btn-sm">
<li class="ion-ios-trash active" data-pack="ios" style="display: inline-block;"></li>
Delete</button>
</td>
</tr>
<?php }?>
</tbody>
</table>
