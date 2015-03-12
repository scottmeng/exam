<!-- index.html -->
<!DOCTYPE html>
<html data-ng-app="examApp">
<head>
    <base href="/" />
    <!-- SCROLLS -->
    <!-- load bootstrap and fontawesome via CDN -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" />
    <!-- SPELLS -->
    <!-- load angular and angular route via CDN -->
     <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
    <!-- // <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.12/angular.min.js"></script> -->

    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular-route.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/angular-strap/2.1.2/angular-strap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/angular-strap/2.1.2/angular-strap.tpl.min.js"></script>

    <!-- local js and css files -->
    <script src="{{ URL::to('js/ui-bootstrap-0.12.1.js') }}"></script>
    <script src="{{ URL::to('js/ace/ace.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ URL::to('js/ui-ace.js') }}"></script>
    <script src="{{ URL::to('js/ace/ext-language_tools.js') }}"></script>
    <link rel="stylesheet" href="{{ URL::to('styles/style.css') }}">
    <link rel='stylesheet' href="{{ URL::to('styles/textAngular.css') }}">
    <link rel='stylesheet' href="{{ URL::to('styles/hljs-default.css') }}">

    <script src="{{ URL::to('js/textAngular/textAngular-rangy.min.js') }}"></script>
    <script src="{{ URL::to('js/textAngular/textAngular-sanitize.min.js') }}"></script>
    <script src="{{ URL::to('js/textAngular/textAngular.min.js') }}"></script>
    <script src="{{ URL::to('js/timer.js') }}"></script>
    <script src="{{ URL::to('js/i18nService.js') }}"></script>
    <script src="{{ URL::to('js/moment.min.js') }}"></script>
    <script src="{{ URL::to('js/locales.min.js') }}"></script>
    <script src="{{ URL::to('js/angular-moment.js') }}"></script>
    <script src="{{ URL::to('bower_components/moment-timezone/builds/moment-timezone-with-data.js') }}"></script>

    <script src="{{ URL::to('js/humanize-duration.js') }}"></script>
    <script src="{{ URL::to('js/checklist-model.js') }}"></script>
    <script src="{{ URL::to('js/highlight.pack.js') }}"></script>
    <script src="{{ URL::to('js/angular-highlightjs.min.js') }}"></script>
    <script src="{{ URL::to('js/FileSaver.min.js') }}"></script>
    <script src="{{ URL::to('js/BlobBuilder.min.js') }}"></script>
    <script src="{{ URL::to('app.js') }}"></script>
</head>
<body>

    <!-- HEADER AND NAVBAR -->
    <header data-ng-controller="headerController">
        <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="/home">Exam</a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="#about"><i class="fa fa-shield"></i> About</a></li>
                <li data-ng-show="isLogin"><b style="padding: 15px; display: block">@{{ userName }}</b></li>
                <li><a href="" data-ng-click="onAuthClicked();">@{{ option }}</a></li>
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
