{* jQuery *}
<script src="{$smarty.const.URL}/public/admin/js/jquery.min.js"></script> {* jQuery Library *}

{* if !empty($tag)&&in_array($tag, array('index', 'catIndex' )) *}
<scr ipt src="{$smarty.const.URL}/public/admin/js/jquery-ui.min.js"></script>  {* jQuery UI *}
{* <scr ipt src="{$smarty.const.URL}/public/admin/js/jquery.easing.1.3.js"></script>  jQuery Easing - Requirred for Lightbox + Pie Charts*}
{* /if *}

{* Bootstrap *}
<script src="{$smarty.const.URL}/public/admin/js/bootstrap.min.js"></script>

{* <script src="{$smarty.const.URL}/public/admin/js/validation/validate.min.js"></script> jQuery Form Validation Library *}
{* <script src="{$smarty.const.URL}/public/admin/js/validation/validationEngine.min.js"></script>  jQuery Form Validation Library - requirred with above js *}

{* Charts *}

{* Map *}


{*  Form Related *}
{if !empty($tag)&&in_array($tag, array( 'userAdd', 'userEdit', 'catIndex' ))}
	<script src="{$smarty.const.URL}/public/admin/js/select.min.js"></script> {* Custom Select *}
{/if}

{if !empty($tag)&&in_array($tag, array( 'userAdd', 'userEdit', 'catIndex' ))}
	<script src="{$smarty.const.URL}/public/admin/js/icheck.js"></script> {* Custom Checkbox + Radio *}
{/if}

{if !empty($tag)&&in_array($tag, array( 'userAdd', 'userEdit' ))}
	<script src="{$smarty.const.URL}/public/admin/js/fileupload.min.js"></script> {* File Upload *}
{/if}

{if !empty($tag)&&in_array($tag, array('catIndex'))}
<script src="{$smarty.const.URL}/public/admin/js/toggler.min.js"></script> {* Toggler *}
{/if}

{if !empty($tag)&&in_array($tag, array( 'userAdd', 'userEdit' ))}
	<script src="{$smarty.const.URL}/public/admin/js/autosize.min.js"></script> {* Textare autosize *}
{/if}

{* UX *}
{if !empty($tag)&&in_array($tag, array( 'userAdd', 'userEdit', 'catIndex' ))}
	<script src="{$smarty.const.URL}/public/admin/js/scroll.min.js"></script>  {* Custom Scrollbar *}
{/if}

{* Other *}
{if !empty($tag)&&in_array($tag, array( 'userAdd', 'userEdit', 'catIndex' ))}
	<script src="{$smarty.const.URL}/public/admin/js/calendar.min.js"></script> {* Calendar *}
{/if}

{* <script src="{$smarty.const.URL}/public/admin/js/feeds.min.js"></script>  News Feeds *}


{* All JS functions *}
<script src="{$smarty.const.URL}/public/admin/js/functions.js"></script>

{* category js *}
{if !empty($tag)&&in_array($tag, array('catIndex' ))}
<script src="{$smarty.const.URL}/public/admin/cat/js/jquery.sort.js"></script>
{/if}
