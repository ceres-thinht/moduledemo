$(window).ready(() => {
    const settingStatusInput = $('input[name="MODULEDEMO_SETTING_STATUS"]');
    const optionElements = $('.-option');
    const currentSettingStatus = $('input[name="MODULEDEMO_SETTING_STATUS"]:checked').val();
    const alertElement = $('.alert');

    const welcomeTabBtn = $('span.-go-to-welcome-tab');
    const advancedSettingsTabBtn = $('span.-go-to-advanced-setting-tab');
    const helpTabBtn = $('span.-go-to-help-tab');

    const welcomeTabElement = $('#welcome_tab');
    const advancedSettingsTabElement = $('#configuration_form');
    const helpTabElement = $('#help_tab');

    /**
     * Handle advanced setting action
     */
    handleShowInput(currentSettingStatus);
    settingStatusInput.change(function () {
        // Check if the radio button is checked
        if ($(this).is(':checked')) {
            // Get the value of the checked radio button
            const selectedValue = $(this).val();
            handleShowInput(selectedValue);
        }
    });

    /**
     * Handle tabs menu action
     */
    handleWelComeTabBtnClick(tab || '', true);
    welcomeTabBtn.click(function () {
        handleWelComeTabBtnClick();
    });
    advancedSettingsTabBtn.click(function () {
        handleAdvancedSettingBtnClick();
    });
    helpTabBtn.click(function () {
        handleHelpBtnClick();
    });

    /**
     * Handle show element when on/off advanced setting
     * @param selectedValue
     */
    function handleShowInput(selectedValue) {
        if (parseInt(selectedValue) === 0) {
            optionElements.hide()
        }
        if (parseInt(selectedValue) === 1) {
            optionElements.show();
        }
    }

    /**
     * Handle the `Welcome` button click
     */
    function handleWelComeTabBtnClick(tab = '', isInit = false) {
        if (tab === 'advanced_settings' && isInit) {
            handleAdvancedSettingBtnClick(false);
            return;
        }
        welcomeTabBtn.addClass('active');
        advancedSettingsTabBtn.removeClass('active');
        helpTabBtn.removeClass('active');
        welcomeTabElement.show();
        advancedSettingsTabElement.hide();
        helpTabElement.hide();
    }

    /**
     * Handle The `Advanced Settings` button click
     */
    function handleAdvancedSettingBtnClick(isHideAlert = true) {
        welcomeTabBtn.removeClass('active');
        advancedSettingsTabBtn.addClass('active');
        helpTabBtn.removeClass('active');
        welcomeTabElement.hide();
        advancedSettingsTabElement.show();
        helpTabElement.hide();
        if (isHideAlert) {
            alertElement.hide();
        }
    }

    /**
     * Handle the `Help` button click
     */
    function handleHelpBtnClick() {
        welcomeTabBtn.removeClass('active');
        advancedSettingsTabBtn.removeClass('active');
        helpTabBtn.addClass('active');
        welcomeTabElement.hide();
        advancedSettingsTabElement.hide();
        helpTabElement.show();
    }
});
