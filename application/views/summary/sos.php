<?php $conn = mysqli_connect('localhost', 'root', '', 'arka_pcr')?>
<div class="main">
    <div class="main-inner">
        <div class="container">
          <div class="row">
            <div class="span12">      		
                <div class="widget ">
                    <div class="widget-header">
                        <i class="icon-columns"></i>
                        <h3>SOS Summary</h3>
                    </div> <!-- /widget-header -->
                    <div class="widget-content">
                        <form class="form-inline" method="POST">
                            <div class="control-group">
                                <div class="controls" align="center">
                                    <div class="accordion" id="accordion2">
                                        <div class="accordion-group">
                                            <div class="accordion-heading">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                                                    <div align="center">-- Advance Filter --</div>
                                                </a>
                                            </div>
                                            <div id="collapseOne" class="accordion-body collapse">
                                                <div class="accordion-inner">
                                                    <table>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="siteCat"> Project</label></td>
                                                            <td>
                                                                <label class="checkbox inline">
                                                                    <!--<input type="text" name="kode_project">-->
                                                                    <?php
                                                                    echo form_dropdown('kode_project', $proj_options, '');
                                                                    ?>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="unitCat"> Unit No</label></td>
                                                            <td><label class="checkbox inline"><input type="text" name="unit_no"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="checkbox inline"><input type="checkbox" name="compCat"> Comp. Desc</label></td>
                                                            <td><label class="checkbox inline"><input type="text" name="comp_desc"></label></td>
                                                        </tr>
                                                        <tr><td></td><td><div align="center"><label class="checkbox inline"><input class="btn btn-info" type="submit" name="submit" value="Submit"> <input class="btn" type="reset" name="reset" value="&nbsp;Reset&nbsp;"></label></td></tr>
                                                     </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- /controls -->				
                            </div> <!-- /control-group -->
                        </form>
                            <?php
                                $bagianWhere = "";
                                if (isset($_POST['siteCat'])){
                                   $project = $_POST['kode_project'];
                                   if (empty($bagianWhere)){
                                        $bagianWhere .= "kode_project LIKE '$project'";
                                   }else{
                                        $bagianWhere .= " AND kode_project LIKE '$project'";
                                   }
                                }
                                if (isset($_POST['unitCat'])){
                                   $unit = $_POST['unit_no'];
                                   if (empty($bagianWhere)){
                                        $bagianWhere .= "unit_no LIKE '%$unit%'";
                                   }else{
                                        $bagianWhere .= " AND unit_no LIKE '%$unit%'";
                                   }
                                }
                                if (isset($_POST['compCat'])){
                                   $comp = $_POST['comp_desc'];
                                   if (empty($bagianWhere)){
                                        $bagianWhere .= "comp_desc LIKE '%$comp%'";
                                   }else{
                                        $bagianWhere .= " AND comp_desc LIKE '%$comp%'";
                                   }
                                }
                            ?>
                        <div class="alert alert-success">
                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                          Status Filter: <?php echo $bagianWhere;?>
                        </div>
                        
                        <form action="sos/export" method="POST">
                            <?php
                            if (empty($bagianWhere)){
                                $where = 1;
                            }else{
                                $where = $bagianWhere;
                            }
//                            ?>
                            <input type="hidden" name="where" value="<?php echo $where ?>" >
                            <div align="center"><input type="submit" value="Export to Excel" class="btn btn-success" ></div>
                        </form>
                        
                            <table id="example1" class="table table-bordered table-condensed" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <td><div align="center"><div align="center"><i class="icon-arrow-down"></i></div></td>
                                    <td><div align="center"><div align="center"><strong>Site</strong></div></td>
                                    <td><div align="center"><strong>Sample Date</strong></div></td>
                                    <td><div align="center"><strong>Unit No.</strong></div></td>
                                    <td><div align="center"><strong>Component Description</strong></div></td>
                                    <td><div align="center"><strong>Lab No.</strong></div></td>
                                    <td><div align="center"><strong>Evaluation Code</strong></div></td>
