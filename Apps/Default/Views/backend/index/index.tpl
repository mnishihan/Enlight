{extends file="backend/base/index.tpl"}

{block name="backend/base/container_inner" prepend}
<div id="header">
    {action controller=index name=menu}
</div>
{/block}

{block name="backend/base/header"}
    {include file="backend/index/header.tpl"}
{/block}