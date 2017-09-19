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
 * ���� FLEA_Helper_Pager ��
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author ������ dualface@gmail.com
 * @package Helper
 * @version $Id: Pager.php 683 2007-01-05 16:27:22Z dualface $
 */

/**
 * FLEA_Helper_Pager ���ṩ���ݲ�ѯ��ҳ����
 *
 * FLEA_Helper_Pager ʹ�úܼ򵥣�ֻ��Ҫ����ʱ���� FLEA_Db_TableDataGateway ʵ���Լ���ѯ�������ɡ�
 *
 * @package Helper
 * @author ������ dualface@gmail.com
 * @version 1.0
 */
class FLEA_Helper_Pager
{
    /**
     * ��� $this->_source ��һ�� FLEA_Db_TableDataGateway ���������
     * $this->_source->findAll() ����ȡ��¼����
     *
     * ����ͨ�� $this->_dbo->selectLimit() ����ȡ��¼����
     *
     * @var FLEA_Db_TableDataGateway|string
     */
    var $_source;

    /**
     * ���ݿ���ʶ��󣬵� $this->_source ����Ϊ SQL ���ʱ���������
     * $this->setDBO() ���ò�ѯʱҪʹ�õ����ݿ���ʶ���
     *
     * @var SDBO
     */
    var $_dbo;

    /**
     * ��ѯ����
     *
     * @var mixed
     */
    var $_conditions;

    /**
     * ����
     *
     * @var string
     */
    var $_sortby;

    /**
     * ÿҳ��¼��
     *
     * @var int
     */
    var $pageSize = -1;

    /**
     * �ܼ�¼��
     *
     * @var int
     */
    var $totalCount = -1;

    /**
     * ���������ļ�¼����
     *
     * @var int
     */
    var $count = -1;

    /**
     * ���������ļ�¼ҳ��
     *
     * @var int
     */
    var $pageCount = -1;

    /**
     * ��һҳ���������� 0 ��ʼ
     *
     * @var int
     */
    var $firstPage = -1;

    /**
     * ��һҳ��ҳ��
     *
     * @var int
     */
    var $firstPageNumber = -1;

    /**
     * ���һҳ���������� 0 ��ʼ
     *
     * @var int
     */
    var $lastPage = -1;

    /**
     * ���һҳ��ҳ��
     *
     * @var int
     */
    var $lastPageNumber = -1;

    /**
     * ��һҳ������
     *
     * @var int
     */
    var $prevPage = -1;

    /**
     * ��һҳ��ҳ��
     *
     * @var int
     */
    var $prevPageNumber = -1;

    /**
     * ��һҳ������
     *
     * @var int
     */
    var $nextPage = -1;

    /**
     * ��һҳ��ҳ��
     *
     * @var int
     */
    var $nextPageNumber = -1;

    /**
     * ��ǰҳ������
     *
     * @var int
     */
    var $currentPage = -1;

    /**
     * ��ǰҳ��ҳ��
     *
     * @var int
     */
    var $currentPageNumber = -1;

