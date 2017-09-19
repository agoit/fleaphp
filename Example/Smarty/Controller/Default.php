<?php
/////////////////////////////////////////////////////////////////////////////
// ����ļ��� FleaPHP ��Ŀ��һ����
//
// Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
//
// Ҫ�鿴�����İ�Ȩ��Ϣ�������Ϣ����鿴Դ�����и����� COPYRIGHT �ļ���
// ���߷��� http://www.fleaphp.org/ �����ϸ��Ϣ��
/////////////////////////////////////////////////////////////////////////////

/**
 * ���� Controller_Default ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Example
 * @subpackage Smarty
 * @version $Id: Default.php 641 2006-12-19 11:51:53Z dualface $
 */

/**
 * Controller_Default ���� Smarty ʾ����Ĭ�Ͽ�����
 *
 * @package Example
 * @subpackage Smarty
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class Controller_Default extends FLEA_Controller_Action
{
    /**
     * Ĭ�Ͽ���������
     */
    function actionIndex() {
        $smarty =& $this->_getView();
        /* @var $smarty Smarty */
        $smarty->assign('my_var', 'The smarty template engine.');
        $smarty->display('tpl-index.html');
    }

    /**
     * ��ʾ��һ��ʹ�� Smarty �ķ���
     */
    function actionAlternative() {
        $viewData = array(
            'my_var' => 'The smarty template engine.',
        );
        $this->_executeView('tpl-alternative.html', $viewData);
    }
}
