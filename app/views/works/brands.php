			<!--
        	<div class="advertise">
            	<div class="bigpic"><a href="#"><img src="<?php echo $pre; ?>public/images/about_03.jpg" /></a></div>
            </div>   
			-->
          
                   <div class="pageRcon">
                   		<div class="tt"><img src="<?php echo $pre; ?>public/images/bra_03.png" /></div>
                   		<div class="brand">
                            <?php foreach($brand as $k=>$v): ?>
                            <span class="brand<?php echo $k; ?>"><img src="<?php echo $pre . $v['img_src']; ?>" /></span>
                            <div class="showdetail">
                            	 <div class="showdetail_con">
                            	 <strong><?php echo $v['img_title']; ?></strong>
								 <p><?php echo $v['img_alt_tw']; ?></p>
								</div>
                                <div class="showdetail_wrap"></div>
                            </div>
							<?php endforeach; ?>                           
                        </div>                        
                   </div>                   
            </div>
        </div>