    /**
     * ���캯��
     *
     * ��� $source ������һ�� TableDataGateway ������ FLEA_Helper_Pager �����
     * �� TDG ����� findCount() �� findAll() ��ȷ����¼���������ؼ�¼����
     *
     * ��� $source ������һ���ַ�������ٶ�Ϊ SQL ��䡣��ʱ��FLEA_Helper_Pager
     * �����Զ����ü�������ҳ����������ͨ�� setCount() ������������Ϊ��ҳ����
     * �����ļ�¼������
     *
     * ͬʱ����� $source ����Ϊһ���ַ���������Ҫ $conditions �� $sortby ������
     * ���ҿ���ͨ�� setDBO() ��������Ҫʹ�õ����ݿ���ʶ��󡣷��� FLEA_Helper_Pager
     * �����Ի�ȡһ��Ĭ�ϵ����ݿ���ʶ���
     *
     * @param TableDataGateway|string $source
     * @param int $currentPage
     * @param int $pageSize
     * @param mixed $conditions
     * @param string $sortby
     *
     * @return FLEA_Helper_Pager
     */
    function FLEA_Helper_Pager(& $source, $currentPage, $pageSize = 20,
                               $conditions = null, $sortby = null)
    {
        log_message("Construction FLEA_Helper_Pager(\$source, {$currentPage}, {$pageSize}, {$conditions}, {$sortby})", 'debug');
        $this->currentPage = $currentPage;
        $this->pageSize = $pageSize;

        if (is_object($source)) {
            $this->_source =& $source;
            $this->_conditions = $conditions;
            $this->_sortby = $sortby;
            $this->count = $this->_source->findCount($conditions);
            $this->totalCount = $this->_source->findCount();
            $this->_computingPage();
        } else {
            $this->_source = $source;
        }
    }

    /**
     * ���ü�¼�������Ӷ����·�ҳ����
     *
     * @param int $count
     */
    function setCount($count) {
        $this->count = $count;
        $this->_computingPage();
    }

    /**
     * �������ݿ���ʶ���
     *
     * @param SDBO $dbo
     */
    function setDBO(& $dbo) {
        $this->_dbo =& $dbo;
    }

    /**
     * ���ص�ǰҳ��Ӧ�ļ�¼��
     *
     * @param string $fields
     *
     * @return array
     */
    function & findAll($fields = '*') {
        if ($this->count == -1) {
            $this->count = 20;
        }

        if (is_object($this->_source)) {
            $limit = array($this->pageSize, $this->currentPage * $this->pageSize);
            $rowset = $this->_source->findAll($this->_conditions, $this->_sortby, $limit, $fields);
        } else {
            if (is_null($this->_dbo)) {
                $this->_dbo =& get_dbo(false);
            }
            $rs = $this->_dbo->selectLimit($this->_source, $this->pageSize,
                $this->currentPage * $this->pageSize);
            $rowset = $this->_dbo->getAll($rs);
        }
        return $rowset;
    }

    /**
     * ����һ��ҳ��ѡ����ת�ؼ�
     *
     * @param string $caption
     * @param string $jsfunc
     */
    function renderPageJumper($caption = '%u', $jsfunc = 'fnOnPageChanged') {
        $out = "<select name=\"PageJumper\" onchange=\"{$jsfunc}(this.value);\">\n";
        for ($i = 0; $i < $this->pageCount; $i++) {
            $out .= "<option value=\"{$i}\"";
            if ($i == $this->currentPage) {
                $out .= " selected";
            }
            $out .=">";
            $out .= sprintf($caption, $i + 1);
            $out .= "</option>\n";
        }
        $out .= "</select>\n";
        echo $out;
    }

    /**
     * ��������ҳ����
     */
    function _computingPage() {
        $this->pageCount = ceil($this->count / $this->pageSize);
        $this->firstPage = 0;
        $this->lastPage = $this->pageCount - 1;
        if ($this->lastPage < 0) { $this->lastPage = 0; }
        if ($this->currentPage >= $this->pageCount) {
            $this->currentPage = $this->lastPage;
        }
        if ($this->currentPage < 0) {
            $this->currentPage = $this->firstPage;
        }
        if ($this->currentPage < $this->lastPage - 1) {
            $this->nextPage = $this->currentPage + 1;
        } else {
            $this->nextPage = $this->lastPage;
        }
        if ($this->currentPage > 0) {
            $this->prevPage = $this->currentPage - 1;
        } else {
            $this->prevPage = 0;
        }

        $this->firstPageNumber = $this->firstPage + 1;
        $this->lastPageNumber = $this->lastPage + 1;
        $this->nextPageNumber = $this->nextPage + 1;
        $this->prevPageNumber = $this->prevPage + 1;
        $this->currentPageNumber = $this->currentPage + 1;
    }
}
