{include file="common/top.tpl" htag='userAdd'}
                
                <h4 class="page-title">添加用户</h4>
                                
                <!-- Multi Column -->
                <div class="block-area" id="tableHover">
                    <h3 class="block-title">&nbsp;<a href="{$smarty.const.URL}/index.php?p=admin&m=user&a=userIndex" class="icon">&#61771;</a>&nbsp;</h3>
						<form class="row form-columned" role="form" method="post" action="{$smarty.const.URL}/index.php?p=admin&m=user&a=userAddh"" enctype="multipart/form-data">
							<p>头像预览</p>
							<div class="fileupload fileupload-new" data-provides="fileupload">
								<div class="fileupload-preview thumbnail form-control"></div>
								
								<div>
									<span class="btn btn-file btn-alt btn-sm">
										<span class="fileupload-new">Select image</span>
										<span class="fileupload-exists">Change</span>
										<input type="file" name="img" />
									</span>
									<a href="#" class="btn fileupload-exists btn-sm" data-dismiss="fileupload">Remove</a>
								</div>
							</div>
							<div class="col-md-4">
								<input type="text" class="form-control input-sm m-b-10" placeholder="帐号" name="acc">
							</div>
							<div class="col-md-4">
								<input type="text" class="form-control input-sm m-b-10" placeholder="昵称" name="nickname">
							</div>
							<div class="col-md-4 m-b-10">
								<select class="select" name="level">
									<option value="0">普通用户</option>
									<option value="1">管理员</option>
								</select>
							</div>
							<div class="clearfix"></div>
							<div class="col-md-4">
								<input type="tel" class="form-control input-sm m-b-10" placeholder="手机号" name="cell">
							</div>
							<div class="col-md-4">
								<input type="text" class="form-control input-sm m-b-10" placeholder="邮箱" name="email">
							</div>
							<div class="col-md-4">
								<input type="password" class="form-control input-sm m-b-10" placeholder="密码" name="pwd">
							</div>
							<!-- <div class="col-md-12"> -->
								<!-- <textarea class="form-control m-b-10" placeholder="Description"></textarea> -->
							<!-- </div> -->
							<div class="col-md-4 m-b-10">
								<select class="select" name="status">
									<option value="0">正常</option>
									<option value="1">禁用</option>
								</select>
							</div>
							<div class="col-md-10">
								<button type="submit" class="btn btn-sm">Save Profile</button>
							</div>
						</form>
                </div>
            
            </section>
            <br/><br/>
        </section>
        
        <!-- Javascript Libraries -->
        {include file="common/js_footer.tpl" tag="userAdd"}
    </body>
</html>

