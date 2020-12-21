<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>  
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body>
    <!--JavaScript at end of body for optimized loading-->
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            M.updateTextFields();
        });
    </script>
    

    <header>
        <nav>
            <div class="nav-wrapper yellow">
                <a href="#!" class="brand-logo black-text">JSON2CSV</a>
                <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <ul class="right hide-on-med-and-down">
                    
                </ul>
            </div>
        </nav>

        <ul class="sidenav" id="mobile-demo">
            
        </ul>
    </header>
    @yield('content')
</body>
</html>