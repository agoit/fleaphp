<?php defined('APP_DIR') or die ('Direct Access to this location is not allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo RESPONSE_CHARSET; ?>" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
<!--
function fnOnPageChanged(page) {
	var url = '<?php echo $this->_url(null); ?>&page=' + page;
	document.location.href = url;
}

// -->
</script>
</head>
<body>
<div id="content">
  <h3><?php echo_t(_T('ui_p_title')); ?> [ <a href="<?php echo $this->_url('create'); ?>"><?php echo_t(_T('ui_p_create')); ?></a> ]</h3>
  <div class="description"><?php echo_t(_T('ui_p_description')); ?></div>
  <br />
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="data">
    <tr>
      <th align="center" nowrap="nowrap">ID</th>
      <th align="left" nowrap="nowrap"><?php echo_t(_T('ui_p_product_name')); ?></th>
      <th align="right" nowrap="nowrap"><?php echo_t(_T('ui_p_price')); ?></th>
      <th align="center" nowrap="nowrap"><?php echo_t(_T('ui_p_created')); ?></th>
      <th align="left" nowrap="nowrap"><?php echo_t(_T('ui_g_operation')); ?></th>
      <th width="100%" align="left" nowrap="nowrap">&nbsp;</th>
    </tr>
    <?php $i = 0; foreach($rowset as $row): $css_class = $i % 2 ? 'even' : 'odd'; $rowid = array('id' => $row[$pk]); ?>
    <tr class="<?php echo $i % 2 ? 'odd' : 'even'; ?>" onmouseover="this.className = 'row_over';" onmouseout="this.className = '<?php echo $i % 2 ? 'odd' : 'even'; ?>';">
      <td align="center" nowrap="nowrap"><?php echo $row[$pk]; ?></td>
      <td nowrap="nowrap"><?php echo_h($row['name']); ?>&nbsp;</td>
      <td align="right" nowrap="nowrap"><?php printf(_T('ui_p_price_value'), $row['price']); ?></td>
      <td align="center" nowrap="nowrap"><?php echo date('y-m-d H:i:s', $row['created']); ?></td>
      <td nowrap="nowrap">
	  <a href="<?php echo $this->_url('picman', $rowid); ?>"><?php echo_t(_T('ui_g_operation_picman')); ?></a>
	  |
	  <a href="<?php echo $this->_url('edit', $rowid); ?>"><?php echo_t(_T('ui_g_operation_edit')); ?></a>
	  |
	  <a href="<?php echo $this->_url('remove', $rowid); ?>" onclick="return confirm('<?php echo_h(_T('ui_p_remove_confirm')); ?>');"><?php echo_t(_T('ui_g_operation_remove')); ?></a>
	  </td>
      <td nowrap="nowrap">&nbsp;</td>
    </tr>
    <?php $i++; endforeach; ?>
  </table>
  <?php if ($pager->count > 0): ?>
  <table width="100%" border="0" cellpadding="2" cellspacing="0">
    <tr>
      <td bgcolor="#FCFCFC"><input name="FirstPage" type="button" id="FirstPage" value=" |&lt; " onclick="fnOnPageChanged(<?php echo $pager->firstPage; ?>);" />
        <input name="PrevPage" type="button" id="PrevPage" value=" &lt; " onclick="fnOnPageChanged(<?php echo $pager->prevPage; ?>);" />
        <?php $pager->renderPageJumper(_T('ui_p_jump_page')); ?>
        <input name="NextPage" type="button" id="NextPage" value=" &gt; " onclick="fnOnPageChanged(<?php echo $pager->nextPage; ?>);" />
        <input name="LastPage" type="button" id="LastPage" value=" &gt;| " onclick="fnOnPageChanged(<?php echo $pager->lastPage; ?>);" />
      </td>
    </tr>
  </table>
  <?php else: // if ($pager->count > 0) ?>
  <table width="100%" border="0" cellpadding="2" cellspacing="0">
    <tr>
      <td><?php echo_h(_T('ui_p_no_products')); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
  <?php endif; // if ($pager->count > 0) ?>
  <table width="100%" border="0" cellpadding="2" cellspacing="0">
    <tr>
      <td><?php printf(_T('ui_p_page_info'), $pager->totalCount, $pager->count, $pager->pageCount, $pager->currentPage + 1); ?></td>
    </tr>
  </table>
  </p>
</div>
</body>
</html>
