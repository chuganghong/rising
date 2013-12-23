        	<div class="advertise" style="height:460px">
			<?php			
			foreach($flags as $k=>$v):				
				if($k == 0):
					echo '<div class="bigpic" style="z-index: 2">';
				else:
					echo '<div class="bigpic">';
				endif;
				
				echo '<a href="' . $v['img_link'] . '">';
				echo '<img src="' . $pre . $v['img_src'] . '" style="width:934px;height:390px" /></a></div>';			
			endforeach; 
			
			echo '<ul>';
			
			foreach($flags as $k=>$v):			
				if($k == 0):
					echo '<li class="cur">';
				else:
					echo '<li>';
				endif;
				echo '<img style="width:74px;height:32px" src="' . $pre . $v['img_src'] . '" /></li>';
			endforeach;
			echo '</ul>';			
			?>            	
            </div>
            
            <div class="adverimg"><a href="<?php echo $banner['img_link']; ?>" target="_blank"><img src="<?php echo $pre . $banner['img_src']; ?>" /></a></div>
            <div class="bottomcon">
            	<div class="bottom_l">
                	 <h3><span>日先动态</span><a href="http://localhost/rising/index.php/trends2/view/trends2/5/13" target="_blank">更多 &gt;&gt;</a></h3>
                     
                     
                     <div class="blc_wrap">
                      <div class="blc_wraps">
					  <?php foreach($itrends[1] as $k=>$v):?>
					  <?php if($k==0): ?>
                             <div class="bottom_l_con" style="display:block">
					  <?php else: ?>
							 <div class="bottom_l_con">
					  <?php endif; ?>
							<?php foreach($v as $kk=>$vv): ?>
								<?php if($kk==0): ?>
                                 <img src="<?php echo $pre . $vv['g_pic']; ?>" style="width:113px;height:72px" class="leftimg" />
                                 <div class="bottom_txt">
                                     <p><?php echo date('Y.m.d',$vv['addtime']); ?></p>
                                     <a href="<?php echo $url_detail_2 . $vv['Case_id']; ?>"><?php echo mb_substr($vv['title'],0,15); ?></a>
									 <p><?php echo mb_substr($vv['content_en'],0,400); ?></p>
								 </div>
                                
                                 <div class="bottom_txt">
								<?php else: ?>
                                     <p><?php echo date('Y.m.d',$vv['addtime']); ?></p>
                                     <a href="<?php echo $url_detail_2 . $vv['Case_id']; ?>"><?php echo mb_substr($vv['title'],0,15); ?></a>
								<?php endif; ?>
							 <?php endforeach; ?>
								</div>
                             </div>
					<?php endforeach; ?>                
                             
                             
                        </div>
                     </div>
                     
                     
                     <div class="changenext">
                     	 <em>1/<?php echo $itrends[0]; ?></em> <span class="prev"></span><span class="next"></span>
                     </div>
                     <br />
					 <br />

                </div>
                <div class="bottom_r">
                	<h3><span>店铺视角</span><a href="http://localhost/rising/index.php/trends/view/trends/5/12" target="_blank">更多 &gt;&gt;</a></h3>
                    <div class="bottom_r_con">
                    	<img src="<?php echo $pre; ?>public/images/index_24.jpg" class="leftimg" />
                        <div class="bottom_txt">							
                        	<a href="<?php echo $url_detail_1 . $iview['Case_id']; ?>"><?php echo $iview['title']; ?></a>
							<p><?php echo mb_substr($iview['content_en'],0,400);?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
