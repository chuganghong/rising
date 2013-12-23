            <!--
			<div class="page subpage">
            	
            		<div class="pagenav">
                    	 <h3>关于我们&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </h3>
                         <span class="cur"><a href="#">日先简介</a></span>
                         <span><a href="#">日先足迹</a></span>
                         <span><a href="#">日先荣誉</a></span>
                         <span><a href="#">日先理念</a></span>
                    </div>
					-->
                    <div class="pageRcon">
                    <div class="toptxt">
                    	<h3>
                        	<?php echo $cat_desc; ?>
						</h3><br />

                    </div>
                    <div class="mid_con">   
                          
                          <div class="conlevel">
                          	  <div class="contxt">
                          		<?php echo $intro_content; ?>
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