<script type="text/javascript">
	$(function(){
			$(".brand span").click(function(){
					$(this).next().show();
				});
			$(".brand").mouseleave(function(){
					$(".showdetail").hide();
				})
		})
</script>
                   <div class="pageRcon">
                   		<div class="txtdetails">
                   		 <div class="date">发布日期：<?php echo date('Y.m.d',$content['addtime']); ?> 原文出自：日先</div>
                         <div class="newstextcon">
                         		<h3><?php echo $content['title']; ?></h3>
						 <?php echo $content['content']; ?>
                         </div>
                        </div>
                   </div>
                   
            </div>
        </div> 