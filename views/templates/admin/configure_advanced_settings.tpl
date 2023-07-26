{if $isUpdated === true}
    <div class="alert alert-success" role="alert">
        <p class="alert-text">
            Settings updated.
        </p>
    </div>
{elseif $isUpdated === false}
    <div class="alert alert-danger" role="alert">
        <p class="alert-text">Please enter a valid configuration value.</p>
    </div>
{/if}
<form id="configuration_form" class="defaultForm form-horizontal moduledemo"
      action="{$smarty.server.REQUEST_URI}"
      method="post" enctype="multipart/form-data" novalidate="">
    <input type="hidden" name="submitmoduledemo" value="1">
    <div class="panel" id="fieldset_0" style="background-color: white">
        <div class="panel-heading">
            <i class="icon-cogs"></i> SUPPORT SETTINGS
            <hr/>
        </div>
        <div class="form-wrapper">
            <div class="form-group">
                <label class="control-label col-lg-4 required">
                    Turn on settings
                </label>
                <div class="col-lg-8">
                    <div class="btn-group active d-flex" data-toggle="buttons">
                        <label class="btn btn-default {if $settingStatus|intval === 1}active{/if}"
                               style="width: 100px;">
                            <input type="radio" name="SETTING_STATUS" id="option1" value="1"
                                   {if $settingStatus|intval === 1}checked{/if}/>
                            <span class="text-nowrap">YES</span>
                        </label>
                        <label class="btn btn-default {if $settingStatus|intval === 0}active{/if}"
                               style="width: 100px;">
                            <input type="radio" name="SETTING_STATUS" id="option2" value="0"
                                   {if $settingStatus|intval === 0}checked{/if}/>
                            <span class="text-nowrap">NO</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group -option">
                <label class="control-label col-lg-4 required">
                    Service API URL
                </label>
                <div class="col-lg-8">
                    <input type="text"
                           name="SERVICE_API_URL"
                           id="SERVICE_API_URL"
                           value="{$serviceAPIURL}"
                           size="20"
                           required="required">
                </div>
            </div>
            <div class="form-group -option">
                <label class="control-label col-lg-4 required">
                    Service Key
                </label>
                <div class="col-lg-8">
                    <input type="text"
                           name="SERVICE_KEY"
                           id="SERVICE_KEY"
                           value="{$serviceKey}"
                           class=""
                           size="20"
                           required="required">
                </div>
            </div>
            <div class="form-group -option">
                <label class="control-label col-lg-4">
                    Authorization API URL
                </label>
                <div class="col-lg-8">
                    <input type="text"
                           name="AUTHORIZATION_API_URL"
                           id="AUTHORIZATION_API_URL"
                           value="{$authorizationAPIURL}"
                           size="20">
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-12">
                    <button type="submit"
                            value="1"
                            id="configuration_form_submit_btn"
                            name="submitmoduledemo" style="height: 50px;"
                            class="btn pull-right">
                        <i class="icon-save"></i> Save
                    </button>
                </div>
            </div>
        </div><!-- /.form-wrapper -->
    </div>
</form>

