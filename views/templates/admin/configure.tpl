<div class="defaultForm form-horizontal moduledemo">
    <input type="hidden" name="submitmoduledemo" value="1">
    <div class="panel" id="fieldset_0">
        <div class="panel-heading">&nbsp;</div>
            <div class="row col">
                <div class="col-sm-3">
                    <div class="list-group">
                        <a href="{$welcomeURL}"
                           class="list-group-item list-group-item-action {if in_array($smarty.get.page|default:'', ['welcome', ''])} active {/if}"
                        >Welcome</a
                        >
                        <a href="{$advancedSettingsURL}"
                           class="list-group-item list-group-item-action {if $smarty.get.page|default:'' === 'advanced_settings'} active {/if}"
                        >Advanced Settings</a
                        >
                        <a href="{$helpURL}"
                           class="list-group-item list-group-item-action {if $smarty.get.page|default:'' === 'help'} active {/if}"
                        >Help</a
                        >
                    </div>
                </div>
                <div class="col-sm-9">
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
</div>
