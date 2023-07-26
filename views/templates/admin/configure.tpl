<div class="defaultForm form-horizontal moduledemo">
    <input type="hidden" name="submitmoduledemo" value="1">
    <div class="panel" id="fieldset_0">
        <div class="panel-heading">&nbsp;</div>
        <div class="row col">
            <div class="col-sm-3">
                <div class="list-group">
                        <span class="list-group-item list-group-item-action cursor-pointer -go-to-welcome-tab">
                            Welcome
                        </span>
                    <span class="list-group-item list-group-item-action cursor-pointer -go-to-advanced-setting-tab">
                            Advanced Settings
                        </span>
                    <span class="list-group-item list-group-item-action cursor-pointer -go-to-help-tab">
                            Help
                        </span>
                </div>
            </div>
            <div class="col-sm-9">
                {include file='module:moduledemo/views/templates/admin/configure_welcome.tpl'}
                {include file='module:moduledemo/views/templates/admin/configure_advanced_settings.tpl'}
                {include file='module:moduledemo/views/templates/admin/configure_help.tpl'}
            </div>
        </div>
    </div>
</div>
