<script language="javascript">
    function toggle(source) {
    checkboxes = document.getElementsByName('members[]');
        for (var i = 0, n = checkboxes.length; i < n; i++) {
            checkboxes[i].checked = source.checked;
        }
    }
</script>
<div class="title">New Bill</div>
<form id="new_bill" name="new_bill" method="post" action="action/create_bill.php">
    <p><input type="text" name="name" placeholder="Name" /></p>
    <p><input type="text" name="value" placeholder="Value" /></p>
    <br />
    <p>
        <p><input type="checkbox" onClick="toggle(this)" /> Select all members</p>
        <p><input type="checkbox" name="members[]" value="1" /> Member 1</p>
        <p><input type="checkbox" name="members[]" value="2" /> Member 2</p>
        <p><input type="checkbox" name="members[]" value="3" /> Member 3</p>
    </p>
    <br />
    <p><input type="submit" name="new_bill" value="Create Bill" /></p>
</form>