<div class="main">
    <div class="main-inner">
        <div class="container">
          <div class="row">
            <div class="span12">      		
                <div class="widget ">
                    <div class="widget-header">
                        <i class="icon-tag"></i>
                        <h3>Magnetic Plug/Screen Inspection - Last B & C Rating Code</h3>
                    </div> <!-- /widget-header -->
                    <div class="widget-content">
                        <table id="example3" class="table table-bordered table-condensed" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <td><div align="center"><div align="center"><i class="icon-arrow-down"></i></div></td>
                                    <td><div align="center"><div align="center"><strong>Site</strong></div></td>
                                    <td><div align="center"><strong>Inspection Date</strong></div></td>
                                    <td><div align="center"><strong>Unit No.</strong></div></td>
                                    <td><div align="center"><strong>Component Description</strong></div></td>
                                    <td><div align="center"><strong>Hour Meter</strong></div></td>
                                    <td><div align="center"><strong>Rating</strong></div></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php 
                                    $mag = 
                                            "SELECT *
                                                FROM inspection i
                                                LEFT JOIN unit u ON i.id_unit = u.id_unit
                                                LEFT JOIN commod cm ON i.id_mod = cm.id_mod
                                                LEFT JOIN model m ON u.id_model = m.id_model AND cm.id_model = m.id_model
                                                LEFT JOIN project p ON u.id_project = p.id_project
                                                LEFT JOIN comp c ON cm.id_comp = c.id_comp
                                                INNER JOIN (SELECT unit.id_unit, max(ins_date) as MaxDate from inspection inner join unit on inspection.id_unit = unit.id_unit group by unit.id_unit) i1 on i.id_unit = i1.id_unit and i.ins_date = i1.MaxDate
                                                WHERE i.rating IN ('B','C') AND type = 'Magnetic Plug/Screen'
                                                ORDER BY p.kode_project ASC, u.unit_no ASC, c.comp_desc ASC, i.id_ins DESC";
                                    $hasil = mysql_query($mag);
                                    ?>
                                    <?php if (empty($hasil)):?>
                                    <td colspan="7"><div align="center">No Data Available</div></td>
                                    <?php else:?>
                                    <?php while ($row = mysql_fetch_array($hasil)):?>
                                    <?php
                                            $warna = "";
                                            if ($row['rating'] == "A"){
                                                $warna = "#00ff00";
                                            } elseif ($row['rating'] == "B") {
                                                $warna = "#ffff00";
                                            } elseif ($row['rating'] == "C") {
                                                $warna = "#ff9900";
                                            } elseif ($row['rating'] == "X") {
                                                $warna = "#ff0000";
                                            }
                                            ?>
                                    <td><div align="center"><div align="center"><a href="<?php echo base_url('unit/magnetic_plug_screen/'.$row['id_unit'].'/'.$row['id_mod']);?>" target="blank"><i class="icon-circle-arrow-right"></i></a></div></td>
                                    <td><div align="center"><div align="center"><?php echo $row['kode_project']; ?></div></td>
                                    <td><div align="center"><?php echo $row['ins_date']; ?></div></td>
                                    <td><div align="center"><?php echo $row['unit_no']; ?></div></td>
                                    <td><div align="center"><?php echo $row['comp_desc']; ?></div></td>
                                    <td><div align="center"><?php echo $row['ins_hm']; ?></div></td>
                                    <td bgcolor=<?php echo $warna; ?>><div align="center"><b><?php echo $row['rating']; ?></b></div></td>

                                </tr>
                                <?php endwhile;?>
                                <?php endif;?>
                            </tbody>
                        </table>
                    </div> <!-- /widget-content -->	
                </div> <!-- /widget -->	
                </div> <!-- /span8 -->
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /main-inner -->
</div> <!-- /main -->