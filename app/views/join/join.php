           <!--
		   <div class="page">
            		<div class="pagenav">
                    	 <h3>加入我们&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &rarr;</h3>
                         <span><a href="#">人才理念</a></span>
                         <span><a href="#">招聘职位</a></span>
                    </div>
			-->
                    <div class="mid_con">
                    	  <div class="conlevel orange">
                          		<h3 class="th3"><?php echo $content1[0]; ?></h3>
								<?php echo $content1[2]['content'];  ?>                                
                                <div class="more">
                                	<a href="<?php echo $url_detail1 . $content1[2]['Case_id']; ?>" target="_blank">查看更多>></a>
                                </div>
                          </div>
                          
                          
                          <div class="conlevel green">
                          		<h3><?php echo $content2[0]; ?></h3>
								<?php echo $content2[1]['content'];  ?>                                
                                <div class="more">
                                	<a href="<?php echo $url_detail1 . $content2[1]['Case_id']; ?>" target="_blank">查看更多>></a>
                                </div>
                          </div>
                          
                          
                          
                          <div class="joinus">
								<?php
								array_shift($content2);
								array_shift($content2);
								foreach($content2 as $v):
								?>
                          		<div class="joinus_area">
                                	<strong class="gl"><?php echo $v['title']; ?></strong>
									<?php echo mb_substr($v['content'],0,200); ?>
                                    <div class="more">
                                	<a href="<?php echo $url_detail1 . $v['Case_id']; ?>" target="_blank">查看更多>></a>
                                	</div>
                                </div>
								<?php
								endforeach;
								?>                           
                          </div>
                          
                          
                          
                          
                          <div class="conlevel">
                          		<h3><?php echo $content3[0]; array_shift($content3); ?></h3>
								<?php foreach($content3 as $v): ?>
                                <b><?php echo $v['title']; ?></b><br /><br />
								<?php echo mb_substr($v['content'],0,100); ?>
                                <div class="more">
                                	<a href="<?php echo $url_detail2 . $v['Case_id']; ?>" target="_blank">查看更多>></a>
                                </div>
								<?php endforeach; ?>                                
                          </div>
                          
                          
                         
                          <br />
                          <br />
                          <br />

                          
                          
                          
                    </div>
                    <div class="right_con">
							<h3>&plus; 新闻会客室</h3>
					<?php foreach($news as $k=>$v): ?>					
                            <a href="<?php echo $v['action_name']; ?>" target="_blank"><img src="<?php echo $pre . $v['pic']; ?>" /></a>
                            <p><?php echo mb_substr($v['cat_desc'],0,360); ?></p>
                    <?php endforeach; ?>
					</div>
            </div>
        </div>  
        
       
