<div id="append_parent"></div>
<div class="userInfo">
<?php if ($this->_var['user_info']): ?>
<font style="position:relative;">
<?php echo $this->_var['lang']['hello']; ?>£¬<font class="f4_b"><?php echo $this->_var['user_info']['username']; ?></font>, <?php echo $this->_var['lang']['welcome_return']; ?>£¡
<a href="user.php"><?php echo $this->_var['lang']['user_center']; ?></a>|
<a href="user.php?act=collection_list">ÊÕ²Ø¼Ð</a>|
 <a class="reg" href="user.php?act=logout"><?php echo $this->_var['lang']['user_logout']; ?></a>
</font>
<?php else: ?>
 [<a href="user.php">µÇÂ¼</a>|
 <a class="reg" href="user.php?act=register">Ãâ·Ñ×¢²á</a>]
<?php endif; ?>
</div>