<div class="box">
 <div class="box_1">
  <div id="category_tree">
    <?php $_from = $this->_var['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat_0_38852700_1359877940');if (count($_from)):
    foreach ($_from AS $this->_var['cat_0_38852700_1359877940']):
?>
     <dl>
     <dt><a href="<?php echo $this->_var['cat_0_38852700_1359877940']['url']; ?>"><?php echo htmlspecialchars($this->_var['cat_0_38852700_1359877940']['name']); ?></a></dt>
     <?php $_from = $this->_var['cat_0_38852700_1359877940']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child_0_38889900_1359877940');if (count($_from)):
    foreach ($_from AS $this->_var['child_0_38889900_1359877940']):
?>
     <dd><a href="<?php echo $this->_var['child_0_38889900_1359877940']['url']; ?>"><?php echo htmlspecialchars($this->_var['child_0_38889900_1359877940']['name']); ?></a></dd>
       <?php $_from = $this->_var['child_0_38889900_1359877940']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'childer');if (count($_from)):
    foreach ($_from AS $this->_var['childer']):
?>
       <dd>&nbsp;&nbsp;<a href="<?php echo $this->_var['childer']['url']; ?>"><?php echo htmlspecialchars($this->_var['childer']['name']); ?></a></dd>
       <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
     <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
       
       </dl>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  </div>
 </div>
</div>
<div class="blank5"></div>
