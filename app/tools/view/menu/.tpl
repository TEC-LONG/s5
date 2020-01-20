<div class="pageContent">

            <div class="panelBar">
                <ul class="toolBar">
                    <li><a class="add" href="{$url.ad.url}" target="navTab" rel="Menu_ad"><span>添加页</span></a></li>
<li><a class="delete" href="{$url.del.url}&id={ldelim}sid_{$navTab}}" target="ajaxTodo" title="确定要删除吗?"><span>删除</span></a></li>
<li><a class="edit" href="{$url.upd.url}&id={ldelim}sid_{$navTab}}" target="navTab"  rel="Menu_upd"><span>编辑页</span></a></li>

                </ul>
            </div>
            
            <table class="table" width="100%" layoutH="138">
                
            <thead>
                <tr>
                    <th width="30"><input type="checkbox" group="ids" class="checkboxCtrl"></th>
                    <th width="30">序号</th>
            <th width="70"></th>

                </tr>
            </thead>
            
                
            <tbody>
            {foreach $rows as $rows_key=>$row}
            <tr target="sid_{$navtab}" rel="{$row.id}">
                <td><input name="ids_{$navtab}[]" value="{$row.id}" type="checkbox"></td>
                <td>{$rows_key+1}</td>
            
                <td>{$row.}</td>
                
            </tr>
            {/foreach}
            </tbody>
            
            </table>
            
        <form id="pagerForm" method="post" action="">
            <input type="hidden" name="pageNum" value="1" />
            <input type="hidden" name="numPerPage" value="{$page.numPerPage}" />
            
            <input type="hidden" name="" value="{$search.}" />
            
        </form>
        <div class="panelBar">
            <div class="pages">
                <span>显示</span>
                <select class="combox" name="numPerPage" {literal}onchange="navTabPageBreak({numPerPage:this.value})"{/literal}>
                    <option value="{$page.numPerPage}">{$page.numPerPage}</option>
                    {foreach $page.numPerPageList as $thisNumPerPage}
                        {if $thisNumPerPage!=$page.numPerPage}
                    <option value="{$thisNumPerPage}">{$thisNumPerPage}</option>
                        {/if}
                    {/foreach}
                </select>
                <span>条，总共{$page.totalNum}条记录，合计{$page.totalPageNum}页</span>
            </div>
            <div class="pagination" targetType="navTab" totalCount="{$page.totalNum}" numPerPage="{$page.numPerPage}" pageNumShown="6" currentPage="{$page.pageNum}"></div>
        </div>
        
</div>