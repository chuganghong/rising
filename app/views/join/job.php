 
            
                    <div class="pageRcon">
                    <div class="toptxt">
                    	<h3>
                        	<?php echo $cat_desc; ?>
						</h3><br />

                    </div>
                    <div class="mid_con">           
                          
                          <div class="conlevel">
                          	  <div class="contxt">
                          		<h4><?php $content[0]; ?></h4>
								<?php
								array_shift($content);
								foreach($content as $k=>$v):
								?>
                                <em><img src="<?php echo $pre; ?>public/images/hire_03.jpg" /><?php echo $v[ 'title']; ?></em><br />
                                <?php echo $v['content'] . '<br />';
								endforeach;
								?>          
                               
                          </div>
                          <br />
                          <br />
                          <br />
						  </div>
                          
                          
                          
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
        </div>  
        

