<div class="main">
    <div class="main-inner">
        <div class="container">
          <div class="row">
            <div class="span12">      		
                <div class="widget ">
                    <div class="widget-header">
                        <i class="icon-tint"></i>
                        <h3>Oil Sampling - Last Red Evaluation Code</h3>
                    </div> <!-- /widget-header -->
                    <div class="widget-content">
                        <table id="example3" class="table table-bordered table-condensed" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <td><div align="center"><div align="center"><i class="icon-arrow-down"></i></div></td>
                                    <td><div align="center"><div align="center"><strong>Site</strong></div></td>
                                    <td><div align="center"><strong>Sample Date</strong></div></td>
                                    <td><div align="center"><strong>Unit No.</strong></div></td>
                                    <td><div align="center"><strong>Component Description</strong></div></td>
                                    <td><div align="center"><strong>Lab No.</strong></div></td>
                                    <td><div align="center"><strong>Evaluation Code</strong></div></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php 
                                    $sos = 
                                            "SELECT *
                                                FROM sos s
                                                LEFT JOIN unit u ON s.id_unit = u.id_unit
                                                LEFT JOIN commod cm ON s.id_mod = cm.id_mod
                                                LEFT JOIN model m ON u.id_model = m.id_model AND cm.id_model = m.id_model
                                                LEFT JOIN project p ON u.id_project = p.id_project
                                                LEFT JOIN comp c ON cm.id_comp = c.id_comp
                                                INNER JOIN (SELECT unit.id_unit, max(sample_date) as MaxDate from sos inner join unit on sos.id_unit = unit.id_unit group by unit.id_unit) s1 on s.id_unit = s1.id_unit and s.sample_date = s1.MaxDate
                                                WHERE s.eval_code IN ('X','Urgent')
                                                ORDER BY p.kode_project ASC, u.unit_no ASC, c.comp_desc ASC, s.id_sos DESC";
                                    $hasil = mysql_query($sos);
                                    ?>
                                    <?php if (empty($hasil)):?>
                                    <td colspan="7"><div align="center">No Data Available</div></td>
                                    <?php else:?>
                                    <?php while ($row = mysql_fetch_array($hasil)):?>
                                    <?php
                                    $warna = "";
                                    if ($row['eval_code'] == "A" || $row['eval_code'] == "Normal"){
                                        $warna = "#00ff00";
                                    } elseif ($row['eval_code'] == "B" || $row['eval_code'] == "Attention") {
                                        $warna = "#ffff00";
                                    } elseif ($row['eval_code'] == "C" || $row['eval_code'] == "D") {
                                        $warna = "#ff9900";
                                    } elseif ($row['eval_code'] == "X" || $row['eval_code'] == "Urgent") {
                                        $warna = "#ff0000";
                                    }
                                    ?>
                                    <td><div align="center"><div align="center"><a href="<?php echo base_url('unit/sos/'.$row['id_unit'].'/'.$row['id_mod']);?>" target="blank"><i class="icon-circle-arrow-right"></i></a></div></td>
                                    <td><div align="center"><div align="center"><?php echo $row['kode_project']; ?></div></td>
                                    <td><div align="center"><?php echo $row['sample_date']; ?></div></td>
                                    <td><div align="center"><?php echo $row['unit_no']; ?></div></td>
                                    <td><div align="center"><?php echo $row['comp_desc']; ?></div></td>
                                    <td><div align="center"><?php echo $row['lab_no']; ?></div></td>
                                    <td bgcolor=<?php echo $warna; ?>><div align="center"><b><?php echo $row['eval_code']; ?></b></div></td>

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