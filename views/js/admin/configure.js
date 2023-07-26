$(window).ready(() => {
    const settingStatusInput = $('input[name="SETTING_STATUS"]');
    const optionElements = $('.-option');
    const currentSettingStatus = $('input[name="SETTING_STATUS"]:checked').val();

    handleShowInput(currentSettingStatus);
    settingStatusInput.change(function () {
        // Check if the radio button is checked
        if ($(this).is(':checked')) {
            // Get the value of the checked radio button
            const selectedValue = $(this).val();
            handleShowInput(selectedValue);
        }
    });
    function handleShowInput(selectedValue) {
        if (parseInt(selectedValue) === 0) {
            optionElements.hide()
        }
        if (parseInt(selectedValue) === 1) {
            optionElements.show();
        }
    }
});
