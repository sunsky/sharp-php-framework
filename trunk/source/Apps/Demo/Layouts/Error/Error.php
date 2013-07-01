<?php require $this->dir . '/Common/Header.php';?>
<h1>From Layout</h1>
错误码:<?php echo $this->view->errorCode ?><br/>
错误类型:<?php echo $this->view->errorType ?><br/>
错误详细:<?php echo $this->view->errorDetail; ?><br/>
<?php 
echo $this->view->content;

?>
<?php require $this->dir . '/Common/Footer.php';?>