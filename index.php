<!DOCTYPE html>
<html lang="en">
    <head>
        <title> Home Page </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge;" />
        <meta name="description" content="">
        <!-- header start -->
        <script src="/vendors/ics.deps.min.js"></script>
        <script src="/vendors/ics.min.js"></script>
        <script src="/vendors/ics.js"></script>
    </head>
    <body>
        <script>
            var cal = ics();
            cal.addEvent('Demo Event', 'This is an all day event', 'Nome, AK', '8/7/2013', '8/7/2013');
            cal.addEvent('Demo Event', 'This is thirty minute event', 'Nome, AK', '8/7/2013 5:30 pm', '8/7/2013 6:00 pm');
        </script>
        <a href="#" onclick="javascript:cal.download()">Demo</a>
        <input id="test-input" type="text" placeholder="stuff"/>
        <script src="/js/test.js"></script>
    </body>
    <!-- footer ends -->
</html>