<!--                                    <td><div align="center"><strong>Fe</strong></div></td>
                                    <td><div align="center"><strong>Cu</strong></div></td>
                                    <td><div align="center"><strong>Cr</strong></div></td>
                                    <td><div align="center"><strong>Si</strong></div></td>
                                    <td><div align="center"><strong>Al</strong></div></td>
                                    <td><div align="center"><strong>Ni</strong></div></td>
                                    <td><div align="center"><strong>Sn</strong></div></td>
                                    <td><div align="center"><strong>Pb</strong></div></td>
                                    <td><div align="center"><strong>PQ</strong></div></td>
                                    <td><div align="center"><strong>Soot</strong></div></td>
                                    <td><div align="center"><strong>Oxid</strong></div></td>
                                    <td><div align="center"><strong>Nitr</strong></div></td>
                                    <td><div align="center"><strong>SOX</strong></div></td>
                                    <td><div align="center"><strong>4um</strong></div></td>
                                    <td><div align="center"><strong>6um</strong></div></td>
                                    <td><div align="center"><strong>14um</strong></div></td>
                                    <td><div align="center"><strong>15um</strong></div></td>
                                    <td><div align="center"><strong>ISO4406</strong></div></td>
                                    <td><div align="center"><strong>ISO.14</strong></div></td>
                                    <td><div align="center"><strong>ISO.6</strong></div></td>
                                    <td><div align="center"><strong>Ca</strong></div></td>
                                    <td><div align="center"><strong>Zn</strong></div></td>
                                    <td><div align="center"><strong>Mo</strong></div></td>
                                    <td><div align="center"><strong>Bo</strong></div></td>
                                    <td><div align="center"><strong>P</strong></div></td>
                                    <td><div align="center"><strong>Na</strong></div></td>
                                    <td><div align="center"><strong>K</strong></div></td>
                                    <td><div align="center"><strong>Mg</strong></div></td>
                                    <td><div align="center"><strong>Visc</strong></div></td>
                                    <td><div align="center"><strong>TBN</strong></div></td>
                                    <td><div align="center"><strong>TAN</strong></div></td>
                                    <td><div align="center"><strong>Gly</strong></div></td>
                                    <td><div align="center"><strong>WATER</strong></div></td>
                                    <td><div align="center"><strong>DILUTION</strong></div></td>-->
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
                                                WHERE ".$bagianWhere."
                                                ORDER BY p.kode_project ASC, u.unit_no ASC, c.comp_desc ASC, s.id_sos DESC";
                                    $hasil = mysqli_query($conn,$sos);
                                    ?>
                                    <?php if (empty($hasil)):?>
                                    <td colspan="43"><div align="center">No Data Available</div></td>
                                    <?php else:?>
                                    <?php while ($row = mysqli_fetch_array($hasil)):?>
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
                                    <td bgcolor=<?php echo $warna;?>><div align="center"><b><?php echo $row['eval_code']; ?></b></div></td>
<!--                                    <td><div align="center"><?php // echo $row['fe']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['cu']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['cr']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['si']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['al']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['ni']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['sn']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['pb']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['pq']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['soot']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['oxid']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['nitr']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['sox']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['4um']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['6um']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['14um']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['15um']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['iso4406']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['iso14']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['iso6']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['ca']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['zn']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['mo']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['bo']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['p']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['na']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['k']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['mg']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['visc']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['tbn']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['tan']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['gly']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['water']; ?></div></td>
                                    <td><div align="center"><?php // echo $row['dilution']; ?></div></td>-->
                                </tr>
                                <?php endwhile;?>
                                <?php endif;?>
                            </tbody>
                        </table>
<!--                        <pre>
                        <?php // print_r($pcr);?><br>
                        <?php // print_r($bagianWhere);?>
                        </pre>-->
                    </div> <!-- /widget-content -->	
                </div> <!-- /widget -->	
                </div> <!-- /span8 -->
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /main-inner -->
</div> <!-- /main -->