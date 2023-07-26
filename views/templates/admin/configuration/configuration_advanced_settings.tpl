{addJsDef tab=$tab|default:''}
<form id="configuration_form" class="defaultForm form-horizontal moduledemo"
      action="{$smarty.server.REQUEST_URI}"
      method="POST"
      enctype="multipart/form-data"
      novalidate="">
    <div class="panel"
         id="fieldset_0">
        <div class="panel-heading">
            <i class="icon-cogs"></i>
            SUPPORT SETTINGS
        </div>
        <div class="form-wrapper">
            {if $isUpdated === '1'}
                <div class="alert alert-success"
                     role="alert">
                    <p class="alert-text">
                        Settings updated.
                    </p>
                </div>
            {elseif $isUpdated === '2'}
                <div class="alert alert-danger"
                     role="alert">
                    <p class="alert-text">
                        Please enter a valid configuration value.
                    </p>
                </div>
            {/if}
            <div class="form-group">
                <label class="control-label col-lg-4 required">
                    Turn on settings
                </label>
                <div class="col-lg-8">
                     <span class="ps-switch ps-switch-lg">
                         <input type="radio"
                                name="MODULEDEMO_SETTING_STATUS"
                                id="no_option"
                                value="0"
                                {if $settingStatus|intval === 0}checked{/if}/>
                         <label for="no_option">NO</label>
                         <input type="radio"
                                name="MODULEDEMO_SETTING_STATUS"
                                id="yes_option"
                                value="1"
                                {if $settingStatus|intval === 1}checked{/if}/>
                         <label for="yes_option">YES</label>
                         <span class="slide-button"></span>
                      </span>
                </div>
            </div>
            <div class="form-group -option">
                <label class="control-label col-lg-4 required"
                       for="MODULEDEMO_SERVICE_API_URL">
                    Service API URL
                </label>
                <div class="col-lg-8">
                    <input type="text"
                           name="MODULEDEMO_SERVICE_API_URL"
                           id="MODULEDEMO_SERVICE_API_URL"
                           value="{$serviceAPIURL}"
                           size="20"
                           required="required">
                </div>
            </div>
            <div class="form-group -option">
                <label class="control-label col-lg-4 required" for="MODULEDEMO_SERVICE_KEY">
                    Service Key
                </label>
                <div class="col-lg-8">
                    <input type="text"
                           name="MODULEDEMO_SERVICE_KEY"
                           id="MODULEDEMO_SERVICE_KEY"
                           value="{$serviceKey}"
                           class=""
                           size="20"
                           required="required">
                </div>
            </div>
            <div class="form-group -option">
                <label class="control-label col-lg-4"
                       for="MODULEDEMO_AUTHORIZATION_API_URL">
                    Authorization API URL
                </label>
                <div class="col-lg-8">
                    <input type="text"
                           name="MODULEDEMO_AUTHORIZATION_API_URL"
                           id="MODULEDEMO_AUTHORIZATION_API_URL"
                           value="{$authorizationAPIURL}"
                           size="20"/>
                </div>
            </div>
        </div><!-- /.form-wrapper -->
        <div class="panel-footer">
            <button type="submit"
                    value="1"
                    id="module_form_submit_btn"
                    name="submitmoduledemo"
                    class="btn btn-default pull-right">
                <i class="process-icon-save"></i> Save
            </button>
        </div>
    </div>
</form>
