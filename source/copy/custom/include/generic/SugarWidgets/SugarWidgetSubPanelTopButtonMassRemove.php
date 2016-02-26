<?php
/**
 * @license http://hardsoft321.org/license/ GPLv3
 * @author  Evgeny Pervushin <pea@lab321.ru>
 * @package subpanel_mass_remove
 */

class SugarWidgetSubPanelTopButtonMassRemove extends SugarWidgetSubPanelTopButton
{
    function display($defines, $additionalFormFields = null, $nonbutton = false)
    {
        $inputID = $this->getWidgetId();
        if(isset($defines['additional_form_fields']) && is_array($defines['additional_form_fields'])) {
            $additionalFormFields = is_array($additionalFormFields)
                ? array_merge($additionalFormFields, $defines['additional_form_fields'])
                : $defines['additional_form_fields'];
        }
        $this->module = $defines['module'];
        if(!empty($defines['scope']) && $defines['scope'] == 'all') {
            $this->form_value = translate('LBL_MASS_REMOVE_ALL_BUTTON', $this->module);
            $scope = 'all';
        }
        else {
            $this->form_value = translate('LBL_MASS_REMOVE_SELECTED_BUTTON', $this->module);
            $scope = 'selected';
        }
        if(!empty($defines['form_value'])) {
            $this->form_value = $defines['form_value'];
        }
        if(!empty($defines['title'])) {
            $this->title = $defines['title'];
        }
        $linked_field = $defines['subpanel_definition']->get_data_source_name(true);
        $js = <<<JS
function subpanel_mass_remove(linked_field, scope, btn) {
    var selected = \$.map(\$(btn).closest(".list.view").find(".choose-in-subpanel:checked"), function(v) {return v.value});
    if(scope == "selected" && !selected.length) {
        alert(SUGAR.language.get("app_strings", "LBL_LISTVIEW_NO_SELECTED"));
        return false;
    }
    if(!confirm(SUGAR.language.get("app_strings", scope == "all" ? "MSG_SUBPANEL_REMOVE_ALL" : "MSG_SUBPANEL_REMOVE_SELECTED"))) {
        return false;
    }
    \$(btn).attr("disabled", "disabled");
    ajaxStatus.showStatus(SUGAR.language.get("app_strings","LBL_SAVING"));
    \$.ajax("index.php", {
        data: {
            module: get_module_name(),
            record: get_record_id(),
            action: "MassDeleteRelationships",
            linked_id: scope == "all" ? "all" : selected,
            linked_field: linked_field
        },
        type: 'POST',
        dataType: 'json'
    }).always(function() {
        ajaxStatus.hideStatus();
        \$(btn).removeAttr("disabled");
    }).done(function(data) {
        if(typeof data.errors === "undefined") {
            alert(data);
        }
        else if(data.errors.length) {
            alert(data.errors.join("\\n"));
        }
        if(data.saved) {
            ajaxStatus.flashStatus(SUGAR.language.get("app_strings","LBL_SAVED"), 3000);
            location.reload();
        }
    }).fail(function(data) {
        alert(data.responseText);
    });
}
JS;
        if ($nonbutton) {
            return "<script>$js</script><a title=\"{$this->title}\" onclick='subpanel_mass_remove(&quot;$linked_field&quot;, &quot;$scope&quot;, this); return false;'>{$this->form_value}</a>";
        }
        return "<script>$js</script><input title='{$this->title}' class='button' type='submit' name='{$inputID}_{$scope}' id='{$inputID}_{$scope}'
            value='{$this->form_value}' onclick='subpanel_mass_remove(&quot;$linked_field&quot;, &quot;$scope&quot;, this); return false;'/>";
    }
}
