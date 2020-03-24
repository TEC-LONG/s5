
<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="{$url.gAdUpd.url}" target="dialog" rel="{$url.gAdUpd.rel}" minable="false" width="750" height="240"><span>新增用户组</span></a></li>
		</ul>
	</div>
	<table class="table" width="100%" layoutH="138">
		<thead>
			<tr>
				<th width="30">序号</th>
				<th width="30">序号</th>
				<th width="30">序号</th>
				<th width="30">序号</th>
				<th width="120">操作</th>
			</tr>
		</thead>
		<tbody>
			<tr target="sid_{$navTab}" rel="{$row.id}">
				<td>1</td>
				<td>aa</td>
				<td>bb</td>
				<td>cc</td>
				<td>
					<a title="确实要删除？" target="ajaxTodo" href="{$url.del.url}?tb=usergroup&id={$row['id']}" class="btnDel">删除</a>
					<a title="编辑用户组" target="dialog" href="{$url.gAdUpd.url}?id={$row['id']}" class="btnEdit" rel="{$url.gAdUpd.rel}"  minable="false" width="650" height="440">编辑用户组</a>
					<a title="设置用户组权限" target="dialog" href="{$url.gpermission.url}?id={$row['id']}" class="btnAssign" rel="{$url.gpermission.rel}"  minable="false" width="650" height="440">设置用户组权限</a>
				</td>
			</tr>
		</tbody>
	</table>

</div>