function toggle(source) {
    checkboxes = document.getElementsByName('members[]');
    for (var i = 0, n = checkboxes.length; i < n; i++) {
        checkboxes[i].checked = source.checked;
    }
}