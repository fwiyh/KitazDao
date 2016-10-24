<?php
/* Smarty version 3.1.30, created on 2016-10-24 16:29:37
  from "F:\My Documents\Projects\src\KitazDao\devel\class\templates\index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_580e1ad127a2d1_33860730',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '425b6a48b4b4c1f6030ecd60cefcd9518fe41230' => 
    array (
      0 => 'F:\\My Documents\\Projects\\src\\KitazDao\\devel\\class\\templates\\index.tpl',
      1 => 1477319353,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_580e1ad127a2d1_33860730 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_html_options')) require_once 'F:\\My Documents\\Projects\\src\\KitazDao\\devel\\class\\Smarty\\plugins\\function.html_options.php';
?>
<html>
<head>
	<title>メニュー</title>
	<?php echo '<script'; ?>
 type="script/javascript" src="../js/jquery-3.1.1.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="script/javascript" src="../js/SessionControl.prot.js"><?php echo '</script'; ?>
>
		
	
</head>
<body>
	対象DB<?php echo $_smarty_tpl->tpl_vars['selectDatabase']->value;?>
<br>
	<?php echo smarty_function_html_options(array('id'=>"selectableDatabase",'name'=>"selectableDatabase",'options'=>$_smarty_tpl->tpl_vars['selectableDatabase']->value,'selected'=>$_smarty_tpl->tpl_vars['selectDatabase']->value),$_smarty_tpl);?>

	<input type="button" id="ChangeDatabase" value="選択" />
</body>
</html><?php }
}
