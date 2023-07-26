<div class="bootstrap">
    <hr class="mt-5">
    <div class="row">
        <div class="col col-sm-3">
            <div class="list-group">
                <a href="{$welcomeURL}" class="list-group-item list-group-item-action {if in_array($smarty.get.page|default:'', ['welcome', ''])} active {/if}"
                >Welcome</a
                >
                <a href="{$advancedSettingsURL}" class="list-group-item list-group-item-action {if $smarty.get.page|default:'' === 'advanced_settings'} active {/if}"
                >Advanced Settings</a
                >
                <a href="{$helpURL}" class="list-group-item list-group-item-action {if $smarty.get.page|default:'' === 'help'} active {/if}"
                >Help</a
                >
            </div>
        </div>
        <div class="col col-sm-9">
            {if in_array($smarty.get.page|default:'', ['welcome', ''])}
                {include file='module:moduledemo/views/templates/admin/configure_welcome.tpl'}
            {/if}
            {if $smarty.get.page|default:'' === 'advanced_settings'}
                {include file='module:moduledemo/views/templates/admin/configure_advanced_settings.tpl'}
            {/if}
            {if $smarty.get.page|default:'' === 'help'}
                {include file='module:moduledemo/views/templates/admin/help.tpl'}
            {/if}
        </div>
    </div>
</div>
