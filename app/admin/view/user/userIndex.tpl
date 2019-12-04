{include file="common/top.tpl" htag='userIndex'}
                
                <h4 class="page-title">用户列表</h4>
                                
                <!-- Table Hover -->
                <div class="block-area" id="tableHover">
                    <h3 class="block-title">&nbsp;<a href="{$smarty.const.URL}/index.php?p=admin&m=user&a=userAdd" class="icon">&#61943;</a>&nbsp;</h3>
                    <div class="table-responsive overflow">
                        <table class="table table-bordered table-hover tile" style="font-size:18px;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>ID.</th>
                                    <th>账号</th>
									<th>账号类型</th>
									<th>来源</th>
                                    <th>昵称</th>
                                    <th>电话</th>
                                    <th>邮箱</th>
                                    <th>添加时间</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
							{foreach from=$rows item="row" key="row_key" name="f1"}
                                <tr>
                                    <td>1</td>
                                    <td>{$row.id} </td>
                                    <td {if $row.status==1}style="color:red;"{/if}>{$row.acc} </td>
                                    <td>{$fields['level'][$row['level']]} </td>
                                    <td>{$fields['ori'][$row['ori']]} </td>
                                    <td>{$row.nickname}</td>
                                    <td>{$row.cell}</td>
                                    <td>{$row.email}</td>
                                    <td>{$row.post_date|date_format:'%Y-%m-%d %H:%M'}</td>
                                    <td>
										<a href="{$smarty.const.URL}/index.php?p=admin&m=user&a=userUpd&id={$row.id}" class="icon" target="_blank">&#61952;</a>{*编辑*}
										&nbsp;&nbsp;
										<a href="{$smarty.const.URL}/index.php?p=admin&m=user&a=userDel&id={$row.id}" class="icon" onclick="return confirm('确定要删除此用户吗？')">&#61918;</a>{*删除*}
										{if $row.status==0}
										&nbsp;&nbsp;
										<a href="{$smarty.const.URL}/index.php?p=admin&m=user&a=userStatus&id={$row.id}&status=1" class="icon" onclick="return confirm('确定要禁用此用户吗？')">&#61756;</a>{*禁用*}
										{elseif $row.status==1}
										&nbsp;&nbsp;
										<a href="{$smarty.const.URL}/index.php?p=admin&m=user&a=userStatus&id={$row.id}&status=0" class="icon" onclick="return confirm('确定要解除禁用此用户吗？')">&#61937;</a>{*解除禁用*}
										{/if}
									</td>
                                </tr>
							{/foreach}
                                <!-- <tr> -->
                                    <!-- <td>2</td> -->
                                    <!-- <td>Malinda</td> -->
                                    <!-- <td>Hollaway</td> -->
                                    <!-- <td>@hollway</td> -->
									<!-- <td> -->
										<!-- <a href="#" class="icon">&#61952;</a> -->
										<!-- &nbsp;&nbsp; -->
										<!-- <a href="#" class="icon">&#61918;</a> -->
									<!-- </td> -->
                                <!-- </tr> -->
                            </tbody>
                        </table>
                    </div>
                </div>
            
            </section>
            <br/><br/>
        </section>
        
        {* Javascript Libraries *}
        {include file="common/js_footer.tpl" tag="userIndex"}
    </body>
</html>

