
<div class="pageHeader">
    <form onsubmit="return navTabSearch(this);" action="{$url.index.url}" method="post" onreset="$(this).find('select.combox').comboxReset()">
    <div class="searchBar">
        <table class="searchContent">
            <tr>
                <td>账号：<input type="text" name="acc" value="{if isset($search.acc)}{$search.acc}{/if}" /></td><td>用户昵称：<input type="text" name="nickname" value="{if isset($search.nickname)}{$search.nickname}{/if}" /></td>
            </tr>
        </table>
        <div class="subBar">
            <ul>
                <li><div class="button"><div class="buttonContent"><button type="reset">重置</button></div></div></li>
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
                <li><a class="button" href="demo_page6.html" target="dialog" mask="true" title="查询框"><span>高级检索</span></a></li>
            </ul>
        </div>
    </div>
    </form>
</div>
            <div class="pageContent">

            <table class="table" width="100%" layoutH="138">
                
            <thead>
                <tr>
                    <th width="30"><input type="checkbox" group="ids" class="checkboxCtrl"></th>
                    <th width="30">序号</th>
            <th width="70">账号</th><th width="70">post_date</th><th width="70">id</th><th width="70">用户昵称</th><th width="70">手机号</th>
                </tr>
            </thead>
            
                
            <tbody>
            {foreach $rows as $rows_key=>$row}
            <tr target="sid_{$navtab}" rel="{$row.id}">
                <td><input name="ids_{$navtab}[]" value="{$row.id}" type="checkbox"></td>
                <td>{$rows_key+1}</td>
            
                <td>{$row.acc}</td>
                
                <td>{$row.post_date}</td>
                
                <td>{$row.id}</td>
                
                <td>{$row.nickname}</td>
                
                <td>{$row.cell}</td>
                
            </tr>
            {/foreach}
            </tbody>
            
            </table>
            
        <form id="pagerForm" method="post" action="{$url.index.url}">
            <input type="hidden" name="pageNum" value="1" />
            <input type="hidden" name="numPerPage" value="{$page.numPerPage}" />
            
            <input type="hidden" name="acc" value="{$search.acc}" />
            
            <input type="hidden" name="nickname" value="{$search.nickname}" />
            
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