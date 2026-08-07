<div class="main">
    <div class="main-inner">
        <div class="container">
          <div class="row">
            <div class="span12">
                <div class="widget ">
                    <div class="widget-header">
                        <i class="icon-wrench"></i>
                        <h3>PCR - Component Life that exceed Unit Policy</h3>
                    </div> <!-- /widget-header -->
                    <div class="widget-content">
                        <table id="example" class="table table-bordered table-condensed" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><div align="center"><i class="icon-arrow-down"></i></div></th>
                            <th><div align="center">Site</div></th>
                            <th>Unit No.</th>
                            <th>Component Description</th>
                            <th>Policy</th>
                            <th>Comp Life</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($hasil)): ?>
                        <tr>
                            <td colspan="6"><div align="center">No Data Available</div></td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($hasil as $row): ?>
                        <tr>
                            <td><div align="center"><a href="<?php echo base_url('unit/replacement/'.$row['id_unit'].'/'.$row['id_mod']);?>" target="blank"><i class="icon-circle-arrow-right"></i></a></div></td>
                            <td><div align="center"><?php echo htmlspecialchars($row['kode_project']); ?></div></td>
                            <td><?php echo htmlspecialchars($row['unit_no']); ?></td>
                            <td><?php echo htmlspecialchars($row['comp_desc']); ?></td>
                            <td><div align="right"><?php echo $row['policy']; ?></div></td>
                            <td><div align="right"><?php echo round($row['comp_life'], 1); ?></div></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                    </div> <!-- /widget-content -->
                </div> <!-- /widget -->
                </div> <!-- /span8 -->
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /main-inner -->
</div> <!-- /main -->
