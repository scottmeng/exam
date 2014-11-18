<!-- index.html -->
<!DOCTYPE html>
<html data-ng-app="examApp">
<head>
    <!-- SCROLLS -->
    <!-- load bootstrap and fontawesome via CDN -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" />
    <link rel="stylesheet" href="styles/style.css">
    <!-- SPELLS -->
    <!-- load angular and angular route via CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.25/angular.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.25/angular-route.js"></script>
    <script src="app.js"></script>
</head>
<body>

    <!-- HEADER AND NAVBAR -->
    <header>
        <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="/">Exam</a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="#about"><i class="fa fa-shield"></i> About</a></li>
                <li><a href="/">Login</a></li>
            </ul>
        </div>
        </nav>
    </header>

    <!-- MAIN CONTENT AND INJECTED VIEWS -->
    <div id="main" class="container">
        <div data-ng-view></div>
    </div>

</body>
</html>
