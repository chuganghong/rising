        	
            
            <!--
            <div class="page">
            		
					<div class="pagenav">
                    	 <h3>关于我们&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &rarr;</h3>
                         <span><a href="#">日先简介</a></span>
                         <span><a href="#">日先足迹</a></span>
                         <span><a href="#">日先荣誉</a></span>
                         <span><a href="#">日先理念</a></span>
                    </div>
					-->
                    <div class="mid_con">
					<?php foreach($content as $k=>$v): ?>
					
						
                    	  <div class="conlevel">
                          		<h3 class="th3"><?php echo $v['title']; ?></h3>
								<?php echo $v['content']; ?>
                                <div class="more">
                                	<a href="<?php echo $url_detail . $v['case_id']; ?>">查看更多>></a>
                                </div>
                          </div>
					<?php endforeach; ?>                
                         
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