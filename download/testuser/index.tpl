
<div class="pageHeader">
    <form onsubmit="return navTabSearch(this);" action="{$url.index.url}" method="post" onreset="$(this).find('select.combox').comboxReset()">
    <div class="searchBar">
        <table class="searchContent">
            <tr>
                <td>姓名：<input type="text" name="name" value="{if isset($search.name)}{$search.name}{/if}" /></td><td>年龄：<input type="text" name="age" value="{if isset($search.age)}{$search.age}{/if}" /></td><td>用户类型：<select class="combox" name="user_type">
<option value="0" {if isset($search.user_type)&&$search.user_type=="0"}selected{/if}>普通用户</option>
<option value="1" {if isset($search.user_type)&&$search.user_type=="1"}selected{/if}>普通管理员</option>
<option value="2" {if isset($search.user_type)&&$search.user_type=="2"}selected{/if}>超级管理员</option>
</select>
</td>
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
            <th width="70">姓名</th>
<th width="70">年龄</th>
<th width="70">手机号</th>
<th width="70">座机号</th>
<th width="70">邮箱</th>
<th width="70">用户类型</th>
<th width="70">头像(25*25)</th>

                </tr>
            </thead>
            
                
            <tbody>
            {foreach $rows as $rows_key=>$row}
            <tr target="sid_{$navtab}" rel="{$row.id}">
                <td><input name="ids_{$navtab}[]" value="{$row.id}" type="checkbox"></td>
                <td>{$rows_key+1}</td>
            
                <td>{$row.name}</td>
                
                <td>{$row.age}</td>
                
                <td>{$row.cell}</td>
                
                <td>{$row.phone}</td>
                
                <td>{$row.email}</td>
                
                <td>{$row.user_type}</td>
                
                <td>{$row.headimg}</td>
                
            </tr>
            {/foreach}
            </tbody>
            
            </table>
            
        <form id="pagerForm" method="post" action="{$url.index.url}">
            <input type="hidden" name="pageNum" value="1" />
            <input type="hidden" name="numPerPage" value="{$page.numPerPage}" />
            
            <input type="hidden" name="name" value="{$search.name}" />
            
            <input type="hidden" name="age" value="{$search.age}" />
            
            <input type="hidden" name="user_type" value="{$search.user_type}" />
            
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