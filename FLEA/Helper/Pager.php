<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 FleaPHP 项目的一部分
//
// Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.fleaphp.org/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * 定义 FLEA_Helper_Pager 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package Helper
 * @version $Id: Pager.php 683 2007-01-05 16:27:22Z dualface $
 */

/**
 * FLEA_Helper_Pager 类提供数据查询分页功能
 *
 * FLEA_Helper_Pager 使用很简单，只需要构造时传入 FLEA_Db_TableDataGateway 实例以及查询条件即可。
 *
 * @package Helper
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class FLEA_Helper_Pager
{
    /**
     * 如果 $this->_source 是一个 FLEA_Db_TableDataGateway 对象，则调用
     * $this->_source->findAll() 来获取记录集。
     *
     * 否则通过 $this->_dbo->selectLimit() 来获取记录集。
     *
     * @var FLEA_Db_TableDataGateway|string
     */
    var $_source;

    /**
     * 数据库访问对象，当 $this->_source 参数为 SQL 语句时，必须调用
     * $this->setDBO() 设置查询时要使用的数据库访问对象。
     *
     * @var SDBO
     */
    var $_dbo;

    /**
     * 查询条件
     *
     * @var mixed
     */
    var $_conditions;

    /**
     * 排序
     *
     * @var string
     */
    var $_sortby;

    /**
     * 每页记录数
     *
     * @var int
     */
    var $pageSize = -1;

    /**
     * 总记录数
     *
     * @var int
     */
    var $totalCount = -1;

    /**
     * 符合条件的记录总数
     *
     * @var int
     */
    var $count = -1;

    /**
     * 符合条件的记录页数
     *
     * @var int
     */
    var $pageCount = -1;

    /**
     * 第一页的索引，从 0 开始
     *
     * @var int
     */
    var $firstPage = -1;

    /**
     * 第一页的页码
     *
     * @var int
     */
    var $firstPageNumber = -1;

    /**
     * 最后一页的索引，从 0 开始
     *
     * @var int
     */
    var $lastPage = -1;

    /**
     * 最后一页的页码
     *
     * @var int
     */
    var $lastPageNumber = -1;

    /**
     * 上一页的索引
     *
     * @var int
     */
    var $prevPage = -1;

    /**
     * 上一页的页码
     *
     * @var int
     */
    var $prevPageNumber = -1;

    /**
     * 下一页的索引
     *
     * @var int
     */
    var $nextPage = -1;

    /**
     * 下一页的页码
     *
     * @var int
     */
    var $nextPageNumber = -1;

    /**
     * 当前页的索引
     *
     * @var int
     */
    var $currentPage = -1;

    /**
     * 当前页的页码
     *
     * @var int
     */
    var $currentPageNumber = -1;

    /**
     * 构造函数
     *
     * 如果 $source 参数是一个 TableDataGateway 对象，则 FLEA_Helper_Pager 会调用
     * 该 TDG 对象的 findCount() 和 findAll() 来确定记录总数并返回记录集。
     *
     * 如果 $source 参数是一个字符串，则假定为 SQL 语句。这时，FLEA_Helper_Pager
     * 不会自动调用计算各项分页参数。必须通过 setCount() 方法来设置作为分页计算
     * 基础的记录总数。
     *
     * 同时，如果 $source 参数为一个字符串，则不需要 $conditions 和 $sortby 参数。
     * 而且可以通过 setDBO() 方法设置要使用的数据库访问对象。否则 FLEA_Helper_Pager
     * 将尝试获取一个默认的数据库访问对象。
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
     * 设置记录总数，从而更新分页参数
     *
     * @param int $count
     */
    function setCount($count) {
        $this->count = $count;
        $this->_computingPage();
    }

    /**
     * 设置数据库访问对象
     *
     * @param SDBO $dbo
     */
    function setDBO(& $dbo) {
        $this->_dbo =& $dbo;
    }

    /**
     * 返回当前页对应的记录集
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
     * 生成一个页面选择跳转控件
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
     * 计算各项分页参数
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
