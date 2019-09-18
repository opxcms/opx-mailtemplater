<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="{{ \Core\Facades\Site::getLocale() }}">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>{{ \Core\Facades\Site::getTitle() }}</title>
</head>

<body class="body">

<table class="email">

    <tr>
        <td>
            <table class="email__body">
                <tr>
                    <td>
                        <!-- Email body -->

                    @if(isset($content))
                        {!! $content !!}
                    @endif

                    <!-- End email body -->
                    </td>
                </tr>
            </table>
        </td>
    </tr>

</table>

</body>
</html>