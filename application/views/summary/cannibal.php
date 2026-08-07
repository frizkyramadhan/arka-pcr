<div class="main">
    <div class="main-inner">
        <div class="container">
          <div class="row">
            <div class="span12">
                <div class="widget ">
                    <div class="widget-header">
                        <i class="icon-random"></i>
                        <h3>Cannibal - Not Approved by PM yet</h3>
                    </div> <!-- /widget-header -->
                    <div class="widget-content">
                        <table id="example1" class="table table-bordered table-condensed" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><div align="center"><i class="icon-arrow-down"></i></div></th>
                            <th><div align="center">Site</div></th>
                            <th>Removed Unit No.</th>
                            <th>Installed Unit No.</th>
                            <th>Component Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($ba)): ?>
                        <tr>
                            <td colspan="5"><div align="center">No Data Available</div></td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($ba as $row): ?>
                        <tr>
                            <td><div align="center"><a href="<?php echo base_url('cannibal/detail/'.$row->no_ba);?>" target="blank"><i class="icon-circle-arrow-right"></i></a></div></td>
                            <td><div align="center"><?php echo htmlspecialchars($row->kode_project); ?></div></td>
                            <td><div align="left"><?php echo $row->unit_remove ? htmlspecialchars($row->unit_remove) : '-'; ?></div></td>
                            <td><div align="left"><?php echo $row->unit_install ? htmlspecialchars($row->unit_install) : '-'; ?></div></td>
                            <td><div align="left"><?php echo $row->comp_desc ? htmlspecialchars($row->comp_desc) : '-'; ?></div></td>
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
