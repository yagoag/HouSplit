<html>

<body>
    <?php include_once "session.php"; ?>
    <form id="new_bill" name="new_bill" method="post" action="new_bill_do.php">
        <p>Bill Name: <input type="text" name="name" /></p>
        <p>Value: <input type="text" name="value" /></p>
        <p>
            <input type="checkbox" name="members[]" value="1" /> Member 1<br />
            <input type="checkbox" name="members[]" value="2" /> Member 2<br />
            <input type="checkbox" name="members[]" value="3" /> Member 3<br />
        </p>
        <p><input type="submit" name="new_bill" /></p>
    </form>
</body>
</html>