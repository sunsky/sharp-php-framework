<h1><?php echo $this->name ?></h1>
<pre>
<strong>$view:</strong>
<?php 
// print_r($this)
?>
</pre>
<img src="Assets/image/hello_world.png" />
<br/>
<strong><a href="http://mini-php-framework.com/?_a=show">跳转到Show页面</a></strong>

<pre>
<!-- <strong>配置:</strong> -->
<?php 
// print_r(\System\Application\Register::getConfig());
echo $aa;
echo $ab;
// notDefinedFunc();
// throw new \System\Event\Exception\Exception('View中异常测试...');
?>
</pre>
