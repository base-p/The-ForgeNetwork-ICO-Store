<ol class='c-pager u-flatList'>
     <?php
     echo ($this->Paginator->hasPrev()) ? $this->Paginator->prev('«', array('tag' => 'li','class'=>'c-pager__page'), null, null) : '<li class="c-pager__page"><a href="#">«</a></li>';
     echo $this->Paginator->numbers(array('separator' => false, 'tag' => 'li', 'class'=>'c-pager__page', 'currentClass'=>'c-pager__page c-pager__active', 'currentTag'=>'a'));   
     echo ($this->Paginator->hasNext()) ? $this->Paginator->next('»', array('tag' => 'li', 'class'=>'c-pager__page'), null, null) : '<li class="c-pager__page"><a href="#">»</a></li>';
   ?>
                                
                            </ol>