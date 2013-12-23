<?php if($cur3 == 0): //从一级栏目链接而来时$cur3为0?>			
			<div class="page">	
<?php else: ?>
			<div class="page subpage">	
<?php endif; ?>
					<div class="pagenav">
					<?php
					$str = '';
					foreach($pagenav as $k=>$v)
					{						
						if($k==0)
						{
							$str .= '<h3>' . $v['cat_name'] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &rarr;</h3>';							
						}
						else if($k == 1)
						{
							continue;							
						}
						else
						{
							if($v['cat_id'] == $cur2)
							{								
								$str .='<span class="cur">';
							}
							else
							{
								$str .= '<span>';
							}
							$str .= '<a href="' . $v['action_name'] . '">' . $v['cat_name'] . '</a></span>';
						}						
					}
					echo $str;
                    ?>
                    </div>